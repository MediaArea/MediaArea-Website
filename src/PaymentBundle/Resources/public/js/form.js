var paymentForm = (function () {
    var init = function() {
        // Show/hide fields depending on payment method
        $('input[type="radio"][name="ma_choose_payment_method[method]"]').on('change', function() {
            if (this.value == 'stripe_credit_card') {
                showStripeForm();
            } else {
                hideStripeForm();
            }
        });

        // Update pay button
        updateSubmitButtonWithPrice($('select[name="ma_choose_payment_method[amount]"] option:selected').text());
        $('select[name="ma_choose_payment_method[amount]"]').on('change', function() {
            updateSubmitButtonWithPrice($(this).find('option:selected').text());
        });
    };

    var hideStripeForm = function() {
        $('.stripe-form').hide();
    }

    var showStripeForm = function() {
        $('.stripe-form').show();
    }

    var updateSubmitButtonWithPrice = function(amount) {
        $('.payment-submit-button').val('Donate ' + amount);
    }

    return {
        init: init,
    };
})();

$(document).ready(function() {
    paymentForm.init();
});
