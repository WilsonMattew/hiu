<!--This page included in forgot or others page so, required the d-hidden in other pages-->
<div class="container <?php if($page_name != 'sign_in') echo 'd-hidden'; ?>" id="loginForm">
	<h3 class="text-center my-4 py-3"><?php echo get_phrase('sign_in_to_your_'.get_settings('system_title').'_account'); ?></h3>
	<div class="row justify-content-center mb-5">
		<div class="col-lg-4">
	        <div class="w-100 text-center pt-2">
				<form action="<?php echo site_url('signin/check_validity'); ?>" method="post">
					<div class="mb-3">
					  <input type="email" name="email" id="email" class="form-control py-2" placeholder="<?php echo get_phrase('email_address'); ?>" aria-label="<?php echo get_phrase('email_address'); ?>">
					</div>
					<div class="mb-3">
					  <input type="password" name="password" id="password" class="form-control py-2" placeholder="<?php echo get_phrase('password'); ?>" aria-label="<?php echo get_phrase('password'); ?>">
					</div>
					<div class="mb-3 w-100 float-start">
						<input name="remember_me" class="form-check-input float-start p-10px border border-secondary" type="checkbox" id="remember_me" value="1">
						<label class="form-check-label float-start text-13 fw-bold ps-2 mt-5px" for="remember_me"><?php echo get_phrase('remember_me'); ?></label>
					</div>

					<button type="submit" class="mstr-header-btn-free w-100 bg-green-muted" onclick="remember_my_data()"><?php echo get_phrase('sign_in'); ?></button>
				</form>
				<a href="javascript:;" id="content" onclick="show_element('#forgotPassForm', '#loginForm'), change_url('signin/forgot_password', '<?php echo get_phrase('forgot_password'); ?>')" class="fw-500 text-primary hover-ul float-start my-3"><?php echo get_phrase('forgot_password'); ?>?</a>

				<hr class="bg-dark w-100">

				<p class="text-12 fw-bold"><?php echo get_phrase('not_a_member_yet'); ?>? <a href="<?php echo site_url('signup'); ?>"><?php echo get_phrase('sign_up'); ?></a></p>
	        </div>
		</div>
	</div>
</div>
<?php if($page_name == 'sign_in') include "forgot_password.php"; ?>

<script type="text/javascript">
    'use strict';

    $(function(){
      if(localStorage.getItem('rememberMe') == 1){
        $('#remember_me').attr('checked', true);
        $('#email').val(localStorage.getItem('myEmail'));
        $('#password').val(localStorage.getItem('myPassword'));
      }
    });

    function remember_my_data(){
      if($('#remember_me').prop('checked') == true){
        // Store data
        localStorage.setItem('rememberMe', 1);
        localStorage.setItem('myEmail', $('#email').val());
        localStorage.setItem('myPassword', $('#password').val());
      }else{
        // Remove data
        localStorage.removeItem('rememberMe');
        localStorage.removeItem('myEmail');
        localStorage.removeItem('MyPassword');
      }
    }
  </script>
