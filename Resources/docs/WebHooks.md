How to configure Serendipity HQ Stripe Bundle
=============================================

Before continuing reading this page, you should read the [Web Hooks section](https://stripe.com/docs/webhooks) on the Stripe's doumentation.

Webhooks are a way Stripe has to communicate with your app, sending it some important information about events that happen on your Stripe account.

Stripe Bundle can receive some of these events and manage them: once received an Event from Stripe, the Stripe Bundle will handle it, persist it and dispatch an event to make your app aware of what's happening.
