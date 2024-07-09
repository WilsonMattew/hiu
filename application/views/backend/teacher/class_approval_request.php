<div class="row">
  <div class="col-lg-12">
    <div class="panel panel-primary" data-collapsed="0">
      <div class="panel-heading">
        <div class="panel-title">
          <?php echo get_phrase('total').' <b>'.$all_requests->num_rows().'</b> '.get_phrase('pending_requests'); ?>
        </div>
      </div>
      <div class="panel-body p-0">
        <div class="table-responsive text-nowrap">
          <table class="table responsive table-bordered datatable m-0" id="classes_server_side_data">
            <thead>
              <tr>
                <th><?php echo get_phrase('teacher'); ?></th>
                <th><?php echo get_phrase('class');?></th>
                <th><?php echo get_phrase('lessons');?></th>
                <th><?php echo get_phrase('status');?></th>
                <th><?php echo get_phrase('option');?></th>
              </tr>
            </thead>
            <tbody>
                <?php
                foreach($all_requests->result_array() as $key => $all_request){
                    $details = json_decode($all_request['details']);
                    $class = $this->crud_model->get_classes($details->class_id)->row_array();
                    $user_details = $this->crud_model->get_users($class['user_id'])->row_array();
                    ?>
                    <tr>
                        <td class="text-center">
                            <img  src="<?php echo get_user_image($class['user_id']); ?>" alt="user image" width="35" height="35" class="rounded-circle">
                            <br>
                            <a target="_blank" href="<?php echo site_url('user/profile/'.$user_details['user_id']); ?>"><?php echo $user_details['first_name'].' '.$user_details['last_name']; ?>
                            </a>
                        </td>
                        <td>
                            <strong>
                                <a href="<?php echo site_url('teacher/manage_class/'.$class['class_id']); ?>">
                                    <?php echo $class["class_title"]; ?>
                                    <?php if($class['is_featured']): ?>
                                        <i class="entypo-star text-11px text-danger" data-toggle="tooltip" data-placement="top" title="<?php echo get_phrase('featured_class'); ?>"></i>
                                    <?php endif; ?>

                                    <?php if($class['is_recommended']): ?>
                                       <i class="fa fa-hand-holding-heart" data-toggle="tooltip" data-placement="top" title="<?php echo get_phrase('recommended_class'); ?>"></i>
                                    <?php endif; ?>
                                </a>
                            </strong>
                            <br>
                            <small>
                                <?php echo date("D, d-M-Y", $class["date_added"]);?>
                            </small>
                        </td>
                        
                        <td>
                            <?php
                            $number_of_lesson = $this->crud_model->get_lessons_by_class_id($class['class_id'])->num_rows();
                            $total_duration = duration_format($class['total_duration']);
                            $lessons = $number_of_lesson.' '.get_phrase('lessons').'<br>';
                            echo $lessons .= $total_duration['h'].'h '.$total_duration['m'].'m '.$total_duration['s'].'s';
                            ?>
                        </td>
                        <td>
                            <?php if ($class['status'] == 'active'): ?>
                                <span class="badge bg-success"><?php echo get_phrase($class['status']); ?></span>
                            <?php elseif($class['status'] == 'pending'): ?>
                                <span class="badge bg-danger"><?php echo get_phrase($class['status']); ?></span>
                            <?php else: ?>
                                <span class="badge"><?php echo get_phrase($class['status']); ?></span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div class="btn-group">
                                <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
                                    <?php echo get_phrase("action"); ?>
                                    <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu dropdown-blue dropdown-menu-right" role="menu">

                                    <li><a href="javascript:;" onclick="showAjaxModal('<?php echo site_url('teacher/class_approval_request/view_message/'.$all_request['notification_id']); ?>', '<?php echo get_phrase('teachers_mail'); ?>')"><?php echo get_phrase("view_message"); ?></a>
                                    </li>

                                    <li><a href="javascript:;" onclick="confirm_modal('<?php echo site_url('teacher/class_approval_request/delete/'.$all_request["notification_id"]); ?>')"><?php echo get_phrase("delete"); ?></a>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div><!-- end col-->
</div>
<script>
  function refreshServersideTable(tableId){
    $('#'+tableId).DataTable().ajax.reload();
  }
</script>
