<!-- start page title -->
<div class="row ">
  <div class="col-lg-12">
    <a href="<?php echo site_url('admin/teacher_add'); ?>" class="btn btn-primary alignToTitle"><i class="entypo-plus"></i><?php echo get_phrase('add_new_teacher'); ?></a>
  </div><!-- end col-->
</div>

<div class="row">
  <div class="col-lg-12">
    <div class="panel panel-primary" data-collapsed="0">
      <div class="panel-heading">
        <div class="panel-title">
          <?php echo get_phrase('all_teachers'); ?>
        </div>
      </div>
      <div class="panel-body">
        <table class="table table-bordered datatable">
          <thead>
            <tr>
              <th><div><?php echo get_phrase('photo');?></div></th>
              <th><div><?php echo get_phrase('name');?></div></th>
              <th><div><?php echo get_phrase('email');?></div></th>
              <th><div><?php echo get_phrase('status');?></div></th>
              <th><div><?php echo get_phrase('contact');?></div></th>
              <th><div><?php echo get_phrase('options');?></div></th>
            </tr>
          </thead>
          <tbody>
            <?php
            foreach ($teachers->result_array() as $key => $teacher): ?>
            <tr>
              <td>
                <img src="<?php echo get_user_image($teacher['user_id']); ?>" alt="user image" width="35" height="35" class="rounded-circle">
              </td>
              <td>
                <?php $total_class_number = $this->crud_model->get_classes_by_user_id($teacher['user_id'])->num_rows(); ?>
                <p class="mt-1px mb-1px">
                  <a href="<?php echo site_url('admin/teacher_edit/'.$teacher['user_id']); ?>"><?php echo $teacher['first_name'].' '.$teacher['last_name']; ?></a></p>
                <span class="text-10"><?php echo get_phrase('total').' '.$total_class_number.' '.get_phrase('classes'); ?></span>
              </td>
              <td>
                <p class="mt-1px mb-1px"><?php echo $teacher['email']; ?></p>
                <span class="text-10"><?php echo get_phrase('joined').' - <b>'.date('d M Y', $teacher['date_added']); ?></b></span>
                <?php if($teacher['is_verified'] == 0): ?>
                  <br>
                  <span class="label label-danger"><?php echo get_phrase('unverified_user'); ?></span>
                <?php endif; ?>
              </td>
              <td>
                <?php if($teacher['status'] == 1): ?>
                  <span class="label label-success"><?php echo get_phrase('active'); ?></span>
                <?php else: ?>
                  <span class="label label-default"><?php echo get_phrase('deactive'); ?></span>
                <?php endif; ?>
              </td>
              <td>
                <?php echo $teacher['phone']; ?>
                <br>
                <?php echo $teacher['address']; ?>
              </td>
              <td>
                <div class="bs-example">
                  <div class="btn-group">
                    <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
                      <?php echo get_phrase('action'); ?> <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu dropdown-blue dropdown-menu-right" role="menu">
                      <li>
                        <a href="<?php echo site_url('user/profile/'.$teacher['user_id']); ?>" target="_blank">
                          <i class="entypo-eye"></i>
                          <?php echo get_phrase('view_profile'); ?>
                        </a>
                      </li>
                      <li>
                        <?php if($teacher['status'] == 1): ?>
                          <a href="javascript:;" onclick="confirm_modal('<?php echo site_url('admin/teacher_status/pending/'.$teacher['user_id']); ?>', 'generic_confirmation')">
                            <i class="entypo-dot text-danger"></i>
                            <?php echo get_phrase('disable_this_user'); ?>
                          </a>
                        <?php else: ?>
                          <a href="javascript:;" onclick="confirm_modal('<?php echo site_url('admin/teacher_status/active/'.$teacher['user_id']); ?>', 'generic_confirmation')">
                            <i class="entypo-dot text-success"></i>
                            <?php echo get_phrase('activate_this_user'); ?>
                          </a>
                        <?php endif; ?>
                      </li>
                      <li>
                        <a href="<?php echo site_url('admin/teacher_edit/'.$teacher['user_id']); ?>">
                          <i class="entypo-pencil"></i>
                          <?php echo get_phrase('edit'); ?>
                        </a>
                      </li>
                      <li class="divider"></li>
                      <li>
                        <a href="#" class="" onclick="confirm_modal('<?php echo site_url('admin/teachers/delete/'.$teacher['user_id']); ?>');">
                          <i class="entypo-trash"></i>
                          <?php echo get_phrase('delete'); ?>
                        </a>
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