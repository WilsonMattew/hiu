<script src="https://js.stripe.com/v3/"></script>
<?php
	// Stripe API configuration
    $stripe_keys = get_settings('stripe_keys');
    $values = json_decode($stripe_keys);
    if ($values[0]->testmode == 'on') {
        $public_key = $values[0]->public_key;
        $private_key = $values[0]->secret_key;
    } else {
        $public_key = $values[0]->public_live_key;
        $private_key = $values[0]->secret_live_key;
    }

	define('STRIPE_API_KEY', $private_key);
	define('STRIPE_PUBLISHABLE_KEY', $public_key);
?>

<div id="stripePaymentResponse"></div>

<!-- Buy button -->
<div id="buynow" class="d-hidden checkout-btn stripe-checkout-btn">
    <button class="mstr-header-btn-free w-100 mt-4 mb-3" id="stripePayButton"><?php echo get_phrase("checkout_with_stripe"); ?></button>
</div>

<script>
var buyBtn = document.getElementById('stripePayButton');
var responseContainer = document.getElementById('stripePaymentResponse');


// Create a Checkout Session with the selected product
var createCheckoutSession = function (stripe) {
    var package_id = $("input[name='package_id']:checked").val();
    if(package_id){
        return fetch("<?= site_url('membership/checkout?payment_method=stripe&package_id='); ?>"+package_id, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify({
                checkoutSession: 1,
            }),
        }).then(function (result) {
            return result.json();
        });
    }else{
        error_message('<?php echo get_phrase('select_a_package'); ?>')
    }
};

// Handle any errors returned from Checkout
var handleResult = function (result) {
    if (result.error) {
        responseContainer.innerHTML = '<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong class="text-danger">'+result.error.message+'</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
    }
    buyBtn.disabled = false;
    buyBtn.textContent = 'Buy Now';
};

// Specify Stripe publishable key to initialize Stripe.js
var stripe = Stripe('<?php echo STRIPE_PUBLISHABLE_KEY; ?>');

buyBtn.addEventListener("click", function (evt) {
    var package_id = $("input[name='package_id']:checked").val();
    if(package_id){
        buyBtn.disabled = true;
        buyBtn.textContent = '<?php echo get_phrase("please_wait"); ?>...';

        createCheckoutSession().then(function (data) {
            if(data.sessionId){
                stripe.redirectToCheckout({
                    sessionId: data.sessionId,
                }).then(handleResult);
            }else{
                handleResult(data);
            }
        });
    }
});
</script>
