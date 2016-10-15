<?php

namespace SerendipityHQ\Bundle\StripeBundle\Tests\Model;
use SerendipityHQ\Bundle\StripeBundle\Form\Type\CreditCardStripeTokenType;
use Symfony\Component\Form\Test\TypeTestCase;

/**
 * Tests the CreditCardStripeTokenType.
 *
 * @author Adamo Aerendir Crespi <hello@aerendir.me>
 */
class CreditCardStripeTokenTypeTest extends TypeTestCase
{
    public function testSubmitValidData()
    {
        $formData = [
            'card_token' => 'tok_tokenid'
        ];

        $form = $this->factory->create(CreditCardStripeTokenType::class);

        $form->submit($formData);

        $this::assertTrue($form->isSynchronized());
        $this::assertTrue($form->isSubmitted());

        $view = $form->createView();
        $children = $view->children;

        foreach(array_keys($formData) as $key) {
            $this::assertArrayHasKey($key, $children);
        }
    }
}
