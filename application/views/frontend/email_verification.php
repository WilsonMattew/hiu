<div class="container">
	<div class="row justify-content-center my-5">
		<div class="col-lg-4">
			<p class="text-center fw-500"><?php echo get_phrase('let_us_know_that_this_email_address_belongs_to_you'); ?>. <?php echo get_phrase('enter_the_code_from_the_email_sent_to').' <b>'.$this->session->userdata('verify_email'); ?></b>.</p>
	        <div class="w-100 text-center pt-2">
				<form action="<?php echo site_url('signup/email_verification'); ?>" method="post">
					<div class="">
					  <input type="text" name="verification_code" class="form-control" placeholder="<?php echo get_phrase('enter_your_verification_code'); ?>"required>
					</div>
					<a href="javascript:;" onclick="send_verification_code()" class="float-start text-decoration-none">
						<?php echo get_phrase('resend_mail'); ?>
						<img class="d-hidden mail-sending-preloader" src="<?= base_url('assets/global/gif/preloader2.gif'); ?>"  width="20px">
					</a>
					<button type="submit" class="mstr-header-btn-pro w-100 bg-green-muted mt-3"><?php echo get_phrase('submit'); ?></button>
				</form>

				<hr class="bg-dark w-100">

				<p class="text-12 fw-bold"><?php echo get_phrase('not_a_member_yet'); ?>? <a href="<?php echo site_url('signup'); ?>"><?php echo get_phrase('sign_up'); ?></a></p>
	        </div>
		</div>
	</div>
</div>