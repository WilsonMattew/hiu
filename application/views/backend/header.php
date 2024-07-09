<div class="row hidden-print" style="margin-left:0px; margin-right:0px;">

	<div class="col-md-12 col-sm-12 clearfix " style="background-color:#ffffff; box-shadow: 0px 10px 30px 0px rgba(82,63,105,0.08); border-radius: 5px;">
		<ul class="list-inline links-list pull-left" style="padding-top: 16px !important; padding-bottom: 6px !important;">
			<li>
				<a href="<?php echo site_url();?>" target="_blank">
					<i class="entypo-paper-plane"></i> <?php echo get_phrase('website'); ?>
				</a>
			</li>
		</ul>


		<!-- Profile Info -->
		<ul class="user-info pull-right pull-none-xsm" style="margin-top: 6px;">
			<li class="profile-info dropdown pull-right">

				<a href="#" class="dropdown-toggle" data-toggle="dropdown">
					<img src="<?php echo get_user_image(); ?>" alt="" class="img-circle" width="44">
					<?php echo $user_name; ?>
					<br>
					<span class="text-11" style="display:block; margin-top: -15px; margin-bottom: 5px;">(<?php echo $user_role;?>)</span>
				</a>

				<ul class="dropdown-menu">

					<!-- Reverse Caret -->
					<li class="caret"></li>

					<!-- Settings sub-links -->
					<?php if (login_type('admin')): ?>
						<li>
							<a href="<?php echo site_url('admin/system_settings'); ?>" class="dropdown-item notify-item">
			                  <i class="flaticon-rotate"></i>
			                  <span><?php echo get_phrase('settings'); ?></span>
			            	</a>
						</li>
 					<?php endif; ?>

					<!-- Profile sub-links -->
					<li>
						<a href="<?php echo site_url(strtolower($this->session->userdata('user_role')).'/profile');?>">
							<i class="flaticon-rotate"></i>
							<?php echo get_phrase('edit_profile');?>
						</a>
					</li>

					<li>
						<a href="<?php echo site_url(strtolower($this->session->userdata('user_role')).'/change_password');?>">
							<i class="flaticon-lock"></i>
							<?php echo get_phrase('change_password');?>
						</a>
					</li>

					<li>
						<a href="<?php echo site_url('signin/sign_out');?>">
							<i class="flaticon-paper-plane-1"></i>
							<?php echo get_phrase('sign_out');?>
						</a>
					</li>

				</ul>
			</li>

		</ul>
	</div>

</div>

<hr style="margin-top:0px;" />
