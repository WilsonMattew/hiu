<div class="container-fluid bg-body pb-12px">
	<div class="row">
		<div class="col-lg-4 card-shadow bg-white p-3">
			<img src="<?php echo get_class_banner($class_details['banner'], 'optimized'); ?>" alt="Class banner" width="100%">
			<h5 class="text-center mt-3"><?php echo $class_details['class_title']; ?></h5>
			<p class="text-16 text-center"><?php echo $class_details['short_description']; ?></p>
			<div class="class-status">
                <div class="class-status-duration ff-gt fw-bold">
                  <?php
                    $duration = duration_format($class_details['total_duration']);
                    if($duration['h'] > 0) echo $duration['h'].'h ';
                    if($duration['m'] > 0) echo $duration['m'].'m ';
                    if($duration['s'] > 0) echo $duration['s'].'s ';
                  ?>
                </div>
                <?php $total_wached_student = $this->frontend_model->get_total_watched_student($class_details['class_id']); ?>
                <?php if($total_wached_student): ?>
                  <span class="class-student-count ff-gt fw-bold"><?php echo $total_wached_student.' '.get_phrase('students'); ?></span>
                <?php endif; ?>
            </div>

			<?php
				$user_id = $this->session->userdata('user_id');
            	$class_owner = $this->crud_model->get_users($class_details['user_id'])->row_array();
            	$is_followed = $this->frontend_model->get_followers_by_follower_id($class_details['user_id'])->num_rows();
            ?>
            <div class="user-info-row w-100 py-3 border-top">
	            <div class="user-image">
	              <a href="<?php echo site_url('home/profile/'.$class_owner['user_id']) ?>"><img src="<?php echo get_user_image($class_owner['user_id']); ?>" alt="User image"></a>
	            </div>
	            <div class="name-title">
	              <h6>
	              	<a class="text-decoration-none mstr-color-blue ff-gt-pro" href="<?php echo site_url('home/profile/'.$class_owner['user_id']) ?>"><?php echo $class_owner['first_name'].' '.$class_owner['last_name']; ?></a>
	               . <a href="javascript:;" onclick="follow('<?php echo $class_owner['user_id']; ?>')" class="following_link <?php if($is_followed > 0){echo 'text-muted-8'; } ?>"><?php if($is_followed > 0){echo get_phrase('unfollow');}else{echo get_phrase('follow');} ?></a></h6>
	              <p><?php echo $class_owner['surname']; ?></p>
	            </div>
	            <div class="lead w-100 float-start mt-3 text-16">
	              <?php echo ellipsis($class_owner['about'], 300); ?>
	            </div>
	            <a href="<?php echo site_url('home/profile/'.$class_owner['user_id']) ?>" class="btn p-0 mt-3 fw-bold"><?php echo get_phrase('see_full_profile') ?></a>
	        </div>
		</div>
		<div class="col-lg-8">
			<h6 class="text-center py-2"><?php echo get_phrase('tell_us_what_you_think_about_this_class'); ?>!</h6>
			<form class="realtimeLeavReview" action="<?php echo site_url('classes/add_review?class_id='.$class_details['class_id']); ?>" method="post" enctype="multipart/form-data">
				<div class="w-100 bg-white mb-4 pb-4">
					<div class="row justify-content-center">
						<div class="col-md-5">
							<h6 class="w-100 pt-4 pb-3 text-center ff-gt-pro">
								<?php echo get_phrase('did_this_class_meet_your_expectations'); ?>?*
							</h6>
						</div>
					</div>
					<div class="row justify-content-center">
						<div class="col-xs-6 col-sm-6 col-md-2">
							<input value="0" type="radio" class="btn-check" name="expectation" id="not_really" autocomplete="off" required>
							<label class="btn btn-outline-primary w-100 rounded-3 mx-1 px-0 py-3 text-center ff-gt-pro text-13 border-0 card-shadow" for="not_really"><?php echo get_phrase('not_really'); ?></label>
						</div>
						<div class="col-xs-6 col-sm-6 col-md-2">
							<input value="1" type="radio" class="btn-check" name="expectation" id="somewhat" autocomplete="off" required>
							<label class="btn btn-outline-primary w-100 rounded-3 mx-1 px-0 py-3 text-center ff-gt-pro text-13 border-0 card-shadow" for="somewhat"><?php echo get_phrase('somewhat'); ?></label>
						</div>
						<div class="col-xs-6 col-sm-6 col-md-2">
							<input value="2" type="radio" class="btn-check" name="expectation" id="yes" autocomplete="off" required>
							<label class="btn btn-outline-primary w-100 rounded-3 mx-1 px-0 py-3 text-center ff-gt-pro text-13 border-0 card-shadow" for="yes"><?php echo get_phrase('yes'); ?></label>
						</div>
						<div class="col-xs-6 col-sm-6 col-md-2">
							<input value="3" type="radio" class="btn-check" name="expectation" id="exceeded" autocomplete="off" required>
							<label class="btn btn-outline-primary w-100 rounded-3 mx-1 px-0 py-3 text-center ff-gt-pro text-13 border-0 card-shadow" for="exceeded"><?php echo get_phrase('exceeded'); ?>!</label>
						</div>
					</div>
				</div>

				<div class="w-100 bg-white mb-4 pb-4">
					<div class="row justify-content-center">
						<div class="col-md-5">
							<h6 class="w-100 pt-4 pb-3 text-center ff-gt-pro">
								<?php echo get_phrase('what_level_of_experience_would_you_suggest_for_students_taking_this_class'); ?>?*
							</h6>
						</div>
					</div>
					<div class="row justify-content-center">
						<div class="col-xs-6 col-sm-6 col-md-2">
							<input value="beginner" type="radio" class="btn-check" name="level" id="beginner" autocomplete="off" required>
							<label class="btn btn-outline-primary w-100 rounded-3 mx-1 px-0 py-3 text-center ff-gt-pro text-13 border-0 card-shadow" for="beginner">
								<div class="skill-level-icon ms-auto me-auto mb-2">
									<span class="active"></span>
									<span class=""></span>
									<span class=""></span>
								</div>
								<?php echo get_phrase('beginner'); ?>
							</label>
						</div>
						<div class="col-xs-6 col-sm-6 col-md-2">
							<input value="intermediate" type="radio" class="btn-check" name="level" id="intermediate" autocomplete="off" required>
							<label class="btn btn-outline-primary w-100 rounded-3 mx-1 px-0 py-3 text-center ff-gt-pro text-13 border-0 card-shadow" for="intermediate">
								<div class="skill-level-icon ms-auto me-auto mb-2">
									<span class=""></span>
									<span class="active"></span>
									<span class=""></span>
								</div>
								<?php echo get_phrase('intermediate'); ?>
							</label>
						</div>
						<div class="col-xs-6 col-sm-6 col-md-2">
							<input value="advanced" type="radio" class="btn-check" name="level" id="advanced" autocomplete="off" required>
							<label class="btn btn-outline-primary w-100 rounded-3 mx-1 px-0 py-3 text-center ff-gt-pro text-13 border-0 card-shadow" for="advanced">
								<div class="skill-level-icon ms-auto me-auto mb-2">
									<span class=""></span>
									<span class=""></span>
									<span class="active"></span>
								</div>
								<?php echo get_phrase('advanced'); ?>
							</label>
						</div>
						<div class="col-xs-6 col-sm-6 col-md-2">
							<input value="all" type="radio" class="btn-check" name="level" id="any_level" autocomplete="off" required>
							<label class="btn btn-outline-primary w-100 rounded-3 mx-1 px-0 py-3 text-center ff-gt-pro text-13 border-0 card-shadow" for="any_level">
								<div class="skill-level-icon ms-auto me-auto mb-2">
									<span class="active"></span>
									<span class="active"></span>
									<span class="active"></span>
								</div>
								<?php echo get_phrase('any_level'); ?>
							</label>
						</div>
					</div>
				</div>

				<div class="w-100 bg-white mb-4 pb-4">
					<div class="row justify-content-center">
						<div class="col-md-5">
							<h6 class="w-100 pt-4 pb-3 text-center ff-gt-pro">
								<?php echo get_phrase('what_did_you_like_most_about_this_class'); ?>?*
							</h6>
						</div>
					</div>
					<div class="row justify-content-center">
						<?php $review_tags = $this->frontend_model->get_review_tags()->result_array(); ?>
						<?php foreach($review_tags as $review_tag): ?>
							<div class="col-auto">
								<input type="radio" value="<?php echo $review_tag['review_tag_id'] ?>" class="btn-check" name="review_tag_id" id="tag_<?php echo $review_tag['review_tag_id'] ?>" autocomplete="off" required>
								<label class="btn btn-outline-primary rounded-pill mx-1 py-2 px-3 text-center ff-gt-pro text-13 border-0 card-shadow" for="tag_<?php echo $review_tag['review_tag_id'] ?>">
									<?php echo $review_tag['review_tag_title'] ?>
								</label>
							</div>
						<?php endforeach; ?>
					</div>
				</div>

				<div class="w-100 bg-white mb-4 pb-4">
					<div class="row justify-content-center">
						<div class="col-md-5">
							<h6 class="w-100 pt-4 mb-0 text-center ff-gt-pro">
								<?php echo get_phrase('anything_else'); ?>?
							</h6>
							<p class="w-100 text-center text-12 mt-0"><?php echo get_phrase('write_a_public_review'); ?> (<?php echo get_phrase('optional'); ?>)</p>
							
						</div>
					</div>
					<div class="row justify-content-center">
						<div class="col-md-10">
							<textarea class="form-control" rows="4" name="comment"></textarea>
						</div>
					</div>
				</div>

				<div class="row my-4">
					<div class="col-md-12 text-center">
						<button type="submit" class="mstr-header-btn-pro"><?php echo get_phrase('submit_review'); ?></button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

