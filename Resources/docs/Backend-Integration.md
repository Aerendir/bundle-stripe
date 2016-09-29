How to integrate Stripe Bundle into your application's Front-end
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


