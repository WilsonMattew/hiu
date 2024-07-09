<?php
  $user_id = $this->session->userdata('user_id');
  $subscription_status = subscription_status();
  $class_owner = $this->crud_model->get_users($class_details['user_id'])->row_array();
  $is_following = $this->frontend_model->get_followers_by_follower_id($class_details['user_id'])->num_rows();
  $all_lessons = $this->frontend_model->get_active_lessons_by_class_id($class_details['class_id']);
  $is_saved_class = $this->frontend_model->saved_class_by_class_id($class_details['class_id'])->num_rows();


  $watch_history = $this->frontend_model->get_watch_histories($class_details['class_id']);

  if(isset($_GET['lesson_id']) && !empty($_GET['lesson_id'])){
    $play_lesson = $this->frontend_model->get_lessons($_GET['lesson_id']);
  }else{
    $play_lesson = $this->frontend_model->get_lessons($watch_history->row('playing_lesson'));
  }

  if($play_lesson->num_rows() > 0){
    $play_lesson = $play_lesson->row_array();
  }else{
    $play_lesson = $all_lessons->row_array();
  }
?>
<div class="container-fluid mstr-bg-blue mstr-color-light">
  <div class="row">
    <div class="col-12">
      <h4 class="fw-bold mstr-color-light mt-3"><?php echo $class_details['class_title']; ?></h4>
      <p class="text-14 text-muted-10">
        <a class="text-muted-10 text-decoration-none" href="<?php echo site_url('user/profile/'.$class_details['user_id']); ?>"><b><?php echo $class_owner['first_name'].' '.$class_owner['last_name'].'</b></a>, '.$class_owner['surname']; ?> .

        <a href="javascript:;" onclick="follow('<?php echo $class_owner['user_id']; ?>')" class="following_link <?php if($is_following > 0){echo 'text-muted-8'; } ?>"><b><?php if($is_following > 0){echo get_phrase('unfollow');}else{echo get_phrase('follow');} ?></b></a>
      </p>
    </div>
    <div class="col-lg-8">
      <!--Vieo element canvas must be stay here for height of lesson list-->
      <div id="videoElementCanvas">
        <?php
        if($all_lessons->num_rows() > 0):
          if($subscription_status || $class_details['is_free'] == 1 || $play_lesson['is_free'] == 1 || $class_details['user_id'] == $user_id){
            if($play_lesson['lesson_type'] == 'youtube'):
              include 'youtube_player.php';
            elseif($play_lesson['lesson_type'] == 'vimeo'):
              include 'vimeo_player.php';
            elseif($play_lesson['lesson_type'] == 'video_file' || $play_lesson['lesson_type'] == 'html5_video_url'):
              include 'html5_player.php';
            endif;
          }else{
            include 'subscription_view.php';
          }
        else:
          echo get_phrase('no_lesson_found');
        endif;
        ?>
      </div>
      <p class="w-100 text-muted-10 text-12 mb-3 py-3">
        <span class="mstr-color-green"></span>
      </p>
    </div>
    <div class="col-lg-4">
      <?php $duration_format = duration_format($class_details['total_duration']); ?>
      <span class="text-15 fw-bold text-muted-9 ms-md-5">
        <?php echo $all_lessons->num_rows().' '.get_phrase('lessons'); ?>
        (<?php if($duration_format['h'] > 0) echo $duration_format['h'].'h '?><?php if($duration_format['m'] > 0) echo $duration_format['m'].'m '?><?php if($duration_format['s'] > 0) echo $duration_format['s'].'s'?>)
      </span>
      <!-- <a href="javascript:;" class="text-15 text-muted-9 float-end text-decoration-none mstr-hover-green"><?php echo get_phrase('view_my_notes'); ?></a> -->
      <ul class="right-lesson-play-list">
        
        <!--Lesson list-->
        <?php foreach($all_lessons->result_array() as $key => $lesson): ?>
          <li>
              <a href="javascript:;" onclick="load_lesson_video(this, '<?php echo slugify($class_details['class_title']); ?>', '<?php echo $class_details['class_id']; ?>', '<?php echo $lesson['lesson_id']; ?>')" class="<?php if($play_lesson['lesson_id'] == $lesson['lesson_id'])echo 'active'; ?>">

                <?php
                $lesson_done = json_decode($watch_history->row('lesson_done'), 1);
                if($watch_history->num_rows() > 0 && array_key_exists($lesson['lesson_id'], $lesson_done)): ?>
                  <i class="bi bi-check2 text-18 me-3"></i>
                <?php else:
                  if($subscription_status || $class_details['user_id'] == $user_id || $class_details['is_free'] == 1 || $lesson['is_free'] == 1): ?>
                    <i class="bi bi-play-circle text-18 me-3"></i>
                  <?php else: ?>
                    <i class="bi bi-lock text-18 me-3"></i>
                  <?php endif; ?>
                <?php endif; ?>

                <span><?php echo ++$key.'. '.$lesson['lesson_title']; ?>
              </a>
          </li>
        <?php endforeach; ?>
      </ul>

    </div>
  </div>
</div>







<section class="bg-body" id="subNavbar">
  <div class="container">
    <div class="row">
      <div class="col-lg-4 order-lg-2 text-center">
        <button type="button" id="addDetailpage<? echo $class_details['class_id']; ?>" onclick="bookMark('add', '<? echo $class_details['class_id']; ?>', 'Detailpage')" class="btn btn-outline-dark btn-sm mt-4 <?php if($is_saved_class) echo 'd-hidden'; ?>">
          <i class="bi bi-bookmark-plus"></i></i>
          <?php echo get_phrase('save'); ?>
        </button>

        <button type="button" id="removeDetailpage<? echo $class_details['class_id']; ?>" onclick="bookMark('remove', '<? echo $class_details['class_id']; ?>', 'Detailpage')" class="btn btn-dark btn-sm mt-4 <?php if(!$is_saved_class) echo 'd-hidden'; ?>">
          <i class="bi bi-bookmark-check-fill"></i></i>
          <?php echo get_phrase('saved'); ?>
        </button>

        <button type="button" onclick="showAjaxModal('<?php echo site_url('home/share_on?class_id='.$class_details['class_id']); ?>')" class="btn btn-outline-dark btn-sm mt-4"><i class="bi bi-share"></i> <?php echo get_phrase('share'); ?></button>
      </div>
      <div class="col-lg-8 order-lg-1">
        <div class="class-custom-collapse">
          <div class="collapse-menu">
            <a href="javascript:;" onclick="load_class_data(this, '<?php echo $class_details['class_id']; ?>', 'about')" class="active"><?php echo get_phrase('about'); ?></a>
            <a href="javascript:;" onclick="load_class_data(this, '<?php echo $class_details['class_id']; ?>', 'reviews')"><?php echo get_phrase('reviews'); ?></a>
            <a href="javascript:;" onclick="load_class_data(this, '<?php echo $class_details['class_id']; ?>', 'discussions')"><?php echo get_phrase('discussions'); ?></a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<hr class="mb-0">
<section class="p-0 m-0" id="subNavbarBody">
  <?php include 'class_about.php'; ?>
</section>
