<!DOCTYPE html>
<html lang="en">
<head>
	<title>Paypal | <?php echo get_settings('system_title');?></title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="<?php echo base_url('assets/payment/css/stripe.css');?>" rel="stylesheet">
  <link name="favicon" type="image/x-icon" href="<?php echo base_url('uploads/system_images/logo/'.get_frontend_settings('favicon')); ?>" rel="shortcut icon" />
	<style type="text/css">
		#loader_modal{
			position: fixed;
			display: none;
			width: 100%;
			height: 100%;
			top: 0;
			left: 0;
			right: 0;
			bottom: 0;
			background-color: #42477077;
			z-index: 1000;
			color: #fff;
			text-align: center;
			padding-top: 100px;
		}
		.mt-15{
			margin-top: 15px;
		}
	</style>
</head>
<body>
  <?php $paypal_keys = json_decode(get_settings('paypal_keys')); ?>
	<div class="package-details">
		<strong><?php echo site_phrase('name');?> | <?php echo $user_details['first_name'].' '.$user_details['last_name'];?></strong> <br>
		<strong><?php echo site_phrase('amount_to_pay');?> | <?php echo $package['price'].' '.system_currency('code');?></strong> <br>
		<div id="paypal-button" class="mt-4 mt-15"></div><br>
	</div>

  <script src="<?php echo base_url('assets/global/jquery/jquery-3.6.0.min.js'); ?>"></script>
  <script src="https://www.paypalobjects.com/api/checkout.js"></script>

  <script>
  paypal.Button.render({
    env: '<?php echo $paypal_keys[0]->mode; ?>', // 'sandbox' or 'production'
    style: {
      label: 'paypal',
      size:  'medium',    // small | medium | large | responsive
      shape: 'rect',     // pill | rect
      color: 'blue',     // gold | blue | silver | black
      tagline: false
    },
    client: {
      sandbox:    '<?php echo $paypal_keys[0]->sandbox_client_id; ?>',
      production: '<?php echo $paypal_keys[0]->production_client_id; ?>'
    },

    commit: true, // Show a 'Pay Now' button

    payment: function(data, actions) {
      return actions.payment.create({
        payment: {
          transactions: [
            {
              amount: { total: '<?php echo $package['price'];?>', currency: '<?php echo system_currency('code'); ?>' }
            }
          ]
        }
      });
    },

    onAuthorize: function(data, actions) {
      // executes the payment
      return actions.payment.execute().then(function() {
        // PASSING TO CONTROLLER FOR CHECKING
        var redirectUrl = '<?php echo site_url('membership/payment_success/paypal/'.$package['package_id'].'/'.$package['price']);?>'+'/'+data.paymentID+'/'+data.paymentToken+'/'+data.payerID;
        $('#loader_modal').fadeIn(50);
        window.location = redirectUrl;
      });
    }

  }, '#paypal-button');
</script>

<div id="loader_modal"><?php echo get_phrase('please_wait'); ?>...</div>
</body>
</html>