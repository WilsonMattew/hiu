<div class="row">
	<div class="col-12 table-responsive">
		<table class="table">
			<thead>
				<tr>
					<th scope="col"><?php echo get_phrase('package'); ?></th>
					<th scope="col"><?php echo get_phrase('total_amout'); ?></th>
					<th scope="col"><?php echo get_phrase('purchase_date'); ?></th>
					<th scope="col"><?php echo get_phrase('expiry_date'); ?></th>
					<th scope="col"><?php echo get_phrase('option'); ?></th>
				</tr>
			</thead>
			<tbody>
				<?php $user_id = $this->session->userdata('user_id'); ?>
				<?php $payments = $this->frontend_model->get_payments($user_id); ?>
				<?php foreach($payments->result_array() as $payment): ?>
					<tr style="background-color:<?php if($payment['expire_date'] < time()){echo '#fff0f0';}else{echo 'aliceblue';} ?>">
						<td class="text-center">
							<span class="ff-gt-pro">
								<?php
									if($payment['package_type'] == 'days'){
										echo $payment['days'].' '.get_phrase('days'); 
									}else{
										echo get_phrase($payment['package_type']);
									}
								?>
							</span>
							<br>
							<?php if($payment['expire_date'] >= time()): ?>
								<span class="badge bg-success"><?php echo get_phrase('active'); ?></span>
							<?php else: ?>
								<span class="badge bg-danger"><?php echo get_phrase('expired'); ?></span>
							<?php endif; ?>
						</td>

						<td class="ff-gt-pro text-center">
							<?php echo currency($payment['paid_amount']); ?>
							<br>
							<span class="badge bg-primary "><?php echo get_phrase('paid_via').' '.get_phrase($payment['payment_method']); ?></span>	
						</td>

						<td scope="row"><?php echo date('d M Y', $payment['date_added']); ?></td>

						<td scope="row">
							<?php echo date('d M Y', $payment['expire_date']); ?>
							<br>
							<span class="badge bg-primary ">
								<?php if($payment['free_days'] > 0)echo get_phrase('included_free').' '.$payment['free_days'].' '.get_phrase('days'); ?>
							</span>
						</td>
						
						<td>
							<a href="<?php echo site_url('user/account/invoice/'.$payment['payment_id']); ?>" class="btn btn-primary mt-2"><i class="bi bi-printer"></i></a>
						</td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
</div>