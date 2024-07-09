<div class="container pt-3">
	<div class="row justify-content-center flex-lg-nowrap">
		<div class="col-md-5 col-lg-4 col-xl-3 mb-3">
			<div class="card p-3">
				<div class="row mt-3">
					<div class="col-12">
						<div class="d-flex justify-content-center align-items-center rounded text-center">
							<img class="rounded" width="110px" height="110px" src="<?php echo get_user_image($user_details['user_id']); ?>" alt="User image">
						</div>
					</div>
					<div class="col-12">
						<div class="text-center text-sm-left mb-2 mb-sm-0">
							<h5 class="pt-sm-2 pb-1 mb-0 text-nowrap">
							<?php echo $user_details['first_name'].' '.$user_details['last_name']; ?>
							</h5>
							<p class="mb-0"><?php echo $user_details['surname']; ?></p>
							<div class="mt-2">
								<form class="realtime-form" action="<?php echo site_url('user/upload_profile_image'); ?>" method="post" enctype="multipart/form-data">
									<input name="user_image" type="file" onchange="$('#image_name').text(getUpImg(this)), $('#proImgSubmitBtn').show()" id="user_image" class="d-hidden">
									<label for="user_image" class="btn bg-body btn-sm">
										<i class="bi bi-camera-fill"></i>
										<span id="image_name" class="text-12"><?php echo get_phrase('Change_photo'); ?></span>
									</label>
									<button type="submit" id="proImgSubmitBtn" class="btn btn-secondary btn-sm d-hidden text-12"><i class="bi bi-cloud-upload-fill"></i> <?php echo get_phrase('upload'); ?></button>
								</form>
							</div>
						</div>
					</div>
				</div>
				<hr>
				<div class="e-navlist e-navlist--active-bg">
					<ul class="nav">

						<li class="nav-item w-100 mt-3">
							<a class="nav-link rounded px-2 <?php if($type == 'invoice' || is_numeric($type))echo 'bg-primary text-white ff-gt-pro'; ?>" href="<?php echo site_url('user/account/'.$user_details['user_id']); ?>">
								<i class="bi bi-file-person p-2"></i>
								<span><?php echo get_phrase('account') ?></span>
							</a>
						</li>

						<li class="nav-item w-100 mt-3">
							<a class="nav-link rounded px-2 <?php if($type == 'profile_edit')echo 'bg-primary text-white ff-gt-pro'; ?>" href="<?php echo site_url('user/account/profile_edit/'.$user_details['user_id']); ?>">
								<i class="bi bi-pencil-square p-2"></i>
								<span><?php echo get_phrase('edit_profile') ?></span>
							</a>
						</li>

						<li class="nav-item w-100 mt-3">
							<a class="nav-link rounded px-2 <?php if($type == 'social')echo 'bg-primary text-white ff-gt-pro'; ?>" href="<?php echo site_url('user/account/social/'.$user_details['user_id']); ?>">
								<i class="bi bi-globe2 p-2"></i>
								<span><?php echo get_phrase('social') ?></span>
							</a>
						</li>

						<li class="nav-item w-100 mt-3">
							<a class="nav-link rounded px-2 <?php if($type == 'change_password')echo 'bg-primary text-white ff-gt-pro'; ?>" href="<?php echo site_url('user/account/change_password/'.$user_details['user_id']); ?>">
								<i class="bi bi-key p-2"></i>
								<span><?php echo get_phrase('change_password') ?></span>
							</a>
						</li>
					</ul>
				</div>
			</div>
		</div>

		<div class="col-md-7 col-lg-8 col-xl-8 mb-3">
			<div class="card">
				<div class="card-body">
					<div class="e-profile">
						<div class="row">
							<div class="col-md-6">
								<div class="">
									<h4 class="mt-2 mb-0">
										<i class="bi bi-arrow-right-circle-fill"></i>
										
										<?php
											if($type == "profile_edit"){
												echo get_phrase('edit_profile');
											}elseif($type == 'social'){
												echo get_phrase('social_links');
											}elseif($type == 'change_password'){
												echo get_phrase('change_password');
											}elseif($type == 'invoice'){
												echo get_phrase('invoice');
											}else{
												echo get_phrase('subscriptions');
											}
										?>
									</h4>
								</div>
							</div>
							<div class="col-md-6">
								<div class="text-end">
									<div class="text-muted"><small><?php echo get_phrase('joined'); ?>, <?php echo date('d M Y', $user_details['date_added']); ?></small></div>
									<?php echo $user_details['email']; ?>
								</div>
							</div>
						</div>

						<hr>

						<div class="tab-content pt-3">
							<?php
								if($type == "profile_edit"){
									include "profile_edit.php";
								}elseif($type == 'social'){
									include "profile_social_edit.php";
								}elseif($type == 'change_password'){
									include 'profile_change_password.php';
								}elseif($type == 'invoice'){
									include "invoice.php";
								}else{
									include "profile_account.php";
								}
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>