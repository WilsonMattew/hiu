<!--Bootstrap Carousel-->
  <div id="classSlider" class="carousel carousel-dark slide pb-5" data-bs-ride="carousel">
    <?php $slider_classes = $this->frontend_model->get_slider_classes()->result_array(); ?>
    <div class="carousel-indicators">
      <?php foreach($slider_classes as $key => $slider_class): ?>
        <button type="button" data-bs-target="#classSlider" data-bs-slide-to="<?php echo $key; ?>" class="<?php if($key == 0) echo 'active'; ?>" aria-current="true" aria-label="Slide <?php echo ++$key; ?>"></button>
      <?php endforeach; ?>
    </div>
    <div class="carousel-inner">
      <?php foreach($slider_classes as $key => $slider_class): ?>
        <div class="carousel-item <?php if($key == 0) echo 'active'; ?>" data-bs-interval="5000" data-bs-touch="true">
          <div class="home-placeholder"></div>
          <img src="<?php echo get_class_banner($slider_class['banner'], 'optimized'); ?>" class="d-block w-100" alt="<?php echo get_phrase('class_banner_image'); ?>"> 
          <div class="container">
            <div class="carousel-caption d-none d-md-block">
              <h1 class="text-white ff-normal fw-bold"><?php echo $slider_class['class_title']; ?></h1>
              <p class="text-white ff-normal"><?php echo $slider_class['short_description']; ?></p>

              <?php if($slider_class['is_free'] == 1 || subscription_status()): ?>
                <p><a class="mstr-header-btn-pro py-1" href="<?php echo site_url('classes/'.slugify($slider_class['class_title']).'/'.$slider_class['class_id']); ?>"><?php echo get_phrase('watch_now'); ?></a></p>
              <?php else: ?>
                <p><a class="mstr-header-btn-pro py-1" href="<?php echo site_url('membership'); ?>"><?php echo get_phrase('go_premium'); ?></a></p>
              <?php endif; ?>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#classSlider" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden"><?php echo get_phrase('previous'); ?></span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#classSlider" data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden"><?php echo get_phrase('next'); ?></span>
    </button>
  </div>
  <!--Bootstrap Carousel End -->

  <!-- Owl-Carousel-->
  <div class="container pb-5">
    <h3 class="ff-gt-pro fw-bold"><?php echo get_phrase('Featured_On_'.get_settings('system_title', 1)); ?></h3>
    <div class="owl-carousel mt-4">
      <?php
      $featured_classes = $this->frontend_model->get_featured_classes()->result_array();
      foreach($featured_classes as $key => $featured_class):
        $is_saved_class = $this->frontend_model->saved_class_by_class_id($featured_class['class_id'])->num_rows();
      ?>
        <div class="class-card">
          <div class="thumbnail-label-gradient"></div>
          <div role="img" aria-label="Mastery label" class="class-thumbnail-label w-100 ff-normal"><?php echo $featured_class['title']; ?></div>
          <a class="class-card-thumbnail" href="<?php echo site_url('classes/'.slugify($featured_class['class_title']).'/'.$featured_class['class_id']); ?>" aria-label="Mastery class">
            <div class="class-card-thumbnail-img">
                <img width="458" src="<?php echo get_class_thumbnail($featured_class['class_thumbnail'], 'optimized'); ?>" alt="class image" loading="lazy">
                <div class="class-play-button"><i class="bi bi-play-circle-fill"></i></div>
            </div>
          </a>

          <div>
            <div class="p-12px">
              <div class="class-status">
                <div class="class-status-duration ff-poppins fw-bold text-12">
                  <?php
                    $duration = duration_format($featured_class['total_duration']);
                    if($duration['h'] > 0) echo $duration['h'].'h ';
                    if($duration['m'] > 0) echo $duration['m'].'m ';
                    if($duration['s'] > 0) echo $duration['s'].'s ';
                  ?>
                </div>
                <?php $total_watched_student = $this->frontend_model->get_total_watched_student($featured_class['class_id']); ?>
                <?php if($total_watched_student): ?>
                  <span class="class-student-count ff-poppins fw-bold text-12"><?php echo $total_watched_student.' '.get_phrase('students'); ?></span>
                <?php endif; ?>
              </div>

              <div>
                <p class="class-card-title">
                  <a href="<?php echo site_url('classes/'.slugify($featured_class['class_title']).'/'.$featured_class['class_id']); ?>" class="text-decoration-none mstr-color-blue fw-bold text-18 ff-poppins"><?php echo $featured_class['class_title']; ?></a>
                </p>
              </div>

              <div class="class-card-placeholder">
                <div class="class-card-teacher-placeholder">
                  <?php $class_owner = $this->crud_model->get_users($featured_class['user_id'])->row_array(); ?>
                  <div class="mt-4">
                    <p class="class-card-teacher-name">
                      <a href="<?php echo site_url('user/profile/'.$class_owner['user_id']); ?>" class="mstr-color-blue text-decoration-none ff-normal fw-bold text-14" title="<?php if($class_owner['role'] == 'admin') {echo get_phrase('admin');}else{echo get_phrase('instructor');} ?>"><?php echo $class_owner['first_name'].' '.$class_owner['last_name']; ?></a>
                    </p>
                  </div>
                </div>

                <div class="wishlist-button-container">
                  <a href="javascript:;" id="addFeatured<? echo $featured_class['class_id']; ?>" onclick="bookMark('add', '<? echo $featured_class['class_id']; ?>', 'Featured')" class="text-muted-4 text-20 mstr-hover-dark <?php if($is_saved_class) echo 'd-hidden'; ?>" title="<?php echo get_phrase('save'); ?>"><i class="bi bi-bookmark-plus"></i></a>

                  <a href="javascript:;" id="removeFeatured<? echo $featured_class['class_id']; ?>" onclick="bookMark('remove', '<? echo $featured_class['class_id']; ?>', 'Featured')" class="text-muted-4 text-20 mstr-hover-dark <?php if(!$is_saved_class) echo 'd-hidden'; ?>" title="<?php echo get_phrase('remove_from_saved_classes'); ?>"><i class="bi bi-bookmark-check-fill text-success"></i></a>
                </div>
              </div>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
  <!-- Owl-Carousel-->


  <!-- Owl-Carousel-->
  <div class="container pb-5">
    <h3 class="ff-gt-pro fw-bold"><?php echo get_phrase('Recommended_Lists'); ?></h3>
    <div class="owl-carousel mt-4">
      <?php
      $recommended_classes = $this->frontend_model->get_recommended_classes()->result_array();
      foreach($recommended_classes as $key => $recommended_class):
        $is_saved_class = $this->frontend_model->saved_class_by_class_id($recommended_class['class_id'])->num_rows();
      ?>
        <div class="class-card">
          <div class="thumbnail-label-gradient"></div>
          <div role="img" aria-label="Mastery label" class="class-thumbnail-label w-100 ff-normal"><?php echo $recommended_class['title']; ?></div>
          <a class="class-card-thumbnail ff-normal" href="<?php echo site_url('classes/'.slugify($recommended_class['class_title']).'/'.$recommended_class['class_id']); ?>" aria-label="Mastery class">
            <div class="class-card-thumbnail-img">
                <img width="458" src="<?php echo get_class_thumbnail($recommended_class['class_thumbnail'], 'optimized'); ?>" alt="class image" loading="lazy">
                <div class="class-play-button"><i class="bi bi-play-circle-fill"></i></div>
            </div>
          </a>

          <div>
            <div class="p-12px">
              <div class="class-status">
                <div class="class-status-duration ff-poppins fw-bold text-12">
                  <?php
                    $duration = duration_format($recommended_class['total_duration']);
                    if($duration['h'] > 0) echo $duration['h'].'h ';
                    if($duration['m'] > 0) echo $duration['m'].'m ';
                    if($duration['s'] > 0) echo $duration['s'].'s ';
                  ?>
                </div>

                <?php $total_watched_student = $this->frontend_model->get_total_watched_student($recommended_class['class_id']); ?>
                <?php if($total_watched_student): ?>
                  <span class="class-student-count ff-poppins fw-bold text-12"><?php echo $total_watched_student.' '.get_phrase('students'); ?></span>
                <?php endif; ?>
              </div>

              <div>
                <p class="class-card-title">
                  <a href="<?php echo site_url('classes/'.slugify($recommended_class['class_title']).'?id='.$recommended_class['class_id']); ?>" class="text-decoration-none mstr-color-blue fw-bold text-18 ff-poppins"><?php echo $recommended_class['class_title']; ?></a>
                </p>
              </div>

              <div class="class-card-placeholder">
                <div class="class-card-teacher-placeholder">
                  <?php $class_owner = $this->crud_model->get_users($recommended_class['user_id'])->row_array(); ?>
                  <div class="mt-4">
                    <p class="class-card-teacher-name">
                      <a href="<?php echo site_url('user/profile/'.$class_owner['user_id']); ?>" class="mstr-color-blue text-decoration-none ff-poppins fw-bold text-14" title="<?php if($class_owner['role'] == 'admin') {echo get_phrase('admin');}else{echo get_phrase('instructor');} ?>"><?php echo $class_owner['first_name'].' '.$class_owner['last_name']; ?></a>
                    </p>
                  </div>
                </div>

                <div class="wishlist-button-container">
                  <a href="javascript:;" id="addRecommended<? echo $recommended_class['class_id']; ?>" onclick="bookMark('add', '<? echo $recommended_class['class_id']; ?>', 'Recommended')" class="text-muted-4 text-20 mstr-hover-dark <?php if($is_saved_class) echo 'd-hidden'; ?>" title="<?php echo get_phrase('save'); ?>"><i class="bi bi-bookmark-plus"></i></a>

                  <a href="javascript:;" id="removeRecommended<? echo $recommended_class['class_id']; ?>" onclick="bookMark('remove', '<? echo $recommended_class['class_id']; ?>', 'Recommended')" class="text-muted-4 text-20 mstr-hover-dark <?php if(!$is_saved_class) echo 'd-hidden'; ?>" title="<?php echo get_phrase('remove_from_saved_classes'); ?>"><i class="bi bi-bookmark-check-fill text-success"></i></a>
                </div>
              </div>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
  <!-- Owl-Carousel-->




<section class="bg-white py-5">
  <div class="container">
    <?php $home_blogs = json_decode(get_frontend_settings('home_page_blogs')); ?>
    <?php foreach($home_blogs as $key => $home_blog): ?>
      <?php if($key%2 == 0): $order = 'order-md-1'; else: $order = 'order-md-2'; endif; ?>
      <div class="row align-items-lg-center mt-5 pt-5">
        <div class="col-md-7 order-md-2 col-lg-7 text-center">
          <img src="<?php echo site_url('uploads/home_page_images/'.$home_blog->image); ?>" width="100%" height="auto" class="box-shadow-bottom-tv">
        </div>
        <div class="col-8 mx-auto <?php echo $order; ?> col-md-5 col-lg-5">
          <h1 class="my-3 ff-gt-pro"><?php echo ($home_blog->title); ?></h1>
          <p class="mb-4 fw-500 text-18"><?php echo remove_js(htmlspecialchars_decode($home_blog->description)); ?></p>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</section>