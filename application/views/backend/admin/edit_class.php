<form class="realtime-form mt-15px" action="<?php echo site_url('admin/update_class/'.$class_details['class_id']); ?>" method="post" enctype="multipart/form-data">
	<div class="row mb-15px">
		<label for="class_title" class="col-sm-3 control-label text-right pt-5px"><?php echo get_phrase('class_title'); ?>*</label>
		<div class="col-sm-7">
			<input type="text" class="form-control" name="class_title" id="class_title" value="<?php echo $class_details['class_title']; ?>" placeholder="<?php echo get_phrase('class_title'); ?>" required>
		</div>
	</div>

	<div class="row mb-15px">
		<label for="category" class="col-sm-3 control-label text-right pt-5px"><?php echo get_phrase('category'); ?>*</label>
		<div class="col-sm-7">
			<?php $parent_categories = $this->crud_model->get_parent_categories()->result_array(); ?>
			<select class="form-control select2" name="category" required>
				<option value=""><?php echo get_phrase('select_a_category'); ?></option>
				<?php foreach($parent_categories as $parent_category): ?>
					<optgroup label="<?php echo $parent_category['title']; ?>">
					<?php $categories = $this->crud_model->get_sub_categories($parent_category['category_id'])->result_array(); ?>
						<?php foreach($categories as $category): ?>
							<option value="<?php echo $category['category_id']; ?>" <?php if($class_details['category_id'] == $category['category_id'])echo 'selected'; ?>>
								<?php echo $category['title']; ?>
							</option>
						<?php endforeach; ?>
					</optgroup>
				<?php endforeach; ?>
			</select>
		</div>
	</div>

	<div class="row mb-15px">
		<label for="level" class="col-sm-3 control-label text-right pt-5px"><?php echo get_phrase('level'); ?>*</label>
		<div class="col-sm-7">
			<select class="form-control select2" name="level" required>
				<option value=""><?php echo get_phrase('select_a_level'); ?></option>
				<option value="all" <?php if($class_details['level'] == 'all')echo 'selected'; ?>><?php echo get_phrase('all_levels'); ?></option>
				<option value="beginner" <?php if($class_details['level'] == 'beginner')echo 'selected'; ?>><?php echo get_phrase('beginner'); ?></option>
				<option value="intermediate" <?php if($class_details['level'] == 'intermediate')echo 'selected'; ?>><?php echo get_phrase('intermediate'); ?></option>
				<option value="advanced" <?php if($class_details['level'] == 'advanced')echo 'selected'; ?>><?php echo get_phrase('advanced'); ?></option>
			</select>
		</div>
	</div>

	<div class="row mb-15px">
		<label for="skills" class="col-sm-3 control-label text-right pt-5px"><?php echo get_phrase('skills'); ?>*</label>
		<div class="col-sm-7">
			<select class="form-control select2" id="skills" multiple name="skills[]" required>
				<?php
				$skills	=	$this->crud_model->get_skills()->result_array();
				foreach ($skills as $skill):?>
					<?php $is_selected = $this->crud_model->get_selected_skills($skill['skill_id'], $class_details['class_id'])->num_rows(); ?>
					<option value="<?php echo $skill['skill_id'];?>" <?php if($is_selected > 0)echo 'selected'; ?>>
						<?php echo $skill['skill_title'];?>
					</option>
				<?php endforeach;?>
			</select>
		</div>
	</div>

	<div class="row mb-15px">
		<label for="long_description" class="col-sm-3 control-label text-right pt-5px">
			<?php echo get_phrase('highlight_this_class'); ?>
		</label>
		<div class="col-sm-7">
			<input type="checkbox" name="is_free" value="1" id="is_free" <?php if($class_details['is_free'] == 1)echo 'checked'; ?>>
			<label for="is_free">
				<?php echo get_phrase('this_is_a_free_class'); ?>
				<i class="fa fa-info-circle" title="<?php echo get_phrase('if_you_add_the_class_for_free,_all_the_lessons_will_be_considered_free'); ?>." data-toggle="tooltip"></i>
			</label>
			<br>
			<input type="checkbox" name="is_featured" value="1" id="featured" <?php if($class_details['is_featured'] == 1)echo 'checked'; ?>>
			<label for="featured"><?php echo get_phrase('mark_as_featured'); ?></label>
			<br>
			<input type="checkbox" name="is_recommended" value="1" id="recommended" <?php if($class_details['is_recommended'] == 1)echo 'checked'; ?>>
			<label for="recommended"><?php echo get_phrase('recommended_class'); ?></label>.
			<br>
			<input type="checkbox" name="is_slider" value="1" id="is_slider" <?php if($class_details['is_slider'] == 1)echo 'checked'; ?>>
			<label for="is_slider"><?php echo get_phrase('add_this_course_to_the_home_page_slider'); ?></label>
		</div>
	</div>

	<div class="row mb-15px">
		<label for="thumbnail" class="col-sm-3 control-label text-right pt-5px">
			<?php echo get_phrase('thumbnail'); ?>
			<span class="text-muted text-9">(520 X 300)</span>
		</label>
		<div class="col-sm-7">
			<div class="fileinput fileinput-new float-left mr-10px" data-provides="fileinput">
				<div class="fileinput-new thumbnail" data-trigger="fileinput">
					<img width="200px" src="<?php echo get_class_thumbnail($class_details['class_thumbnail'], 'optimized'); ?>" alt="thumbnail">
				</div>

				<div class="fileinput-preview fileinput-exists thumbnail w-200px"></div>
				<div>
					<span class="btn btn-white btn-file">							<span class="fileinput-new"><?php echo get_phrase('select_a_class_thumbnail'); ?></span>
						<span class="fileinput-exists"><?php echo get_phrase('change'); ?></span>
						<input type="file" id="class_thumbnail" name="class_thumbnail" accept="image/*">
					</span>
					<a href="#" class="btn btn-orange fileinput-exists" data-dismiss="fileinput"><?php echo get_phrase('remove'); ?></a>
				</div>
			</div>
		</div>
	</div>

	<div class="row mb-15px">
		<label for="thumbnail" class="col-sm-3 control-label text-right pt-5px">
			<?php echo get_phrase('banner'); ?>
			<span class="text-muted text-9">(2600 X 800)</span>
		</label>
		<div class="col-sm-7">
			<div class="fileinput fileinput-new" data-provides="fileinput">
				<div class="fileinput-new thumbnail" data-trigger="fileinput">
					<img width="372px" src="<?php echo get_class_banner($class_details['banner'], 'optimized'); ?>" alt="banner">
				</div>
				<div class="fileinput-preview fileinput-exists thumbnail w-372px"></div>
				<div>
					<span class="btn btn-white btn-file">
						<span class="fileinput-new"><?php echo get_phrase('select_a_class_banner'); ?></span>
						<span class="fileinput-exists"><?php echo get_phrase('change'); ?></span>
						<input type="file" id="banner" name="banner" accept="image/*">
					</span>
					<a href="#" class="btn btn-orange fileinput-exists" data-dismiss="fileinput"><?php echo get_phrase('remove'); ?></a>
				</div>
			</div>
		</div>
	</div>

	<div class="row mb-15px">
		<label for="short_description" class="col-sm-3 control-label text-right pt-5px"><?php echo get_phrase('short_description'); ?></label>
		<div class="col-sm-7">
			<textarea class="form-control" rows="3" id="short_description" name="short_description"><?php echo $class_details['short_description']; ?></textarea>
		</div>
	</div>

	<div class="row mb-15px">
		<label for="long_description" class="col-sm-3 control-label text-right pt-5px"><?php echo get_phrase('long_description'); ?></label>
		<div class="col-sm-7">
			<textarea class="form-control" id="common_editor" rows="4" name="long_description"><?php echo remove_js(htmlspecialchars_decode($class_details['description'])); ?></textarea>
		</div>
	</div>
	
	<div class="row">
		<div class="col-sm-3"></div>
		<div class="col-sm-7">
			<button type="submit" class="btn btn-primary float-right">
				<?php echo get_phrase('save_changes'); ?>
			</button>
		</div>
	</div>
</form>