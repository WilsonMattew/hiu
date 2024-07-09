<?php if(get_settings('free_subscription_days') > 0): ?>
	<div class="row justify-content-center mb-5 py-5">
		<div class="col-md-6 text-center">
			<h4 class="mstr-color-light"><b><?php echo get_phrase('start_a_free_trial_to_continue_this_class'); ?></b></h4>
			<p><?php echo get_phrase('start_your_free_trial_to_get_access_to_this_premium_class_and_all_on').' '.get_settings('system_title'); ?>.</p>
			<a href="<?php echo site_url('membership'); ?>" class="mstr-header-btn-free py-2"><?php echo get_phrase('Start_Your_Free_Trial'); ?></a>
		</div>
	</div>
<?php else: ?>
	<div class="row justify-content-center mb-5 py-5">
		<div class="col-md-6 text-center">
			<h4 class="mstr-color-light"><b><?php echo get_phrase('go_premium_to_continue_this_class'); ?></b></h4>
			<p><?php echo get_phrase('buy_a_subscroption_to_get_access_to_this_premium_class_and_all_on').' '.get_settings('system_title'); ?>.</p>
			<a href="<?php echo site_url('membership'); ?>" class="mstr-header-btn-free py-2"><?php echo get_phrase('Start_your_'.get_settings('system_title').'_premium_subscription_today'); ?>!</a>
		</div>
	</div>
<?php endif; ?>