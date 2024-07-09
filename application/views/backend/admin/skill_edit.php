<form action="<?php echo site_url('admin/skills/updated/'.$skill['skill_id']); ?>" method="post" enctype="multipart/form-data">
	<div class="row mb-15px">
		<label for="skill_title" class="col-sm-3 control-label text-right pt-5px"><?php echo get_phrase('skill_title'); ?>*</label>
		<div class="col-sm-7">
			<input type="text" value="<?php echo $skill['skill_title'] ?>" class="form-control" name="skill_name" id="skill_title" placeholder="<?php echo get_phrase('enter_your_skill_title'); ?>" required>
		</div>
	</div>

	<div class="row mb-15px">
		<label class="col-sm-3 control-label text-right pt-5px"></label>
		<div class="col-sm-7">
			<button class="btn btn-primary" type="submit"><?php echo get_phrase('update_skill'); ?></button>
		</div>
	</div>
</form>