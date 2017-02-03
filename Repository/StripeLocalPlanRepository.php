<?php

namespace SerendipityHQ\Bundle\StripeBundle\Repository;

use Doctrine\ORM\EntityRepository;
use SerendipityHQ\Bundle\StripeBundle\Model\StripeLocalPlan;

/**
 * {@inheritdoc}
 */
class StripeLocalPlanRepository extends EntityRepository implements ByStripeIdInterface
{
    /**
     * @param $id
     *
     * @return object|StripeLocalPlan|null
     */
    public function findOneByStripeId($id)
    {
        return $this->findOneBy(['id' => mb_strtolower($id)]);
    }
}
