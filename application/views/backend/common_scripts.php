<script type="text/javascript">
	"use strict";

	jQuery(document).ready(function($) {
		$('.datatable').DataTable();
		$('.icon-picker').iconpicker();
		$('.common_editor').trumbowyg();
		$('#common_editor').trumbowyg();
		
		$( "#sortable" ).sortable();
    	$( "#sortable" ).disableSelection();
	});

	$(function() {
	    var progress_bar = $('.top-progress-bar');

	    $('.realtime-form').ajaxForm({
	        beforeSend: function() {
	            var percentVal = '0%';
	            progress_bar.width(percentVal);
	            progress_bar.show();
	            console.log(percentVal);
	        },
	        uploadProgress: function(event, position, total, percentComplete) {
	            var percentVal = percentComplete + '%';
	            progress_bar.width(percentVal);
	            console.log(percentVal);
	            
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

	function validURL(str) {
		var pattern = new RegExp('^(https?:\\/\\/)?'+ // protocol
			'((([a-z\\d]([a-z\\d-]*[a-z\\d])*)\\.)+[a-z]{2,}|'+ // domain name
			'((\\d{1,3}\\.){3}\\d{1,3}))'+ // OR ip (v4) address
			'(\\:\\d+)?(\\/[-a-z\\d%_.~+]*)*'+ // port and path
			'(\\?[;&a-z\\d%_.~+=-]*)?'+ // query string
			'(\\#[-a-z\\d_]*)?$','i'); // fragment locator
		return !!pattern.test(str);
	}
</script>