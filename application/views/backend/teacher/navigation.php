<div class="sidebar-menu">
    <header class="logo-env" >

        <!-- logo collapse icon -->
        <div class="sidebar-collapse" style="margin-top: 0px;">
            <a href="#" class="sidebar-collapse-icon" onclick="hide_brand()">
                <i class="entypo-menu"></i>
            </a>
        </div>
        <script type="text/javascript">
        function hide_brand() {
            $('#branding_element').toggle();
        }
        </script>

        <!-- open/close menu icon (do not remove if you want to enable menu on mobile devices) -->
        <div class="sidebar-mobile-menu visible-xs">
            <a href="#" class="with-animation">
                <i class="entypo-menu"></i>
            </a>
        </div>
    </header>

    <ul id="main-menu" class="">
        <div style="text-align: -webkit-center;" id="branding_element">
            <img src="<?php echo get_logo('light_logo'); ?>" width="120px"/>
        </div>
        <br>
        <!-- Home -->
        <li class="<?php if ($page_name == 'dashboard') echo 'active'; ?> " style="border-top:1px solid #232540;">
            <a href="<?php echo site_url('teacher/dashboard'); ?>">
                <i class="fa fa-home"></i>
                <span><?php echo get_phrase('dashboard'); ?></span>
            </a>
        </li>

        <!-- Classes -->
        <li class="<?php if ($page_name == 'classes' || $page_name == 'manage_class' || $page_name == 'add_class' || $page_name == 'skills' || $page_name == 'class_approval_request') echo 'opened active has-sub'; ?>">
            <a href="#">
                <i class="fa fa-chalkboard-teacher"></i>
                <span><?php echo get_phrase('classes'); ?></span>
            </a>
            <ul>
                <li class="<?php if ($page_name == 'classes') echo 'active'; ?> ">
                    <a href="<?php echo site_url('teacher/classes'); ?>">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('all_classes'); ?></span>
                    </a>
                </li>

                <li class="<?php if ($page_name == 'class_approval_request') echo 'active'; ?> ">
                    <a href="<?php echo site_url('teacher/class_approval_request'); ?>">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('approval_request'); ?></span>
                        <span class="badge label-danger float-right">
                            <?php echo $this->crud_model->get_notification_by_type('class_approval_request', $this->session->userdata('user_id'))->num_rows(); ?>
                        </span>
                    </a>
                </li>

                <li class="<?php if ($page_name == 'add_class') echo 'active'; ?> ">
                    <a href="<?php echo site_url('teacher/add_class'); ?>">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('add_new_class'); ?></span>
                    </a>
                </li>
            </ul>
        </li>

        <!-- profile -->
        <li class="<?php if ($page_name == 'profile') echo 'active'; ?> ">
            <a href="<?php echo site_url('teacher/profile'); ?>">
                <i class="fas fa-user"></i>
                <span><?php echo get_phrase('profile'); ?></span>
            </a>
        </li>
    </ul>
</div>