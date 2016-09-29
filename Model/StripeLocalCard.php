<?php

/*
 * This file is part of the SerendipityHQ Stripe Bundle.
 *
 * Copyright (c) Adamo Crespi <hello@aerendir.me>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SerendipityHQ\Bundle\StripeBundle\Model;

use Stripe\ApiResource;
use Stripe\Card;

/**
 * @author Adamo Crespi <hello@aerendir.me>
 *
 * @see https://stripe.com/docs/api#card_object
 */
class StripeLocalCard
{
    /** @var string The Stripe ID of the card (used in conjunction with a customer or recipient ID) */
    private $id;

    /** @var null|string $addressCity  */
    private $addressCity;

    /** @var null|string */
    private $addressCountry;

    /** @var null|string */
    private $addressLine1;

    /** @var null|string $addressLine1Check If address_line1 was provided, results of the check: pass, fail, unavailable, or unchecked.*/
    private $addressLine1Check;

    /** @var null|string */
    private $addressLine2;

    /** @var null|string */
    private $addressState;

    /** @var null|string */
    private $addressZip;

    /** @var null|string $addressZipCheck If address_zip was provided, results of the check: pass, fail, unavailable, or unchecked.*/
    private $addressZipCheck;

    /** @var string $brand Card brand. Can be Visa, American Express, MasterCard, Discover, JCB, Diners Club, or Unknown.*/
    private $brand;

    /** @var string $country Two-letter ISO code representing the country of the card. You could use this attribute to get a sense of the international breakdown of cards you’ve collected. */
    private $country;

    /** @var null|StripeLocalCustomer $customer The customer that this card belongs to. This attribute will not be in the card object if the card belongs to an account or recipient instead. */
    private $customer;

    /** @var null|string $cvcCheck If a CVC was provided, results of the check: pass, fail, unavailable, or unchecked*/
    private $cvcCheck;

    /** @var null|string $dynamicLast4 (For tokenized numbers only.) The last four digits of the device account number. */
    private $dynamicLast4;

    /** @var string */
    private $expMonth;

    /** @var string */
    private $expYear;

    /** @var string $fingerprint Uniquely identifies this particular card number. You can use this attribute to check whether two customers who’ve signed up with you are using the same card number, for example. */
    private $fingerprint;

    /** @var string Card funding type. Can be credit, debit, prepaid, or unknown */
    private $funding;

    /** @var string */
    private $last4;

    /** @var null|string $metadata A set of key/value pairs that you can attach to a card object. It can be useful for storing additional information about the card in a structured format. */
    private $metadata;

    /** @var null|string $name Cardholder name */
    private $name;

    /** @var null|string $tokenizationMethod If the card number is tokenized, this is the method that was used. Can be apple_pay or android_pay. */
    private $tokenizationMethod;

