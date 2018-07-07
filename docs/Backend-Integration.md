*Do you like this bundle? [**Leave a &#9733;**](#js-repo-pjax-container) or run `composer global require symfony/thanks && composer thanks` to say thank you to all libraries you use in your current project, this one too!*

How to integrate Stripe Bundle into your application's Back-end
================================================================

Once we have integrated the bundle in the front-end, we need to handle the backend operations to persist data and update plans.

Serendipity HQ Stripe Bundle works using events: this way, it is possible to manage all the operations with a little effort and without duplicating code.

You have to simply dispatch an event to make the Stripe Bundle able to perform the action you need.

The bundle, on its part, will respond with another event that you can intercept to make your application able to respond in the most appropriate way.

How to charge the customer
--------------------------

As an example, let's charge our customer of an arbitrary amount (the way you compute this amount is up to you and outside of the scope of this documentation).

NOTE: Se passo un Customer ID che non ha una carta associata e passo anche un token proveniente da Stripe.js, Stripe restituisce un errore `\Stripe\Error\Card` "Cannot charge a customer that has no active card" "card_error" param: card, code: missing

Quindi, se ho un token di Stripe.js, devo prima associarlo al Customer quando lo creo.

Se il Customer già ce l'ho, invece, vuol dire che l'utente sta aggiungendo una nuova carta (o sta sostituendone una che già ha): in questo caso, prima aggiorno il customer con il nuovo token, magari impostandolo come default_source, dopo faccio il charge passando l'ID del customer.

Se non aggiorno il customer associando il nuovo token, il pagamento avviene lo stesso, ma perdo la carta e dopo il customer dovrà riaggiungerla.

##How to create a plan
We can create a plan in Stripe for defining an object SerendipityHQ\Bundle\StripeBundle\Model\StripeLocalPlan and dispatch the event StripePlanUpdateEvent::CREATE
Remember your plan will be created into Stripe and in your entity stripe_plans.

    ...
    use SerendipityHQ\Bundle\StripeBundle\Model\StripeLocalPlan;
    use SerendipityHQ\Component\ValueObjects\Money\Money;
    ...
    $amount = 999; // in cents (9.99 EUR)
    $currency = "eur";
    $amount = new Money(['amount' => $amount, 'currency' => $currency]);
    $currency = new Currency($currency);
    $plan = 'PLAN_ID';

    $stripeLocalPlan = new StripeLocalPlan();
    $stripeLocalPlan
        ->setId($plan)
        ->setObject('plan') // Kind of plan object
        ->setName('XYZ PLAN')
        ->setCreated(new \DateTime())
        ->setAmount($amount)
        ->setCurrency($currency)
        ->setInterval('month') // either day, week, month or year
        ->setIntervalCount(1) // each 1 month
        ->setLivemode(false)
        ->setMetadata('') // more information about the plan, a set of key/value pairs
        ->setStatementDescriptor('COMPANY. SUBSCRIPTION OF XYZ PLAN') // An arbitrary string to be displayed on your customer’s credit card statement.  
        ->setTrialPeriodDays(0); // set number of trial period days
    $planCreateEvent = new StripePlanCreateEvent($stripeLocalPlan);
    $this->getContainer()->get('event_dispatcher')->dispatch(
        StripePlanCreateEvent::CREATE, $planCreateEvent
    );

### If you created the plans into Stripe directly you would sync with your entity
If that's your case you can run the command for updating:

    php app/console stripe:update:plans

##How to create the subscription
As an example, let's subscribe our customer to one plan. If the plan has no trial period days, stripe charge the first amount of plan when create the subscription.

1. Stage: We have a created plan and a customer.
2. Verify if there is some subscription link to this customer
3. Create the subscription, define the object SerendipityHQ\\Bundle\\StripeBundle\\Model\\StripeLocalSubscription 
4. We dispatch the event to create the subscription. 


    ...
    use SerendipityHQ\Bundle\StripeBundle\Model\StripeLocalSubscription;
    use SerendipityHQ\Bundle\StripeBundle\Event\StripeCustomerCreateEvent;
    use SerendipityHQ\Component\ValueObjects\Email\Email;
    ...    
    
    // 1. Stage: We have a created plan a customer
    $plan = 'PLAN_ID';
    $email = new Email('USER@DOMAIN.TLD');
    $stripeLocalCustomer = $em->getRepository("SerendipityHQ\\Bundle\\StripeBundle\\Model\\StripeLocalCustomer")
        ->findOneBy(['email' => $email]);
        
    // 2. Verify if there is some subscription link to this customer
    $stripeLocalSubscription = $em->getRepository("SerendipityHQ\\Bundle\\StripeBundle\\Model\\StripeLocalSubscription")
        ->findOneBy(['customer' => $stripeLocalCustomer]);
    if ($stripeLocalSubscription == null) {
    
        // 3. Create the subscription, define the object SerendipityHQ\\Bundle\\StripeBundle\\Model\\StripeLocalSubscription 
        $stripeLocalSubscription = new StripeLocalSubscription();
        $stripeLocalSubscription->setCustomer($stripeLocalCustomer);
        $stripeLocalSubscription->setPlan($plan);
        
        // 4. We dispatch the event to create the subscription. 
        $subscriptionCreateEvent = new StripeSubscriptionCreateEvent($stripeLocalSubscription);
        $this->eventDispatcher->dispatch(
            StripeSubscriptionCreateEvent::CREATE, $subscriptionCreateEvent
        );
    }

*Do you like this bundle? [**Leave a &#9733;**](#js-repo-pjax-container) or run `composer global require symfony/thanks && composer thanks` to say thank you to all libraries you use in your current project, this one too!*
