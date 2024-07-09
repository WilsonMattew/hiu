<div class="panel panel-primary" data-collapsed = "0">
	<div class="panel-heading">
		<div class="panel-title">
			<?php echo get_phrase('purchase_histories'); ?>
		</div>
	</div>
	<div class="panel-body">
		<form class="form-inline" action="<?php echo site_url('admin/purchase_history') ?>" method="get">
			<div class="row mb-15px">
				<div class="col-lg-offset-2 col-lg-6">
					<div id="reportrange" class="daterange daterange-inline add-ranges" data-format="MMMM D, YYYY" data-start-date="<?php echo date("F d, Y" , $timestamp_start); ?>" data-end-date="<?php echo date("F d, Y" , $timestamp_end); ?>">
						<i class="entypo-calendar"></i>
						<span id="selectedValue"><?php echo date("F d, Y" , $timestamp_start) . " - " . date("F d, Y" , $timestamp_end);?></span>
					</div>
					<input id="date_range" type="hidden" name="date_range" value="<?php echo date("d F, Y" , $timestamp_start) . " - " . date("d F, Y" , $timestamp_end);?>">
				</div>
				<div class="col-lg-2">
					<button type="submit" class="btn btn-info" id="submit-button" onclick="update_date_range();"> <?php echo get_phrase('filter');?></button>
				</div>
			</div>
		</form>
		<div class="row">
			<div class="col-lg-12">
				<table class="table table-bordered datatable">
					<thead>
						<tr>
							<th class="text-center"><div><?php echo get_phrase('user');?></div></th>
							<th class="text-center"><div><?php echo get_phrase('package');?></div></th>
							<th class="text-center"><div><?php echo get_phrase('paid_amount');?></div></th>
							<th class="text-center"><div><?php echo get_phrase('subscription');?></div></th>
							<th class="text-center"><div><?php echo get_phrase('status');?></div></th>
							<th class="text-center"><div><?php echo get_phrase('actions');?></div></th>
						</tr>
					</thead>
					<tbody class="text-center">
						<?php
						foreach ($payments->result_array() as $key => $payment):
							$user =  $this->crud_model->get_users($payment['user_id'])->row_array();
							$package =  $this->crud_model->get_packages($payment['package_id'])->row_array();
							?>
							<tr>
								<td>
									<a href="<?php echo site_url('user/profile/'.$payment['user_id']); ?>" target="_blank">
										<?php echo $user['first_name'].' '.$user['last_name']; ?>
										<br>
										<span class="text-11 text-muted"><?php echo $user['email']; ?></span>
									</a>
								</td>
								<td>
									<b>
									<?php echo currency($package['price']); ?>
									<br>
									<?php
										if($package['package_type'] == 'days'){
											echo $package['days'].' '.get_phrase('days'); 
										}else{
											echo get_phrase($package['package_type']);
										}
									?>
									</b>
								</td>
								<td>
									<b><?php echo currency($payment['paid_amount']); ?></b>
									<br>
									<small><span class="badge label-primary "><?php echo get_phrase('paid_via_'.$payment['payment_method']); ?></span></small>
								</td>
								<td>
									<?php echo date('d M Y', $payment['date_added']); ?>
									<br>
									to
									<br>
									<?php echo date('d M Y', $payment['expire_date']); ?>
									<br>
									<span class="badge bg-primary">
										<?php if($payment['free_days'] > 0)echo get_phrase('included_free').' '.$payment['free_days'].' '.get_phrase('days'); ?>
									</span>
								</td>
								<td>
									<?php if($payment['expire_date'] >= time()): ?>
										<span class="badge label-success"><?php echo get_phrase('active'); ?></span>
									<?php else: ?>
										<span class="badge label-danger"><?php echo get_phrase('expired'); ?></span>
									<?php endif; ?>
								</td>
								<td class="">
									<a href="<?php echo site_url('admin/invoice/'.$payment['payment_id']); ?>" class="btn btn-info"><i class="fas fa-print"></i> <?php echo get_phrase('invoice'); ?></a>
								</td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	'use strict';

	function update_date_range()
	{
		var x = $("#selectedValue").html();
		$("#date_range").val(x);
	}
</script>