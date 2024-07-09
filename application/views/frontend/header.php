<?php if(get_frontend_settings('top_notification_status') == 1): ?>
  <div class="alert alert-light alert-dismissible fade show m-0 text-center py-2" id="topAlertBox" role="alert">
    <?php echo remove_js(htmlspecialchars_decode(get_frontend_settings('top_notification'))); ?>
    <button type="button" class="btn-close pt-2 pb-3" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
<?php endif; ?>

<nav class="navbar navbar-expand-lg mstr-navbar">
  <div class="container-fluid">
    <a class="navbar-brand" href="<?php echo site_url(); ?>">
      <img src="<?php echo base_url('uploads/system_images/logo/'.get_frontend_settings('light_logo')); ?>" height="22px" width="auto">
    </a>

    <!--Profile droupdown for small device-->
    <a href="javaScript:;" class="mstr-hover-green mstr-color-light ms-auto text-20 me-3 d-md-hidden" data-bs-toggle="offcanvas" data-bs-target="#offcanvasTopSearch" aria-controls="offcanvasTopSearch"><i class="bi bi-search"></i></a>

    <!--For mobile device icon-->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="bi bi-border-width mstr-color-light"></span>
    </button>

    <!--Its only for mobile device-->
    <?php if($login_type): ?>
      <div class="dropdown d-md-hidden me-2">
        <button class="btn p-0" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
          <img src="<?php echo get_user_image(); ?>" alt="mdo" width="32" height="32" class="rounded-circle">
        </button>
        <ul class="dropdown-menu dropdown-menu-end min-width-200px p-3" aria-labelledby="dropdownMenuButton1">
          <li class="text-center">
            <img src="<?php echo get_user_image(); ?>" alt="mdo" width="60" height="60" class="rounded-circle">
          </li>
          <li class="mb-3 text-center">
            <a class="mstr-color-blue text-decoration-none text-center d-block" href="javascript:;"><?php echo $user_name; ?></a>
            <span class="text-muted text-11">(<?php echo get_phrase($user_role); ?>)</span>
          </li>
          <li class="mb-2 text-center"><a class="mstr-header-btn-free mstr-color-blue py-1" href="<?php echo site_url('user/profile/'.$user_id); ?>"><?php echo get_phrase('view_profile'); ?></a></li>
          <hr>
          <li><a class="dropdown-item mstr-color-blue fw-bold ff-gt text-1 py-2" href="<?php echo site_url('classes/my_classes'); ?>"><?php echo get_phrase('my_classes'); ?></a></li>
          <li><a class="dropdown-item mstr-color-blue fw-bold ff-gt text-1 py-2" href="<?php echo site_url('user/account/'.$user_id); ?>"><?php echo get_phrase('account'); ?></a></li>
          <li><a class="dropdown-item mstr-color-blue fw-bold ff-gt text-1 py-2" href="<?php echo site_url('signin/sign_out'); ?>"><?php echo get_phrase('sign_out'); ?></a></li>
        </ul>
      </div>
    <?php endif; ?>


    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item dropdown">
          <a class="nav-link text-16 mstr-hover-green" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false"><?php echo get_phrase('browse'); ?> <i class="bi bi-chevron-down text-13"></i></a>
          <div class="dropdown-menu category-droupdown px-3" aria-labelledby="navbarDropdown">
            <div class="droupdown-scroll">
              <?php $categories = $this->crud_model->get_parent_categories(); ?>
              <?php foreach($categories->result_array() as $key => $category): ?>
                <?php if($key%2 == 0 && $key!=0)echo "<hr class='w-100 float-left bg-white my-2'>"; ?>
                <div class="category-menu float-left">
                  <a href="javascript:;" class="mstr-color-blue text-17 ff-gt-pro text-decoration-none pl-20px">
                    <?php echo $category['title']; ?>
                    <hr class="mt-0 pt-0 mb-1 me-0 ml-20px">
                  </a>

                  <?php $sub_categories = $this->crud_model->get_sub_categories($category['category_id']); ?>
                  <?php foreach($sub_categories->result_array() as $sub_category): ?>
                    <div class="category-sub-menu"><a href="<?php echo site_url('browse/'.$sub_category['slugify']); ?>" class="mstr-color-blue text-14 text-decoration-none fw-500 ff-normal"><?php echo $sub_category['title']; ?></a></div>
                  <?php endforeach; ?>
                </div>
              <?php endforeach; ?>
            </div>
            <div class="category-menu right float-right h-100">
              <div class="category-sub-menu">
                <a href="<?php echo site_url('browse'); ?>" class="ff-gt-pro text-dark text-17 text-decoration-none fw-bold "><?php echo get_phrase('all_classes'); ?></a>
              </div>

              <div class="category-sub-menu">
                <a href="<?php echo site_url('browse?featured=yes'); ?>" class="ff-gt-pro text-dark text-17 text-decoration-none fw-bold "><?php echo get_phrase('featured_classes'); ?></a>
              </div>

              <div class="category-sub-menu">
                <a href="<?php echo site_url('browse?recommended=yes'); ?>" class="ff-gt-pro text-dark text-17 text-decoration-none fw-bold "><?php echo get_phrase('recommended_classes'); ?></a>
              </div>
            </div>
          </div>
        </li>

        <li class="nav-item d-sm-hidden">
          <form class="d-flex header-search-box" action="<?php echo site_url('browse') ?>" method="get">
            <div class="input-group">
              <div class="input-group-text p-0">
                <button class="btn" type="submit"><i class="bi bi-search mstr-color-light"></i></button>
              </div>
              <input name="search" value="<?php if(isset($_GET['search']) && $_GET['search'] != "") echo $_GET['search']; ?>" class="form-control" list="searchingTags" type="search" placeholder="<?php echo get_phrase('what_do_you_want_to_learn_today'); ?>?" aria-label="Search">
            </div>
          </form>
        </li>
      </ul>

      <!--Profile droupdown for large device-->
      <?php if($login_type): ?>
        <?php if($user_role == 'admin'): ?>
          <a href="<?php echo site_url('admin'); ?>" class="mstr-header-btn mstr-hover-green"><?php echo get_phrase('administrator'); ?></a>
        <?php else: ?>
          <?php if($user_role == 'teacher'): ?>
            <a href="<?php echo site_url('teacher'); ?>" class="mstr-header-btn mstr-hover-green"><?php echo get_phrase('teacher'); ?></a>
          <?php endif; ?>

          <a href="<?php echo site_url('classes/my_classes'); ?>" class="mstr-header-btn mstr-hover-green"><?php echo get_phrase('my_classes'); ?></a>
          <!-- <a href="#" class="mstr-header-btn mstr-hover-green" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight"><i class="bi bi-bell"></i></a> -->
        <?php endif; ?>


        <div class="nav-item dropdown mr-12px d-sm-hidden">
          <button class="btn p-0" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="<?php echo get_user_image(); ?>" alt="mdo" width="32" height="32" class="rounded-circle">
          </button>
          <ul class="dropdown-menu dropdown-menu-end min-width-200px p-3" aria-labelledby="dropdownMenuButton1">
            <li class="text-center">
              <img src="<?php echo get_user_image(); ?>" alt="mdo" width="60" height="60" class="rounded-circle">
            </li>
            <li class="mb-3 text-center">
              <a class="mstr-color-blue text-decoration-none text-center d-block" href="javascript:;"><?php echo $user_name; ?></a>
              <span class="text-muted text-11">(<?php echo get_phrase($user_role); ?>)</span>
            </li>
            <li class="mb-2 text-center"><a class="mstr-header-btn-free mstr-color-blue py-1" href="<?php echo site_url('user/profile/'.$user_id); ?>"><?php echo get_phrase('view_profile'); ?></a></li>
            <hr>
            <li><a class="dropdown-item mstr-color-blue fw-bold ff-gt text-1 py-2" href="<?php echo site_url('classes/my_classes'); ?>"><?php echo get_phrase('my_classes'); ?></a></li>
            <li><a class="dropdown-item mstr-color-blue fw-bold ff-gt text-1 py-2" href="<?php echo site_url('user/account/'.$user_id); ?>"><?php echo get_phrase('account'); ?></a></li>
            <li><a class="dropdown-item mstr-color-blue fw-bold ff-gt text-1 py-2" href="<?php echo site_url('signin/sign_out'); ?>"><?php echo get_phrase('sign_out'); ?></a></li>
          </ul>
        </div>

        <?php if(!subscription_status()): ?>
          <a href="<?php echo site_url('membership'); ?>" class="mstr-header-btn-pro"><?php echo get_phrase('go_premium'); ?></a>
        <?php endif; ?>
      <?php endif; ?>

      <?php if(!$login_type): ?>
        <a href="<?php echo site_url('membership'); ?>" class="btn mstr-hover-green mstr-color-light fw-500 me-3 px-1"><?php echo get_phrase('go_premium'); ?></a>

        <a href="<?php echo site_url('signin'); ?>" class="btn mstr-hover-green mstr-color-light fw-500 me-3 px-1"><?php echo get_phrase('sign_in'); ?></a>

        <a href="javascript:;" onclick="showAjaxModal('<?php echo site_url('signup/modal_view'); ?>')" class="mstr-header-btn-pro"><?php echo get_phrase('sign_up'); ?></a>
      <?php endif; ?>
    </div>
  </div>
</nav>




<!--Search modal for mobile-->
<div class="offcanvas offcanvas-top h-min-content" tabindex="-1" id="offcanvasTopSearch" aria-labelledby="offcanvasTopLabel">
  <div class="offcanvas-header">
    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvasTopSearchBody pb-4 pt-1">
    <form action="<?php echo site_url('browse') ?>" method="get">
      <div class="input-group input-group-lg">
        <input name="search" value="<?php if(isset($_GET['search']) && $_GET['search'] != "") echo $_GET['search']; ?>" type="text" class="form-control" aria-describedby="inputGroup-sizing-lg" placeholder="<?php echo get_phrase('what_do_you_want_to_learn_today'); ?>?" aria-label="Search">
        <button type="submit" class="input-group-text mstr-bg-blue mstr-color-light" id="inputGroup-sizing-lg"><?php echo get_phrase('search'); ?></button>
      </div>
    </form>
  </div>
</div>
<!--End search modal-->