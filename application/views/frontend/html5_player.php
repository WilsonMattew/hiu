
<?php
	if(login_type() && $watch_history->num_rows() > 0){
		$lesson_duration = json_decode($watch_history->row('lesson_current_duration'), 1);
		if(array_key_exists($play_lesson['lesson_id'], $lesson_duration)){
			$current_duration = $lesson_duration[$play_lesson['lesson_id']];
		}else{
			$current_duration = 0;
		}
	}else{
		$current_duration = 0;
	}
?>
<div pictureInPicture="<?php if(login_type()){echo 'true';}else{echo 'false';} ?>">
  <button class="btn-pip-close d-hidden"><i class="bi bi-x-circle"></i></button>
  <video class="p-0 m-0" width="100%" controlsList="nodownload" oncontextmenu="return false;" controls disablePictureInPicture playsinline id="html5Videoplayer">
    <source id="mp4src" type="video/mp4" src="<?php echo $play_lesson['lesson_src']; ?>#t=<?php echo $current_duration; ?>">
  </video>
</div>
<link rel="stylesheet" href="<?php echo base_url();?>assets/global/plyr/plyr.css">
<script src="<?php echo base_url();?>assets/global/plyr/plyr.js"></script>
<style type="text/css">
	button[data-plyr="pip"] {
	  display: none !important;
	}
</style>
<script type="text/javascript">
	$('#mp4src').remove();

	const player = new Plyr('#html5Videoplayer');
	var vid = document.getElementById("html5Videoplayer");
	
	setInterval(function(){
		if(player.currentTime > 0){
			update_watch_history('<?php echo $class_details['class_id']; ?>','<?php echo $play_lesson['lesson_id']; ?>', player.currentTime);
		}

	},5000);

	vid.onended = function() {
		if(<?php echo $play_lesson['duration'] ?> < <?php echo get_frontend_settings('lesson_done_seconds'); ?>){
	  		update_watch_history('<?php echo $class_details['class_id']; ?>', '<?php echo $play_lesson['lesson_id']; ?>', player.currentTime, 1);
	  	}
	};

	var done = false;
	var videoPause = false;
	vid.onplay = function() {
		if (!videoPause && !done) {
		  setTimeout(isDone, 120000);
		  done = true;
		}
	};

	vid.onpause = function() {
		videoPause == true;
	};

	function isDone() {
		update_watch_history('<?php echo $class_details['class_id']; ?>', '<?php echo $play_lesson['lesson_id']; ?>', player.currentTime, 1);
	}

	
</script>