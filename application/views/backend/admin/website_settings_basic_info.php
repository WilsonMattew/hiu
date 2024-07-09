<form action="<?php echo site_url('admin/website_settings/basic/updated'); ?>" method="post" enctype="multipart/form-data" class="form-horizontal form-groups-bordered">
	<h4 class="mb-15px"><b><?php echo get_phrase('update_basic_information'); ?></b></h4>

	<div class="form-group p-10px">
		<label class="control-label mb-10px"><b><?php echo get_phrase('top_header_notification'); ?></b></label>
		<br>
		<input <?php if(get_frontend_settings('top_notification_status'))echo 'checked'; ?> type="radio" name="top_notification_status" id="nEnabled" value="1">
		<label for="nEnabled" class="mr-10px"><?php echo get_phrase('enabled'); ?></label>

		<input <?php if(!get_frontend_settings('top_notification_status'))echo 'checked'; ?> type="radio" name="top_notification_status" id="nDisabled" value="0">
		<label for="nDisabled"><?php echo get_phrase('disabled'); ?></label>
	</div>

	<div class="form-group p-10px">
		<label class="control-label mb-10px"><b><?php echo get_phrase('top_header_notification_message'); ?></b></label>
		<textarea name="top_notification" class="form-control common_editor" required><?php echo get_frontend_settings('top_notification'); ?></textarea>
	</div>

	<div class="form-group p-10px">
		<label for="about_us" class="control-label mb-10px"><b><?php echo get_phrase('about_us'); ?></b></label>
		<textarea name="about_us" class="form-control common_editor" required><?php echo get_frontend_settings('about_us'); ?></textarea>
	</div>

	<div class="form-group p-10px">
		<label for="privacy_policy" class="control-label mb-10px"><b><?php echo get_phrase('privacy_policy'); ?></b></label>
		<textarea name="privacy_policy" class="form-control common_editor" required><?php echo get_frontend_settings('privacy_policy'); ?></textarea>
	</div>

	<div class="form-group p-10px">
		<label for="terms_and_condition" class="control-label mb-10px"><b><?php echo get_phrase('terms_&_condition'); ?></b></label>
		<textarea name="terms_and_condition" class="form-control common_editor" required><?php echo get_frontend_settings('terms_and_condition'); ?></textarea>
	</div>

	<div class="form-group p-10px">
		<label for="faq" class="control-label mb-10px"><b><?php echo get_phrase('faq'); ?></b></label>
		<textarea name="faq" class="form-control common_editor" required><?php echo get_frontend_settings('faq'); ?></textarea>
	</div>

	<button type="submit" class="btn btn-info"><?php echo get_phrase('save_changes'); ?></button>
</form>