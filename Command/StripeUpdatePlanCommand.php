<?php

namespace SerendipityHQ\Bundle\StripeBundle\Command;

use SerendipityHQ\Bundle\StripeBundle\Event\StripePlanUpdateEvent;
use SerendipityHQ\Component\ValueObjects\Currency\Currency;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Doctrine\Bundle\DoctrineBundle\Command\DoctrineCommand;
use SerendipityHQ\Bundle\StripeBundle\Model\StripeLocalPlan;

class StripeUpdatePlanCommand extends DoctrineCommand
{
    protected function configure()
    {
        $this
            ->setName('stripe:update:plan')
            ->setDescription('Update plans to your database.')
            ->addOption('em', null, InputOption::VALUE_REQUIRED, 'The entity manager to use for this command.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var $doctrine \Doctrine\Common\Persistence\ManagerRegistry */
        $doctrine = $this->getContainer()->get('doctrine');
        $em = $doctrine->getManager($input->getOption('em'));

        $em->getConnection()->beginTransaction();

        $stripeManager = $this->getContainer()->get('stripe_bundle.manager.stripe_api');
        $stripePlans = $stripeManager->retrievePlans();
        foreach ($stripePlans['data'] as $plan) {
            $aPlan = $plan->__toArray();

            $stripeLocalPlan = $em
                ->getRepository('SerendipityHQ\\Bundle\\StripeBundle\\Model\\StripeLocalPlan')
                ->findOneBy(['id' => $aPlan['id']]);
            if ($stripeLocalPlan == null) {
                $stripeLocalPlan = new StripeLocalPlan();
                $stripeLocalPlan->setId($aPlan['id']);
                $stripeLocalPlan->setCreated(new \DateTime());
            }
            $amount = new \SerendipityHQ\Component\ValueObjects\Money\Money(['amount' => $aPlan['amount'], 'currency' => $aPlan['currency']]);
            $currency = new Currency($aPlan['currency']);
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
        } catch (\Exception $e) {
            $em->getConnection()->rollBack();
            print_r(get_class($e) . "\n");
            print_r($e->getMessage() . "\n");
            exit(1);

            return false;
        }
        $output->writeln('Updated Plans.');
    }
}
