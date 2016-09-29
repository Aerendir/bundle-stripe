How to integrate Stripe Bundle into your application's Front-end
================================================================

Once we have integrated the bundle in the front-end, we need to handle the backend operations to persist data and update plans.

Serendipity HQ Stripe Bundle works using events: this way, it is possible to manage all the operations with a little effort and without duplicating code.

You have to simply dispatch an event to make the Stripe Bundle able to perform the action you need.

The bundle, on its part, will respond with another event that you can intercept to make your application able to respond in the most appropriate way.

How to charge the customer
--------------------------

As an example, let's charge our customer of an arbitrary amount (the way you compute this amount is up to you and outside of the scope of this documentation).


