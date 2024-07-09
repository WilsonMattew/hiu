<div class="row">
  <div class="col-lg-12">
    <div class="panel panel-primary" data-collapsed="0">
      <div class="panel-heading">
        <div class="panel-title">
          <?php echo get_phrase('all_packages'); ?>
        </div>
      </div>
      <div class="panel-body">
        <table class="table table-bordered datatable">
          <thead>
            <tr>
              <th width="80"><div>#</div></th>
              <th><div><?php echo get_phrase('package');?></div></th>
              <th><div><?php echo get_phrase('price');?></div></th>
              <th><div><?php echo get_phrase('status');?></div></th>
              <th><div><?php echo get_phrase('options');?></div></th>
            </tr>
          </thead>
          <tbody>
            <?php
            foreach ($packages->result_array() as $key => $package): ?>
            <tr>
				<td><?php echo ++$key; ?></td>
				<td>
					<b>
						<?php if($package['package_type'] == 'days'): ?>
							<?php echo $package['days'].' '.get_phrase('days'); ?>
						<?php else: ?>
							<?php echo get_phrase($package['package_type']); ?>
						<?php endif; ?>
					</b>
				</td>
				<td>
					<?php echo currency($package['price']); ?>
				</td>
				<td>
					<?php if($package['status'] == 1): ?>
						<span class="badge label-success"><?php echo get_phrase('active'); ?></span>
					<?php else: ?>
						<span class="badge label-secondary"><?php echo get_phrase('deactive'); ?></span>
					<?php endif; ?>
				</td>
              <td>
                <div class="bs-example">
                  <div class="btn-group">
                    <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
                      <?php echo get_phrase('action'); ?> <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu dropdown-blue dropdown-menu-right" role="menu">
                      <li>
                        <a href="javascript:;" onclick="showAjaxModal('<?php echo site_url('admin/package_edit/'.$package['package_id']); ?>', '<?php echo get_phrase('edit_package'); ?>')">
                          <i class="entypo-pencil"></i>
                          <?php echo get_phrase('edit'); ?>
                        </a>
                      </li>

                      <li>
                      	<?php if($package['status'] == 1): ?>
                      		<a href="javascript:;" onclick="confirm_modal('<?php echo site_url('admin/package_status/pending/'.$package['package_id']); ?>', 'generic_confirmation')">
	                          <i class="entypo-dot text-danger"></i>
	                          <?php echo get_phrase('disable_this_package'); ?>
	                        </a>
                      	<?php else: ?>
	                        <a href="javascript:;" onclick="confirm_modal('<?php echo site_url('admin/package_status/active/'.$package['package_id']); ?>', 'generic_confirmation')">
	                          <i class="entypo-dot text-success"></i>
	                          <?php echo get_phrase('activate_this_package'); ?>
	                        </a>
	                    <?php endif; ?>
                      </li>
                    </ul>
                  </div>
                </div>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>