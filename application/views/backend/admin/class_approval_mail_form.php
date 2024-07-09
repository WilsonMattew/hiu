<form action="<?php echo site_url('admin/class_approval/'.$type.'/'.$notification['notification_id']); ?>" method="post">
	<div class="form-group">
		<label><?php echo get_phrase('write_your_message'); ?></label>
		<textarea class="form-control" name="message" rows="5"></textarea>
	</div>
<!-- 
	<div class="form-group">
		<input type="checkbox" name="send_mail" value="1" id="send_mail">
		<label for="send_mail"><?php echo get_phrase('check_here_to_send_a_mail'); ?></label>
	</div> -->

	<div class="form-group">
		<button type="submit" class="btn btn-primary"><?php echo get_phrase('submit'); ?></button>
	</div>
</form>