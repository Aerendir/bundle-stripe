<?php

namespace SerendipityHQ\Bundle\StripeBundle\Repository;

use Doctrine\ORM\EntityRepository;
use SerendipityHQ\Bundle\StripeBundle\Model\StripeLocalSubscription;

/**
 * {@inheritdoc}
 */
class StripeLocalInvoiceItemRepository extends EntityRepository implements ByStripeIdInterface
{
    /**
     * @param $id
     *
     * @return object|StripeLocalSubscription|null
     */
    public function findOneByStripeId($id)
    {
        return $this->findOneBy(['id' => mb_strtolower($id)]);
    }
}
