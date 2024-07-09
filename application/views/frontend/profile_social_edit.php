<?php $socials = json_decode($user_details['social']); ?>

<form class="realtime-form" action="<?php echo site_url('user/social_link_update'); ?>" method="post" enctype="multipart/form-data">
	<div class="row">
		<div class="col-12">
			<div class="form-group">
				<label class="ff-gt-pro mb-1" for="facebook">
					<i class="bi bi-facebook"></i>
					<?php echo get_phrase('facebook'); ?>
				</label>
				<input class="form-control" type="url" id="facebook" name="facebook" placeholder="https://facebook.com/user-profile" value="<?php echo $socials->facebook ?>">
			</div>

			<div class="form-group mt-3">
				<label class="ff-gt-pro mb-1" for="twitter">
					<i class="bi bi-twitter"></i>
					<?php echo get_phrase('twitter'); ?>
				</label>
				<input class="form-control" type="url" id="twitter" name="twitter" placeholder="https://twitter.com/user-profile" value="<?php echo $socials->twitter ?>">
			</div>

			<div class="form-group mt-3">
				<label class="ff-gt-pro mb-1" for="linkedin">
					<i class="bi bi-linkedin"></i>
					<?php echo get_phrase('linkedin'); ?>
				</label>
				<input class="form-control" type="url" id="linkedin" name="linkedin" placeholder="https://linkedin.com/user-profile" value="<?php echo $socials->linkedin ?>">
			</div>

			<div class="form-group mt-3">
				<label class="ff-gt-pro mb-1" for="website">
					<i class="bi bi-globe"></i>
					<?php echo get_phrase('website'); ?>
				</label>
				<input class="form-control" type="url" id="website" name="website" placeholder="https://website.com/user-profile" value="<?php echo $socials->website ?>">
			</div>
		
			<div class="form-group mt-3">
				<button class="btn btn-primary float-end mt-4" type="submit"><?php echo get_phrase('Save_Changes'); ?></button>
			</div>
		</div>
	</div>
</form>