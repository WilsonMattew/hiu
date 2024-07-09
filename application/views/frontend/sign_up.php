
<div class="container" id="signUpForm">
  <h3 class="text-center my-4 py-3">
    <?php if(get_settings('free_subscription_days') >= 1): ?>
      <?php echo get_phrase('start_your_free').' '.get_settings('free_subscription_days').' '.get_phrase('days_of_unlimited_classes'); ?>
    <?php else: ?>
      <?php echo get_phrase('start_your_premium_subscription_of_unlimited_classes'); ?>
    <?php endif; ?>
    </h3>
  <div class="row justify-content-center mb-5">
    <div class="col-lg-4">

      <div class="w-100 text-center pt-2">
        <form action="<?php echo site_url('signup/register'); ?>" method="post">
          <div class="input-group mb-3">
            <input type="text" name="first_name" class="form-control me-2 rounded-end py-2" placeholder="<?php echo get_phrase('first_name'); ?>" aria-label="<?php echo get_phrase('first_name'); ?>" required>
            <input type="text" name="last_name" class="form-control ml-2 rounded-start py-2" placeholder="<?php echo get_phrase('last_name'); ?>" aria-label="<?php echo get_phrase('last_name'); ?>">
          </div>
          <div class="mb-3">
            <input type="email" name="email" class="form-control py-2" placeholder="<?php echo get_phrase('email_address'); ?>" aria-label="<?php echo get_phrase('email_address'); ?>" required>
          </div>
          <div class="mb-3">
            <input type="password" name="password" class="form-control py-2" placeholder="<?php echo get_phrase('password'); ?>" aria-label="<?php echo get_phrase('password'); ?>" required>
          </div>

          <button type="submit" class="mstr-header-btn-free w-100 bg-green-muted"><?php echo get_phrase('sign_up'); ?></button>
        </form>
        <p class="mt-4"><?php echo get_phrase('already_a_member'); ?>? <a href="<?php echo site_url('signin'); ?>" class="fw-bold text-primary hover-ul"><?php echo get_phrase('sign_in'); ?></a></p>
        <hr class="bg-dark">

        <p class="text-13"><?php echo get_phrase("by_signing_up_you_agree_to_our"); ?> <a class="fw-bold text-dark hover-ul" href="jvascript:;"><?php echo get_phrase('terms_of_service'); ?></a> <?php echo get_phrase('and'); ?> <a class="fw-bold text-dark hover-ul" href="jvascript:;"><?php echo get_phrase('privacy_policy'); ?>.
      </div>
    </div>
  </div>
</div>