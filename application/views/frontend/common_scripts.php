<script type="text/javascript">
	function send_verification_code(){
		$('.mail-sending-preloader').show();
		$.ajax({
			type: 'post',
			url: '<?php echo site_url('signup/resend_verification_mail'); ?>',
			success: function(response){
				if(response == 1){
					success_message('<?php echo get_phrase('mail_successfully_sent_to_your_inbox'); ?>');
				}else if(response == 2){
					error_message('<?php echo get_phrase('session_time_out'); ?>');
				}else{
					error_message('<?php echo get_phrase('user_not_found'); ?>');
				}
				$('.mail-sending-preloader').hide();
			}
		});
	}
	
	function change_url(url, title){
		var url = '<?php echo site_url(); ?>'+url;
		

		const stateObj = { foo: 'bar' };
		if(title){
			var title  = title+' | <?php echo get_settings('system_title'); ?>';
		}else{
			var title = $('title').html();
		}
		window.history.pushState(stateObj, title, url);
	}

	window.onpopstate = function() {
		location.reload();
	}

	function bookMark(type,class_id,class_type){
		$.ajax({
			type: 'get',
			url: '<?php echo site_url('home/bookmark'); ?>',
			data:{'type':type, 'class_id':class_id},
			success: function(response){
				response = JSON.parse(response);
				if(response.status == 'error'){
					error_message(response.message);
				}else{
					if(class_type){
						if(type == 'add'){
							$('#add'+class_type+class_id).hide();
							$('#remove'+class_type+class_id).show();
						}else{
							$('#remove'+class_type+class_id).hide();
							$('#add'+class_type+class_id).show();
						}
					}
				}
			}
		});
	}


	function follow(user_id, color){
		$.ajax({
			type: 'post',
			url: '<?php echo site_url('home/follow/'); ?>'+user_id,
			success: function(response){
				response = JSON.parse(response);
				if(response.status == 'error'){
					error_message(response.message);
				}else{
					if(response.message == 'followed'){
						$('.following_link').html('<b><?php echo get_phrase('unfollow'); ?></b>');
						$('.following_link').addClass('<?php echo 'text-muted-8'; ?>');
					}else{
						$('.following_link').html('<b><?php echo get_phrase('follow'); ?></b>');
						$('.following_link').removeClass('<?php echo 'text-muted-8'; ?>');
					}
				}
			}
		});
	}
	function follow2(e, actionElem, user_id){
		$.ajax({
			type: 'post',
			url: '<?php echo site_url('home/follow/'); ?>'+user_id,
			success: function(response){
				response = JSON.parse(response);
				if(response.status == 'error'){
					error_message(response.message);
				}else{
					$(e).hide();
					$(actionElem).show();
				}
			}
		});
	}

	function load_lesson_video(e, class_title, class_id, lesson_id){
		var lesson_url = 'classes/'+class_title+'/'+class_id+'?lesson_id='+lesson_id;
		$('.right-lesson-play-list li a').removeClass('active');
		$(e).addClass('active');
		change_url(lesson_url);
		$.ajax({
			type: 'post',
			url: '<?php echo site_url(); ?>'+lesson_url,
			data:{'is_ajax_call':1},
			success: function(response){
				location.reload();
			}
		});
	}

	function load_all_classes(e, url, loading){
		if(!loading){
			$('.top-loader-bar').html('<div class="top-loader"></div>');
		}

		change_url(url);
		if(e){
			$('.category-list li a').removeClass('active');
			$(e).addClass('active');
		}

		$.ajax({
			type: 'post',
			url: '<?php echo site_url(); ?>'+url,
			data:{'is_ajax_call':1},
			success: function(response){
				$('.top-loader-bar').html('');
				$('#loadAllClasses').html(response);
			}
		});
	}

	function load_class_data(e, class_id, type, loader_off){
		if(!loader_off){
			$('.top-loader-bar').html('<div class="top-loader"></div>');
		}
		if(e){
			$('.collapse-menu a').removeClass('active');
			$(e).addClass('active');
		}
		$.ajax({
			type: 'get',
			url: '<?php echo site_url('classes/class_details'); ?>',
			data:{'class_id':class_id, 'type':type},
			success: function(response){
				$('.top-loader-bar').html('');
				$('#subNavbarBody').html(response);
			}
		});
	}

	function my_classes(e, type){
		var loader = '<div class="col-12 w-100"><div class="w-100 text-center"><img src="<?php echo base_url('assets/global/gif/preloader1.gif'); ?>" width="200px"></div></div>';
		$('#myClassBody').html(loader);

		change_url('classes/my_classes?type='+type);
		if(e){
			$('.collapse-menu a').removeClass('active');
			$(e).addClass('active');
		}
		$.ajax({
			type: 'post',
			url: '<?php echo site_url('classes/my_classes?type='); ?>'+type,
			data:{'is_ajax_call':'yes'},
			success: function(response){
				$('#myClassBody').html(response);
			}
		});
	}

	function update_watch_history(class_id, lesson_id, seconds, is_done){
		$.ajax({
			type: 'post',
			url: '<?php echo site_url('classes/update_watch_history/'); ?>'+class_id+'/'+lesson_id+'/'+seconds+'/'+is_done,
			success: function(response){
				console.log(response);
			}
		});
	}

	function confirm_modal(url, hide, show){
		var delete_btn = '<a href="javascript:;" onclick="$(&apos;.custom-modal&apos;).removeClass(&apos;custom-modal-show&apos;), ajax_call(&apos;'+url+'&apos;, &apos;'+hide+'&apos;)" class="btn btn-danger ms-t common-delete-button-No-reapet"><?php echo get_phrase("continue"); ?></a>';
		$('#deleteModal').addClass('custom-modal-show');
		$('.common-delete-button-No-reapet').remove();
		$("#deleteModalContentBody").append(delete_btn);
	}

	function ajax_call(url, hide, show){
		$.ajax({
			type: 'get',
			url: url,
			success: function(response){
				response = JSON.parse(response);
				if(response.status == 'error'){
					error_message(response.message);
				}else{
					success_message(response.message);
					if(hide){
						$(hide).fadeOut(500);
					}
					if(show){
						$(show).show();
					}
					if(!hide && !show){
						location.reload();
					}
				}
			}
		});
	}

	function review_delete_confirm_modal(url, class_id, type){
		var delete_btn = '<a href="javascript:;" onclick="$(&apos;.custom-modal&apos;).removeClass(&apos;custom-modal-show&apos;), review_delete_ajax_call(&apos;'+url+'&apos;, &apos;'+class_id+'&apos;, &apos;'+type+'&apos;)" class="btn btn-danger ms-t common-delete-button-No-reapet"><?php echo get_phrase("continue"); ?></a>';
		$('#deleteModal').addClass('custom-modal-show');
		$('.common-delete-button-No-reapet').remove();
		$("#deleteModalContentBody").append(delete_btn);
	}

	function review_delete_ajax_call(url, class_id, type){
		$.ajax({
			type: 'get',
			url: url,
			success: function(response){
				response = JSON.parse(response);
				if(response.status == 'error'){
					error_message(response.message);
				}else{
					success_message(response.message);
					load_class_data('', class_id, type);
				}
			}
		});
	}
	
	function removeFromWatchingClass(class_id){
		$.ajax({
			type: 'get',
			url: "<?php echo site_url('classes/remove_watching_class?class_id='); ?>"+class_id,
			success: function(response){
				response = JSON.parse(response);
				if(response.status == 'error'){
					error_message(response.message);
				}
			}
		});
	}
	
	$(function() {
	    //Top progress & progress bar
	    var progress = '<div class="real-top-progress"><div class="real-top-progress-bar " role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div></div>';
	    
	    //The progress bar appended on the body.
	    $('body').append(progress);

	    //The progress bar inside the progress div has been taken in a variable.
	    var progress_bar = $('.real-top-progress-bar');

	    //The form of submission to RailTeam js is defined here.(Form class or ID)
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
	                location.reload();
	            }, 700);
	        },
	        error: function()
	        {
	            //You can write here your js error message
	        }
	    });
	});
</script>