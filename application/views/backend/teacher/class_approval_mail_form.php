<form action="<?php echo site_url('teacher/class_approval/'.$class_id); ?>" method="post">
	<div class="form-group">
		<label><?php echo get_phrase('write_your_message'); ?></label>
		<textarea class="form-control" name="message" rows="5"></textarea>
	</div>

	<div class="form-group">
		<button type="submit" class="btn btn-primary"><?php echo get_phrase('submit'); ?></button>
	</div>
</form>