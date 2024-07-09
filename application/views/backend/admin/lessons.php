<div class="row">
  <div class="col-lg-8 col-lg-offset-2">
    <h5 class="mb-15px pb-15px">
      <span class="text-16"><b><?php echo get_phrase('lessons'); ?></b></span>
      <span class="text-11">(<?php echo $lessons->num_rows(); ?>)</span>

      <a class="btn btn-primary btn-sm float-right" href="javascript:;" onclick="showAjaxModal('<?php echo site_url('admin/lesson_add/'.$class_details['class_id']); ?>', '<?php echo get_phrase('add_lesson'); ?>')">
        <i class="fa fa-plus"></i>
        <?php echo get_phrase('add_new_lesson'); ?>
      </a>
    </h5>
    
  </div>
  <div class="col-lg-8 col-lg-offset-2 pt-15px">
    <ul id="sortable" class="list-group">
      <?php foreach($lessons->result_array() as $lesson): ?>
        <li class="list-group-item mb-10px" id="<?php echo $lesson['lesson_id']; ?>">
          <?php if($lesson['lesson_type'] == 'youtube'): ?>
            <i class="fab fa-youtube mr-10px text-15 text-youtube"></i>
          <?php elseif($lesson['lesson_type'] == 'vimeo'): ?>
            <i class="fab fa-vimeo-v mr-10px text-15 text-vimeo"></i>
          <?php elseif($lesson['lesson_type'] == 'html5_video_url'): ?>
            <i class="fab fa-html5 mr-10px text-15 text-video-url"></i>
          <?php elseif($lesson['lesson_type'] == 'video_file'): ?>
            <i class="far fa-file-video mr-10px text-15 text-video-file"></i>
          <?php endif; ?>

          <!-- lesson title -->
          <span class="text-15"><?php echo $lesson['lesson_title']; ?></span>

          <a href="javascript:;" class="float-right arrows">
            <i class="fa fa-arrows-alt"></i>
          </a>


          <a href="javascript:;" class="float-right text-danger" onclick="confirm_modal('<?php echo site_url('admin/lesson_delete/'.$class_details['class_id'].'/'.$lesson['lesson_id']); ?>')" data-toggle="tooltip" title="<?php echo get_phrase('delete'); ?>">
            <i class="entypo-trash"></i>
          </a>

          <a href="javascript:;" class="float-right" onclick="showAjaxModal('<?php echo site_url('admin/lesson_edit/'.$class_details['class_id'].'/'.$lesson['lesson_id']); ?>', '<?php echo get_phrase('edit_lesson'); ?>')" data-toggle="tooltip" title="<?php echo get_phrase('edit'); ?>">
            <i class="entypo-pencil"></i>
          </a>

          <a href="<?php echo site_url('classes/'.slugify($class_details['class_title']).'/'.$class_details['class_id'].'?lesson_id='.$lesson['lesson_id']); ?>" target="_blank" class="float-right" data-toggle="tooltip" title="<?php echo get_phrase('view_on_frontend'); ?>">
            <i class="entypo-eye"></i>
          </a>


        </li>
      <?php endforeach; ?>
    </ul>
  </div>
</div>

<script type="text/javascript">
  'use strict';

  $(document).ajaxSuccess(function() {
    $("[data-toggle='tooltip']").tooltip();
  });

  $(function() {
    $('#sortable').sortable({
        start: function(event, ui) {
            var start_pos = ui.item.index();
            ui.item.data('start_pos', start_pos);
        },
        change: function(event, ui) {
            var start_pos = ui.item.data('start_pos');
            var index = ui.placeholder.index();
            if (start_pos < index) {
                $('#sortable li:nth-child(' + index + ')').addClass('highlights');
            } else {
                $('#sortable li:eq(' + (index + 1) + ')').addClass('highlights');
            }
        },
        update: function(event, ui) {
          $('#sortable li').removeClass('highlights');

          var lesson_id = ui.item.attr('id');
          var item_index = ui.item.index();
          $.ajax({
            type: 'post',
            url: '<?php echo site_url('admin/sort_lesson'); ?>',
            data: {class_id:'<?php echo $class_details['class_id']; ?>', 'lesson_id':lesson_id, sort_position:item_index},
            success: function(response){
              var jsonResponse = JSON.parse(response);

              if(jsonResponse.status == 'error'){
                error_notify(jsonResponse.message);
              }else{
                success_notify(jsonResponse.message);
              }
            }
          });
        }
    });
});
</script>