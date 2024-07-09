<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/frontend/text-editor/ui/trumbowyg.min.css'); ?>">

<form class="realtime-form" action="<?php echo site_url('user/profile_update'); ?>" method="post" enctype="multipart/form-data">
	<div class="tab-pane active">
		<div class="row">
			<div class="col">
				<div class="form-group">
					<label class="ff-gt-pro mb-1" for="first_name"><?php echo get_phrase('first_name'); ?></label>
					<input class="form-control" type="text" id="first_name" name="first_name" placeholder="<?php echo get_phrase('enter_your_first_name'); ?>" value="<?php echo $user_details['first_name']; ?>" required>
				</div>
			</div>
			<div class="col">
				<div class="form-group">
					<label class="ff-gt-pro mb-1" for="last_name"><?php echo get_phrase('last_name'); ?></label>
					<input class="form-control" type="text" id="last_name" name="last_name" placeholder="<?php echo get_phrase('enter_your_last_name'); ?>" value="<?php echo $user_details['last_name']; ?>">
				</div>
			</div>
		</div>

		<div class="row mt-3">
			<div class="col">
				<div class="form-group">
					<label class="ff-gt-pro mb-1" for="surname"><?php echo get_phrase('surname'); ?></label>
					<input class="form-control" type="text" id="surname" name="surname" placeholder="<?php echo get_phrase('enter_your_surname_name'); ?>" value="<?php echo $user_details['surname']; ?>">
				</div>
			</div>
		</div>

		<div class="row mt-3">
			<div class="col">
				<div class="form-group">
					<label class="ff-gt-pro mb-1" for="phone"><?php echo get_phrase('phone'); ?></label>
					<input class="form-control" type="text" id="phone" name="phone" placeholder="<?php echo get_phrase('phone'); ?>" value="<?php echo $user_details['phone']; ?>">
				</div>
			</div>
		</div>

		<div class="row mt-3">
			<div class="col mb-3">
				<div class="form-group">
					<label  for="address" class="ff-gt-pro mb-1"><?php echo get_phrase('address'); ?></label>
					<textarea id="address" name="address" class="form-control" rows="4" placeholder="<?php echo get_phrase('address'); ?>"><?php echo $user_details['address']; ?></textarea>
				</div>
			</div>
		</div>

		<div class="row mt-3">
			<div class="col mb-3">
				<div class="form-group">
					<label class="ff-gt-pro mb-1"><?php echo get_phrase('about'); ?></label>
					<textarea name="about" id="common_editor" class="form-control" rows="5" placeholder="<?php echo get_phrase('my_Bio'); ?>"><?php echo $user_details['about']; ?></textarea>
				</div>
			</div>
		</div>
	
	</div>

	<div class="row">
		<div class="col d-flex justify-content-end">
			<button class="btn btn-primary" type="submit"><?php echo get_phrase('Save_Changes'); ?></button>
		</div>
	</div>
</form>



<script type="text/javascript">
	'use strict';
	$(function(){
		$('#common_editor').trumbowyg();
	});
</script>
<script type="text/javascript" src="<?php echo base_url('assets/frontend/text-editor/trumbowyg.min.js'); ?>"></script>