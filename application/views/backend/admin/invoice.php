<?php
$user_details = $this->crud_model->get_users($payment['user_id'])->row_array();
$package =  $this->crud_model->get_packages($payment['package_id'])->row_array();
?>

<div class="row">
  <div class="col-lg-12">
    <div class="panel panel-primary" data-collapsed="0">
      <div class="panel-body">
        <div class="invoice">

        	<div class="row">
        		<div class="col-sm-6 invoice-left">
        			<a href="#">
        				<img src="<?php echo base_url('uploads/system_images/logo/'.get_frontend_settings('dark_logo')); ?>" height="20"/>
        			</a>
        		</div>
        		<div class="col-sm-6 invoice-right">
    				<h3><?php echo get_phrase('invoice'); ?></h3>
    				<span><b><?php echo get_phrase('printed_on'); ?></b> : <?php echo date('D, d/M/Y'); ?></span>
        		</div>
        	</div>

        	<hr class="margin" />

        	<div class="row">
        		<div class="col-sm-3 invoice-left">
            		<h4><?php echo get_phrase('billing_to'); ?></h4>
                    <?php echo $user_details['first_name'].' '.$user_details['last_name']; ?><br>
                    <span class="text-11 text-muted">
                        <?php echo $user_details['address']; ?><br>
                        <?php echo $user_details['phone']; ?><br>
                    </span>
        		</div>

        		<div class="col-sm-3 invoice-left">
            		<h4><?php echo get_phrase('billing_from'); ?></h4>
                    <?php echo get_settings('system_title'); ?><br>
                    <span class="text-11 text-muted">
                        <?php echo get_settings('address'); ?><br>
                        <?php echo get_settings('phone'); ?><br>
                    </span>
        		</div>

        		<div class="col-md-6 invoice-right">
        			<h4><?php echo get_phrase('payment_details'); ?></h4>
        			<strong><?php echo get_phrase('purchase_date'); ?>:</strong> <?php echo date('D, d-M-Y', $payment['date_added']); ?>
        			<br />
        			<strong><?php echo get_phrase('package'); ?>:</strong>
                    <b>
                        <?php
                            if($package['package_type'] == 'days'){
                                echo $package['days'].' '.get_phrase('days'); 
                            }else{
                                echo get_phrase($package['package_type']);
                            }
                        ?>
                    </b>
        			<br />
        			<?php echo get_phrase('paid_via_'.$payment['payment_method']); ?>
        		</div>

        	</div>

        	<div class="margin"></div>

        	<table class="table table-bordered">
        		<thead>
        			<tr>
                        <th class="text-center"><?php echo get_phrase('package_name'); ?></th>
                        <th class="text-center"><?php echo get_phrase('expiry_date'); ?></th>
                        <th class="text-center"><?php echo get_phrase('paid_amount'); ?></th>
                        <th class="text-center"><?php echo get_phrase('status'); ?></th>
        			</tr>
        		</thead>

        		<tbody class="text-center">
        			<tr>
                        <td>
                            <b>
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
                            <?php echo date('D, d-M-Y', $payment['expire_date']); ?>
                            <br>
                            <span class="badge bg-primary">
                                <?php if($payment['free_days'] > 0)echo get_phrase('included_free').' '.$payment['free_days'].' '.get_phrase('days'); ?>
                            </span>        
                        </td>
                        <td><?php echo currency($payment['paid_amount']); ?></td>
                        <td>
                            <?php if($payment['expire_date'] >= time()): ?>
                                <span class="badge label-success"><?php echo get_phrase('active'); ?></span>
                            <?php else: ?>
                                <span class="badge label-danger"><?php echo get_phrase('expired'); ?></span>
                            <?php endif; ?>
                        </td>
        			</tr>
        		</tbody>
        	</table>

        	<div class="margin"></div>

        	<div class="row">

        		<div class="col-sm-6">

        		</div>

        		<div class="col-sm-6">

        			<div class="invoice-right">

        				<ul class="list-unstyled">
        					<li>
        						<?php echo get_phrase('sub_total_amount'); ?>:
        						<strong><?php echo currency($payment['paid_amount']); ?></strong>
        					</li>
        					<li>
        						<?php echo get_phrase('grand_total'); ?>:
        						<strong><?php echo currency($payment['paid_amount']); ?></strong>
        					</li>
        				</ul>

        				<br />

        				<a href="javascript:window.print();" class="btn btn-primary btn-icon icon-left hidden-print">
        					<?php echo get_phrase('print_invoice'); ?>
        					<i class="entypo-doc-text"></i>
        				</a>
        				&nbsp;
        			</div>

        		</div>

        	</div>

        </div>
      </div>
    </div>
  </div><!-- end col-->
</div>
