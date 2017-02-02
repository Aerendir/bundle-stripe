jQuery(function($) {
    var form = $('#' + window.stripe_payment_form_id),
        switchCreditCardIcon = function(vendor) {
            path = $('.credit-card-icon').attr('src').split('/');
            path.pop(-1);

            if (null === vendor)
                vendor = 'credit';

            path.push(vendor + '.png');

            if ('' === path[0])
                path[0] = document.location.origin;

            newPath = path.join('/');
            $('.credit-card-icon').attr('src', newPath);
        };


    $(document).ready(function(){
        inputHeight = $('#cc-number').height();
        $('.credit-card-icon').attr('height', inputHeight-2);
        form.find('#' + window.stripe_card_token_input_id).val('');
    });
    $('.cc-number').payment('formatCardNumber');
    $('.cc-exp').payment('formatCardExpiry');
    $('.cc-cvc').payment('formatCardCVC');
    $('[data-numeric]').payment('restrictNumeric');

    $.fn.toggleInputError = function(hasError) {
        this.parents('.form-group').toggleClass('has-error', hasError);
        return hasError;
    };

    $(form.find('#cc-number')).keyup(function () {
        var cardType = $.payment.cardType($('#cc-number').val());
        switchCreditCardIcon(cardType);
    });

    form.submit(function(e) {
        var cardType = $.payment.cardType($('#cc-number').val());
        var hasErrors = false;
        var toggle = false;

        // Disable the submit button to prevent repeated clicks:
        form.find('.submit').prop('disabled', true);

        // Validate cc-number
        toggle = $('.cc-number').toggleInputError(false === $.payment.validateCardNumber($('.cc-number').val()));
        if (true === toggle) {
            hasErrors = true;
            console.log('Error in credit card number.');
        }

        // Validate cc-exp
        toggle = $('.cc-exp').toggleInputError(false === $.payment.validateCardExpiry($('.cc-exp').payment('cardExpiryVal')));
        if (true === toggle) {
            hasErrors = true;
            console.log('Error in expiration date.');
        }

        // Validate cc-cvc
        toggle = $('.cc-cvc').toggleInputError(false === $.payment.validateCardCVC($('.cc-cvc').val(), cardType));
        if (true === toggle) {
            hasErrors = true;
            console.log('Error in cvc.');
        }

        // Request a token from Stripe:
        if (false === hasErrors) {
            // Add expiration month and yaer to the form
            $('#exp_month').val($('.cc-exp').payment('cardExpiryVal').month);
            $('#exp_year').val($('.cc-exp').payment('cardExpiryVal').year);
            try {
                Stripe.card.createToken(form, stripeResponseHandler);
            } catch (err) {
                return false;
            }
        }

        // Prevent the form from being submitted:
        return false;
    });
});

function stripeResponseHandler(status, response) {
    // Grab the form:
    var form = $('#' + window.stripe_payment_form_id);

    if (response.error) { // Problem!

        // Show the errors on the form:
        form.find('.payment-errors').text(response.error.message);
        form.find('.submit').prop('disabled', false); // Re-enable submission

    } else { // Token was created!

        // Get the token ID:
        var token = response.id;

        // Insert the token ID into the form so it gets submitted to the server:
        //$form.append($('<input type="hidden" name="stripeToken">').val(token));
        form.find('#' + window.stripe_card_token_input_id).val(token);

        // Submit the form:
        form.get(0).submit();
    }
};
