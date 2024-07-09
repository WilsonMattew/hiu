<?php
    $social_links = json_decode($user_info['social'], true);
 ?>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-primary" data-collapsed="0">
            <div class="panel-heading">
                <div class="panel-title">
                    <?php echo get_phrase('edit_profile'); ?>
                </div>
            </div>
            <div class="panel-body">
                <form action="<?php echo site_url('admin/profile/updated'); ?>" method="post" enctype="multipart/form-data" role="form" class="form-horizontal form-groups-bordered">
                    <div class="form-group">
                        <label for="first_name" class="col-sm-3 control-label"><?php echo get_phrase('first_name'); ?></label>
                        <div class="col-sm-7">
                            <input type="text" name="first_name" value="<?php echo $user_info['first_name'];?>" class="form-control" id="first_name" aria-describedby="emailHelp" placeholder="<?php echo get_phrase('enter_first_name'); ?>" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="last_name" class="col-sm-3 control-label"><?php echo get_phrase('last_name'); ?></label>
                        <div class="col-sm-7">
                            <input type="text" name="last_name" value="<?php echo $user_info['last_name'];?>" class="form-control" id="last_name" aria-describedby="emailHelp" placeholder="<?php echo get_phrase('enter_last_name'); ?>" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="surname" class="col-sm-3 control-label"><?php echo get_phrase('designation'); ?></label>
                        <div class="col-sm-7">
                            <textarea class="form-control" rows="3" name="surname"><?php echo $user_info['surname']; ?></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="phone" class="col-sm-3 control-label"><?php echo get_phrase('phone'); ?></label>
                        <div class="col-sm-7">
                            <input type="text" name="phone" value="<?php echo $user_info['phone'];?>" class="form-control" id="phone" placeholder="<?php echo get_phrase('phone'); ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="facebook" class="col-sm-3 control-label"><?php echo get_phrase('facebook'); ?></label>
                        <div class="col-sm-7">
                            <input type="link" class="form-control" name="facebook" placeholder="<?php echo get_phrase('write_down_facebook_url') ?>" value="<?php echo $social_links['facebook']; ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="twitter" class="col-sm-3 control-label"><?php echo get_phrase('twitter'); ?></label>
                        <div class="col-sm-7">
                            <input type="link" class="form-control" name="twitter" placeholder="<?php echo get_phrase('write_down_twitter_url') ?>" aria-describedby="twitter" value="<?php echo $social_links['twitter']; ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="linkedin" class="col-sm-3 control-label"><?php echo get_phrase('linkedin'); ?></label>
                        <div class="col-sm-7">
                            <input type="link" class="form-control" name="linkedin" placeholder="<?php echo get_phrase('write_down_linkedin_url') ?>" aria-describedby="linkedin" value="<?php echo $social_links['linkedin']; ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="website" class="col-sm-3 control-label"><?php echo get_phrase('website'); ?></label>
                        <div class="col-sm-7">
                            <input type="link" class="form-control" name="website" placeholder="<?php echo get_phrase('write_down_website_url') ?>" aria-describedby="website" value="<?php echo $social_links['website']; ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="address" class="col-sm-3 control-label"><?php echo get_phrase('address'); ?></label>
                        <div class="col-sm-7">
                            <textarea name="address" class="form-control" rows="5" cols="80"><?php echo $user_info['address'];?></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="about" class="col-sm-3 control-label"><?php echo get_phrase('about'); ?></label>
                        <div class="col-sm-7">
                            <textarea name="about" class="form-control common_editor" rows="4" cols="80"><?php echo $user_info['about'];?></textarea>
                        </div>
                    </div>


                    <div class="form-group">
                    <label class="col-sm-3 control-label"><?php echo get_phrase('user_image'); ?></label>

                    <div class="col-sm-7">

                      <div class="fileinput fileinput-new" data-provides="fileinput">
                        <div class="fileinput-new thumbnail" style="width: 200px; height: 200px;" data-trigger="fileinput">
                          <img src="<?php echo get_user_image($this->session->userdata('user_id')); ?>" alt="...">
                        </div>
                        <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px"></div>
                        <div>
                          <span class="btn btn-white btn-file">
                            <span class="fileinput-new"><?php echo get_phrase('select_image'); ?></span>
                            <span class="fileinput-exists"><?php echo get_phrase('change'); ?></span>
                            <input type="file" name="user_image" accept="image/*">
                          </span>
                          <a href="#" class="btn btn-orange fileinput-exists" data-dismiss="fileinput"><?php echo get_phrase('remove'); ?></a>
                        </div>
                      </div>
                    </div>
                  </div>

                    <div class="col-sm-offset-3 col-sm-5" style="padding-top: 10px;">
                        <button type="submit" class="btn btn-info"><?php echo get_phrase('update_profile'); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div><!-- end col-->
</div>