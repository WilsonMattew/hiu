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
            <a href="<?php echo site_url('admin/dashboard'); ?>">
                <i class="fa fa-home"></i>
                <span><?php echo get_phrase('dashboard'); ?></span>
            </a>
        </li>

        <!-- Classes -->
        <li class="<?php if ($page_name == 'classes' || $page_name == 'manage_class' || $page_name == 'add_class' || $page_name == 'class_approval_request') echo 'opened active has-sub'; ?>">
            <a href="#">
                <i class="fa fa-chalkboard-teacher"></i>
                <span><?php echo get_phrase('classes'); ?></span>
            </a>
            <ul>
                <li class="<?php if ($page_name == 'classes') echo 'active'; ?> ">
                    <a href="<?php echo site_url('admin/classes'); ?>">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('all_classes'); ?></span>
                    </a>
                </li>

                <li class="<?php if ($page_name == 'class_approval_request') echo 'active'; ?> ">
                    <a href="<?php echo site_url('admin/class_approval_request'); ?>">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('approval_request'); ?></span>
                        <span class="badge label-danger float-right">
                            <?php echo $this->crud_model->get_notification_by_type('class_approval_request', 'admin')->num_rows(); ?>
                        </span>
                    </a>
                </li>

                <li class="<?php if ($page_name == 'add_class') echo 'active'; ?> ">
                    <a href="<?php echo site_url('admin/add_class'); ?>">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('add_new_class'); ?></span>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Teachers -->
        <li class="<?php if ($page_name == 'teachers' || $page_name == 'teacher_add' || $page_name == 'teacher_edit') echo 'opened active has-sub'; ?>">
            <a href="#">
                <i class="fas fa-user-friends"></i>
                <span><?php echo get_phrase('teachers'); ?></span>
            </a>
            <ul>
                <li class="<?php if ($page_name == 'teachers') echo 'active'; ?> ">
                    <a href="<?php echo site_url('admin/teachers'); ?>">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('teachers'); ?></span>
                    </a>
                </li>

                <li class="<?php if ($page_name == 'teacher_add') echo 'active'; ?> ">
                    <a href="<?php echo site_url('admin/teacher_add'); ?>">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('add_new_teacher'); ?></span>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Teachers -->
        <li class="<?php if ($page_name == 'students' || $page_name == 'student_add' || $page_name == 'student_edit') echo 'opened active has-sub'; ?>">
            <a href="#">
                <i class="fas fa-users"></i>
                <span><?php echo get_phrase('students'); ?></span>
            </a>
            <ul>
                <li class="<?php if ($page_name == 'students') echo 'active'; ?> ">
                    <a href="<?php echo site_url('admin/students'); ?>">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('students'); ?></span>
                    </a>
                </li>

                <li class="<?php if ($page_name == 'student_add') echo 'active'; ?> ">
                    <a href="<?php echo site_url('admin/student_add'); ?>">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('add_new_student'); ?></span>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Category -->
        <li class="<?php if ($page_name == 'categories' || $page_name == 'edit_category' || $page_name == 'add_category') echo 'opened active has-sub'; ?>">
            <a href="#">
                <i class="fas fa-code-branch"></i>
                <span><?php echo get_phrase('categories'); ?></span>
            </a>
            <ul>
                <li class="<?php if ($page_name == 'categories') echo 'active'; ?> ">
                    <a href="<?php echo site_url('admin/categories'); ?>">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('categories'); ?></span>
                    </a>
                </li>

                <li class="<?php if ($page_name == 'add_category') echo 'active'; ?> ">
                    <a href="<?php echo site_url('admin/add_category'); ?>">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('add_new_category'); ?></span>
                    </a>
                </li>
            </ul>
        </li>

        <li class="<?php if ($page_name == 'skills') echo 'active'; ?> ">
            <a href="<?php echo site_url('admin/skills'); ?>">
                <i class="fab fa-skyatlas"></i>
                <span><?php echo get_phrase('skills'); ?></span>
            </a>
        </li>

        <!-- Purchase history -->
        <li class="<?php if ($page_name == 'purchase_history') echo 'active'; ?> ">
            <a href="<?php echo site_url('admin/purchase_history'); ?>">
                <i class="fas fa-history"></i>
                <span><?php echo get_phrase('purchase_history'); ?></span>
            </a>
        </li>

        <!-- packages -->
        <li class="<?php if ($page_name == 'packages') echo 'active'; ?> ">
            <a href="<?php echo site_url('admin/packages'); ?>">
                <i class="fas fa-shopping-cart"></i>
                <span><?php echo get_phrase('packages'); ?></span>
            </a>
        </li>
       
        <li class="<?php
            if ($page_name == 'system_settings' || $page_name == 'website_settings'|| $page_name == 'payment_settings' || $page_name == 'manage_language' || $page_name == 'smtp_settings' || $page_name == 'about' ) echo 'opened active'; ?> ">
            <a href="#">
                <i class="fa fa-cogs"></i>
                <span><?php echo get_phrase('settings'); ?></span>
            </a>
            <ul>
                <li class="<?php if ($page_name == 'system_settings') echo 'active'; ?> ">
                    <a href="<?php echo site_url('admin/system_settings'); ?>">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('system_settings'); ?></span>
                    </a>
                </li>
                <li class="<?php if ($page_name == 'website_settings') echo 'active'; ?> ">
                    <a href="<?php echo site_url('admin/website_settings'); ?>">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('website_settings'); ?></span>
                    </a>
                </li>
                
                <li class="<?php if ($page_name == 'payment_settings') echo 'active'; ?> ">
                    <a href="<?php echo site_url('admin/payment_settings'); ?>">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('payment_settings'); ?></span>
                    </a>
                </li>
                <li class="<?php if ($page_name == 'manage_language') echo 'active'; ?> ">
                    <a href="<?php echo site_url('admin/manage_language'); ?>">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('language_settings'); ?></span>
                    </a>
                </li>
                <li class="<?php if ($page_name == 'smtp_settings') echo 'active'; ?> ">
                    <a href="<?php echo site_url('admin/smtp_settings'); ?>">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('smtp_settings'); ?></span>
                    </a>
                </li>
                <li class="<?php if ($page_name == 'about') echo 'active'; ?> ">
                    <a href="<?php echo site_url('admin/about'); ?>">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('about'); ?></span>
                    </a>
                </li>
            </ul>
        </li>
        <!-- profile -->
        <li class="<?php if ($page_name == 'profile') echo 'active'; ?> ">
            <a href="<?php echo site_url('admin/profile'); ?>">
                <i class="fas fa-user"></i>
                <span><?php echo get_phrase('profile'); ?></span>
            </a>
        </li>
    </ul>
</div>