<div class="row ">
  <div class="col-lg-12">
    <a href="<?php echo site_url('admin/students'); ?>" class="btn btn-primary alignToTitle"><i class="fa fa-reply"></i> <?php echo get_phrase('back'); ?></a>
  </div><!-- end col-->
</div>


<div class="panel panel-primary" data-collapsed="0">
	<div class="panel-heading">
		<div class="panel-title">
			<?php echo get_phrase('add_new_student'); ?>
		</div>
	</div>
	<div class="panel-body">
		<form action="<?php echo site_url('admin/students/added'); ?>" method="post" enctype="multipart/form-data">
			<div class="row mb-15px">
				<label for="first_name" class="col-sm-3 control-label text-right pt-5px"><?php echo get_phrase('name'); ?>*</label>
				<div class="col-sm-7">
					<input type="text" class="form-control float-left brr-0 w-50 mr-0px" name="first_name" id="first_name" placeholder="<?php echo get_phrase('enter_first_name'); ?>" required>
					<input type="text" class="form-control float-left brl-0 w-50 ml-0px" name="last_name" id="last_name" placeholder="<?php echo get_phrase('enter_last_name'); ?>">
				</div>
			</div>

			<div class="row mb-15px">
				<label for="surname" class="col-sm-3 control-label text-right pt-5px"><?php echo get_phrase('designation'); ?></label>
				<div class="col-sm-7">
					<input type="text" class="form-control" name="surname" id="surname" placeholder="<?php echo get_phrase('designation'); ?>">
				</div>
			</div>

			<div class="row mb-15px">
				<label for="email" class="col-sm-3 control-label text-right pt-5px"><?php echo get_phrase('email'); ?>*</label>
				<div class="col-sm-7">
					<input type="email" class="form-control" name="email" id="email" placeholder="<?php echo get_phrase('email_address'); ?>" required>
				</div>
			</div>

			<div class="row mb-15px">
				<label for="password" class="col-sm-3 control-label text-right pt-5px"><?php echo get_phrase('password'); ?>*</label>
				<div class="col-sm-7">
					<input type="password" class="form-control" name="password" id="password" placeholder="<?php echo get_phrase('enter_a_password'); ?>" required>
				</div>
			</div>

			<div class="row mb-15px">
				<label for="phone" class="col-sm-3 control-label text-right pt-5px"><?php echo get_phrase('phone'); ?></label>
				<div class="col-sm-7">
					<input type="text" class="form-control" name="phone" id="phone" placeholder="<?php echo get_phrase('phone_number'); ?>">
				</div>
			</div>

			<div class="row mb-15px">
				<label for="address" class="col-sm-3 control-label text-right pt-5px"><?php echo get_phrase('address'); ?></label>
				<div class="col-sm-7">
					<textarea class="form-control" rows="3" name="address" id="address" placeholder="<?php echo get_phrase('address'); ?>"></textarea>
				</div>
			</div>

			<div class="row mb-15px">
				<label for="common_editor" class="col-sm-3 control-label text-right pt-5px"><?php echo get_phrase('about'); ?></label>
				<div class="col-sm-7">
					<textarea class="form-control" rows="4" name="about" id="common_editor" placeholder="<?php echo get_phrase('about'); ?>"></textarea>
				</div>
			</div>

			<div class="row mb-15px">
				<label for="photo" class="col-sm-3 control-label text-right pt-5px"><?php echo get_phrase('photo'); ?></label>
				<div class="col-sm-7">
					<div class="fileinput fileinput-new float-left mr-10px" data-provides="fileinput">
						<div class="fileinput-new thumbnail" data-trigger="fileinput">
							<img width="200px" src="<?php echo base_url('uploads/user_images/thumbnail.png'); ?>" alt="...">
						</div>

						<div class="fileinput-preview fileinput-exists thumbnail w-200px"></div>
						<div>
							<span class="btn btn-white btn-file">					<span class="fileinput-new"><?php echo get_phrase('select_user_photo'); ?></span>
								<span class="fileinput-exists"><?php echo get_phrase('change'); ?></span>
								<input type="file" id="photo" name="photo" accept="image/*">
							</span>
							<a href="#" class="btn btn-orange fileinput-exists" data-dismiss="fileinput"><?php echo get_phrase('remove'); ?></a>
						</div>
					</div>
				</div>
			</div>

			<hr>
			<div class="row">
				<label class="col-sm-3 control-label text-right pt-5px"></label>
				<div class="col-sm-7">
					<h4><b><?php echo get_phrase('socials'); ?></b></h4>
				</div>
			</div>

			<div class="row mb-15px">
				<label for="facebook" class="col-sm-3 control-label text-right pt-5px"><?php echo get_phrase('facebook'); ?></label>
				<div class="col-sm-7">
					<input type="link" class="form-control" name="facebook" id="facebook" placeholder="https://facebook.com/username">
				</div>
			</div>

			<div class="row mb-15px">
				<label for="twitter" class="col-sm-3 control-label text-right pt-5px"><?php echo get_phrase('twitter'); ?></label>
				<div class="col-sm-7">
					<input type="link" class="form-control" name="twitter" id="twitter" placeholder="https://twitter.com/username">
				</div>
			</div>

			<div class="row mb-15px">
				<label for="linkedin" class="col-sm-3 control-label text-right pt-5px"><?php echo get_phrase('linkedin'); ?></label>
				<div class="col-sm-7">
					<input type="link" class="form-control" name="linkedin" id="linkedin" placeholder="https://linkedin.com/username">
				</div>
			</div>

			<div class="row mb-15px">
				<label for="website" class="col-sm-3 control-label text-right pt-5px"><?php echo get_phrase('website'); ?></label>
				<div class="col-sm-7">
					<input type="link" class="form-control" name="website" id="website" placeholder="https://website.com/username">
				</div>
			</div>

			<div class="row mb-15px">
				<label for="password" class="col-sm-3 control-label"></label>
				<div class="col-sm-7">
					<input type="checkbox" value="1" name="account_access" id="account_access">
					<label for="account_access" class=""><?php echo get_phrase('send_account_access_to_the_user'); ?></label>
				</div>
			</div>

			<div class="row mb-15px">
				<label class="col-sm-3 control-label text-right pt-5px"></label>
				<div class="col-sm-7">
					<button class="btn btn-primary" type="submit"><?php echo get_phrase('add_student'); ?></button>
				</div>
			</div>
		</form>
	</div>
</div>