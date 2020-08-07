<?php

/*
 * This file is part of the Serendipity HQ Stripe Bundle.
 *
 * Copyright (c) Adamo Aerendir Crespi <aerendir@serendipityhq.com>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SerendipityHQ\Bundle\StripeBundle\Command;

use Doctrine\Bundle\DoctrineBundle\Command\DoctrineCommand;
use SerendipityHQ\Bundle\StripeBundle\Event\StripePlanUpdateEvent;
use SerendipityHQ\Bundle\StripeBundle\Model\StripeLocalPlan;
use SerendipityHQ\Component\ValueObjects\Currency\Currency;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

final class StripeUpdatePlansCommand extends DoctrineCommand
{
    /**
     * @var string
     */
    private const ID = 'id';
    /**
     * @var string
     */
    private const CURRENCY = 'currency';
    /**
     * @var string
     */
    protected static $defaultName = 'stripe:update:plans';

    protected function configure(): void
    {
        $this->setDescription('Update plans to your database.')
            ->addOption('em', null, InputOption::VALUE_REQUIRED, 'The entity manager to use for this command.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        /** @var $doctrine \Doctrine\Common\Persistence\ManagerRegistry */
        $doctrine = $this->getContainer()->get('doctrine');
        $em       = $doctrine->getManager($input->getOption('em'));

        $em->getConnection()->beginTransaction();

        $stripeManager = $this->getContainer()->get('stripe_bundle.manager.stripe_api');
        $stripePlans   = $stripeManager->retrievePlans();
        foreach ($stripePlans['data'] as $plan) {
            $aPlan = $plan->__toArray();

            $stripeLocalPlan = $em
                ->getRepository(\SerendipityHQ\Bundle\StripeBundle\Model\StripeLocalPlan::class)
                ->findOneBy([self::ID => $aPlan[self::ID]]);
            if (null === $stripeLocalPlan) {
                $stripeLocalPlan = new StripeLocalPlan();
                $stripeLocalPlan->setId($aPlan[self::ID]);
                $stripeLocalPlan->setCreated(new \DateTime());
            }
            $amount   = new \SerendipityHQ\Component\ValueObjects\Money\Money(['amount' => $aPlan['amount'], self::CURRENCY => $aPlan[self::CURRENCY]]);
            $currency = new Currency($aPlan[self::CURRENCY]);
            $stripeLocalPlan->setObject('plan')
                ->setAmount($amount)
                ->setCurrency($currency)
                ->setInterval($aPlan['interval'])
                ->setIntervalCount($aPlan['interval_count'])
                ->setLivemode($aPlan['livemode'])
                ->setMetadata($aPlan['metadata'])
                ->setName($aPlan['name'])
                ->setStatementDescriptor($aPlan['statement_descriptor'])
                ->setTrialPeriodDays($aPlan['trial_period_days']);
            $planUpdateEvent = new StripePlanUpdateEvent($stripeLocalPlan);
            $this->getContainer()->get('event_dispatcher')->dispatch(
                StripePlanUpdateEvent::UPDATE, $planUpdateEvent
            );
        }
        try {
            $em->getConnection()->commit();

            $output->writeln('Updated Plans.');
        } catch (\Exception $exception) {
            $em->getConnection()->rollBack();
            $output->writeln(\get_class($exception));
            $output->writeln($exception->getMessage());
        }

        return 0;
    }
}
