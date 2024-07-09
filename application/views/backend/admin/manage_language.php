<?php  ?>
<div class="row">
    <div class="col-12">
        <div class="panel" style="margin-left: 15px; margin-right: 15px">
            <div class="panel-body">
                <ul class="nav nav-tabs nav-bordered">
                    <?php if(isset($edit_phrase_language)):?>
                        <li class="nav-item">
                            <a href="#edit" data-toggle="tab" aria-expanded="false" class="nav-link <?php if(isset($edit_phrase_language)) echo 'active';?>">
                                <?php echo get_phrase('edit_phrase');?>
                            </a>
                        </li>
                    <?php endif;?>
                    <li class="nav-item">
                        <a href="#list" data-toggle="tab" aria-expanded="false" class="nav-link <?php if(!isset($edit_phrase_language)) echo 'active';?>">
                            <i class="entypo-menu"></i>
                            <span class="d-none d-lg-block"><?php echo get_phrase('language_list');?></span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#add_lang" data-toggle="tab" aria-expanded="false" class="nav-link">
                            <i class="entypo-plus-circled"></i>
                            <span class="d-none d-lg-block"><?php echo get_phrase('add_language');?></span>
                        </a>
                    </li>
                </ul>

                <div class="tab-content">
                    <!----PHRASE EDITING TAB STARTS-->
                    <?php if (isset($edit_phrase_language)):
                        $current_editing_language   =   $edit_phrase_language;
                    ?>
                        <div class="tab-pane <?php if(isset($edit_phrase_language)) echo 'active';?>" id="edit">
                            <div class="row">
                                <?php foreach ($language_phrases as $key => $lang_phrase): ?>
                                <div class="col-sm-12 col-md-3 col-lg-3">
                                    <div class="panel" style="border: 1px solid #efefef; box-shadow: 3px 4px 20px 5px rgb(245 245 245);">
                                        <div class="panel-header" style=" padding: 8px; padding-left: 15px; border-bottom: 1px solid #efefef;">
                                            <?php
                                                echo str_replace('_', ' ', $lang_phrase['phrase']);
                                            ?>
                                        </div>
                                        <div class="panel-body">
                                            <form action="javascript:;">
                                                <p>
                                                    <input type="text" class="form-control" name="updated_phrase" value="<?php echo ucfirst($lang_phrase['translated']); ?>" id = "phrase-<?php echo $key; ?>">
                                                </p>
                                                <button type="submit" class="btn btn-primary edit-success" style="float: right;" id = "btn-<?php echo $key; ?>" onclick="updatePhrase('<?php echo $lang_phrase['phrase']; ?>', '<?php echo $key; ?>')"><i class = "fa fa-check"></i> </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif;?>
                    <!----PHRASE EDITING TAB ENDS-->

                    <!----TABLE LISTING STARTS-->
                    <div class="tab-pane <?php if(!isset($edit_phrase_language)) echo 'active';?>" id="list">

                        <div class="table-responsive-sm">
                            <table class="table table-bordered table-centered mb-0">
                                <thead>
                                    <tr>
                                        <th><?php echo get_phrase('language');?></th>
                                        <th><?php echo get_phrase('option');?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach(get_all_language() as $key => $language):?>
                                    <tr>
                                        <td><?php echo ucwords($language['name']);?></td>
                                        <td>
                                            <a href="<?php echo site_url('admin/manage_language/edit_phrase/'.$language['name']);?>"
                                                class="btn btn-info">
                                                <?php echo get_phrase('edit_phrase');?>
                                            </a>
                                            <a href="<?php echo site_url('admin/manage_language/delete_language/'.$language['name']);?>"
                                                class="btn btn-danger">
                                                <?php echo get_phrase('delete_language');?>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>

                        </div>
                    </div>
                    <!----TABLE LISTING ENDS--->

                    <!----ADD NEW LANGUAGE---->
                    <div class="tab-pane" id="add_lang">
                        <div class="row ">
                            <div class="col-md-3"></div>
                            <div class="col-sm-12 col-md-6">
                                <div class="panel">
                                    <div class="panel-body">
                                        <form class="" action="<?php echo site_url('admin/manage_language/add_language'); ?>" method="post">
                                            <div class="form-group">
                                                  <label for="language"><?php echo get_phrase('add_new_language'); ?></label>
                                                  <input type="text" id="language" name="language" class="form-control" placeholder="" required>
                                              </div>
                                            <button type="submit" class="btn btn-primary" name="button"><?php echo get_phrase('save'); ?></button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!----LANGUAGE ADDING FORM ENDS-->

                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    function updatePhrase(phrase, key) {

        $('#btn-'+key).attr('disabled', true);
        $('#phrase-'+key).attr('disabled', true);
        var updated_phrase = $('#phrase-'+key).val();
        var language = '<?php echo $current_editing_language; ?>';

        $.ajax({
            type : "POST",
            url  : "<?php echo site_url('admin/update_phrase_with_ajax'); ?>",
            data : {phrase : phrase, updated_phrase : updated_phrase, language : language},
            success : function(response) {
                $('#btn-'+key).attr('disabled', false);
                $('#phrase-'+key).attr('disabled', false);

                toastr.success('Translation saved');
            }
        });
    }

</script>
