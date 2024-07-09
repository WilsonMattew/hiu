<a href="<?php echo site_url('teacher/classes'); ?>" class="btn btn-primary alignToTitle"><i class="fa fa-reply"></i> <?php echo get_phrase('back_to_list'); ?></a>

<div class="panel panel-primary" data-collapsed="0">
	<div class="panel-heading">
		<div class="panel-title">
			<?php echo get_phrase('add_a_new_class'); ?>
		</div>
	</div>
	<div class="panel-body">
		<form class="realtime-form" action="<?php echo site_url('teacher/add_class/added'); ?>" method="post" enctype="multipart/form-data">
			<div class="row mb-15px">
				<label for="class_title" class="col-sm-3 control-label text-right pt-5px"><?php echo get_phrase('class_title'); ?>*</label>
				<div class="col-sm-7">
					<input type="text" class="form-control" name="class_title" id="class_title" placeholder="<?php echo get_phrase('class_title'); ?>" required>
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
									<option value="<?php echo $category['category_id']; ?>"><?php echo $category['title']; ?></option>
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
						<option value="all"><?php echo get_phrase('all_levels'); ?></option>
						<option value="beginner"><?php echo get_phrase('beginner'); ?></option>
						<option value="intermediate"><?php echo get_phrase('intermediate'); ?></option>
						<option value="advanced"><?php echo get_phrase('advanced'); ?></option>
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
							<option value="<?php echo $skill['skill_id'];?>">
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
					<input type="checkbox" name="is_free" value="1" id="is_free">
					<label for="is_free">
						<?php echo get_phrase('this_is_a_free_class'); ?>
						<i class="fa fa-info-circle" title="<?php echo get_phrase('if_you_add_the_class_for_free,_all_the_lessons_will_be_considered_free'); ?>." data-toggle="tooltip"></i>
					</label>
					<br>
					<input type="checkbox" name="is_featured" value="1" id="featured">
					<label for="featured"><?php echo get_phrase('mark_as_featured'); ?></label>
					<br>
					<input type="checkbox" name="is_recommended" value="1" id="recommended">
					<label for="recommended"><?php echo get_phrase('recommended_class'); ?></label>.
					<br>
					<input type="checkbox" name="is_slider" value="1" id="is_slider">
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
							<img width="200px" src="<?php echo base_url('uploads/classes/thumbnail/thumbnail.png'); ?>" alt="...">
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
							<img width="372px" src="<?php echo base_url('uploads/classes/banner/thumbnail.png'); ?>" alt="...">
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
					<textarea class="form-control" rows="3" id="short_description" name="short_description"></textarea>
				</div>
			</div>

			<div class="row mb-15px">
				<label for="long_description" class="col-sm-3 control-label text-right pt-5px"><?php echo get_phrase('long_description'); ?></label>
				<div class="col-sm-7">
					<textarea class="form-control" id="common_editor" rows="4" name="long_description"></textarea>
				</div>
			</div>
			
			<div class="row">
				<div class="col-sm-3"></div>
				<div class="col-sm-7">
					<button type="submit" class="btn btn-primary float-right">
						<?php echo get_phrase('save_and_next'); ?>
						<i class="fa fa-arrow-right"></i>
					</button>
				</div>
			</div>
		</form>
	</div>
</div>