<script type="text/javascript">
	//Ajax load
	"use strict";

	$(function() {
	    //Top progress & progress bar
	    var progress = '<div class="real-top-progress"><div class="real-top-progress-bar " role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div></div>';
	    
	    //The progress bar appended on the body.
	    $('body').append(progress);

	    //The progress bar inside the progress div has been taken in a variable.
	    var progress_bar = $('.real-top-progress-bar');

	    //The form of submission to RailTeam js is defined here.(Form class or ID)
	    $('.realtimeLeavReview').ajaxForm({
	        beforeSend: function() {
	            var percentVal = '0%';
	            progress_bar.width(percentVal);
	            progress_bar.show();
	        },
	        uploadProgress: function(event, position, total, percentComplete) {
	            var percentVal = percentComplete + '%';
	            progress_bar.width(percentVal);
	            
	        },
	        complete: function(xhr) {
	        	setTimeout(function(){
	                progress_bar.hide();
	            }, 800);

	        	var jsonResponse = JSON.parse(xhr.responseText);

	        	if(jsonResponse.status == 'error'){
	        		error_message(jsonResponse.message);
	        	}else{
		        	load_class_data('', jsonResponse.class_id, 'reviews', 'top_loader_off');
		        	$('.custom-modal').removeClass('custom-modal-show');
		        }
	        },
	        error: function()
	        {
	            //You can write here your js error message
	        }
	    });
	});
</script>