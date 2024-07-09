<?php $user_id = $this->session->userdata('user_id'); ?>
<section class="bg-white py-4">
	<?php if(subscription_status()): ?>
		<div class="container">
			<form class="realtimeLoadDiscussion" action="<?php echo site_url('classes/add_discussion'); ?>" method="post" enctype="multipart/form-data" >
				<div class="row justify-content-center">
					<div class="col-lg-10 p-3">
						<input type="hidden" name="parent_id" value="0">
						<input type="hidden" name="class_id" value="<?php echo $class_details['class_id']; ?>">
						<textarea class="form-control" name="discussion" rows="4"></textarea>
						<button type="submit" class="mstr-header-btn-free float-end mt-3"><?php echo get_phrase('post'); ?></button>
					</div>
				</div>
			</form>
		</div>
	<?php endif; ?>

	<div class="container px-32px" id="appendParentDiscussion">
		<?php foreach($discussions->result_array() as $key => $discussion): ?>
			<div class="row py-3 justify-content-center" id="parent_discussion_element_<?php echo $discussion['discussion_id']; ?>">
				<div class="col-lg-10 bg-body py-3">
					<div class="user-info-row w-100">
						<div class="user-image">
							<a href="<?php echo site_url('home/profile/'.$discussion['user_id']) ?>">
								<img src="<?php echo get_user_image($discussion['user_id']); ?>" alt="User image">
							</a>
						</div>
						<div class="name-title">
							<h6 class="fw-bold">
								<a href="<?php echo site_url('home/profile/'.$discussion['user_id']) ?>" class="text-decoration-none mstr-color-blue ff-gt text-17">
									<?php echo $discussion['first_name'].' '.$discussion['last_name']; ?>    
								</a>
							</h6>
							<p><?php echo $discussion['surname']; ?></p>
						</div>
					</div>

					<div class="w-100 mt-3 ff-gt ps-md-5 ms-md-2"><?php echo $discussion['description']; ?></div>

					<p class="w-100 pb-0 mb-0 text-end text-12 ff-gt text-muted-6">
						<?php echo get_phrase('posted').' '.get_time_ago($discussion['added_date']); ?>
					</p>


					<?php if($user_id == $discussion['user_id'] || login_type('admin')): ?>
						<a href="javascript:;" onclick="confirm_modal('<?php echo site_url('classes/delete_discussion?discussion_id='.$discussion['discussion_id']); ?>', '#parent_discussion_element_<?php echo $discussion['discussion_id']; ?>')" class="float-end text-14 text-danger text-decoration-none fw-bold m-1" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo get_phrase('delete'); ?>"><i class="bi bi-trash"></i><?php echo get_phrase('delete'); ?></a>
					<?php endif; ?>

					<a href="javascript:;" onclick="$('#reply_form_<?php echo $discussion['discussion_id']; ?>').toggle();" class="float-end text-14 text-decoration-none mstr-color-blue fw-bold m-1" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo get_phrase('reply'); ?>"><i class="bi bi-reply"></i><?php echo get_phrase('reply'); ?></a>

					<form class="realtimeLoadDiscussion d-hidden" id="reply_form_<?php echo $discussion['discussion_id']; ?>" action="<?php echo site_url('classes/add_discussion'); ?>" method="post" enctype="multipart/form-data" >
						<input type="hidden" name="parent_id" value="<?php echo $discussion['discussion_id']; ?>">
						<input type="hidden" name="class_id" value="<?php echo $class_details['class_id']; ?>">
						<textarea class="form-control" name="discussion" rows="3"></textarea>
						<button type="submit" class="mstr-header-btn-free float-end mt-3"><?php echo get_phrase('post_reply'); ?></button>
					</form>
				</div>

				<?php $child_discussions = $this->frontend_model->get_child_discussions($discussion['discussion_id']); ?>
				<?php foreach($child_discussions->result_array() as $key => $child_discussion): ?>
					<div class="col-lg-10 bg-light ps-md-5 py-2" id="child_discussion_element_<?php echo $child_discussion['discussion_id']; ?>">
						<div class="user-info-row w-100">
							<div class="user-image ms-md-4">
								<a href="<?php echo site_url('home/profile/'.$child_discussion['user_id']) ?>">
									<img src="<?php echo get_user_image($child_discussion['user_id']); ?>" alt="User image" class="w-40px h-40px">
								</a>
							</div>
							<div class="name-title">
								<h6 class="fw-bold">
									<a href="<?php echo site_url('home/profile/'.$child_discussion['user_id']) ?>" class="text-decoration-none mstr-color-blue ff-gt text-17">
										<?php echo $child_discussion['first_name'].' '.$child_discussion['last_name']; ?>    
									</a>
								</h6>
								<p><?php echo $child_discussion['surname']; ?></p>
							</div>
						</div>

						<div class="w-100 mt-3 ff-gt ps-md-5 ms-md-2"><?php echo $child_discussion['description']; ?></div>

						<p class="w-100 pb-0 mb-0 text-end text-12 ff-gt text-muted-6">
							<?php echo get_phrase('posted').' '.get_time_ago($child_discussion['added_date']); ?>
						</p>

						<?php if($user_id == $child_discussion['user_id'] || login_type('admin')): ?>
						<a href="javascript:;" onclick="confirm_modal('<?php echo site_url('classes/delete_discussion?discussion_id='.$child_discussion['discussion_id']); ?>', '#child_discussion_element_<?php echo $child_discussion['discussion_id']; ?>')" class="float-end text-14 text-danger text-decoration-none fw-bold m-1" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo get_phrase('delete'); ?>"><i class="bi bi-trash"></i><?php echo get_phrase('delete'); ?></a>
						<?php endif; ?>
					</div>
				<?php endforeach; ?>
			</div>
		<?php endforeach; ?>
	</div>
</section>
<script type="text/javascript">
	//Ajax load
	"use strict";

	$("[data-bs-toggle='tooltip']").tooltip();

	$(function() {
	    //The form of submission to RailTeam js is defined here.(Form class or ID)
	    $('.realtimeLoadDiscussion').ajaxForm({
	        beforeSend: function() {
	            var percentVal = '0%';
	        },
	        uploadProgress: function(event, position, total, percentComplete) {
	            var percentVal = percentComplete + '%';
	            
	        },
	        complete: function(xhr) {
	        	var jsonResponse = JSON.parse(xhr.responseText);

	        	if(jsonResponse.status == 'error'){
	        		error_message(jsonResponse.message);
	        	}else{
		        	load_class_data('', jsonResponse.class_id, 'discussions');
		        }
		        
	        },
	        error: function()
	        {
	            //You can write here your js error message
	        }
	    });
	});
</script>