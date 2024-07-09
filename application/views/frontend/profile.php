<div class="container pt-5">
	<div class="row justify-content-center">
		<div class="col-md-4 col-lg-3 text-center">
			<img class="rounded-circle" width="130px" height="130px" src="<?php echo get_user_image($user_details['user_id']); ?>" alt="User image">

			<h4 class="mt-3 fw-normal fw-500"><?php echo $user_details['first_name'].' '.$user_details['last_name']; ?></h4>
			<p class="ff-normal text-14"><?php echo $user_details['surname']; ?></p>
			
			<?php $is_followed = $this->frontend_model->get_followers_by_follower_id($user_details['user_id'])->num_rows(); ?>

			<?php if($user_id == $user_details['user_id']): ?>
				<a href="<?php echo site_url('user/account/profile_edit/'.$user_id); ?>" class="btn mstr-header-btn-free px-4 mt-3"><?php echo get_phrase('edit_profile'); ?></a>
			<?php else: ?>
				<a href="javascript:;" onclick="follow2(this, '.followBTN', '<?php echo $user_details['user_id']; ?>')" class="followingBTN btn btn-primary rounded-pill border-primary fw-500 py-1 px-4 <?php if(!$is_followed) echo 'd-hidden'; ?>">
					<?php echo get_phrase('following'); ?>
				</a>

				<a href="javascript:;" onclick="follow2(this, '.followingBTN', '<?php echo $user_details['user_id']; ?>')" class="followBTN btn btn-outline-primary rounded-pill border border-2 border-primary fw-500 py-1 px-4 <?php if($is_followed > 0) echo 'd-hidden'; ?>">
					<i class="bi bi-plus text-18"></i>
					<?php echo get_phrase('follow'); ?>
				</a>
			<?php endif; ?>

			<div class="row justify-content-center mt-4">
				<div class="col-4">
					<a href="javascript:;" onclick="showAjaxModal('<?php echo site_url('user/followers?user_id='.$user_details['user_id']); ?>')" class="text-decoration-none mstr-color-blue">
						<h4><?php echo $this->frontend_model->number_of_followers($user_details['user_id']); ?></h4>
						<p class="ff-gt-pro"><?php echo get_phrase('followers'); ?></p>
					</a>
				</div>
				<div class="col-4">
					<a href="javascript:;" onclick="showAjaxModal('<?php echo site_url('user/following?user_id='.$user_details['user_id']); ?>')" class="text-decoration-none mstr-color-blue">
						<h4><?php echo $this->frontend_model->number_of_following($user_details['user_id']); ?></h4>
						<p class="ff-gt-pro"><?php echo get_phrase('following'); ?></p>
					</a>
				</div>
			</div>
			<hr class="bg-secondary mb-3 mt-1 mx-5">
			<div class="row mb-4">
				<div class="col-12">
					<?php $socials = json_decode($user_details['social']); ?>
					<?php if($socials->facebook): ?>
						<a class="p-2" target="_blank" href="<?php echo $socials->facebook; ?>" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo get_phrase('facebook'); ?>"><i class="bi bi-facebook"></i></a>
					<?php endif; ?>

					<?php if($socials->twitter): ?>
						<a class="p-2" target="_blank" href="<?php echo $socials->twitter; ?>" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo get_phrase('twitter'); ?>"><i class="bi bi-twitter"></i></a>
					<?php endif; ?>

					<?php if($socials->linkedin): ?>
						<a class="p-2" target="_blank" href="<?php echo $socials->linkedin; ?>" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo get_phrase('linkedin'); ?>"><i class="bi bi-linkedin"></i></a>
					<?php endif; ?>

					<?php if($socials->website): ?>
						<a class="p-2" target="_blank" href="<?php echo $socials->website; ?>" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo get_phrase('website'); ?>"><i class="bi bi-globe"></i></a>
					<?php endif; ?>
				</div>
			</div>
		</div>



		<div class="col-md-8 col-lg-8">
	        <?php echo remove_js(htmlspecialchars_decode($user_details['about'])); ?>

	        <?php if($user_details['role'] != 'student'): ?>
		        <hr class="bg-secondary my-4">

		        <?php $user_classes = $this->frontend_model->get_classes_by_user_id($user_details['user_id']); ?>
		     	<div class="row">
		     		<div class="col-8">
		     			<h3><?php echo get_phrase('classes'); ?></h3>
		     		</div>
		     		<div class="col-4">
		     			<span class="float-end mt-2"><?php echo get_phrase('total').' <b>'.$user_classes->num_rows().'</b> '.get_phrase('classes'); ?></span>
		     		</div>

		     		<div class="col-12">
		     			<div class="row">
		     				<?php foreach($user_classes->result_array() as $user_classe):
		     					$is_saved_class = $this->frontend_model->saved_class_by_class_id($user_classe['class_id'])->num_rows(); ?>
			     				<div class="col-md-6 col-lg-4 pb-3">
						<div class="class-card">
				          <div class="thumbnail-label-gradient"></div>
				          <div role="img" aria-label="Mastery label" class="class-thumbnail-label">
					          <?php if($user_classe['is_featured'] == 1){ ?>
					            <span class="rounded-pill mstr-bg-blue ff-gt-pro text-uppercase text-10 px-3 py-1"><?php echo get_phrase('featured'); ?></span>
					          <?php } ?>
					        </div>
				          <a class="class-card-thumbnail" href="<?php echo site_url('classes/'.slugify($user_classe['class_title']).'/'.$user_classe['class_id']); ?>" aria-label="Mastery class">
				            <div class="class-card-thumbnail-img">
				                <img width="458" src="<?php echo get_class_thumbnail($user_classe['class_thumbnail'], 'optimized'); ?>" alt="class image" loading="lazy">
				                <div class="class-play-button"><i class="bi bi-play-circle-fill"></i></div>
				            </div>
				          </a>

				          <div>
				            <div class="p-12px">
				              <div class="class-status">
				                <div class="class-status-duration ff-poppins fw-bold text-12">
				                  <?php
				                    $duration = duration_format($user_classe['total_duration']);
				                    if($duration['h'] > 0) echo $duration['h'].'h ';
				                    if($duration['m'] > 0) echo $duration['m'].'m ';
				                    if($duration['s'] > 0) echo $duration['s'].'s ';
				                  ?>
				                </div>
				                <?php $total_wached_student = $this->frontend_model->get_total_watched_student($user_classe['class_id']); ?>
				                <?php if($total_wached_student): ?>
				                  <span class="class-student-count ff-poppins fw-bold text-12"><?php echo $total_wached_student.' '.get_phrase('students'); ?></span>
				                <?php endif; ?>
				              </div>

				              <div>
				                <p class="class-card-title">
				                  <a href="<?php echo site_url('classes/'.slugify($user_classe['class_title']).'/'.$user_classe['class_id']); ?>" class="text-decoration-none mstr-color-blue fw-bold text-18 ff-poppins"><?php echo $user_classe['class_title']; ?></a>
				                </p>
				              </div>

				              <div class="class-card-placeholder">
				                <div class="class-card-teacher-placeholder">
				                  <?php $class_owner = $this->crud_model->get_users($user_classe['user_id'])->row_array(); ?>
				                  <div class="mt-4">
				                    <p class="class-card-teacher-name">
				                      <a href="<?php echo site_url('home/profile/'.$class_owner['user_id']); ?>" class="mstr-color-blue text-decoration-none ff-normal fw-bold text-14" title="<?php if($class_owner['role'] == 'admin') {echo get_phrase('admin');}else{echo get_phrase('instructor');} ?>"><?php echo $class_owner['first_name'].' '.$class_owner['last_name']; ?></a>
				                    </p>
				                  </div>
				                </div>

				                <div class="wishlist-button-container">
				                  <a href="javascript:;" id="addFeatured<? echo $user_classe['class_id']; ?>" onclick="bookMark('add', '<? echo $user_classe['class_id']; ?>', 'Featured')" class="text-muted-4 text-20 mstr-hover-dark <?php if($is_saved_class) echo 'd-hidden'; ?>" title="<?php echo get_phrase('save'); ?>"><i class="bi bi-bookmark-plus"></i></a>

				                  <a href="javascript:;" id="removeFeatured<? echo $user_classe['class_id']; ?>" onclick="bookMark('remove', '<? echo $user_classe['class_id']; ?>', 'Featured')" class="text-muted-4 text-20 mstr-hover-dark <?php if(!$is_saved_class) echo 'd-hidden'; ?>" title="<?php echo get_phrase('remove_from_saved_classes'); ?>"><i class="bi bi-bookmark-check-fill text-success"></i></a>
				                </div>
				              </div>
				            </div>
				          </div>
				        </div>
			     				</div>
			     			<?php endforeach; ?>
		     			</div>
		     		</div>
		     	</div>

		     <?php endif; ?>
		</div>
	</div>
</div>