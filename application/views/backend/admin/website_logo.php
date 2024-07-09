<form action="<?php echo site_url('admin/website_settings/website_logo/updated'); ?>" method="post" enctype="multipart/form-data">
	<h4 class="mb-15px"><b><?php echo get_phrase('update_website_logo'); ?></b></h4>
	<div class="row">
		<div class="col-md-4">
			<div class="fileinput fileinput-new float-left mr-10px" data-provides="fileinput">
				<div class="fileinput-new thumbnail rounded" data-trigger="fileinput" style="width: 100%; height: 110px; background: #000;">
					<img width="200px" src="<?php echo base_url('uploads/system_images/logo/'.get_frontend_settings('light_logo')); ?>" alt="...">
				</div>

				<div class="fileinput-preview fileinput-exists thumbnail w-200px"></div>
				<div>
					<span class="btn btn-white btn-file">							<span class="fileinput-new"><?php echo get_phrase('select_a_light_logo'); ?></span>
						<span class="fileinput-exists"><?php echo get_phrase('change'); ?></span>
						<input type="file" id="class_thumbnail" name="light_logo" accept="image/*">
					</span>
					<a href="#" class="btn btn-orange fileinput-exists" data-dismiss="fileinput"><?php echo get_phrase('remove'); ?></a>
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="fileinput fileinput-new float-left mr-10px" data-provides="fileinput">
				<div class="fileinput-new thumbnail" data-trigger="fileinput" style="width: 100%; height: 110px;">
					<img width="200px" src="<?php echo base_url('uploads/system_images/logo/'.get_frontend_settings('dark_logo')); ?>" alt="...">
				</div>

				<div class="fileinput-preview fileinput-exists thumbnail w-200px"></div>
				<div>
					<span class="btn btn-white btn-file">							<span class="fileinput-new"><?php echo get_phrase('select_a_dark_logo'); ?></span>
						<span class="fileinput-exists"><?php echo get_phrase('change'); ?></span>
						<input type="file" id="class_thumbnail" name="dark_logo" accept="image/*">
					</span>
					<a href="#" class="btn btn-orange fileinput-exists" data-dismiss="fileinput"><?php echo get_phrase('remove'); ?></a>
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="fileinput fileinput-new float-left mr-10px" data-provides="fileinput">
				<div class="fileinput-new thumbnail" data-trigger="fileinput" style="width: 100%; height: 110px;">
					<img width="200px" src="<?php echo base_url('uploads/system_images/logo/'.get_frontend_settings('favicon')); ?>" alt="...">
				</div>

				<div class="fileinput-preview fileinput-exists thumbnail w-200px"></div>
				<div>
					<span class="btn btn-white btn-file">							<span class="fileinput-new"><?php echo get_phrase('select_a_favicon'); ?></span>
						<span class="fileinput-exists"><?php echo get_phrase('change'); ?></span>
						<input type="file" id="class_thumbnail" name="favicon" accept="image/*">
					</span>
					<a href="#" class="btn btn-orange fileinput-exists" data-dismiss="fileinput"><?php echo get_phrase('remove'); ?></a>
				</div>
			</div>
		</div>
		<div class="col-12">
			<button type="submit" class="btn btn-primary"><?php echo get_phrase('update_logo'); ?></button>
		</div>
	</div>
</form>