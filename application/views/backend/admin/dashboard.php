<style type="text/css">
	*:before,
	*:after {
	  box-sizing: inherit;
	}

	.line-chart {
		animation: fadeIn 600ms cubic-bezier(.57,.25,.65,1) 1 forwards;
		opacity: 0;
		width: 100%;
	}

	.aspect-ratio {
	  height: 0;
	  padding-bottom: 50%;
	}

	@keyframes fadeIn {
	  to {
	    opacity: 1;
	  }
	}
</style>
<script type="text/javascript" src="<?php echo base_url('assets/backend/js/Chart.min.js'); ?>"></script>
<div class="row">
	<div class="col-md-12">
		<div class="panel">
			<div class="panel-body">
				<h6 class="mb-3"><?php echo get_phrase('yearly_sales_report'); ?></h6>
				<div class="line-chart">
				  <div class="aspect-ratio">
				    <canvas id="chart"></canvas>
				  </div>
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	'use strict';

	var chart    = document.getElementById('chart').getContext('2d'), gradient = chart.createLinearGradient(0, 0, 0, 450);
	gradient.addColorStop(0, 'rgba(41, 69, 255, 0.11)');
	gradient.addColorStop(0.5, 'rgba(41, 69, 255, 0.11)');
	gradient.addColorStop(1, 'rgba(41, 69, 255, 0.11)');

	var data  = {
	    labels: [ '<?php echo get_phrase('january'); ?>', '<?php echo get_phrase('february'); ?>', '<?php echo get_phrase('march'); ?>', '<?php echo get_phrase('april'); ?>', '<?php echo get_phrase('may'); ?>', '<?php echo get_phrase('june'); ?>', '<?php echo get_phrase('july'); ?>', '<?php echo get_phrase('august'); ?>', '<?php echo get_phrase('september'); ?>', '<?php echo get_phrase('october'); ?>', '<?php echo get_phrase('november'); ?>', '<?php echo get_phrase('december'); ?>'],
	    datasets: [{
			label: '<?php echo get_phrase('this_month'); ?>',
			backgroundColor: gradient,
			pointBackgroundColor: 'white',
			borderWidth: 1,
			borderColor: '#2945ff',
			data: [<?php echo $this->crud_model->get_monthly_earn(1).','.$this->crud_model->get_monthly_earn(2).','.$this->crud_model->get_monthly_earn(3).','.$this->crud_model->get_monthly_earn(4).','.$this->crud_model->get_monthly_earn(5).','.$this->crud_model->get_monthly_earn(6).','.$this->crud_model->get_monthly_earn(7).','.$this->crud_model->get_monthly_earn(8).','.$this->crud_model->get_monthly_earn(9).','.$this->crud_model->get_monthly_earn(10).','.$this->crud_model->get_monthly_earn(11).','.$this->crud_model->get_monthly_earn(12); ?>]
	    }]
	};


	var options = {
		responsive: true,
		maintainAspectRatio: true,
		animation: {
			easing: 'easeInOutQuad',
			duration: 500
		},
		scales: {
			xAxes: [{
				gridLines: {
					color: 'rgba(188, 210, 198, 0.17)',
					lineWidth: 1
				}
			}],
			yAxes: [{
				gridLines: {
					color: 'rgba(188, 210, 198, 0.04)',
					lineWidth: 1
				}
			}]
		},
		elements: {
			line: {
				tension: .4
			}
		},
		legend: {
			display: false
		},
		point: {
			backgroundColor: 'white'
		},
		tooltips: {
			titleFontFamily: 'Open Sans',
			backgroundColor: 'rgba(41, 69, 255, 0.61)',
			titleFontColor: 'white',
			caretSize: 5,
			cornerRadius: 2,
			xPadding: 10,
			yPadding: 10
		}
	};


	var chartInstance = new Chart(chart, {
	    type: 'line',
	    data: data,
			options: options
	});
</script>


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
					<b><?php echo get_phrase('top_10_classes'); ?></b>
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