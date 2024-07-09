<?php $payment_details = $this->frontend_model->get_payments_by_payment_id($payment_id); ?>
<div class="row d-flex justify-content-center">
    <div class="col-md-12">
        <div class="card print-content">
        	<span class="text-muted-5 p-2 text-12"><?php echo get_phrase('invoice'); ?></span>
            <div class="upper p-4">
                <div class="row mb-5">
                	<div class="col-12 text-center">
                		<img src="<?php echo base_url('uploads/system_images/logo/'.get_frontend_settings('dark_logo')); ?>" height="22px" width="auto">
                		<br>
                		<span class="text-13"><?php echo get_settings('system_name'); ?></span>
                	</div>
                </div>
                <div class="d-flex justify-content-between">
                    <div class="d-flex flex-row align-items-center">
                        <div class="add">
                        	<span class="font-weight-bold d-block ff-gt-pro"><?php echo $user_details['first_name'].' '.$user_details['last_name']; ?></span>
                            <small class="text-12"><?php echo $user_details['email'] ?></small>
                            <br>
                        	<small><?php echo $user_details['address'] ?></small>
                        </div> 
                    </div>

                    <div class="amount text-center">
                    	<span class="text-primary fw-bold ff-normal text-uppercase">
                    		<?php
								if($payment_details['package_type'] == 'days'){
									echo $payment_details['days'].' '.get_phrase('days'); 
								}else{
									echo get_phrase($payment_details['package_type']);
								}
							?>
                    	</span>
                        <h4><?php echo currency($payment_details['price']); ?></h4>
                        <small><?php echo get_phrase('paid_via').' <b>'.get_phrase($payment_details['payment_method']); ?></b></small>
                    </div>
                </div>
                <hr>
                <div class="d-flex justify-content-between">
                    <div class="d-flex flex-row align-items-center">
                    	<span class="ms-2"><?php echo get_phrase('purchase_date'); ?></span>
                    </div>
                    <span class="fw-bold"><?php echo date('d M Y', $payment_details['date_added']); ?></span>
                </div>

                <div class="d-flex justify-content-between mt-3">
                    <div class="d-flex flex-row align-items-center">
                    	<span class="ms-2"><?php echo get_phrase('expiry_date'); ?></span>
                    </div>
                    <span class="fw-bold"><?php echo date('d M Y', $payment_details['expire_date']); ?></span>
                </div>

               <?php if($payment_details['free_days'] > 0): ?>
	                <div class="d-flex justify-content-between mt-3">
	                    <div class="d-flex flex-row align-items-center">
	                    	<span class="ms-2"><?php echo get_phrase('free'); ?></span>
	                    </div>
	                    <span class="fw-bold"><?php echo $payment_details['free_days'].' '.get_phrase('days'); ?></span>
	                </div>
	            <?php endif; ?>
                <hr>
                <div class="d-flex justify-content-between mt-3">
                    <div class="d-flex flex-row align-items-center">
                    	<i class="bi bi-check-circle-fill text-success"></i>
                    	<span class="ms-2"><?php echo get_phrase('total_paid_amount'); ?></span>
                    </div>
                    <span class="fw-bold"><?php echo currency($payment_details['paid_amount']); ?></span>
                </div>


                <div class="d-flex justify-content-between mt-5">
                    <div class="d-flex flex-row align-items-center">
                    	<div class="row">
	                    	<div class="col-12">
		                   		<h6 class="m-0"><?php echo get_settings('system_title'); ?></h6>
		            			<span class="text-12 text-muted-5"><?php echo get_settings('system_name'); ?></span>
		            			<br>
		            			<span class="text-12 text-muted-5"><?php echo get_settings('address'); ?></span>
		            		</div>
		            	</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-3">
        	<div class="col-md-12">
        		<button class="btn btn-primary float-end" onclick="print()">
        			<i class="bi bi-printer"></i>
        			<?php echo get_phrase('print'); ?>
        		</button>
        	</div>
        </div>
    </div>
</div>