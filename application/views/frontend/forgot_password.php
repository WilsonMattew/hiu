<!--This page included in login page so, required the d-hidden in other pages-->
<div class="container <?php if($page_name != 'forgot_password') echo 'd-hidden'; ?>" id="forgotPassForm">
	<div class="row justify-content-center my-5">
		<div class="col-lg-4">
			<p class="text-center fw-500"><?php echo get_phrase("We'll_send_password_reset_instructions_to_the_email_address_associated_with_your_account"); ?>.</p>
	        <div class="w-100 text-center pt-2">
				<form action="<?php echo site_url('signin/send_forgot_password_mail'); ?>" method="post">
					<div class="mb-3">
					  <input type="email" name="email" class="form-control" placeholder="<?php echo get_phrase('email_address'); ?>" aria-label="<?php echo get_phrase('email_address'); ?>" required>
					</div>
					<button type="submit" class="mstr-header-btn-pro w-100 bg-green-muted"><?php echo get_phrase('reset_password'); ?></button>
				</form>
				<a href="javascript:;" onclick="show_element('#loginForm', '#forgotPassForm'), change_url('signin', '<?php echo get_phrase('sign_in'); ?>')" class="fw-500 text-primary hover-ul float-start my-3"><?php echo get_phrase('sign_in'); ?></a>
				<hr class="bg-dark w-100">

				<p class="text-12 fw-bold"><?php echo get_phrase('not_a_member_yet'); ?>? <a href="<?php echo site_url('signup'); ?>"><?php echo get_phrase('sign_up'); ?></a></p>
	        </div>
		</div>
	</div>
</div>
<?php if($page_name == 'forgot_password') include "sign_in.php"; ?>
