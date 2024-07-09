<div class="panel panel-primary" data-collapsed="0">
  <div class="panel-heading">
    <div class="panel-title">
      <?php echo get_phrase('website_information'); ?>
    </div>
  </div>

  <div class="paned-body">
    <ul class="nav nav-tabs" role="tablist">
      <li role="presentation" class="<?php if($type == 'basic')echo 'active'; ?>"><a href="#basic" aria-controls="basic" role="tab" data-toggle="tab"><b><?php echo get_phrase('basic'); ?></b></a></li>

      <li role="presentation" class="<?php if($type == 'website_logo')echo 'active'; ?>"><a href="#website_logo" aria-controls="website_logo" role="tab" data-toggle="tab"><b><?php echo get_phrase('website_logo'); ?></b></a></li>

      <li role="presentation" class="<?php if($type == 'home_page_blogs')echo 'active'; ?>"><a href="#home_page_blogs" aria-controls="home_page_blogs" role="tab" data-toggle="tab"><b><?php echo get_phrase('home_page_blogs'); ?></b></a></li>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
      <div role="tabpanel" class="tab-pane <?php if($type == 'basic')echo 'active'; ?>" id="basic">
        <div class="row">
          <div class="col-md-6 col-md-offset-1">
            <?php include 'website_settings_basic_info.php'; ?>
          </div>
        </div>
      </div>

      <div role="tabpanel" class="tab-pane <?php if($type == 'website_logo')echo 'active'; ?>" id="website_logo">
        <div class="row">
          <div class="col-md-8 col-md-offset-1">
            <?php include 'website_logo.php'; ?>
          </div>
        </div>
      </div>

      <div role="tabpanel" class="tab-pane <?php if($type == 'home_page_blogs')echo 'active'; ?>" id="home_page_blogs">
        <div class="row">
          <div class="col-md-9 col-md-offset-1">
            <?php include 'website_home_page_blogs.php'; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

