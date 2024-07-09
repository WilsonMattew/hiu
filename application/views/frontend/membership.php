<div class="container-fluid mw-1365px">
  <div class="row">
    <div class="col-lg-6 py-5">
      <div class="row justify-content-center">
        <div class="col-md-10">
          <h4 class="highlights-text-dark mb-1">
            <?php if(get_settings('free_subscription_days') >= 1): ?>
              <?php echo get_phrase('start_your_free').' <b>'.get_settings('free_subscription_days').' '.get_phrase('days'); ?></b>
            <?php else: ?>
               <?php echo get_phrase('start_your_premium_subscription'); ?>
            <?php endif; ?>

          </h4>
          <p><?php echo get_phrase('no_commitments'); ?>. <?php echo get_phrase('cancel_anytime'); ?>.</p>
        </div>
        <div class="col-md-10">
          <form action="<?php echo site_url('membership/checkout'); ?>" method="get">
            <div class="py-3">
              <div class="form-check form-check-inline mt-2">
                <input class="form-check-input border border-secondary border-2" type="radio" name="payment_method" id="paypal" value="paypal" onclick="$('.checkout-btn').hide(); $('.paypal-checkout-btn').show();" required>
                <label class="form-check-label" for="paypal">
                  <img src="<?php echo base_url('assets/payment/paypal.png'); ?>" width="70px" alt="Papal Logo">
                </label>
              </div>

              <div class="form-check form-check-inline mt-2">
                <input class="form-check-input border border-secondary border-2" type="radio" name="payment_method" id="stripe" value="stripe" onclick="$('.checkout-btn').hide(); $('.stripe-checkout-btn').show();" required>
                <label class="form-check-label" for="stripe">
                  <img src="<?php echo base_url('assets/payment/stripe.png'); ?>" class="mt--3px" width="70px" height="25px" alt="Stripe Logo">
                </label>
              </div>
            </div>

            <h5 class="fw-bold mt-4"><?php echo get_phrase('pick_a_plan_to_start_after_your_trial'); ?></h5>
            <?php foreach($packages->result_array() as $key => $package): ?>
              <div class="form-check form-check-inline mt-2">
                <input class="form-check-input border border-secondary border-2" type="radio" name="package_id" id="<?php echo $package['package_id']; ?>_plan" value="<?php echo $package['package_id']; ?>" required>
                <label class="form-check-label" for="<?php echo $package['package_id']; ?>_plan">

                  <?php if($package['package_type'] == 'yearly'): ?>
                    <p><b class="text-20 m-0"><?php echo currency($package['price']/12); ?></b>/<?php echo get_phrase('month'); ?></p>
                    <p class="text-muted text-13 mt--15px"><?php echo currency($package['price']).' '.get_phrase('billed_annually'); ?></p>
                  <?php elseif($package['package_type'] == 'monthly'): ?>
                    <p><b class="text-20 m-0"><?php echo currency($package['price']); ?></b>/<?php echo get_phrase('month'); ?></p>
                    <p class="text-muted text-13 mt--15px"><?php echo get_phrase('billed_monthly'); ?></p>
                  <?php else: ?>
                    <p><b class="text-20 m-0"><?php echo currency(round($package['price']/12, 2)); ?></b>/<?php echo get_phrase('month'); ?></p>
                    <p class="text-muted text-13 mt--15px"><?php echo currency($package['price']).' '.get_phrase('billed_after_'.$package['days'].'_days'); ?></p>
                  <?php endif; ?>
                </label>
              </div>
            <?php endforeach; ?>

            <div class="card mstr-bg-blue mstr-color-light mt-5">
              <div class="card-body px-4">
                <?php if(get_settings('free_subscription_days')): ?>
                  <h6 class="mstr-color-light"><?php echo get_phrase("Today's_Total"); ?></h6>
                  <b class="text-32">US$0.00</b>
                  <span class="text-13">(<?php echo get_phrase('free_for_your_first_'.get_settings('free_subscription_days').'_days'); ?>)</span>
                <?php endif; ?>

                <?php if(login_type()): ?>

                  <button type="submit" class="checkout-btn mstr-header-btn-free w-100 mt-4 mb-3"><?php echo get_phrase('select_a_payment_gateway'); ?></button>

                  <!--Paypal catching data from the form by get method-->
                  <button type="submit" class="checkout-btn paypal-checkout-btn d-hidden mstr-header-btn-free w-100 mt-4 mb-3"><?php echo get_phrase('checkout_with_Paypal'); ?></button>

                  <!--Stripe is ignired the foem data its simple a button-->
                  <?php include APPPATH.'views/payment/stripe/stripe_payment_gateway_form.php'; ?>
                <?php else: ?>
                  <br>
                  <a href="<?php echo site_url('signin'); ?>" class="mstr-header-btn-free w-100 mt-4 mb-3"><?php echo get_phrase('signin_to_checkout'); ?></a>
                <?php endif; ?>

                <p class="text-12"><?php echo get_phrase('your_subscription_day_will_be_counted_automatically_and_start_on'); ?> <?php echo date('d M Y', time()+(86400*get_settings('free_subscription_days'))) ?>. <?php echo get_phrase('by_clicking_checkout_button'); ?>, <?php echo get_phrase('you_agree_to_our_Terms_of_Service_and_authorize_this_recurring_charge'); ?>.</p>
              </div>
            </div>
          </form>
        </div>
      </div>

    </div>
    <div class="col-lg-6 bg-white py-5">
      <div class="row justify-content-center">
        <div class="col-12 py-3">
          <h4 class="fw-bold text-center mb-3"><?php echo get_phrase('Premium_Member_Benefits'); ?></h4>
        </div>
        <div class="col-md-10 py-3">
          <div class="card border-0">
            <div class="card-body bg-body text-center p-4">
              <img src="<?php echo base_url('assets/frontend/image/video-list.png'); ?>" width="52px" alt="benefits">
              <h5 class="fw-bold mt-3"><?php echo get_phrase('Unlimited_Access_to_all_of_The_Online_Classes') ?></h5>
              <p class="m-0"><?php echo get_phrase('take_as_many_classes_as_you_want_Ad_Free'); ?>.</p>
            </div>
          </div>
        </div>

        <div class="col-md-10 py-3">
          <div class="card border-0">
            <div class="card-body bg-body text-center p-4">
              <img src="<?php echo base_url('assets/frontend/image/teachers.png'); ?>" width="52px" alt="benefits">
              <h5 class="fw-bold mt-3"><?php echo get_phrase('Quality_Teachers'); ?></h5>
              <p class="m-0"><?php echo get_phrase('experts_in_design,_business,_technology,_and_more'); ?>.</p>
            </div>
          </div>
        </div>

        <div class="col-md-10 py-3">
          <div class="card border-0">
            <div class="card-body bg-body text-center p-4">
              <img src="<?php echo base_url('assets/frontend/image/offline-video.png'); ?>" width="52px" alt="benefits">
              <h5 class="fw-bold mt-3"><?php echo get_phrase('comfortable'); ?></h5>
              <p class="m-0"><?php echo get_phrase('access_on_the_mobile,_laptop,_and_TV_responsively'); ?>.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>