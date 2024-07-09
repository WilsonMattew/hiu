<div class="row mt-4">
  <div class="col-12">
    <?php
      $current_url = explode(base_url(), current_url());
      $current_url =  $current_url[1];
      $url_arr =  explode('/', $current_url);

      $offset = end($url_arr);

      //check is offset valu or category title
      if(is_numeric($offset)){
        $current_url = str_replace('/'.$offset, '', $current_url);
      }
      if(isset($_GET['featured'])){
        $action_url = $current_url.'?featured='.$_GET['featured'].'&';
        $reset_url = $current_url.'?featured='.$_GET['featured'];
      }elseif(isset($_GET['recommended'])){
        $action_url = $current_url.'?recommended='.$_GET['recommended'].'&';
        $reset_url = $current_url.'?recommended='.$_GET['recommended'];
      }elseif(isset($_GET['skill'])){
        $action_url = $current_url.'?skill='.$_GET['skill'].'&';
        $reset_url = $current_url.'?skill='.$_GET['skill'];
      }elseif(isset($_GET['search'])){
        $action_url = $current_url.'?search='.$_GET['search'].'&';
        $reset_url = $current_url.'?search='.$_GET['search'];
      }else{
        $action_url = $current_url.'?';
        $reset_url = $current_url;
      }

      if(isset($_GET['pricing']) && $_GET['pricing'] != 'all'){
        $get_pricing = $_GET['pricing'];
      }else{
        $get_pricing = 'all';
      }

      if(isset($_GET['duration_range']) && $_GET['duration_range'] != 'all'){
        $duration_range = $_GET['duration_range'];
      }else{
        $duration_range = 'all';
      }
    ?>
    <div class="form-group float-start">
      <input type="radio" id="filter_free" class="ml-3" onclick="load_all_classes(false, '<?php echo $action_url.'pricing=free&duration_range='.$duration_range; ?>')" <?php if(isset($_GET['pricing']) && $_GET['pricing'] == 'free')echo 'checked'; ?>>
      <label class="pe-3 fw-500" for="filter_free"><?php echo get_phrase('free'); ?></label>
    </div>
    <div class="form-group float-start">
      <input type="radio" id="filter_premium" class="ml-3" onclick="load_all_classes(false, '<?php echo $action_url.'pricing=premium&duration_range='.$duration_range; ?>')" <?php if(isset($_GET['pricing']) && $_GET['pricing'] == 'premium')echo 'checked'; ?>>
      <label class="pe-3 fw-500" for="filter_premium"><?php echo get_phrase('premium'); ?></label>
    </div>

    <div class="float-start px-3">|</div>

    <div class="form-group float-start">
      <input type="radio" id="0-30min" class="ml-3" onclick="load_all_classes(false, '<?php echo $action_url.'pricing='.$get_pricing.'&duration_range=less30'; ?>')" <?php if(isset($_GET['duration_range']) && $_GET['duration_range'] == 'less30')echo 'checked'; ?>>
      <label class="pe-3 fw-500" for="0-30min"> <?php echo get_phrase('less_than_30_min'); ?></label>
    </div>
    <div class="form-group float-start">
      <input type="radio" id="31-60min" class="ml-3" onclick="load_all_classes(false, '<?php echo $action_url.'pricing='.$get_pricing.'&duration_range=31to60'; ?>')" <?php if(isset($_GET['duration_range']) && $_GET['duration_range'] == '31to60')echo 'checked'; ?>>
      <label class="pe-3 fw-500" for="31-60min"><?php echo get_phrase('30_to_60_min'); ?></label>
    </div>

    <div class="form-group float-start">
      <input type="radio" id="greater60" class="ml-3" onclick="load_all_classes(false, '<?php echo $action_url.'pricing='.$get_pricing.'&duration_range=greater60'; ?>')" <?php if(isset($_GET['duration_range']) && $_GET['duration_range'] == 'greater60')echo 'checked'; ?>>
      <label class="pe-3 fw-500" for="greater60"> <?php echo get_phrase('greater_than_60_min'); ?></label>
    </div>
    <div class="form-group float-end">
      <button class="btn btn-outline-dark py-0" onclick="load_all_classes(false, '<?php echo $reset_url; ?>')">
        <i class="bi bi-arrow-repeat"></i>
        <?php echo get_phrase('reset'); ?>
      </button>
    </div>
  </div>
</div>


  <div class="row mt-4">
    <div class="col-12">
      <a class="ff-gt-pro mstr-color-blue text-decoration-none"><?php echo get_phrase('related_skills'); ?> : </a>
      <?php
      if($classes->num_rows() > 0):

        $class_ids = array();
        foreach($classes->result_array() as $class_row):
          array_push($class_ids, $class_row['class_id']);
        endforeach;

        $related_skills = $this->frontend_model->get_related_skills_by_class_ids($class_ids);
        foreach($related_skills->result_array() as $related_skill): ?>
          <a href="javascript:;" onclick="load_all_classes(this, 'browse?skill=<?php echo $related_skill['slugify'] ?>')" class="btn btn-outline-dark py-1 my-1 px-3 text-13 fw-bold <?php if(isset($_GET['skill']) && $related_skill['slugify'] == $_GET['skill'])echo 'active'; ?>"><?php echo $related_skill['skill_title']; ?></a>
        <?php endforeach; ?>
      <?php else: ?>
        <span class="ff-normal text-12"><?php echo get_phrase('no_related_skills'); ?></span>
      <?php endif; ?>
    </div>
  </div>

