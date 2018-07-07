*Do you like this bundle? [**Leave a &#9733;**](#js-repo-pjax-container) or run `composer global require symfony/thanks && composer thanks` to say thank you to all libraries you use in your current project, this one too!*

How to integrate Stripe Bundle into your application's Front-end
================================================================

To integrate Stripe in the frontend of your application you have to basically follow the flow described by Stripe itself.

This bundle doesn't provide much front-end integration tools as the ones provided by Stripe are really strong and as the
the front-end integration is really tied to your concrete implementation.

Are you using React? Or Bootstrap? Or are you using other technologies?

Here we report just a recap of the fundamental steps required to integrate Stripe in your frontend. For all other
information, refer to the [Stripe JS's documentation](https://stripe.com/docs/stripe-js).

This is what we have to do:

1. Import `Stripe.js` in ALL your pages;
2. Create the form to be included;

Step 1: Import `Stripe.js` in ALL your pages
--------------------------------------------

`Stripe.js` permits your application to collect sensitive data from your customers in a secure way and send them to
Stripe's servers to tokenize and then use them later.

Passing n Internet sensitive data such as the credit card information is really dangerous. For this reason Stripe
provides this script that takes care of all the security aspects of handling customers' information and payment
credentials.

The only thing required by us, is using their strong tools to communicate with the Stripe's servers.

`Stripe.js` does exactly this: opens a communication channel between our app and Stripe's servers, handling all the
informaiton flow in a secure way.

The `Stripe.js` script has to be included in all pages of the app as it is able to understand the users' behavior and
intercept fraudolent behaviors by analyzing each action done by the user on our pages.

Including it in all your pages makes possible to spread the full potential of [Stripe's Radar](https://stripe.com/docs/radar), the anti-fraud system
powered by the machine learning that analyzes and processes hundreds of signals about thousand of thousands credit card
processings.

So, the first thing we have to do is include this script in all pages of our app (without minifying nor combining it
with other javascripts!):

```
{# app/base.html.twig #}
<!DOCTYPE html>
<html lang="{{ locale }}">
    <head>
        <title>{% block title %}{% endblock %}</title>
        <meta name="description" content="{% block metaDescription %}{% endblock %}" />
        {# This must be in the header as it is used by the credit card form that is loaded before all other Javascripts #}
        <script type="text/javascript" src="https://js.stripe.com/v3/"></script>
        ...
    </head>
    <body>
    ...
    </body>
</html>
```

Step 2: Integrate the credit card form on your payment page
-----------------------------------------------------------

To make your customer able to send you his credit card information, you need to provide him with a credit card form.

In the [Stripe's documentation](https://stripe.com/docs/custom-form) you can find some basic information about how to do this.

Stripe Bundle ships a form type for this.

The form type is really simple: it is composed of only one field: [`card_token`](https://github.com/Aerendir/stripe-bundle/blob/master/Form/Type/CreditCardStripeTokenType.php).

Before you ask why, let us explain a bit about how Stripe's credit cards processing works (you can see it in action in the link above).

### 2.1: How does Stripe's credit cards processing work

In abstract, the flow is this:

1. Your customer provides his credit card details on a form generated using the `Stripe.js` (v3) script;
2. The customer enters his credit card details in the form and submit it (more about submissionvery soon);
3. Stripe processes these data and returns you a card token that is a unique identifier of the card on the Stripe's systems;
4. You use the token to charge the customer.

This is the very abstract process. In each step there is a lot to know. And we are going to know it!

To make it a bit more concrete, lets see how StripeBundle implements it.

**THIS IS THE STRIPE FLOW FOLLOWED BY THE SERENDIPITY HQ STRIPE BUNDLE**:

1. We create a form type, let's call it `PremiumType`, with the fields we like (they can be what we like: a set of features to select or what you like);
2. To this form type we add the Stripe Bundle `CreditCardStripeTokenType` that will contain the token returned by Stripe (yes, Stripe will return your app a token - be patient :) );
3. On our page, we will render our form `PremiumType`;
5. We'll add to the form a button to submit the entire form;

A bit theoretical, isn't it? Let's make it practical! :)

### 2.2: Create the `PremiumType` form type

Following is a piece of code from the form type we use on TrustBack.Me to make the merchant able to choose which features he likes to add to his store profile:

```php
class PremiumType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('ads', CheckboxType::class, ['required' => false])
            ->add('seo', CheckboxType::class, ['required' => false])
            ->add('social', CheckboxType::class, ['required' => false]);
    }
}
```

### 2.3: Create the form to be rendered on the `Twig` template, integrating the `CreditCardStripeTokenType`

We have created a method that serves the form:

```php
public function getPlansForm(Store $store)
    {
        $form = $this->formFactory->createBuilder(FormType::class, [
            'action' => $this->router->generate('store_subscription', ['id' => $store->getId()]),
            'method' => 'POST',
        ])
            ->add('plan', PremiumType::class, [
                'data_class' => PremiumFeaturesEmbeddable::class,
                'data'       => $store->getPremium()
            ]);

        if (null === $store->getBranchOf()->getStripeCustomer() || 0 === $store->getBranchOf()->getStripeCustomer()->getCards()->count())
            // This will add an HIDDENTYPE input field
            $form->add('credit_card', CreditCardStripeTokenType::class);

        return $form->getForm();
    }
```

Without taking care, for the moment, of the `if (null === $store->...`, note how we added to the form the field `credit_card` setting it as a `CreditCardStripeTokenType` type.

This will make we able to render the hidden field that will contain our card token returned by Stripe (be patient, we will speak about this in a moment! :) ).

### 2.4: Render the form on the front end

And now it's time to render our form on the frontend:

```
{# ATTENTION 1: NOTE WE GIVE THE FORM AN ID #}
{{ form_start(form, {'attr': {'id': subscription_form_id, 'autocomplete': 'on'}}) }}

{{ form_widget(form.plan.ads) }}
{{ form_widget(form.plan.seo) }}
{{ form_widget(form.plan.social) }}

{# ATTENTION 4: NOTE WE RENDER THE FIELD WE ADDED AT STEP 2.3 #}
{{ form_widget(form.credit_card.card_token) }}

{# ATTENTION 5: WE ADD THE CLASS `charge` to disable the button once clicked #}
<div class="form-group"><input type="submit" value="{% trans %}subscription.update{% endtrans %}" class="btn btn-success pull-right charge" /></div>
{{ form_end(form) }}
```

KEEP ATTENTION NOW: note these things:

1. We gave the form an `id`;
2. We render the field `card_token` we added at step 2.3;
3. We add a class `charge` to the button to submit the form so we will abe to disable it once the form is submitted.
4. The credit card input field is a `HiddenType` input field: it is only a container and is not meant to be filled by the User (more on this later).

### Step 2.5: Create the Stripe JS script

In this section the real "magic" happens.

To get the credit card information, you have to first create the fields using the `Stripe.js` (v3) library and then submit them to the Stripe's servers.

So we don't use the Symfony Form Component, but the Stripe.js script itself: this is because the script is always loaded from a secure server and the data transmitted are always tunneled through an HTTPS connection.  

Once sent to the Stripe's servers, Stripe processes the information and returns to your page a token that represents the data you provided.

The token is received via Javascript and stored in your form via Javascript, then the form is submitted to your server where you handle it using PHP (and StripeBundle).

The field that will store the token is the one we added at step 2.3: the one created adding `CreditCardStripeTokenType`.

Then you use this token to create the user on the Stripe's servers and associate the payment information to the just created user. 

So we need the Javascript code to use to submit the credit card info and get back the generated token.

The Javascript code we have to use is exactly the the same described in the [Stripe's documentation](https://stripe.com/docs/stripe-js/elements/quickstart#setup):
you have to only take care of the binding between the Stripe's form and the Symfony's form.

To do this you have to modify the code just a little bit.

This is the code in the [`Submit the token and the rest of your form to your server`](https://stripe.com/docs/stripe-js/elements/quickstart#submit-token)
section of the Quick Start Stripe's documentation there is this code:

```
function stripeTokenHandler(token) {
    // Insert the token ID into the form so it gets submitted to the server
    var form = document.getElementById('payment-form');
    var hiddenInput = document.createElement('input');
    hiddenInput.setAttribute('type', 'hidden');
    hiddenInput.setAttribute('name', 'stripeToken');
    hiddenInput.setAttribute('value', token.id);
    form.appendChild(hiddenInput);
    
    // Submit the form
    form.submit();
}
```

Your code MUSt be a bit different:

1) You have to not create the hidden input field as your form already has it (`CreditCardStripeTokenType`)
2) You have to select the already existent credit card field
3) You have to update it with the token returned by Stripe

So, the javascript code will become this:

```
function stripeTokenHandler(token) {
    // Insert the token ID into the form so it gets submitted to the server
    var form = document.getElementById('payment-form');
    
    // Here we select the already rendered credit card form field
    var hiddenInput = document.getElementById('form_credit_card_card_token');
    
    // Here we update it with the token returned by Stripe
    hiddenInput.setAttribute('value', token.id); 
    
    // Submit the form
    form.submit();
}
```

Now load yur page and all should work well: the credit card form should be created and once submitted it should return back the token.

Try to fill the form with some [test cards](https://stripe.com/docs/testing#cards) and submit it: what does it happen?

### What you should expect

When you hit the the submit button, you should expect a really short delay before the form is submitted.

This delay is caused by the communication between you app and the Stripe's server. This communication happens via the `Stripe.js` library that is included automatically by the Stripe Bundle.

When you hit the submit button, the submit event is intercepted by JavaScript.

Then the data of the form are sent to the Stripe's servers (only data about credit cards are sent to Stripe!) on a secure connection (SSL/TLS encrypted, also if your app hasn't SSL enabled).

The Stripe's servers save the card, tokenize it and return your app a token representation of the card.

The javascript on your page set this token as value of the `card_token` field (remember? We added this field in our form in step 2.3) and then sends the entire form to your server.

As the form that collects the credit cards data doesn't have names, these data will never be submitted to your server, so you don't have to take care of their security: all the dirty stuff is done by the Stripe's servers.

The entire procedure is described in full details on the [Stripe's documentation](https://stripe.com/docs/custom-form).

Now that we have a form ready to be used, and that we have a tokenized representation of the credit card, we only remains to write the code for the backend.

## To show past used credit cards

```
{% if company.stripeCustomer.cards.count > 1 %}
<div style="display: block;" role="button" data-toggle="collapse" href="#past-cards" aria-expanded="false">
    <span class="glyphicon glyphicon-chevron-down"></span>{% trans %}company.account.billing.past_cards_are{% endtrans %}
    <div class="collapse out" id="past-cards">
        <p><small>{% trans %}company.account.billing.past_cards_are.disclaimer{% endtrans %}</small></p>
        <ul>
        {% for card in company.stripeCustomer.cards %}
            {% if card.id != company.stripeCustomer.defaultSource %}
                <li>{{ card.brand }}: xxxx-xxxx-xxxx-{{ card.last4 }} ({{ card.expMonth }}/{{ card.expYear }})</li>
            {% endif %}
        {% endfor %}
        </ul>
    </div>
</div>
{% endif %}
```

In the disclaimer something like:

    Di queste carte non abbiamo più nessun dato utile per addebitarle: conserviamo per referenza solo le ultime 4 cifre e la data di scadenza.

*Do you like this bundle? [**Leave a &#9733;**](#js-repo-pjax-container) or run `composer global require symfony/thanks && composer thanks` to say thank you to all libraries you use in your current project, this one too!*

([Go back to index](Index.md)) | Next step: [Integrate the back-end](Backend-Integration.md)
