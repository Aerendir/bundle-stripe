*Do you like this bundle? [**Leave a &#9733;**](#js-repo-pjax-container) or run `composer global require symfony/thanks && composer thanks` to say thank you to all libraries you use in your current project, this one too!*

How to configure Serendipity HQ Stripe Bundle
=============================================

The Serendipity HQ Stripe Bundle uses the [`Stripe's PHP Library`](https://stripe.com/docs/api/php) to connect and communicate with the Stripe's API.

The bundle intializes the `\Stripe\Stripe` object setting the secret key you have configured in you `parameters.yml` file (more on this later).

To access the Stripe's API, [you need a secret key](https://stripe.com/docs/api/php#authentication) you can get from your dashboard.

Step 3: Configure the Stripe Client
-----------------------------------

First, add the Stripe's keys to your `parameters.yml`.

Stripe will give you two keys: one is secret and MUST be used only for communication server-2-server; another is your "publishable key" and can be used on the client side to communicate with the Stripe's API via `Stripe.js` (it is not a popup, but a simple `javascript` that permits you to do some tasks in a secure way without your user will know you are communicating with Stripe's API - more on this later).

So, in your `parameters.yml`:

```yaml
parameters:
    ...
    stripe.secret_key: 'your_key'
    stripe.publishable_key: 'your_key'
```

These keys will be used by the bundle to integrate Stripe in your Symfony app, communicating with the API and making you able to display a SYMFONY'S FORM TYPE on your pages where the customer will give you his credit number and other payment details.

STEP 4: CONFIGURE STRIPE BUNDLE
-------------------------------

The full configuration is as follows. The set values are the default ones:

```yaml
# Default configuration for "StripeBundle"
shq_stripe:
    debug: true|false # If not set is === kernel.debug. If set, overwrites kernel.debug
    db_driver: orm #OPTIONL. Currently only ORM supported.
    model_manager_name: null # OPTIONAL. Set this if you are using a custom ORM model manager.
    stripe_config:
        secret_key: "%stripe.secret_key%"
        statement_descriptor: "your_statement" # OPTION. If not set is null. It may be overwritten when creating a Charge.
    endpoint:
        route_name: _stripe_bundle_endpoint # OTIONAL. The endpoint Stripe calls when notify an event.
        protocolol: http # OPTIONAL. The protocol to use. Accepted values are: http, HTTP, https, HTTPS.
        host: your_domain.com # REQUIRED. The hostname of your project when in production.
```

Add routing file for bounce endpoint (feel free to edit prefix)

```yaml
# app/config/routing.yml
stripe:
    resource: '@SHQStripeBundle/Resources/config/routing.yml'
    prefix: /stripe/endpoints # Optional. You can leave this blank to not add a prefix to the StripeBundle's routes.
```

Step 4: Update your database schema
-----------------------------------

```
$ php app/console doctrine:schema:update --force
```

*Do you like this bundle? [**Leave a &#9733;**](#js-repo-pjax-container) or run `composer global require symfony/thanks && composer thanks` to say thank you to all libraries you use in your current project, this one too!*

([Go back to index](Index.md)) | Next step: [Integrate the front-end](Frontend-Integration.md)
