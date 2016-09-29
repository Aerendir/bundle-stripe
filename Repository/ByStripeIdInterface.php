<?php

namespace SerendipityHQ\Bundle\StripeBundle\Repository;

use SerendipityHQ\Bundle\StripeBundle\Model\StripeLocalResourceInterface;

/**
 * All Interface implemented by repositories that permits to find a LocalStripeObject by their StripeId.
 *
 * @author Adamo Aerendir Crespi <hello@aerendir.me>
 */
interface ByStripeIdInterface
{
    /**
     * @param $id
     *
     * @return StripeLocalResourceInterface|null
     */
    public function findOneByStripeId($id);
}
