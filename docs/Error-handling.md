*Do you like this bundle? [**Leave a &#9733;**](#js-repo-pjax-container) or run `composer global require symfony/thanks && composer thanks` to say thank you to all libraries you use in your current project, this one too!*

HOW TO MANAGE CARD ERRORS
=========================

When a credit card is associated with a Customer or it is charged, may happen some errors.

Stripe provides a [list of test cards](https://stripe.com/docs/testing#cards-responses) to use to test some scenarios.

Lets recap the flows: to make a payment using Stripe (for a Charge or for a Subscription) you have to:

1) Create a Customer;
2) Associate a Card/Source to this Customer.
3) Charge the Customer's credit card/source (with a Charge or with a Subscription).

You can associate a card/source to a Customer in two ways:

1) Associating the card/source to the Customer when you create the Customer (in one API call);
2) First creating the Customer and then associating a card/source to it (in two calls).

Last thing: errors may arise in two cases:

1) When the card is created;
2) When the card is charged.

Well understand these differences is very important as this will help you identify errors and reasons of them.

For example, it required us a lot of time to spot the logic behind the different behaviors of a `card_declined` with a
 `generic_decline` reason and of a `card_declined` with a `fraudulent` reason.
 
We will better explain this difference
 very soon. For the moment put your best efforts to maintain the concentration on what we are writing!
 
 So, finally, we have three things to remember:

1) The payment flow (Create Customer, associate a card to it, charge the card);
2) How to associate a Card/Source to a Customer (in one call, when creating a new Customer; or in two calls, associating
 it to an already existing Customer);
3) Errors may happen when the card is being created and associated to a Customer or when it is charged,

Despite the structure of the Stripe's documentation, there are three main scenarios:
1) You create the Customer and at the same time associate a card;
2) You first create a customer and then associate the card.
3) You have a Customer and you create a Charge for him/her.

In the next paragraphs we will examine the behaviors of Stripe and how this bundle handles them.

Exposing the scenarios, we will use the test cards and we will show them here from the most simple ones to the most
 complex ones.

## SCENARIO 1: You create the Customer and at the same time associate a card

Here we will show what happens if you try to use those credit card numbers while creating a Customer.

So, what you are doing is create a Customer and at the same time associating a Card to it.

### CARD 4000 0000 0000 0010

**Described Behavior**: The `address_line1_check` and `address_zip_check` verifications fail. If your account is
 [blocking payments that fail postal code validation](https://stripe.com/docs/radar/rules#traditional-bank-checks), the
 charge is declined.

_Not fully tested yet. Please, provide feedbacks [opening an issue](https://github.com/Aerendir/stripe-bundle/issues)._

### CARD 4000 0000 0000 0028

**Described Behavior**: Charge succeeds but the `address_line1_check` verification fails.

_Not fully tested yet. Please, provide feedbacks [opening an issue](https://github.com/Aerendir/stripe-bundle/issues)._

### CARD 4000 0000 0000 0036

**Descripted behavior**: The address_zip_check verification fails. If your account [is blocking payments that fail
 postal code validation](https://stripe.com/docs/radar/rules#traditional-bank-checks), the charge is declined.

_Not fully tested yet. Please, provide feedbacks [opening an issue](https://github.com/Aerendir/stripe-bundle/issues)._

### CARD 4000 0000 0000 0044

**Descripted behavior**: Charge succeeds but the `address_zip_check` and `address_line1_check` verifications are both
 `unavailable`.

_Not fully tested yet. Please, provide feedbacks [opening an issue](https://github.com/Aerendir/stripe-bundle/issues)._

### CARD 4000 0000 0000 0101

**Descripted behavior**: If a CVC number is provided, the `cvc_check` fails. If your account is [blocking payments that
 fail CVC code validation](https://stripe.com/docs/radar/rules#traditional-bank-checks), the charge is declined.

**Stripe Behavior**: no customer is created (and so, no card associated and no charge created)

**Bundle Returned error**: `stripe.card_error.incorrect_cvc`

**Bundle Behavior**: no customer is created (and so, no card associated and no charge created)

### CARD 4000 0000 0000 0341

**Descripted behavior**: Attaching this card to a [Customer](https://stripe.com/docs/api#customer_object) object
 succeeds, but attempts to charge the customer fail.

**Stripe Behavior**: Creates the Customer, associates the card, creates the Charge but then marks it as fraudulent

**Bundle Returned error**: `stripe.card_error.card_declined.generic_decline`

**Bundle Behaior**: Saves the same data and associates the error to the card. The Charge is filled with fictional
 data that are then updated by the webhook event sent by Stripe.

### CARD 4000 0000 0000 9235

**Descripted behavior**: Charge succeeds with a `risk_level` of `elevated` and [placed into review](https://stripe.com/docs/radar/review).

**Stripe Behavior**: Customer created, card associated, Charge created but put in manual review queue. A `review` event
 is sent other than the `customer`, `card` and `charge` ones.

**Bundle Behavior**: Customer created, card associated, Charge created

### CARD 4000 0000 0000 0002

**Descripted behavior**: Charge is declined with a `card_declined` code.

**Stripe Behavior**: no customer is created (and so, no card associated and no charge created)

**Bundle Returned error**: `stripe.card_error.card_declined.generic_decline`

**Bundle Behavior**: no customer is created (and so, no card associated and no charge created)

### CARD 4100 0000 0000 0019

**Descripted behavior**: Charge is declined with a `card_declined` code and a `fraudulent` reason.

**Stripe Behavior**: Creates the Customer, associates the card, creates the Charge but then marks it as fraudulent

**Bundle Returned error**: `stripe.card_error.card_declined.fraudulent`

**Bundle Behaior**: Saves the same data and associates the error to the card. The Charge is filled with fictional
 data that are then updated by the webhook event sent by Stripe.

### CARD 4000 0000 0000 0127

**Descripted behavior**: Charge is declined with a `incorrect_cvc` code.

**Stripe Behavior**: no customer is created (and so, no card associated and no charge created)

**Bundle Returned error**: `stripe.card_error.incorrect_cvc`

**Bundle Behavior**: no customer is created (and so, no card associated and no charge created)

### CARD 4000 0000 0000 0069

**Descripted behavior**: Charge is declined with a `expired_card` code.

**Stripe Behavior**: no customer is created (and so, no card associated and no charge created)

**Bundle Returned error**: `stripe.card_error.expired_card`

**Bundle Behavior**: no customer is created (and so, no card associated and no charge created)

### CARD 4000 0000 0000 0119

**Descripted behavior**: Charge is declined with a `processing_error` code.

**Stripe Behavior**: no customer is created (and so, no card associated and no charge created)

**Bundle Returned error**: `stripe.card_error.processing_error`

**Bundle Behavior**: no customer is created (and so, no card associated and no charge created)

### CARD 4242424242424241

**Descripted behavior**: Charge is declined with an incorrect_number code as the card number fails the Luhn check.

**Bundle Returned error**: The form sending is blocked by JavaScript (remember that if JS is disabled a
 `stripe.card_error.missing` error is anyway returned as it is not possible to get the card token from Stripe)

*Do you like this bundle? [**Leave a &#9733;**](#js-repo-pjax-container) or run `composer global require symfony/thanks && composer thanks` to say thank you to all libraries you use in your current project, this one too!*
