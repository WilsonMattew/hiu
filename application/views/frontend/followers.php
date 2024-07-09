<?php $user_id = $this->session->userdata('user_id'); ?>
<div class="card pt-4">
  <div class="card-body">
    <ul class="list-group list-group-dividered list-group-full">
      <?php foreach($followers->result_array() as $key => $row): ?>
        <?php $user_row = $this->crud_model->get_users($row['follower_user_id'])->row_array(); ?>
        <?php $indu_followers =  $this->frontend_model->get_followers_by_user_id($user_row['user_id'])->num_rows(); ?>
        <?php $is_followed = $this->frontend_model->get_followers_by_follower_id($user_row['user_id'])->num_rows(); ?>
        <li class="list-group-item">
          <div class="row">
            <div class="col-sm-2 col-md-1 text-center">
              <a href="<?php echo site_url('user/profile/'.$user_row['user_id']); ?>">
                <img src="<?php echo get_user_image($row['follower_user_id']); ?>" width="40px" class="rounded-circle">
              </a>
            </div>
            <div class="col-sm-5 col-md-6 text-center text-md-start">
              <a href="<?php echo site_url('user/profile/'.$user_row['user_id']); ?>" class="text-decoration-none">
                <h6 class="m-0 p-0"><?php echo $user_row['first_name'].' '.$user_row['last_name']; ?></h6>
                <span class="m-0 p-0 text-11"><?php echo get_phrase('followers').' '.$indu_followers; ?> </span>
              </a>
            </div>

            <div class="col-sm-5 col-md-5 text-center text-md-end">
              <a href="javascript:;" onclick="follow2(this, '.<?= $key; ?>follow_btn', '<?php echo $user_row['user_id']; ?>')" class="<?= $key; ?>following_btn btn btn-primary rounded-pill border-primary fw-500 py-1 px-4 <?php if($is_followed <= 0) echo 'd-hidden'; ?>">
                <?php echo get_phrase('following'); ?>
              </a>

              <a href="javascript:;" onclick="follow2(this, '.<?= $key; ?>following_btn', '<?php echo $user_row['user_id']; ?>')" class="<?= $key; ?>follow_btn btn btn-outline-primary rounded-pill border border-2 border-primary fw-500 py-1 px-4 <?php if($is_followed > 0) echo 'd-hidden'; ?>">
                <i class="bi bi-plus text-18"></i>
                <?php echo get_phrase('follow'); ?>
              </a>
            </div>
        </li>
      <?php endforeach; ?>
    </ul>
  </div>
</div>