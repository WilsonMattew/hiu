<?php
$user_id = $this->session->userdata('user_id');
$saved_classes = $this->frontend_model->get_saved_classes($user_id);
foreach($saved_classes->result_array() as $saved_class):
	$class_details = $this->crud_model->get_classes($saved_class['class_id'])->row_array();
	$category = $this->crud_model->get_categories($class_details['category_id'])->row_array(); ?>
	<div class="row mx-1" id="saved_class_<?php echo $saved_class['bookmark_id'] ?>">
		<div class="col-md-3 col-lg-2 p-0">
			<div class="class-card radius-right-top-0">
				<div class="thumbnail-label-gradient radius-right-top-0"></div>
				<a class="class-card-thumbnail" href="<?php echo site_url('classes/'.slugify($class_details['class_title']).'/'.$class_details['class_id']); ?>" aria-label="Mastery class">
					<div class="class-card-thumbnail-img">
						<img class="rounded-start radius-right-top-0" width="458" src="<?php echo get_class_thumbnail($class_details['class_thumbnail'], 'optimized'); ?>" alt="class image" loading="lazy">
						<div class="class-play-button"><i class="bi bi-play-circle-fill"></i></div>
					</div>
				</a>
			</div>
		</div>
		<div class="col-md-9 col-lg-10 py-2">
			<div>
				<p class="class-card-title my-1 w-100">
					<a href="<?php echo site_url('classes/'.slugify($class_details['class_title']).'/'.$class_details['class_id']); ?>" class="text-decoration-none mstr-color-blue fw-bold text-18 ff-gt-pro"><?php echo $class_details['class_title']; ?></a>

					<a href="javascript:;" onclick="confirm_modal('<?php echo site_url('home/bookmark?class_id='.$class_details['class_id'].'&type=remove'); ?>', '#saved_class_<?php echo $saved_class['bookmark_id'] ?>')" class="float-end text-decoration-none text-danger text-14 fw-500"><i class="bi bi-trash"></i><?php echo get_phrase('remove'); ?></a>
				</p>
				<p class="ff-normal text-14 fw-500"><?php echo $class_details['short_description']; ?></p>

				<span class="ff-gt-pro text-14 me-4">
					<?php
					$total_wached_student = $this->frontend_model->get_total_watched_student($class_details['class_id']);
					echo $total_wached_student.' '.get_phrase('students');
					?>
				</span>
				
				<span class="ff-gt-pro text-13 me-4">
					<?php
					$duration = duration_format($class_details['total_duration']);
					echo $duration['h'].'h '.$duration['m'].'m '.$duration['s'].'s ';
					?>
				</span>
				
				<span class="ff-gt-pro text-13 me-4"><?php echo $category['title']; ?></span>
			</div>
		</div>
		<div class="col-12"><hr class="bg-secondary my-3"></div>
	</div>
<?php endforeach; ?>