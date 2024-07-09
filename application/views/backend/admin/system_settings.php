<div class="row">
  <div class="col-lg-7">
    <div class="panel panel-primary" data-collapsed="0">
      <div class="panel-heading">
        <div class="panel-title">
          <?php echo get_phrase('system_settings'); ?>
        </div>
      </div>
      <div class="panel-body">
        <form action="<?php echo site_url('admin/system_settings/updated'); ?>" method="post" enctype="multipart/form-data" class="form-horizontal form-groups-bordered">
          <div class="form-group">
            <label for="system_title" class="col-sm-3 control-label"><?php echo get_phrase('website_title'); ?></label>
            <div class="col-sm-7">
              <input type="text" class="form-control" name="system_title" id="system_title" placeholder="<?php echo get_phrase('website_title'); ?>" value="<?php echo get_settings('system_title');  ?>" required>
            </div>
          </div>

          <div class="form-group">
            <label for="system_name" class="col-sm-3 control-label"><?php echo get_phrase('system_name'); ?></label>
            <div class="col-sm-7">
              <input type="text" class="form-control" name="system_name" id="system_name" placeholder="<?php echo get_phrase('system_name'); ?>" value="<?php echo get_settings('system_name');  ?>" required>
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-3 control-label"><?php echo get_phrase('slogan'); ?></label>
            <div class="col-sm-7">
              <textarea name="slogan" class="form-control" rows="3" required><?php echo get_settings('slogan');  ?></textarea>
            </div>
          </div>

          <div class="form-group">
            <label for="meta_keyword" class="col-sm-3 control-label"><?php echo get_phrase('meta_keyword'); ?></label>
            <div class="col-sm-7">
              <input type="text" class="form-control" id = "meta_keyword" value="<?php echo get_settings('meta_keywords');  ?>" name="meta_keywords" data-role="tagsinput"/>
              <span class="text-10 text-muted"><?php echo get_phrase('write_your_key_and_press_enter'); ?></span>
            </div>
          </div>

          <div class="form-group">
            <label for="meta_description" class="col-sm-3 control-label"><?php echo get_phrase('meta_description'); ?></label>
            <div class="col-sm-7">
              <textarea name="meta_description" class="form-control" rows="4" cols="80"><?php echo get_settings('meta_description');  ?></textarea>
            </div>
          </div>

          <div class="form-group">
            <label for="system_email" class="col-sm-3 control-label"><?php echo get_phrase('system_email'); ?></label>
            <div class="col-sm-7">
              <input type="email" class="form-control" name="system_email" id="system_email" placeholder="<?php echo get_phrase('system_email'); ?>" value="<?php echo get_settings('system_email');  ?>" required>
            </div>
          </div>

          <div class="form-group">
            <label for="address" class="col-sm-3 control-label"><?php echo get_phrase('address'); ?></label>
            <div class="col-sm-7">
              <textarea name="address" class="form-control" rows="5" cols="80"><?php echo get_settings('address');  ?></textarea>
            </div>
          </div>

          <div class="form-group">
            <label for="phone" class="col-sm-3 control-label"><?php echo get_phrase('phone'); ?></label>
            <div class="col-sm-7">
              <input type="text" class="form-control" name="phone" id="phone" placeholder="<?php echo get_phrase('phone'); ?>" value="<?php echo get_settings('phone');  ?>">
            </div>
          </div>

          <div class="form-group">
            <label for="timezone" class="col-sm-3 control-label"><?php echo get_phrase('timezone'); ?></label>

            <div class="col-sm-7">
              <select name="timezone" id = "timezone" class="select2" data-allow-clear="true" data-placeholder="<?php echo get_phrase('select_timezone'); ?>">
                <?php $tzlist = DateTimeZone::listIdentifiers(DateTimeZone::ALL); ?>
                <?php foreach ($tzlist as $tz): ?>
                  <option value="<?php echo $tz; ?>" <?php if(get_settings('timezone') == $tz) echo 'selected'; ?>><?php echo $tz; ?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>

        <div class="form-group">
          <label for="language" class="col-sm-3 control-label"><?php echo get_phrase('system_language'); ?></label>
          <div class="col-sm-7">
            <select name="language" id = "language" class="select2" data-allow-clear="true" data-placeholder="<?php echo get_phrase('select_language'); ?>">

              <?php foreach (get_all_language() as $language): ?>
                <option value="<?php echo $language['name']; ?>" <?php if(get_settings('language') == $language['name']) echo 'selected'; ?>><?php echo ucfirst($language['name']); ?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>

        <div class="form-group">
          <label for="purchase_code" class="col-sm-3 control-label"><?php echo get_phrase('purchase_code'); ?></label>
          <div class="col-sm-7">
            <input type="text" class="form-control" name="purchase_code" id="purchase_code" placeholder="<?php echo get_phrase('purchase_code'); ?>" value="<?php echo get_settings('purchase_code');  ?>">
          </div>
        </div>

        <div class="form-group">
          <label for="footer_text" class="col-sm-3 control-label"><?php echo get_phrase('footer_text'); ?></label>
          <div class="col-sm-7">
            <input type="text" class="form-control" name="footer_text" id="footer_text" placeholder="<?php echo get_phrase('text'); ?>" value="<?php echo get_settings('footer_text');  ?>">
          </div>
        </div>
        
        <div class="form-group">
          <label for="footer_link" class="col-sm-3 control-label"><?php echo get_phrase('footer_link'); ?></label>
          <div class="col-sm-7">
            <input type="url" class="form-control" name="footer_link" id="footer_link" placeholder="<?php echo get_phrase('url'); ?>" value="<?php echo get_settings('footer_link');  ?>">
          </div>
        </div>

        <div class="form-group">
          <label for="email_verification" class="col-sm-3 control-label"><?php echo get_phrase('email_verification'); ?></label>
          <div class="col-sm-7">
            <select name="email_verification" class="form-control">
              <option value="0" <?php if(get_settings('email_verification') == 0)echo 'selected'; ?>> <?php echo get_phrase('inactive'); ?></option>

              <option value="1" <?php if(get_settings('email_verification') == 1)echo 'selected'; ?>> <?php echo get_phrase('active'); ?></option>
            </select>
          </div>
        </div>

        <div class="form-group">
          <label for="youtube_api_key" class="col-sm-3 control-label"><?php echo get_phrase('youtube_api_key'); ?></label>
          <div class="col-sm-7">
            <input type="text" class="form-control" name="youtube_api_key" id="youtube_api_key" placeholder="<?php echo get_phrase('url'); ?>" value="<?php echo get_settings('youtube_api_key');  ?>">
            <span class="text-10"><?php echo get_phrase('make_sure_that').' <b>allow_url_fopen</b> '.get_phrase('is_enabled_on_your_server_to_use_youtube_videos'); ?></span>
          </div>
        </div>

        <div class="form-group">
          <label for="vimeo_api_key" class="col-sm-3 control-label"><?php echo get_phrase('vimeo_api_key'); ?></label>
          <div class="col-sm-7">
            <input type="text" class="form-control" name="vimeo_api_key" id="vimeo_api_key" placeholder="<?php echo get_phrase('url'); ?>" value="<?php echo get_settings('vimeo_api_key');  ?>">
          </div>
        </div>

        <div class="form-group">
          <label for="free_subscription_days" class="col-sm-3 control-label"><?php echo get_phrase('free_days'); ?></label>
          <div class="col-sm-7">
            <input type="text" class="form-control" name="free_subscription_days" id="free_subscription_days" placeholder="<?php echo get_phrase('url'); ?>" value="<?php echo get_settings('free_subscription_days');  ?>">
            <span class="text-10"><?php echo get_phrase('give_some_free_days_with_the_subscriptions'); ?>. <?php echo get_phrase("enter_0_if_you_don't_want_it"); ?>.</span>
          </div>
        </div>

        <div class="col-sm-offset-3 col-sm-5" style="padding-top: 10px;">
          <button type="submit" class="btn btn-info"><?php echo get_phrase('save_changes'); ?></button>
        </div>
      </form>
    </div>
  </div>
</div><!-- end col-->


<div class="col-lg-5">
  <div class="panel panel-primary" data-collapsed="0">
    <div class="panel-heading">
      <div class="panel-title">
        <?php echo get_phrase('product_version'); ?>
        <span class="float-right text-10">(<?php echo get_phrase('current_version').' '.get_settings('version'); ?>)</span>
      </div>
    </div>
    <div class="panel-body">
      <form action="<?php echo site_url('updater/update'); ?>" method="post" enctype="multipart/form-data" role="form" class="form-horizontal form-groups-bordered">
        <div class="form-group">
          <label for="name" class="col-sm-3 control-label"><?php echo get_phrase('file'); ?></label>
          <div class="col-sm-7">
            <input type="file" class="form-control btn-primary" id="file_name" name="file_name" accept=".zip" />
            <span class="text-10 text-muted"><b>Ex:</b> update_1.0.zip</span>
          </div>
        </div>

        <div class="col-sm-offset-3 col-sm-5" style="padding-top: 10px;">
          <button type="submit" class="btn btn-info"><?php echo get_phrase('update_product_version'); ?></button>
        </div>
      </form>
    </div>
  </div>
</div>
</div>
