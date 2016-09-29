STRIPE BUNDLE
=============

A bundle to integrate the use of Stripe in your Symfony App.

CONFIGURE
=========

1) Create the `stripe.secret_key` parameter
-------------------------------------------

In your `app/config/parameter.yml` create the parameter `stripe.secret_key` and the parameter `stripe.publishable_key`: this is used by the `stripe_bundle.manager.stripe` service and by the credit card form.


2) Import config, services and listeners
----------------------------------------

Import the Stripe Bundle services in your services.

In your `app/config/services.yml` file, import the ``

```
imports:
    - { resource: '@SerendipityHQStripeBundle/Resources/config/listeners.yml'}
    - { resource: '@SerendipityHQStripeBundle/Resources/config/services.yml'}

services:
    # HERE ALL OTHER SERVICES OF YOUR APP
    ...
```

In your `app/config/config.yml` file, import the ``

```
imports:
    - { resource: '@SerendipityHQStripeBundle/Resources/config/config.yml'}

# HERE ALL OTHER SERVICES OF YOUR APP
```

3) Create twig global variable to use with the form template
------------------------------------------------------------

In your `config.yml`, in the `twig` section, put this:

```
twig:
    globals:
        stripe_publishable_key: "%stripe.publishable_key%"
        form_1_id: 'subscription'            # form_1 id
        form_1_token_input_id: 'credit_card' # form_1 token input field id
        form_2_id: 'another-form-ID'         # form_2 id
        form_2_token_input_id: 'credit_card' # form_2 token input field id
        form_x_id: 'all_the_forms_you_need'  # form_3 id
        form_x_token_input_id: 'credit_card' # form_3 token input field id
```

Read more to know where to set those values in your form.

4) Add the `CreditCardStripeTokenType` to your form builder:

```
public function getPlansForm(Store $store)
{
    return $this->formFactory->createBuilder(FormType::class, [
        'action' => $this->router->generate('storeSubscription', ['id' => $store->getId()]),
        'method' => 'POST',
    ])
        ->add('plan', PremiumType::class, [
            'data_class' => PremiumFeaturesEmbeddable::class,
            'data'       => $store->getPremium()
        ])
        ->add('credit_card', CreditCardStripeTokenType::class)
        ->getForm();
}
```

5) Include the javascripts and the pre-built credit card form
-------------------------------------------------------------

Now it's time to setup the form.

On [Stripe's documentation](https://stripe.com/docs/custom-form) you can find some basic information about how to do this.

First of all, include the following javascript file in your template, setting also the required variables:

```
{% block javascripts %}
    {% javascripts
    '@AppBundle/Resources/public/js/jquery-1.11.3.min.js'
    '@AppBundle/Resources/public/App/js/bootstrap.js'
    '@AppBundle/Resources/public/App/js/jquery-ui-1.11.4-custom.min.js'
    ...
    '@SerendipityHQStripeBundle/Resources/public/js/intialize.js'
    '@SerendipityHQStripeBundle/Resources/public/js/jquery.payment/jquery.payments.min.js'

    %}
    <script src="{{ asset_url }}"></script>
    {% endjavascripts %}
    <script type="text/javascript">
        window.stripe_publishable_key = '{{ stripe_publishable_key }}'; 
    </script>
{% endblock %}
```

and add also the CSS file:

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

The Stripe Bundle offers a pre-built form with all the required information set.

On your part you have to only include it passing the required variables and rendering the hidden field for the credit card token (created at point 4):

```
{{ form_start(form, {'attr': {'id': form_1}}) }} {# This is the 'form_id' set at step 3 #}
    {{ form_widget(form.your_fields) }}
    {% include('SerendipityHQStripeBundle::creditCardForm.html.twig') with {'publishable_key': stripe_publishable_key, 'form_id': form_1_id, 'token_input_id': form_1_token_input_id} %}
    {{ form_widget(form.credit_card.card_token) }}
    <input type="submit" value="Pay" />
{{ form_end(form) }}
```

and render the field in your form: