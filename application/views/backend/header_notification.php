<li class="notifications dropdown">
    <?php $notifications = $this->crud_model->get_notification_by_type('class_approval_request', 'admin', '0', 20); ?>
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
        <i class="fas fa-bell text-17"></i>
        <?php if($notifications->num_rows() > 0): ?>
	        <span class="badge label-danger" style="top: 5px !important; right: 2px !important;">
	        	<?php echo $notifications->num_rows(); ?>
	        </span>
	    <?php endif; ?>
    </a>

    <ul class="dropdown-menu">
        <li class="top">
            <p class="text-12"><?php echo get_phrase('total').' '.$notifications->num_rows().' '.get_phrase('unread_notification'); ?></p>
        </li>

        <li style="padding: 8px; background: #fff;">
            <ul class="dropdown-menu-list scroller">
            <?php
            foreach($notifications->result_array() as $notification):
            $details = json_decode($notification['details']);
            $class = $this->crud_model->get_classes($details->class_id)->row_array();
            $status = 'danger';
            ?>
                <li class="mt-5px">
                    <a href="<?php echo site_url($this->session->userdata('role').'/class_approval_request');?>">
                        <span class="task">
                            <span class="desc">
                                <i class="fa fa-chalkboard-teacher"></i>
                                <?php echo $class['class_title'];?>
                                <span class="text-10"><?php echo get_phrase($notification['type']); ?></span>
                            </span>
                            <span class="percent text-10">
                                <?php echo get_time_ago($notification['date_added']); ?>
                            </span>
                        </span>
                    </a>
                </li>
            <?php endforeach;?>
                <li>
                    <a href="<?php echo site_url($this->session->userdata('role').'/class_approval_request');?>">
                        <?php echo get_phrase('view_all_request');?>
                    </a>
                </li>
            </ul>
        </li>
    </ul>
</li>