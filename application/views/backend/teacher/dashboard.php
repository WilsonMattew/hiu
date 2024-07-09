<div class="row">
	<div class="col-lg-4">
		<div class="panel widget-flat">
			<div class="panel-body text-center">
				<i class="fa fa-chalkboard-teacher" style="font-size: 28px; color: #7484f7;"></i>
				<h2 class="">
					<b>
						<?php echo $this->crud_model->get_classes()->num_rows(); ?>
					</b>
				</h2>
				<h4 class="text-muted font-weight-normal"><?php echo get_phrase('total_classes'); ?></h4>
			</div>
		</div>
	</div>
	<div class="col-lg-4">
		<div class="panel widget-flat">
			<div class="panel-body text-center">
				<i class="fas fa-user-friends" style="font-size: 28px; color: #7484f7;"></i>
				<h2 class="">
					<b>
						<?php echo $this->crud_model->get_teachers()->num_rows(); ?>
					</b>
				</h2>
				<h4 class="text-muted font-weight-normal"><?php echo get_phrase('total_teachers'); ?></h4>
			</div>
		</div>
	</div>
	<div class="col-lg-4">
		<div class="panel widget-flat">
			<div class="panel-body text-center">
				<i class="fas fa-users" style="font-size: 28px; color: #7484f7;"></i>
				<h2 class="">
					<b>
						<?php echo $this->crud_model->get_students()->num_rows(); ?>
					</b>
				</h2>
				<h4 class="text-muted font-weight-normal"><?php echo get_phrase('total_students'); ?></h4>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-12">
		<div class="panel">
			<div class="panel-heading">
				<div class="panel-title">
					<b><?php echo get_phrase('my_top_10_classes'); ?></b>
				</div>
			</div>
			<div class="panel-body">
				<table class="table table-bordered">
					<thead>
						<tr>
							<th class="text-center"><b><?php echo get_phrase('class');?></b></th>
							<th class="text-center"><b><?php echo get_phrase('lesson');?></b></th>
							<th class="text-center"><b><?php echo get_phrase('class_owner');?></b></th>
						</tr>
					</thead>
					<tbody class="text-center">
						<?php foreach ($popular_classes as $key => $popular_class):
							$class = $this->crud_model->get_classes($popular_class['class_id'])->row_array();
							$class_owner = $this->crud_model->get_users($class['user_id'])->row_array();?>

							<tr>
								<td>
									<a href="<?php echo site_url('classes/').slugify($class['class_title']).'/'.$class['class_id']; ?>" target="_blank">
										<?php echo $class['class_title']; ?>
									</a>
									<br>
									<span class="text-10"><?php echo '<b>'.$popular_class['student_number'].'</b> '.get_phrase('students'); ?></span>
								</td>
								<td>
									<?php $lessons = $this->frontend_model->get_active_lessons_by_class_id($class['class_id']); ?>
									<span><?php echo '<b>'.$lessons->num_rows().'</b> '.get_phrase('lessons'); ?></span>
									<br>
									<span class="text-10">
										<?php $duration_format = duration_format($class['total_duration']); ?>
										<?php if($duration_format['h'] > 0) echo $duration_format['h'].'h '?><?php if($duration_format['m'] > 0) echo $duration_format['m'].'m '?><?php if($duration_format['s'] > 0) echo $duration_format['s'].'s'?>
									</span>
								</td>
								<td>
									<a href="<?php echo site_url('user/profile/'.$class_owner['user_id']); ?>" target="_blank">
									<img src="<?php echo get_user_image($class_owner['user_id']); ?>" alt="user image" width="35" height="35" class="rounded-circle">
									<br>
									<?php echo $class_owner['first_name'].' '.$class_owner['last_name']; ?>
								</td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>