<div class="row mt-3">
  <div class="col-12 text-end text-12 pb-2 pe-3"><?php echo get_phrase('total').' <b>'.$total_result.'</b> '.get_phrase('results'); ?></div>
  <?php foreach($classes->result_array() as $class): ?>
    <?php $is_saved_class = $this->frontend_model->saved_class_by_class_id($class['class_id'])->num_rows(); ?>
    <?php $class_owner = $this->crud_model->get_users($class['user_id'])->row_array(); ?>
    <div class="col-sm-6 col-md-6 col-lg-4 mb-4">
      <div class="class-card">
        <div class="thumbnail-label-gradient"></div>
        <div role="img" aria-label="Mastery label" class="class-thumbnail-label">
          <?php if($class['is_featured'] == 1){ ?>
            <span class="rounded-pill mstr-bg-blue ff-gt-pro text-uppercase text-10 px-3 py-1"><?php echo get_phrase('featured'); ?></span>
          <?php } ?>
        </div>
        <a class="class-card-thumbnail" href="<?php echo site_url('classes/'.slugify($class['class_title']).'/'.$class['class_id']); ?>" aria-label="Mastery class">
          <div class="class-card-thumbnail-img">
              <img width="458" src="<?php echo get_class_thumbnail($class['class_thumbnail'], 'optimized'); ?>" alt="class image" loading="lazy">
              <div class="class-play-button"><i class="bi bi-play-circle-fill"></i></div>
          </div>
        </a>

        <div>
          <div class="p-15px">
            <div class="class-status">
              <div class="class-status-duration ff-poppins fw-bold text-13">
                <?php
                  $duration = duration_format($class['total_duration']);
                  if($duration['h'] > 0) echo $duration['h'].'h ';
                  if($duration['m'] > 0) echo $duration['m'].'m ';
                  if($duration['s'] > 0) echo $duration['s'].'s ';
                ?>
              </div>
              <?php $total_wached_student = $this->frontend_model->get_total_watched_student($class['class_id']); ?>
              <?php if($total_wached_student): ?>
                <span class="class-student-count ff-poppins fw-bold text-13"><?php echo $total_wached_student.' '.get_phrase('students'); ?></span>
              <?php endif; ?>
            </div>

            <div>
              <p class="class-card-title">
                <a href="<?php echo site_url('classes/'.slugify($class['class_title']).'/'.$class['class_id']); ?>" class="text-decoration-none mstr-color-blue fw-bold text-18 ff-normal"><?php echo $class['class_title']; ?></a>
              </p>

              <p class="ff-normal text-13 fw-bold mb-0"><?php echo $class['short_description']; ?></p>

              <div class="class-card-placeholder">
                <div class="class-card-teacher-placeholder">
                  <div class="mt-4">
                    <p class="class-card-teacher-name">
                      <a href="<?php echo site_url('user/profile/'.$class_owner['user_id']); ?>" class="mstr-color-blue text-decoration-none ff-normal fw-bold text-15" title="<?php if($class_owner['role'] == 'admin') {echo get_phrase('admin');}else{echo get_phrase('instructor');} ?>"><?php echo $class_owner['first_name']; ?></a>
                    </p>
                  </div>
                </div>

                <div class="wishlist-button-container">
                  <a href="javascript:;" id="addFeatured<? echo $class['class_id']; ?>" onclick="bookMark('add', '<? echo $class['class_id']; ?>', 'Featured')" class="text-muted-4 text-20 mstr-hover-dark <?php if($is_saved_class) echo 'd-hidden'; ?>" title="<?php echo get_phrase('save'); ?>"><i class="bi bi-bookmark-plus"></i></a>

                  <a href="javascript:;" id="removeFeatured<? echo $class['class_id']; ?>" onclick="bookMark('remove', '<? echo $class['class_id']; ?>', 'Featured')" class="text-muted-4 text-20 mstr-hover-dark <?php if(!$is_saved_class) echo 'd-hidden'; ?>" title="<?php echo get_phrase('remove'); ?>"><i class="bi bi-bookmark-check-fill text-success"></i></a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  <?php endforeach; ?>

  <?php if($classes->num_rows() <=0 ): ?>
    <div class="row mt-5">
      <div class="col-md-12 text-center">
        <h5 class="ff-gt-pro text-muted-7"><?php echo get_phrase('no_data_found'); ?>!</h5>
        <p class="text-13 text-muted-7"><?php echo get_phrase('try_again_with_another_category'); ?></p>
      </div>
    </div>
  <?php endif; ?>

  <div class="col-12">
    <div class="row justify-content-center mt-3 mb-4">
      <div class="col-auto">
        <?php echo $this->pagination->create_links(); ?>
      </div>
    </div>
  </div>
</div>