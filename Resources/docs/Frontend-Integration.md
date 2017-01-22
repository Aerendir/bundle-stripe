How to integrate Stripe Bundle into your application's Front-end
================================================================

To integrate Stripe into your application through Stripe Bundle you need to import some other files into your app.

This is what we have to do:

1. Import `jquery.payment.min.js` and `initialize.js`;
2. Create the credit card form configuration;
3. Integrate our form into the payment pages.

Step 1: Import `jquery.payment.min.js` and `initialize.js`
----------------------------------------------------------

First of all, you need to import two javascript files: `jquery.payment.min.js` and `initialize.js`.

Thefirst one is a [javascript library](https://github.com/stripe/jquery.payment) that Stripes makes available to developers to help them integrate Stripe into their own applications.
 Its purpose is to render credit cards form fields in the right way and validate their values before submitting them to the Stripe API.

So, we first need to import thoes two scripts.

Somewhere in your app templates, you should have a block that imports javascript in your frontend:

```
{% block javascripts %}
    {% javascripts
    '@AppBundle/Resources/public/js/jquery-1.11.3.min.js'
    ...
    '@StripeBundle/Resources/public/js/jquery.payment/jquery.payment.min.js'
    '@StripeBundle/Resources/public/js/intialize.js'
    %}
    <script src="{{ asset_url }}"></script>
    {% endjavascripts %}
{% endblock %}

```

Remember that `jquery.payment.min.js` requires JQuery library, so you have to import it too.

You need to also import some `css`s:

```
{% block stylesheets %}
    {% stylesheets filter='scssphp,cssrewrite' output='css/app.css'
        'bundles/app/App/css/bootstrap.css'
        'bundles/app/App/css/bootstrap-theme.css'
        'bundles/app/App/css/jquery-ui-1.11.4-custom.css'
        'bundles/app/App/css/jquery-ui-1.11.4-custom.structure.css'
        ...
        'bundles/serendipityhqstripe/css/payment.css'
    %}
    <link rel="stylesheet" href="{{ asset_url }}" />
    {% endstylesheets %}
{% endblock %}
```

Now you have to install the assets in your `web` folder to make them available to your app in the frontend:

    app/console assets:install

Step 2: Integrate the credit card form on your payment page
-----------------------------------------------------------

To make your customer able to send you his credit card information, you need to provide him with a credit card form.

In the [Stripe's documentation](https://stripe.com/docs/custom-form) you can find some basic information about how to do this.

Stripe Bundle ships a form type for this and a pre-buil template.

The form type is really simple: it is composed of only one field: [`card_token`](https://github.com/Aerendir/stripe-bundle/blob/master/Form/Type/CreditCardStripeTokenType.php).

Before you ask why, let us explain a bit about how Stripe's credit cards processing works (you can see it in action in the link above).

### 2.1: How does Stripe's credit cards processing work

In abstract, the flow is this:

1. Your customer provides his credit card details on a form on your page or, alternatively, you can load a modal box served directly by the Stripe's secure servers.
2. The customer enters his credit card details in the form and submit it (more about submissionvery soon);
3. Stripe processes these data and returns you a card token that is a unique identifier of the card on the Stripe's systems;
4. You use the token to charge the customer.

This is the very abstract process. In each step there is a lot to know. And we are going to know it!

First, which kind of form can we use to get the credit cards information?

We can use:

* [Checkout](https://stripe.com/docs/checkout/tutorial), that is a javascript based modal box that is served directly by the Stripe's secured servers;
* [Stripe.js](https://stripe.com/docs/custom-form), that is a javascript file loaded directly from the Stripe's secure servers that silently sends the form data to Stripe and returns the token. The user never knows that something is happening on the background.

This second option is the one we have implemented in Stripe Bundle as we want the user fills a form rendered on our pages using the Symfony's form types and that he never notice that we are communicating with Stripe: all MUST happen in the background.

So, **THIS IS THE STRIPE FLOW FOLLOWED BY THE SERENDIPITY HQ STRIPE BUNDLE**:

1. We create a form type, let's call it `PremiumType`, with the fields we like (they can be what we like: a set of features to select or what you like);
2. To this form type we add the Stripe Bundle `CreditCardStripeTokenType` that will contain the token returned by Stripe (yes, Stripe will return your app a token - be patient :) );
3. On our page, we will render our form `PremiumType`;
4. In the form we will simply include the template `StripeBundle::creditCardForm.html.twig` to render the form where the customer will give us his credit card info;
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
{{ form_start(form, {'attr': {'id': subscription_form_id}}) }}

{{ form_widget(form.plan.ads) }}
{{ form_widget(form.plan.seo) }}
{{ form_widget(form.plan.social) }}

{# ATTENTION 2: NOTE WE INCLUDE THE BUNDLED TEMPLATE PASSING IT SOME VARIABLES #}
{% include('StripeBundle::creditCardForm.html.twig') with {'publishable_key': stripe_publishable_key, 'form_id': subscription_form_id, 'token_input_id': subscription_token_input_id} %}

{# ATTENTION 3: NOTE WE RENDER THE FIELD WE ADDED AT STEP 2.3 #}
{{ form_widget(form.credit_card.card_token) }}

<div class="form-group"><input type="submit" value="{% trans %}subscription.update{% endtrans %}" class="btn btn-secure pull-right" /></div>
{{ form_end(form) }}
```

KEEP ATTENTION NOW: note these things:

1. We gave the form an `id`;
2. We simply included a template provided by Stripe Bundle, BUT we passed it some variables;
3. We render the field `card_token` we added at step 2.3;

The questions:

1. Where is the form ID set?
2. Where are set the variable passed to the included template?

Answers: in our `config.yml` file... Let's add them!

### 2.5: Create twig global variable to use with the form template

As you can note, we set three variables:

1. `stripe_publishable_key`;
2. `subscription_form_id`;
3. `subscription_token_input_id`.

We need to set these manually in our `config.yml` and make them available to Twig setting them in its `global` key.

In your `config.yml`, in the `twig` section, put this:

```
twig:
    globals:
        stripe_publishable_key: "%stripe.publishable_key%"
        subscription_form_id: 'subscription'                                              # form_1 id
        subscription_token_input_id: 'form_credit_card_card_token'                        # form_1 token input field id
        company_billing_update_card_form_id: 'company_billing_update_card'                # form_2 id
        company_billing_update_card_token_input_id: 'credit_card_stripe_token_card_token' # form_2 token input field id
```

As you can see, we have set details for two forms: `subscription` and `company_billing`: doing this is possible to include the form in different places with different parameters in a very flexible and intuitive way.

Note that the variable `stripe_form_id` is used as form ID and is also passed to the included credit card template: this variable, infact, is used by the javascript scripts to set the credit card token returned by Stripe (... yes, again, be patient! :) ).

Now all is ready: try to render the page where you included the form and see what happens! :)

Do all work well? Right...

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

([Go back to index](Index.md)) | Next step: [Integrate the back-end](Backend-Integration.md)
