<div class="container">
	<div class="class-custom-collapse mt-3">
	    <div class="action-collapse-body">
	      <div class="row">
	        <div class="col-lg-8 text-description py-3">
	          <h4 class="w-100 pb-3"><?php echo get_phrase('About_This_Class'); ?></h4>
	          <?php echo remove_js(htmlspecialchars_decode($class_details['description'])); ?>
	        </div>
	        <div class="col-lg-4 col-xl-4">
	          <div class="row my-3">
	            <div class="col align-self-start text-center px-0 pt-1 text-16">
	              <div class="skill-level-icon ms-auto me-auto mb-2">
	                <span></span>
	                <span></span>
	                <span class="active"></span>
	              </div>
	              <?php echo get_phrase('advanced_level'); ?>
	            </div>
	            <div class="col align-self-center text-center px-0 text-16">
	              <h4 class="fw-bold"><?php echo $this->frontend_model->get_total_watched_student($class_details['class_id']); ?></h4>
	              <?php echo get_phrase('students'); ?>
	            </div>
	            <!-- <div class="col align-self-end text-center px-0 text-16">
	              <h4 class="fw-bold"><?php echo $this->frontend_model->get_class_projects($class_details['class_id'])->num_rows(); ?></h4>
	              <?php echo get_phrase('projects'); ?>
	            </div> -->
	          </div>

	          <div class="user-info-row w-100 py-3 border-top">
	            <div class="user-image">
	              <a href="<?php echo site_url('user/profile/'.$class_owner['user_id']) ?>"><img src="<?php echo get_user_image($class_owner['user_id']); ?>" alt="User image"></a>
	            </div>
	            <div class="name-title">
	              <h6>
	              	<a class="text-decoration-none mstr-color-blue ff-gt-pro" href="<?php echo site_url('user/profile/'.$class_owner['user_id']) ?>"><?php echo $class_owner['first_name'].' '.$class_owner['last_name']; ?></a>

	               . <a href="javascript:;" onclick="follow('<?php echo $class_owner['user_id']; ?>')" class="following_link <?php if($is_following > 0){echo 'text-muted-8'; } ?>"><?php if($is_following > 0){echo get_phrase('unfollow');}else{echo get_phrase('follow');} ?></a></h6>
	              <p><?php echo $class_owner['surname']; ?></p>
	            </div>
	            <div class="lead w-100 float-start mt-3 text-16">
	              <?php echo ellipsis(remove_js(htmlspecialchars_decode($class_owner['about'], 300))); ?>
	            </div>
	            <a href="<?php echo site_url('user/profile/'.$class_owner['user_id']) ?>" class="btn p-0 mt-3 fw-bold"><?php echo get_phrase('see_full_profile') ?></a>
	          </div>

	          <div class="w-100 border-top py-3">
	            <?php $related_skills = $this->frontend_model->get_related_skills($class_details['class_id']); ?>
	            <h4 class="mb-3"><?php echo get_phrase('Related_Skills'); ?></h4>
	            <?php foreach($related_skills->result_array() as $skill): ?>
	            	<a href="<?php echo site_url('browse?skill='.$skill['slugify']); ?>" class="btn btn-outline-dark py-1 my-1 px-3 text-13 fw-bold"><?php echo $skill['skill_title']; ?></a>
	            <?php endforeach; ?>
	          </div>
	        </div>
	      </div>
	    </div>
	</div>
</div>