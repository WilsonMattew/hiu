<form action="<?php echo site_url('admin/website_settings/home_page_blogs/updated'); ?>" method="post" enctype="multipart/form-data">
	<?php $home_page_bologes = json_decode(get_frontend_settings('home_page_blogs')); ?>
		<h4 class="mb-15px"><b><?php echo get_phrase('update_the_home_page_blogs'); ?></b></h4>
	<?php foreach($home_page_bologes as $blog): ?>
		<div class="row mb-15px mt-15px">
			<div class="col-md-8">
				<div class="form-group mb-15px">
					<label><b><?php echo get_phrase('title'); ?>*</b></label>
					<input type="text" value="<?php echo $blog->title; ?>" name="title[]" class="form-control" required>
				</div>
				<textarea name="description[]" class="common_editor"><?php echo $blog->description; ?></textarea>
			</div>
			<div class="col-md-4">
				<label><b><?php echo get_phrase('image'); ?>*</b></label>
				<div class="fileinput fileinput-new float-left mr-10px" data-provides="fileinput">
					<div class="fileinput-new thumbnail" data-trigger="fileinput">
						<img width="200px" src="<?php echo site_url('uploads/home_page_images/'.$blog->image); ?>" alt="...">
					</div>

					<div class="fileinput-preview fileinput-exists thumbnail w-200px"></div>
					<div>
						<span class="btn btn-white btn-file">							<span class="fileinput-new"><?php echo get_phrase('select_image'); ?></span>
							<span class="fileinput-exists"><?php echo get_phrase('change'); ?></span>
							<input type="file" name="image[]" accept="image/*">
							<input type="hidden" name="previous_image[]" value="<?php echo $blog->image; ?>">
						</span>
						<a href="#" class="btn btn-orange fileinput-exists" data-dismiss="fileinput"><?php echo get_phrase('remove'); ?></a>
					</div>
				</div>
			</div>
		</div>
		<hr>
	<?php endforeach; ?>

	<button type="submit" class="btn btn-primary"><?php echo get_phrase('save_changes'); ?></button>

</form>