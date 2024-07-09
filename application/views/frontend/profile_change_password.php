<?php $socials = json_decode($user_details['social']); ?>

<form class="realtime-form" action="<?php echo site_url('user/change_password'); ?>" method="post" enctype="multipart/form-data">
	<div class="row">
		<div class="col-12">
			<div class="form-group">
				<label class="ff-gt-pro mb-1" for="email">
					<?php echo get_phrase('email'); ?>
				</label>
				<input class="form-control" type="url" id="email" placeholder="" value="<?php echo $user_details['email']; ?>" readonly>
			</div>

			<div class="form-group mt-3">
				<label class="ff-gt-pro mb-1" for="current_password">
					<?php echo get_phrase('current_password'); ?>
				</label>
				<input class="form-control" type="text" id="current_password" name="current_password" onfocus="$(this).attr('type', 'text');" onblur="$(this).attr('type', 'password');" placeholder="">
			</div>

			<div class="form-group mt-3">
				<label class="ff-gt-pro mb-1" for="new_password">
					<?php echo get_phrase('new_password'); ?>
				</label>
				<input class="form-control" type="text" id="new_password" name="new_password" onfocus="$(this).attr('type', 'text');" onblur="$(this).attr('type', 'password');" placeholder="">
			</div>

			<div class="form-group mt-3">
				<label class="ff-gt-pro mb-1" for="confirm_password">
					<?php echo get_phrase('confirm_password'); ?>
				</label>
				<input class="form-control" type="text" id="confirm_password" name="confirm_password" onfocus="$(this).attr('type', 'text');" onblur="$(this).attr('type', 'password');" placeholder="">
			</div>

		
			<div class="form-group mt-3">
				<button class="btn btn-primary float-end mt-4" type="submit"><?php echo get_phrase('change_password'); ?></button>
			</div>
		</div>
	</div>
</form>