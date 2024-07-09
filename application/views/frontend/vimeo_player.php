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
<div class="plyr__video-embed" id="player">
  <iframe
    src="https://player.vimeo.com/video/76979871?loop=false&amp;byline=false&amp;portrait=false&amp;title=false&amp;speed=true&amp;transparent=0&amp;gesture=media"
    allowfullscreen
    allowtransparency
    allow="autoplay"
  ></iframe>
</div>
<link rel="stylesheet" href="<?php echo base_url();?>assets/global/plyr/plyr.css">
<script src="<?php echo base_url();?>assets/global/plyr/plyr.js"></script>
<script>
	const player = new Plyr('#player');
	var vid = document.getElementById("player");
	var seeking = false;

	player.on('ready', event => {
		player.play();
	});
	vid.addEventListener('seeking', event => {
	  seeking = true;
	});

	setInterval(function(){
		if(player.currentTime > 0){
			update_watch_history('<?php echo $class_details['class_id']; ?>', '<?php echo $play_lesson['lesson_id']; ?>', player.currentTime);
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
		if(seeking == false){
			player.currentTime = <?php echo $current_duration; ?>;
		}
		 
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