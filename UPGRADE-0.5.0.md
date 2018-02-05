UPGRADE FROM 0.4.0 to 0.5.0
===========================

The main difference between the `0.4` and the `0.5` is that this last version uses Stripe's `Stripe JS` that makes
really easier to handle the tokenization of credit card information and provides a level of customization really high.

For this reason many front-end configurations were removed and some editings to your front-end templates are needed.

Below the list of things you have to remove from your configuration using the new `0.5` version, upgrading from the `0.4`.

Remove the `shq_stripe.stripe_config.publishable_key` parameter
---------------------------------------------------------------

As per the new really flexible options the of the Stripe JS script, we decided to completely drop the front-end
integration support: it will be easier and faster to directly use the Stripe's tools instead of relying on the bundle
features.

For this reason it is not required anymore to pass the `publishable_key` as this will be something you will get directly
in your twig templates.

Do not include `SHQStripeBundle::creditCardForm.html.twig` and `initialize.js`
------------------------------------------------------------------------------

Instead create your own Twig template and use the `Stripe JS` power to render the form fields.

Twig globals are not required anymore (unless you need it for your custom integration)
--------------------------------------------------------------------------------------

These Twig global variable are not required anymore:

```
twig:
    globals:
        stripe_publishable_key
        subscription_form_id
        subscription_token_input_id
``` 

You can delete them safely.

The `StripeBundle` doesn't require anymore this option to be passed to Twig.

Anyway it is a useful way to handle the rendering of the form also in your custom front-end implementation. Keep it in mind!
