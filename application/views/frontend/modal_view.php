<div class="signup-form row w-100 m-0">
  <div class="col-md-5 mstr-bg-blue px-4 py-5">
    <div class="w-100 mt-50 mb-50">
      <h3 class="mstr-color-light mt-auto"><?php echo get_phrase('join_'.get_settings('system_title').'_for_free'); ?></h3>
      <div class="mstr-bg-green w-50 p-1 rounded-pill my-3"></div>
      <p class="mstr-color-light mb-auto"><?php echo get_phrase('explore_your_creativity_with_thousands_of_inspiring_classes_in_design,_illustration,_photography,_and_more.'); ?></p>
    </div>
  </div>
  <div class="col-md-7 p-5">
    <h5 class="text-center mb-3"><?php echo get_phrase('fill_out_the_form'); ?></h5>
    <div class="w-100 text-center pt-2">
      <form action="<?php echo site_url('signup/register'); ?>" id="SignUpForm" method="post">
        <div class="input-group mb-3">
          <input type="text" name="first_name" class="form-control me-2 rounded-end" placeholder="<?php echo get_phrase('first_name'); ?>" aria-label="<?php echo get_phrase('first_name'); ?>">
          <input type="text" name="last_name" class="form-control ml-2 rounded-start" placeholder="<?php echo get_phrase('last_name'); ?>" aria-label="<?php echo get_phrase('last_name'); ?>">
        </div>
        <div class="mb-3">
          <input type="email" name="email" class="form-control" placeholder="<?php echo get_phrase('email_address'); ?>" aria-label="<?php echo get_phrase('email_address'); ?>">
        </div>
        <div class="mb-3">
          <input type="password" name="password" class="form-control" placeholder="<?php echo get_phrase('password'); ?>" aria-label="<?php echo get_phrase('password'); ?>">
        </div>

        <button type="submit" class="mstr-header-btn-pro w-100 bg-green-muted"><?php echo get_phrase('sign_up'); ?></button>
      </form>
      <p class="mt-4"><?php echo get_phrase('already_a_member'); ?>? <a href="<?php echo site_url('signin'); ?>" class="fw-bold text-primary hover-ul"><?php echo get_phrase('sign_in'); ?></a></p>
      <hr class="bg-dark">

      <p class="text-12"><?php echo get_phrase("by_signing_up_you_agree_to_our"); ?> <a class="fw-bold text-dark hover-ul" href="jvascript:;"><?php echo get_phrase('terms_of_service'); ?></a> <?php echo get_phrase('and'); ?> <a class="fw-bold text-dark hover-ul" href="jvascript:;"><?php echo get_phrase('privacy_policy'); ?></a>.
    </div>

  </div>
</div>