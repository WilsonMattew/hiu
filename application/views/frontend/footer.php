<footer class="footer mstr-bg-blue pt-4 pb-md-4 pt-md-5 border-top">
  <div class="container">
    <div class="row">
      <div class="col-6 col-md">
        <h4 class="ff-normal"><?php echo get_phrase('top_categories'); ?></h4>
        <?php $top_categories = $this->frontend_model->get_top_categories(); ?>
        <ul class="list-unstyled text-small">
          <?php foreach($top_categories as $category_and_class_num): ?>
            <?php $category = $this->crud_model->get_categories($category_and_class_num['category_id'])->row_array(); ?>
            <li class="mb-1">
              <a class="link-secondary" href="<?php echo site_url('browse/'.$category['slugify']); ?>"><?php echo $category['title']; ?> <b>(<?php echo $category_and_class_num['class_number']; ?>)</b></a>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>
      <div class="col-6 col-md">
        <h4 class="ff-normal"><?php echo get_phrase('top_skills'); ?></h4>
        <?php $top_skils = $this->frontend_model->get_top_skills(); ?>
        <ul class="list-unstyled text-small">
          <?php foreach($top_skils as $skills_and_class_num):
            $skills = $this->crud_model->get_skills($skills_and_class_num['skill_id'])->row_array(); ?>
            <li class="mb-1">
              <a class="link-secondary" href="<?php echo site_url('browse?skill='.$skills['slugify']); ?>"><?php echo $skills['skill_title']; ?> <b>(<?php echo $skills_and_class_num['class_number']; ?>)</b></a>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>
      <div class="col-6 col-md">
        <h4 class="ff-normal"><?php echo get_phrase('useful_links'); ?></h4>
        <ul class="list-unstyled text-small">
          <li class="mb-1">
            <a class="link-secondary" href="<?php echo site_url('browse'); ?>">
              <?php echo get_phrase('all_classes'); ?>
            </a>
          </li>
          <li class="mb-1">
            <a class="link-secondary" href="<?php echo site_url('browse?featured=yes'); ?>">
              <?php echo get_phrase('featured_classes'); ?>
            </a>
          </li>
          <li class="mb-1">
            <a class="link-secondary" href="<?php echo site_url('browse?recommended=yes'); ?>">
              <?php echo get_phrase('recommended_classes'); ?>
            </a>
          </li>
          <li class="mb-1">
            <a class="link-secondary" href="<?php echo site_url('membership'); ?>">
              <?php echo get_phrase('go_premium'); ?>
            </a>
          </li>
        </ul>
      </div>
      <div class="col-6 col-md">
        <h4 class="ff-normal fw-bold text-white"><?php echo get_settings('system_title'); ?></h4>
        <small class="d-block mb-3 text-white"><?php echo get_settings('system_name'); ?></small>
        <hr class="my-2 bg-white">
        <small class="d-block mb-3 text-muted-8">
          <?php echo ellipsis(get_settings('slogan'), 300); ?>
        </small>
      </div>
    </div>
    <div class="bottom-footer">
      <div class="link">
        <?php if(get_settings('footer_link')): ?>
          <a href="<?php echo get_settings('footer_link'); ?>"><?php echo get_settings('footer_text'); ?></a>
        <?php endif; ?>
        <a href="<?php echo site_url('home/about_us'); ?>"><?php echo get_phrase('about_us'); ?></a>
        <a href="<?php echo site_url('home/privacy_policy'); ?>"><?php echo get_phrase('privacy_policy'); ?></a>
        <a href="<?php echo site_url('home/terms_and_condition'); ?>"><?php echo get_phrase('terms_&_condition'); ?></a>
        <a href="<?php echo site_url('home/faq'); ?>"><?php echo get_phrase('faq'); ?></a>
      </div>
      <div class="social-link">
        <?php
          $instagram = get_settings('instagram');
          $twitter = get_settings('twitter');
          $linkedin = get_settings('linkedin');
          $facebook = get_settings('facebook');
        ?>
        <?php if($instagram): ?><a href="<?php echo $instagram; ?>"><i class="bi bi-instagram"></i></a><?php endif; ?>
        <?php if($twitter): ?><a href="<?php echo $twitter; ?>"><i class="bi bi-twitter"></i></a><?php endif; ?>
        <?php if($linkedin): ?><a href="<?php echo $linkedin; ?>"><i class="bi bi-linkedin"></i></a><?php endif; ?>
        <?php if($facebook): ?><a href="<?php echo $facebook; ?>"><i class="bi bi-facebook"></i></a><?php endif; ?>
      </div>
    </div>
  </div>
</footer>