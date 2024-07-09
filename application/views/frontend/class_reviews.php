<?php $user_id = $this->session->userdata('user_id'); ?>
<section class="bg-white py-4">
  <div class="container mt-2 px-lg-5 px-md-5">
    <div class="row">
      <div class="col-12">
        <h4 class="w-100">
          <?php echo get_phrase('how_students_rated_this_class'); ?>

          <?php $my_reviews = $this->frontend_model->get_reviews_user_and_class($class_details['class_id']); ?>

          <?php if($my_reviews->num_rows() > 0): ?>
            <button class="btn btn-sm btn-light float-end border border-1 fw-bold <?php if(!subscription_status())echo ''; ?>" onclick="showLargeModal('<?php echo site_url('classes/edit_review_form?class_id='.$class_details['class_id']); ?>')">
              <?php echo get_phrase('Edit_Review'); ?>
            </button>
          <?php else: ?>
            <button class="btn btn-sm btn-light float-end border border-1 fw-bold <?php if(!subscription_status() && $class_details['is_free'] == 0)echo 'disabled'; ?>" onclick="showLargeModal('<?php echo site_url('classes/add_review_form?class_id='.$class_details['class_id']); ?>')">
              <?php echo get_phrase('Leave_Review'); ?>
            </button>
          <?php endif; ?>
        </h4>
      </div>
      <div class="col-sm-12 col-lg-4 mt-3">
        <div class="bg-body p-4 mx-2 justify-content-center">
          <?php $level_arr = $this->frontend_model->best_suited_level($class_details['class_id'], 'count_result'); ?>
          <h6 class="mb-4 mt-2 fw-bold text-center"><?php echo get_phrase('best_suited_for'); ?></h6>
          <div class="w-60px h-60px rounded-circle mstr-bg-blue p-3 ms-auto me-auto">
            <div class="skill-level-icon ms-auto me-auto mb-2">
              <span class="<?php if($level_arr['best_suited_level'] == 'all' || $level_arr['best_suited_level'] == 'beginner')echo 'active'; ?>"></span>
              <span class="<?php if($level_arr['best_suited_level'] == 'all' || $level_arr['best_suited_level'] == 'intermediate')echo 'active'; ?>"></span>
              <span class="<?php if($level_arr['best_suited_level'] == 'all' || $level_arr['best_suited_level'] == 'advanced')echo 'active'; ?>"></span>
            </div>
          </div>
          <div class="ms-auto me-auto py-2 px-4 bg-white text-center fw-bold mt-3">
            <?php echo get_phrase($level_arr['best_suited_level']); ?>
            <i class="bi bi-info-circle" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo get_phrase('the_teachers_recommendation_is_shown_until_at_least_5_student_responses_are_collected').' '.get_phrase('the_level_is_determined_by_a_majority_opinion_of_students_who_have_reviewed_this_class'); ?>"></i>
          </div>
          <div class="w-100 text-center fw-bold text-12 mt-4 pt-2px">
            (<?php
              if($level_arr['total_reviews'] < 5):
                echo get_phrase('based_on_the_teachers_recommendation');
              else:
                echo get_phrase('based_on').' '.$level_arr['total_reviews'].' '.get_phrase('reviews');
              endif;
            ?>)
          </div>
        </div>
      </div> 
      <div class="col-sm-12 col-lg-4 mt-3">
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
      
      <div class="col-sm-12 col-lg-4 mt-3">
        <div class="bg-body p-4 mx-2">
          <h6 class="mb-4 mt-2 fw-bold text-center"><?php echo get_phrase('Expectations_Met'); ?>?</h6>
          <?php $expectations_arr = $this->frontend_model->get_expectations_met($class_details['class_id']); ?>
          <div class="w-100 py-2 px-3">
            <div class="float-start lh-sm pe-2 fw-500">
              <p><?php echo get_phrase('exceeded'); ?>!</p>
              <p><?php echo get_phrase('yes'); ?></p>
              <p><?php echo get_phrase('somewhat'); ?></p>
              <p><?php echo get_phrase('not_really'); ?></p>
            </div>
            <div class="w-auto float-left">
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
    </div>
  </div>


  <div class="container px-32px">
    <?php foreach($reviews->result_array() as $key => $review): ?>
      <div class="row bg-body mt-4 py-3 mx-lg-4 mx-md-4" id="review_element_<?php echo $key; ?>">
        <div class="col-lg-3">
          <div class="user-info-row w-100">
            <div class="user-image">
              <a href="<?php echo site_url('home/profile/'.$review['user_id']) ?>">
                <img src="<?php echo get_user_image($review['user_id']); ?>" alt="User image">
              </a>
            </div>
            <div class="name-title">
              <h6 class="fw-bold">
                <a href="<?php echo site_url('home/profile/'.$review['user_id']) ?>" class="text-decoration-none mstr-color-blue ff-gt">
                  <?php echo $review['first_name'].' '.$review['last_name']; ?>    
                </a>
              </h6>
              <p><?php echo $review['surname']; ?></p>
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
              <div class="mt-7px"><?php echo get_phrase('i_recommend_it_for').' <b>'.get_phrase($review['level'].'_level').'.</b>'; ?></div>
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
                <a href="javascript:;" onclick="review_delete_confirm_modal('<?php echo site_url('classes/delete_review?review_id='.$review['review_id']); ?>', '<?php echo $class_details['class_id']; ?>', 'reviews')" class="float-end mt-2 text-12 text-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo get_phrase('delete'); ?>"><i class="bi bi-trash"></i></a>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</section>
<script type="text/javascript">$("[data-bs-toggle='tooltip']").tooltip();</script>