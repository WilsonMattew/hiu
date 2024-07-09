<form class="realtime-form" action="<?php echo site_url('admin/lesson_edit/updated/'.$lesson['lesson_id'].'/'.$class_id); ?>" method="post" enctype="multipart/form-data">
	<div class="row mb-15px">
		<label for="lesson_title" class="col-sm-3 control-label text-right pt-5px"><?php echo get_phrase('lesson_title'); ?>*</label>
		<div class="col-sm-7">
			<input type="text" class="form-control" value="<?php echo $lesson['lesson_title'] ?>" name="lesson_title" id="lesson_title" placeholder="<?php echo get_phrase('lesson_title'); ?>" required>
		</div>
	</div>

	<div class="row mb-15px">
		<label for="lesson_type" class="col-sm-3 control-label text-right pt-5px"><?php echo get_phrase('lesson_type'); ?>*</label>
		<div class="col-sm-7">
			<select class="form-control" name="lesson_type" id="lesson_type" onchange="showSrcField(this)" required>
				<option value=""><?php echo get_phrase('select_a_lesson_type'); ?></option>
				<option value="youtube" <?php if('youtube' == $lesson['lesson_type'])echo 'selected'; ?>><?php echo get_phrase('youtube'); ?></option>

				<option value="vimeo" <?php if('vimeo' == $lesson['lesson_type'])echo 'selected'; ?>><?php echo get_phrase('vimeo'); ?></option>

				<option value="html5_video_url" <?php if('html5_video_url' == $lesson['lesson_type'])echo 'selected'; ?>><?php echo get_phrase('html5_video_url'); ?></option>

				<option value="video_file" <?php if('video_file' == $lesson['lesson_type'])echo 'selected'; ?>><?php echo get_phrase('video_file'); ?></option>
			</select>
		</div>
	</div>

	<div class="row mb-15px lesson_src_field <?php if($lesson['lesson_type'] == 'video_file')echo 'd-hidden'; ?>" id="for_video_url">
		<label for="video_url" class="col-sm-3 control-label text-right pt-5px"><?php echo get_phrase('video_url'); ?>*</label>
		<div class="col-sm-7">
			<input id="video_url" onblur="get_video_duration(this)" type="url" name="video_url" value="<?php echo $lesson['lesson_src'] ?>" class="form-control" placeholder="<?php echo get_phrase('enter_your_video_url'); ?>">
		</div>
	</div>

	<div class="row mb-15px lesson_src_field <?php if($lesson['lesson_type'] != 'video_file')echo 'd-hidden'; ?>" id="for_video_file">
		<label for="video_file" class="col-sm-3 control-label text-right pt-5px"><?php echo get_phrase('video_file'); ?>*</label>
		<div class="col-sm-7">
			<input id="video_file" onchange="get_video_duration(this)" type="file" name="video_file" accept="video/*" class="form-control">
		</div>
	</div>

	<div class="row mb-15px" id="for_duration">
		<label for="duration" class="col-sm-3 control-label text-right pt-5px">
			<?php echo get_phrase('duration'); ?>*
		</label>
		<div class="col-sm-7 input-group pl-15px pr-15px">
			<?php $duration = duration_format($lesson['duration']); ?>
			<input type="text" value="<?php echo $duration['h'].':'.$duration['m'].':'.$duration['s']; ?>" id="duration" name="duration" class="form-control timepicker" data-template="dropdown" data-show-seconds="true" data-show-meridian="false" data-hour-step="2" data-minute-step="2" data-second-step="2" placeholder="<?php echo get_phrase('hour').' : '.get_phrase('minutes').' : '.get_phrase('seconds'); ?>" readonly required>
			<span class="input-group-btn">
				<button id="durationSyncBtn" type="button" class="btn rounded-right-3" data-toggle="tooltip" data-placement="top" title="<?php echo get_phrase('enter_video_duration'); ?>">
					<i class="fa fa-info-circle"></i>
				</button>
			</span>
		</div>
	</div>

	<div class="row mb-15px">
		<label class="col-sm-3 control-label text-right pt-5px"></label>
		<div class="col-sm-7">
			<input type="checkbox" name="is_free_lesson" value="1" id="is_free_lesson" <?php if ($lesson['is_free'] == 1)echo 'checked'; ?>>
			<label for="is_free_lesson">
				<?php echo get_phrase('if_you_want_to_keep_it_free,_checked_here'); ?>
			</label>
		</div>
	</div>

	<div class="row mb-15px">
		<label for="video_thumbnail" class="col-sm-3 control-label text-right pt-5px"></label>
		<div class="col-sm-7">
			<button type="submit" class="btn btn-primary"><?php echo get_phrase('update_lesson'); ?></button>
		</div>
	</div>

</form>

<script type="text/javascript">
	'use strict';

	$('#durationSyncBtn').tooltip();
	$('.timepicker').timepicker();

	function showSrcField(e){
		var lesson_type = $(e).val();
		$('.lesson_src_field').hide();
		if(lesson_type == 'video_file'){
			$('#for_video_file').show();
		}else if(lesson_type == ''){
			$('.lesson_src_field').hide();
		}else{
			$('#for_video_url').show();
		}
	}

	function get_video_duration(e){
		var lesson_type = $('#lesson_type').val();
		var video_url = $(e).val();

		if(lesson_type == 'youtube' || lesson_type == 'vimeo'){
			$('#durationSyncBtn').text('<?php echo get_phrase('syncing'); ?>..');
			if(validURL(video_url)){
				$.ajax({
					type: 'post',
					url: '<?php echo site_url('admin/get_video_duration_by_type/'); ?>',
					data:{'lesson_type' : lesson_type, 'video_url' : video_url},
					success: function(response){
						$('#duration').val(response);
						$('#durationSyncBtn').html('<?php echo get_phrase('done'); ?>!');
					}
				});
			}else{
				error_notify('<?php echo get_phrase('please_enter_a_valid_url'); ?>');
			}
		}else{
			$('#duration').prop('readonly', false);
			$('#durationSyncBtn').html('<?php echo get_phrase('enter_manually'); ?>');
		}
	}

	$(function() {
	    var progress_bar = $('.top-progress-bar');

	    $('.realtime-form').ajaxForm({
	        beforeSend: function() {
	            var percentVal = '0%';
	            progress_bar.width(percentVal);
	            progress_bar.show();
	        },
	        uploadProgress: function(event, position, total, percentComplete) {
	            var percentVal = percentComplete + '%';
	            progress_bar.width(percentVal);
	            
	        },
	        complete: function(xhr) {
	        	setTimeout(function(){
	                progress_bar.hide();
	            }, 800);

	        	var jsonResponse = JSON.parse(xhr.responseText);

	        	if(jsonResponse.status == 'error'){
	        		error_notify(jsonResponse.message);
	        	}else{
	        		if(jsonResponse.redirect){
		        		window.location.replace(jsonResponse.redirect);
		        	}else{
		        		$('.modal').modal('hide');
		        		load_class_info('lessons');
		        		success_notify(jsonResponse.message);
		        	}
		        }
	        },
	        error: function()
	        {
	            //You can write here your js error message
	        }
	    });
	});
</script>