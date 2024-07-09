<?php
	$video_details = $this->video_model->getVideoDetails($play_lesson['lesson_src']);

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

<div id="player"></div>
<script id="rendered-js" >
	if($(window).width() >= 992){
		var iframeHeight = 490;
	}else{
		var iframeHeight = 200;
	}
	var tag = document.createElement('script');
	tag.src = "https://www.youtube.com/player_api";
	var firstScriptTag = document.getElementsByTagName('script')[0];
	firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
	var player;
	function onYouTubePlayerAPIReady() {
		player = new YT.Player('player', {
		    height: iframeHeight,
		    width: '100%',
		    videoId: '<?php echo $video_details['video_id']; ?>',
			events: {
				'onReady': onPlayerReady,
				'onStateChange': onPlayerStateChange
			}
		});
	}

	//auto play after ready video
	function onPlayerReady(event){
		event.target.playVideo();
		player.seekTo(<?php echo $current_duration; ?>);


		var video_element_height = Number($('#videoElementCanvas').height()) - 5;
    	$('.right-lesson-play-list').height(video_element_height);
	}


	//minimum stay 2 minutes on this video while playing the video to mark as Done
	var done = false;
	function onPlayerStateChange(event) {
		if (event.data == YT.PlayerState.PLAYING && !done) {
		  setTimeout(isDone, 120000);
		  done = true;
		}
		if(event.data==YT.PlayerState.ENDED  && <?php echo $play_lesson['duration'] ?> < <?php echo get_frontend_settings('lesson_done_seconds'); ?>){
			isDone();
		}

		//reset current time after ending the video
		if(event.data==YT.PlayerState.ENDED){
			update_watch_history('<?php echo $class_details['class_id']; ?>', '<?php echo $play_lesson['lesson_id']; ?>', 0, 1);
		}
	}


	function isDone() {
		update_watch_history('<?php echo $class_details['class_id']; ?>', '<?php echo $play_lesson['lesson_id']; ?>', player.playerInfo.currentTime, 1);
	}


	//Duration update
	setInterval(function(){
		if(player.playerInfo.currentTime > 0){
			update_watch_history('<?php echo $class_details['class_id']; ?>', '<?php echo $play_lesson['lesson_id']; ?>', player.playerInfo.currentTime);
		}
	},5000);
</script>


