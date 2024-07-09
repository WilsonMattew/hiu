<?php
  $is_saved_class = 0;
  $is_following = 0;
  $class_owner = $this->crud_model->get_users($class_details['user_id'])->row_array();
  $all_lessons = $this->frontend_model->get_active_lessons_by_class_id($class_details['class_id']);

  if(isset($_GET['lesson_id']) && !empty($_GET['lesson_id'])){
    $play_lesson = $this->frontend_model->get_lessons($_GET['lesson_id']);
  }else{
    $play_lesson = $all_lessons;
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
        <a class="text-muted-10 text-decoration-none" href="<?php echo site_url('instructor/profile/'.$class_details['user_id']); ?>"><b><?php echo $class_owner['first_name'].' '.$class_owner['last_name'].'</b></a>, '.$class_owner['surname']; ?> .

        <a href="javascript:;" onclick="follow('<?php echo $class_owner['user_id']; ?>')" class="following_link <?php if($is_following > 0){echo 'text-muted-8'; } ?>"><b><?php if($is_following > 0){echo get_phrase('unfollow');}else{echo get_phrase('follow');} ?></b></a>
      </p>
    </div>
    <div class="col-lg-8">
      <!--Vieo element canvas must be stay here for height of lesson list-->
      <div id="videoElementCanvas">
        <?php
        if($all_lessons->num_rows() > 0):
          if($class_details['is_free'] == 1 || $play_lesson['is_free'] == 1){
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
      <ul class="right-lesson-play-list">
        <!--Lesson list-->
        <?php foreach($all_lessons->result_array() as $key => $lesson): ?>
          <li>
              <a href="javascript:;" onclick="load_lesson_video(this, '<?php echo slugify($class_details['class_title']); ?>', '<?php echo $class_details['class_id']; ?>', '<?php echo $lesson['lesson_id']; ?>')" class="<?php if($play_lesson['lesson_id'] == $lesson['lesson_id'])echo 'active'; ?>">

                <?php if($class_details['is_free'] == 1 || $lesson['is_free'] == 1): ?>
                  <i class="bi bi-play-circle text-18 me-3"></i>
                <?php else: ?>
                  <i class="bi bi-lock text-18 me-3"></i>
                <?php endif; ?>

                <span><?php echo ++$key.'. '.$lesson['lesson_title']; ?>
              </a>
          </li>
        <?php endforeach; ?>
      </ul>

    </div>
  </div>
</div>


<div class="container">
  <div class="row">
    <div class="col-lg-4 order-lg-2 order-xl-2 order-xxl-2" id="joiningBenefits">
      <div class="joining-benefits">
        <h3 class="pb-3 pt-xs-4 pt-sm-4 pt-md-2"><?php echo get_phrase('your_creative_journey_starts_here'); ?>.</h3>
        <div class="row">
          <div class="col-sm-12 col-md-4 col-lg-12">
            <p class="fw-500"><i class="bi bi-play-circle text-muted-7 text-23 me-2"></i> <?php echo get_phrase('unlimited_access_to_every_class'); ?></p>
          </div>
          <div class="col-sm-12 col-md-4 col-lg-12">
            <p class="fw-500"><i class="bi bi-person-circle text-muted-7 text-23 me-2"></i> <?php echo get_phrase('supportive_online_creative_community'); ?></p>
          </div>
          <div class="col-sm-12 col-md-4 col-lg-12">
            <p class="fw-500"><i class="bi bi-tablet text-muted-7 text-23 me-2"></i> <?php echo get_phrase('access_on_mobile,_laptop_and_TV'); ?></p>
          </div>
          <div class="col-sm-12 col-md-4 col-lg-12 text-center pt-3">
            <a href="<?php echo site_url('signup'); ?>" class="mstr-header-btn-free d-block"><?php echo get_phrase('Get_Started_For_Free'); ?></a>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-8 order-lg-1 order-xl-1 order-xxl-1 text-description">
      
      <div class="row pt-4">
        <div class="col align-self-start text-center px-0 text-16">
          <?php $level_arr = $this->frontend_model->best_suited_level($class_details['class_id'], 'count_result'); ?>
          <div class="skill-level-icon ms-auto me-auto mb-2">
            <span class="<?php if($level_arr['best_suited_level'] == 'all' || $level_arr['best_suited_level'] == 'beginner')echo 'active'; ?>"></span>
            <span class="<?php if($level_arr['best_suited_level'] == 'all' || $level_arr['best_suited_level'] == 'medium')echo 'active'; ?>"></span>
            <span class="<?php if($level_arr['best_suited_level'] == 'all' || $level_arr['best_suited_level'] == 'advanced')echo 'active'; ?>"></span>
          </div>
          <?php echo get_phrase($level_arr['best_suited_level'].'_level'); ?>
        </div>
        <div class="col align-self-center text-center px-0 text-16">
          <h4 class="fw-bold">
            <?php echo $this->frontend_model->get_total_watched_student($class_details['class_id']); ?>
          </h4>
          <?php echo get_phrase('students'); ?>
        </div>
        <div class="col align-self-end text-center px-0 text-16">
          <h4 class="fw-bold">
            <?php echo $this->frontend_model->get_class_projects($class_details['class_id'])->num_rows(); ?>
          </h4>
          <?php echo get_phrase('projects'); ?>
        </div>
      </div>

      <hr class="my-4">

      <h4 class="w-100 pb-3"><?php echo get_phrase('About_This_Class'); ?></h4>
      <div>
        <?php echo remove_js(htmlspecialchars_decode($class_details['description'])); ?>
      </div>

      <hr class="my-4">

      <div class="user-info-row w-100">
        <h4><?php echo get_phrase('Meet_Your_Teacher'); ?></h4>
        <div class="user-image">
          <img src="<?php echo get_user_image($class_owner['user_id']); ?>" alt="User image">
        </div>
        <div class="name-title">
          <h6><?php echo $class_owner['first_name'].' '.$class_owner['last_name']; ?> . <a href="javascript:;" onclick="follow('<?php echo $class_owner['user_id']; ?>')" class="following_link <?php if($is_following > 0){echo 'text-muted-8'; } ?>"><?php if($is_following > 0){echo get_phrase('unfollow');}else{echo get_phrase('follow');} ?></a></h6>
          <p><?php echo $class_owner['surname']; ?></p>
        </div>
        <div class="lead w-100 float-start mt-3 text-16">
          <?php echo ellipsis($class_owner['about'], 300); ?>
        </div>
        <a href="<?php echo site_url('user/profile/'.$class_owner['user_id']) ?>" class="btn p-0 mt-3 fw-bold"><?php echo get_phrase('see_full_profile') ?></a>
      </div>

      <hr class="my-4">

      <div class="w-100 mb-4">
        <?php $related_skills = $this->frontend_model->get_related_skills($class_details['class_id']); ?>
        <h4 class="mb-3"><?php echo get_phrase('Related_Skills'); ?></h4>
        <?php foreach($related_skills->result_array() as $skill): ?>
          <a href="<?php echo site_url('browse?skill='.$skill['slugify']); ?>" class="btn btn-outline-dark py-1 px-3 text-13 fw-bold"><?php echo $skill['skill_title']; ?></a>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</div>

<section class="bg-white py-4" id="calcHeigtClassRating">
  <div class="container">
    <div class="row">
      <div class="col-lg-8 pb-3">
        <h4><?php echo get_phrase('Class_Ratings'); ?></h4>
        <div class="row">
          <div class="col-sm-12 col-lg-6 mt-3">

            <?php
              $count_1st_highest  = 0;
              $count_2nd_highest = 0;
              $count_3rd_highest = 0;
              $counted_array = array();
              $indu_tag = array();
              $this->db->select('review_tag_id');
              $this->db->distinct('review_tag_id');
              $this->db->where('class_id', $class_details['class_id']);
              $review_tags = $this->db->get('reviews')->result_array();

              foreach($review_tags as $review_tag){
                $this->db->where('review_tag_id', $review_tag['review_tag_id']);
                $reviews_for_tag = $this->db->get('reviews');
                $review_num_rows = $reviews_for_tag->num_rows();

                if($count_1st_highest < $review_num_rows){
                  $count_1st_highest = $review_num_rows;

                  $indu_tag[0] = $count_1st_highest;
                  $indu_tag[1] = $this->db->get_where('review_tags', array('review_tag_id' => $review_tag['review_tag_id']))->row('review_tag_title');
                  $counted_array[0] = $indu_tag;
                }elseif($count_2nd_highest < $review_num_rows){
                  $count_2nd_highest = $review_num_rows;

                  $indu_tag[0] = $count_2nd_highest;
                  $indu_tag[1] = $this->db->get_where('review_tags', array('review_tag_id' => $review_tag['review_tag_id']))->row('review_tag_title');
                  $counted_array[1] = $indu_tag;
                }elseif($count_3rd_highest < $review_num_rows){
                  $count_3rd_highest = $review_num_rows;

                  $indu_tag[0] = $count_3rd_highest;
                  $indu_tag[1] = $this->db->get_where('review_tags', array('review_tag_id' => $review_tag['review_tag_id']))->row('review_tag_title');
                  $counted_array[2] = $indu_tag;
                }
                
              }
            ?>
            <div class="bg-body p-4 mx-2 justify-content-center">
              <h6 class="mb-4 mt-2 fw-bold text-center"><?php echo get_phrase('Most_Liked'); ?></h6>
              <?php foreach($counted_array as $counted_arr): ?>
                <p class="text-14 bg-white py-2 px-3 rounded-3 ms-auto me-auto mw-295px"><i class="bi bi-heart-fill"></i> <b><?php echo $counted_arr[0] ?></b> <?php echo $counted_arr[1] ?></p>
              <?php endforeach; ?>
            </div>
          </div>
          
          <div class="col-sm-12 col-lg-6 mt-3">
            <div class="bg-body p-4 mx-2">
              <h6 class="mb-4 mt-2 fw-bold text-center"><?php echo get_phrase('Expectations_Met'); ?>?</h6>

              <div class="w-100 py-2 px-3">
                <div class="float-start lh-sm pe-2 fw-500">
                  <p><?php echo get_phrase('exceeded'); ?>!</p>
                  <p><?php echo get_phrase('yes'); ?></p>
                  <p><?php echo get_phrase('somewhat'); ?></p>
                  <p><?php echo get_phrase('not_really'); ?></p>
                </div>
                <div class="w-auto float-left">
                  <?php $expectations_arr = $this->frontend_model->get_expectations_met($class_details['class_id']); ?>
                  <div class="w-100 mb-13px">
                    <div class="progress mr-35px h-23px">
                      <div class="progress-bar bg-warning" role="progressbar" style="width: <?php echo $expectations_arr['exceeded']; ?>%" aria-valuenow="<?php echo $expectations_arr['exceeded']; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <span class="float-end mt--22px text-13 fw-500"><?php echo $expectations_arr['exceeded']; ?>%</span>
                  </div>

                  <div class="w-100 mb-13px">
                    <div class="progress mr-35px h-23px">
                      <div class="progress-bar bg-warning" role="progressbar" style="width: <?php echo $expectations_arr['yes']; ?>%" aria-valuenow="<?php echo $expectations_arr['yes']; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <span class="float-end mt--22px text-13 fw-500"><?php echo $expectations_arr['yes']; ?>%</span>
                  </div>

                  <div class="w-100 mb-13px">
                    <div class="progress mr-35px h-23px">
                      <div class="progress-bar bg-warning" role="progressbar" style="width: <?php echo $expectations_arr['somewhat']; ?>%" aria-valuenow="<?php echo $expectations_arr['somewhat']; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <span class="float-end mt--22px text-13 fw-500"><?php echo $expectations_arr['somewhat']; ?>%</span>
                  </div>

                  <div class="w-100 mb-13px">
                    <div class="progress mr-35px h-23px">
                      <div class="progress-bar bg-warning" role="progressbar" style="width: <?php echo $expectations_arr['not_really']; ?>%" aria-valuenow="<?php echo $expectations_arr['not_really']; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <span class="float-end mt--22px text-13 fw-500"><?php echo $expectations_arr['not_really']; ?>%</span>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-12">
            <?php $reviews = $this->frontend_model->get_reviews_by_class_id($class_details['class_id']); ?>
            <?php foreach($reviews->result_array() as $key => $review): ?>
              <div class="row bg-body mt-4 py-3 mx-2" id="review_element_<?php echo $key; ?>">
                <div class="col-lg-3">
                  <div class="user-info-row w-100">
                    <div class="user-image">
                      <a href="<?php echo site_url('user/profile/'.$review['user_id']) ?>">
                        <img src="<?php echo get_user_image($review['user_id']); ?>" alt="User image">
                      </a>
                    </div>
                    <div class="name-title">
                      <h6 class="fw-bold lh-15px">
                        <a href="<?php echo site_url('user/profile/'.$review['user_id']) ?>" class="text-decoration-none mstr-color-blue ff-gt">
                          <?php echo $review['first_name'].' '.$review['last_name']; ?>    
                        </a>
                      </h6>
                      <p class="pt-2"><?php echo $review['surname']; ?></p>
                    </div>
                  </div>
                </div>
                <div class="col-lg-9">
                  <div class="row">
                    <div class="col-lg-6 ff-gt pt-7px">
                      <?php
                        if($review['expectation'] == 1){
                          echo get_phrase('this_class_met_my_expectations').' <b>'.get_phrase('somewhat').'.</b>';
                        }elseif($review['expectation'] == 2){
                          echo '<b>'.get_phrase('yes').'</b> '.get_phrase('this_class_met_my_expectations').'.';
                        }elseif($review['expectation'] == 3){
                          echo get_phrase('this_class').' <b>'.get_phrase('exceeded').'</b> '.get_phrase('my_expectations').'!';
                        }else{
                          echo get_phrase('did_this_class_meet_my_expectations').'? <b>'.get_phrase('not_really').'.</b>';
                        }
                      ?>
                    </div>
                    <div class="col-lg-6 text-end ff-gt">
                      <div class="skill-level-icon float-end ms-2">
                        <span class="<?php if($review['level'] == 'all' || $review['level'] == 'beginner')echo 'active'; ?>"></span>
                        <span class="<?php if($review['level'] == 'all' || $review['level'] == 'intermediate')echo 'active'; ?>"></span>
                        <span class="<?php if($review['level'] == 'all' || $review['level'] == 'advanced')echo 'active'; ?>"></span>
                      </div>
                      <div class="mt-7px float-end"><?php echo get_phrase('i_recommend_it_for').' <b>'.get_phrase($review['level'].'_level').'.</b>'; ?></div>
                    </div>
                  </div>
                  <hr class="my-1 bg-secondary">
                  <div class="row">
                    <div class="col-lg-12 ff-gt">
                      <?php echo $review['comment']; ?>
                      <p class="w-100 pb-0 mb-0 text-end text-12 ff-gt text-muted-6">
                        <?php 
                          if($review['updated_date']){
                            echo get_phrase('updated').' '.get_time_ago($review['updated_date']);
                          }else{
                            echo get_phrase('posted').' '.get_time_ago($review['added_date']);
                          }
                        ?>
                      </p>
                      <?php if($user_id == $review['user_id'] || login_type('admin')): ?>
                        <a href="javascript:;" onclick="confirm_modal('<?php echo site_url('classes/delete_review?review_id='.$review['review_id']); ?>', '#review_element_<?php echo $key; ?>')" class="float-end mt-2 text-12 text-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo get_phrase('delete'); ?>"><i class="bi bi-trash"></i></a>
                      <?php endif; ?>
                    </div>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          </div>

        </div>
      </div>
    </div>
  </div>
</section>