    /**
     * @param Card|null|array $data
     */
    public function __construct($data = null)
    {
        // If $data are passed...
        if (null !== $data) {
            // If is array
            if (is_array($data)) {
                $this->fromArray($data);
            }

            if ($data instanceof Card) {
                $this->fromStripeObject($data);
            }

            throw new \InvalidArgumentException('The value passed is not recognized: it can be array, Customer or null.');
        }
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return null|string
     */
    public function getAddressCity()
    {
        return $this->addressCity;
    }

    /**
     * @return null|string
     */
    public function getAddressCountry()
    {
        return $this->addressCountry;
    }

    /**
     * @return null|string
     */
    public function getAddressLine1()
    {
        return $this->addressLine1;
    }

    /**
     * @return null|string
     */
    public function getAddressLine1Check()
    {
        return $this->addressLine1Check;
    }

    /**
     * @return null|string
     */
    public function getAddressLine2()
    {
        return $this->addressLine2;
    }

    /**
     * @return null|string
     */
    public function getAddressState()
    {
        return $this->addressState;
    }

    /**
     * @return null|string
     */
    public function getAddressZip()
    {
        return $this->addressZip;
    }

    /**
     * @return null|string
     */
    public function getAddressZipCheck()
    {
        return $this->addressZipCheck;
    }

    /**
     * @return string
     */
    public function getBrand()
    {
        return $this->brand;
    }

    /**
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @return null|string
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * @return null|string
     */
    public function getCvcCheck()
    {
        return $this->cvcCheck;
    }

    /**
     * @return null|string
     */
    public function getDynamicLast4()
    {
        return $this->dynamicLast4;
    }

    /**
     * @return string
     */
    public function getExpMonth()
    {
        return $this->expMonth;
    }

    /**
     * @return string
     */
    public function getExpYear()
    {
        return $this->expYear;
    }

    /**
     * @return string
     */
    public function getFingerprint()
    {
        return $this->fingerprint;
    }

    /**
     * @return string
     */
    public function getFunding()
    {
        return $this->funding;
    }

    /**
     * @return string
     */
    public function getLast4()
    {
        return $this->last4;
    }

    /**
     * @return null|string
     */
    public function getMetadata()
    {
        return $this->metadata;
    }

    /**
     * @return null|string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return null|string
     */
    public function getTokenizationMethod()
    {
        return $this->tokenizationMethod;
    }

    /**
     * @param string $addressCity
     */
    public function setAddressCity($addressCity)
    {
        $this->addressCity = $addressCity;
    }

    /**
     * @param string $addressCountry
     */
    public function setAddressCountry($addressCountry)
    {
        $this->addressCountry = $addressCountry;
    }

    /**
     * @param string $addressLine1
     */
    public function setAddressLine1($addressLine1)
    {
        $this->addressLine1 = $addressLine1;
    }

    /**
     * @param string $addressLine2
     */
    public function setAddressLine2($addressLine2)
    {
        $this->addressLine2 = $addressLine2;
    }

    /**
     * @param string $addressState
     */
    public function setAddressState($addressState)
    {
        $this->addressState = $addressState;
    }

    /**
     * @param int $addressZip
     */
    public function setAddressZip($addressZip)
    {
        $this->addressZip = $addressZip;
    }

    /**
     * @param string $country
     */
    public function setCountry($country)
    {
        $this->country = $country;
    }

    /**
     * @param StripeLocalCustomer $customer
     */
    public function setCustomer(StripeLocalCustomer $customer)
    {
        $this->customer = $customer;
    }

    /**
     * @param int $expMonth
     */
    public function setExpMonth($expMonth)
    {
        $this->expMonth = $expMonth;
    }

    /**
     * @param int $expYear
     */
    public function setExpYear($expYear)
    {
        $this->expYear = $expYear;
    }

    /**
     * @param string $metadata
     */
    public function setMetadata($metadata)
    {
        $this->metadata = $metadata;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * {@inheritdoc}
     */
    public function fromArray(array $data)
    {
        if (isset($data['id'])) {
            $this->setId($data['id']);
        }

        if (isset($data['address_city'])) {
            $this->setAddressCity($data['address_city']);
        }

        if (isset($data['address_country'])) {
            $this->setAddressCountry($data['address_country']);
        }

        if (isset($data['address_line1'])) {
            $this->setAddressLine1($data['address_line1']);
        }

        if (isset($data['address_line1_check'])) {
            $this->setAddressLine1Check($data['address_line1_check']);
        }

        if (isset($data['address_line2'])) {
            $this->setAddressLine2($data['address_line2']);
        }

        if (isset($data['address_state'])) {
            $this->setAddressState($data['address_state']);
        }

        if (isset($data['address_zip'])) {
            $this->setAddressZip($data['address_zip']);
        }

        if (isset($data['address_zip_check'])) {
            $this->setAddressZipCheck($data['address_zip_check']);
        }

        if (isset($data['brand'])) {
            $this->setBrand($data['brand']);
        }

        if (isset($data['country'])) {
            $this->setCountry($data['country']);
        }

        if (isset($data['customer'])) {
            $this->setCustomer($data['customer']);
        }

        if (isset($data['cvc_check'])) {
            $this->setCvcCheck($data['cvc_check']);
        }

        if (isset($data['dynamic_last4'])) {
            $this->setDynamicLast4($data['dynamic_last4']);
        }

        if (isset($data['exp_month'])) {
            $this->setExpMonth($data['exp_month']);
        }

        if (isset($data['exp_year'])) {
            $this->setExpYear($data['exp_year']);
        }

        if (isset($data['fingerprint'])) {
            $this->setFingerprint($data['fingerprint']);
        }

        if (isset($data['funding'])) {
            $this->setFingerprint($data['funding']);
        }

        if (isset($data['last4'])) {
            $this->setLast4($data['last4']);
        }

        if (isset($data['metadata'])) {
            $this->setMetadata($data['metadata']);
        }

        if (isset($data['name'])) {
            $this->setName($data['name']);
        }

        if (isset($data['tokenization_method'])) {
            $this->setTokenizationMethod($data['tokenization_method']);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function fromStripeObject(ApiResource $object)
    {
        if (!$object instanceof Card) {
            throw new \InvalidArgumentException('fromStripeObject accepts only Stripe\Source objects.');
        }

        dump($object);
        throw new \RuntimeException('To implement');
    }

    /**
     * {@inheritdoc}
     */
    public function toCreate()
    {
        $return = [];

        return $return;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->getId();
    }

    /**
     * @param string $id
     */
    private function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @param string $addressLine1Check
     */
    private function setAddressLine1Check($addressLine1Check)
    {
        $this->addressLine1Check = $addressLine1Check;
    }

    /**
     * @param string $addressZipCheck
     */
    private function setAddressZipCheck($addressZipCheck)
    {
        $this->addressZipCheck = $addressZipCheck;
    }

    /**
     * @param string $brand
     */
    private function setBrand($brand)
    {
        $this->brand = $brand;
    }

    /**
     * @param string $cvcCheck
     */
    private function setCvcCheck($cvcCheck)
    {
        $this->cvcCheck = $cvcCheck;
    }

    /**
     * @param string $dynamicLast4
     */
    private function setDynamicLast4($dynamicLast4)
    {
        $this->dynamicLast4 = $dynamicLast4;
    }

    /**
     * @param string $fingerprint
     */
    private function setFingerprint($fingerprint)
    {
        $this->fingerprint = $fingerprint;
    }

    /**
     * @param string $last4
     */
    private function setLast4($last4)
    {
        $this->last4 = $last4;
    }

    /**
     * @param string $tokenizationMethod
     */
    private function setTokenizationMethod($tokenizationMethod)
    {
        $this->tokenizationMethod = $tokenizationMethod;
    }
}
