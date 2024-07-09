var mailformat = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;

//$(document).ready(function(e) {
	// // Custom droupdown on hover
	// $('.onHover').on('mouseover', function(){
	// 	if($(".showOnHover").hasClass('show') == 1){
	// 		$('.showOnHover').removeClass("show");
	// 	}else{
	// 		$('.showOnHover').addClass("show");
	// 	}
	// });
	// $('.onHover, .showOnHover').on('mouseleave', function(){
	// 	if($(".showOnHover").hasClass('show') == 1){
	// 		$('.showOnHover').removeClass("show");
	// 	}else{
	// 		$('.showOnHover').addClass("show");
	// 	}
	// });

	// // Custom slide droupdown on hover
	// $('.slideOnHover').on('mouseover', function(){
	// 	if($(".slideShowOnHover").hasClass('showed') == 1){
	// 		$('.slideShowOnHover').removeClass("showed");
	// 		$('.slideShowOnHover').slideUp(200);
	// 	}else{
	// 		$('.slideShowOnHover').addClass("showed");
	// 		$('.slideShowOnHover').slideDown(200);
	// 	}
	// });
	// $('.slideOnHover, .slideShowOnHover').on('mouseleave', function(){
	// 	if($(".slideShowOnHover").hasClass('showed') == 1){
	// 		$('.slideShowOnHover').removeClass("showed");
	// 		$('.slideShowOnHover').slideUp(200);
	// 	}else{
	// 		$('.slideShowOnHover').addClass("showed");
	// 		$('.slideShowOnHover').slideDown(200);
	// 	}
	// });

	// // Custom droupdown on click
	// $('.onClick').on('click', function(){
	// 	if($(".showOnClick").hasClass('show') == 1){
	// 		$('.showOnClick').removeClass("show");
	// 	}else{
	// 		$('.showOnClick').addClass("show");
	// 		$('.showOnClick2').removeClass("show");
	// 	}
	// });

	// // Custom droupdown on click
	// $('.onClick2').on('click', function(){
	// 	if($(".showOnClick2").hasClass('show') == 1){
	// 		$('.showOnClick2').removeClass("show");
	// 	}else{
	// 		$('.showOnClick2').addClass("show");
	// 		$('.showOnClick').removeClass("show");
	// 	}
	// });

	// // Custom slide droupdown on click
	// $('.slideOnClick').on('click', function(){
	// 	if($(".slideShowOnClick").hasClass('showed') == 1){
	// 		$('.slideShowOnClick').removeClass("showed");
	// 		$('.slideShowOnClick').slideUp(200);
	// 	}else{
	// 		$('.slideShowOnClick').addClass("showed");
	// 		$('.slideShowOnClick').slideDown(200);
	// 	}
	// });
//});


$(document).ready(function(){
	var navbar_height_withMP = Number($('.navbar').height()) + 40;
	var subNavbarHeight = $('#subNavbar').height();

	VPictureInPictire();
    fixedTopNavbar();
    joiningBenefits();

	if(!subNavbarHeight){
		$('#topAlertBox button').on('click', function(){
			setTimeout(function(){
				$('.navbar').addClass('fixed-top');
				$('body').css("padding-top", navbar_height_withMP);
			}, 200);
		});
		if (!$('#topAlertBox').length){
			$('.navbar').addClass('fixed-top');
			$('body').css("padding-top", navbar_height_withMP);
	    }
	}


    //Set daynamic height of right-lesson-play-list
    var video_element_height = Number($('#videoElementCanvas').height()) - 5;
    $('.right-lesson-play-list').height(video_element_height);

    //Picture in picture disable by onclick
    $('.btn-pip-close').on('click', function(){
    	var checkPip = $("[pictureInPicture='true']");
    	$(checkPip).removeClass('fixed-right-bottom');
		$("[pictureInPicture='true'] video").removeClass('fixed-right-bottom-video');
    	$(checkPip).attr("pictureInPicture", "false");
    });


    //For Owl Carousel
    if($(".owl-carousel")[0]){
	    $('.owl-carousel').owlCarousel({
	        lazyLoad:true,
	        margin:20,
	        responsiveClass:true,
	        navText:["<div class='nav-btn prev-slide'><i class='bi bi-chevron-left'></i></div>","<div class='nav-btn next-slide'><i class='bi bi-chevron-right'></i></div>"],
	        responsive:{
	          0:{
	              items:1,
	              nav:false
	          },
	          500:{
	            items:2,
	            nav:false
	          },
	          768:{
	              items:3,
	              nav:true
	          },
	          1000:{
	              items:4,
	              nav:true,
	              loop:false
	          }
	        }
	    });
    }


    var divWidth = $('.placeholder-1').parent().width();
	var divHeight = $('.placeholder-1').parent().height();
	$('.placeholder-1').width(divWidth);
	$('.placeholder-1').height(divHeight);
	var divWidth = $('.placeholder-2').parent().width();
	var divHeight = $('.placeholder-2').parent().height();
	$('.placeholder-2').width(divWidth);
	$('.placeholder-2').height(divHeight);


});

//Bootstrap popover initialize
var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
  return new bootstrap.Popover(popoverTriggerEl)
});
//Bootstrap popover initialize

window.onscroll = function() {fixedTopNavbar(), VPictureInPictire(), joiningBenefits()};
//Header fixed
function fixedTopNavbar() {
	var bodyScrollTop = document.body.scrollTop;
	var elementScrollTop = document.documentElement.scrollTop;
	var topAlertBoxHeight = Number($("#topAlertBox").height());
	var topAlertBoxHeightMP = Number($("#topAlertBox").height()) + 18;
	var navbar_height_withMP = Number($('.navbar').height()) + 30;
	var subNavbarHeight = $('#subNavbar').height() + 30;

	if (bodyScrollTop >= topAlertBoxHeightMP || elementScrollTop >= topAlertBoxHeightMP || subNavbarHeight) {
		//If sub navbar not exist then fixed main navbar on top else subnavbar fixed on top
		if(subNavbarHeight){
			var subNavbarBodyOffsetTop = Number($('#subNavbarBody').offset().top) - subNavbarHeight;
			if(bodyScrollTop >= subNavbarBodyOffsetTop || elementScrollTop >= subNavbarBodyOffsetTop){
				$('#subNavbar').addClass('fixed-top');
				$('#subNavbarBody').css("margin-top", subNavbarHeight-13);
				// console.log(1);
			}else{
				$('#subNavbar').removeClass('fixed-top');
				$('#subNavbarBody').css("margin-top", 0);
				// console.log(2);
			}
		}else{
			$('.navbar').addClass('fixed-top');
			$('body').css("padding-top", navbar_height_withMP);
			// console.log(3);
		}
	}else {
		if(topAlertBoxHeight > 0){
			$('.navbar').removeClass('fixed-top');
			$('body').css("padding-top", 0);
			// console.log(4);
		}
	}
}


//Video picture in picture when scroll down
function VPictureInPictire(){
    var checkPip = $("[pictureInPicture='true']");
    var videoElementHeight = $("[pictureInPicture='true'] video").height() + 7;
    var videoElementWidth = $("[pictureInPicture='true'] video").width();

    if(checkPip.height()){
		var videoElementOffset = Number($("#videoElementCanvas").offset().top) + 120;
    	if (document.body.scrollTop >= videoElementOffset || document.documentElement.scrollTop >= videoElementOffset) {
    		if(!$(checkPip).hasClass('fixed-right-bottom')){
				$(checkPip).addClass('fixed-right-bottom');
				$("[pictureInPicture='true'] video").addClass('fixed-right-bottom-video');
				$('#videoElementCanvas').height(videoElementHeight);
				$('#videoElementCanvas').width(videoElementWidth);
				$('.btn-pip-close').show();
			}
		}else {
			if($(checkPip).hasClass('fixed-right-bottom')){
				$(checkPip).removeClass('fixed-right-bottom');
				$("[pictureInPicture='true'] video").removeClass('fixed-right-bottom-video');
				$('#videoElementCanvas').height('auto');
				$('#videoElementCanvas').width('auto');
				$('.btn-pip-close').hide();
			}
		}
    }
}

function joiningBenefits(){
	// var elementScrollTop = document.documentElement.scrollTop + 150;
	// var heightParentOfThis = $('#joiningBenefits').parent().height();
	// if(heightParentOfThis){
	// 	var joiningBenefitsOffset = $('#joiningBenefits').offset().top;
	// 	var offSetWithHeight = heightParentOfThis + joiningBenefitsOffset - 24;

	// 	if(elementScrollTop >= joiningBenefitsOffset){
	// 		if(elementScrollTop < offSetWithHeight){
	// 			if(!$('#joiningBenefits .joining-benefits').hasClass('joining-benefits-fixed')){
	// 				if($('#storeVal').length){
	// 					$('#joiningBenefits .joining-benefits').css({
	// 						marginBottom: 0,
	// 						marginTop: -25
	// 					});
	// 				}
	// 				$('#joiningBenefits .joining-benefits').addClass('joining-benefits-fixed');
	// 			}
	// 		}else{
	// 			if($('#joiningBenefits .joining-benefits').hasClass('joining-benefits-fixed')){
	// 				$('#joiningBenefits .joining-benefits').removeClass('joining-benefits-fixed');
	// 			}

	// 			var calcHeigtClassRating = Number($('#calcHeigtClassRating').height()) + 20;
	// 			if(!$('#storeVal').length){
	// 				$('body').append('<div class="d-none" id="storeVal">'+heightParentOfThis+'</div>');
	// 			}
	// 			$('#joiningBenefits .joining-benefits').css({
	// 				marginBottom: - calcHeigtClassRating,
	// 				marginTop: Number($('#storeVal').text())-50
	// 			});
	// 		}	
	// 	}else{
	// 		if($('#joiningBenefits .joining-benefits').hasClass('joining-benefits-fixed')){
	// 			$('#joiningBenefits .joining-benefits').removeClass('joining-benefits-fixed');
	// 		}
	// 	}
	// }
	if($('#joiningBenefits').height()){
		var elementScrollTop = document.documentElement.scrollTop;
		var topAlertBoxHeight = Number($("#topAlertBox").height());
		var joiningBenefitsOffset = $('#joiningBenefits').offset().top - 150;
		var heightOfjoiningBenefits = $('.joining-benefits').height();
		var heightOfjoiningBenefitsFullRow = $('#joiningBenefits').parent().height();
		var heightOfClassRating = $('#calcHeigtClassRating').height();

		var totalOffset = (heightOfjoiningBenefitsFullRow + heightOfClassRating + 580) - heightOfjoiningBenefits;
		if(elementScrollTop >= joiningBenefitsOffset && $(window).width() >= 992){
			if(!topAlertBoxHeight){
				elementScrollTop = elementScrollTop + 24;
			}
			if(elementScrollTop <= totalOffset){
				$('#joiningBenefits .joining-benefits').css({
					position: 'fixed',
					top: 150,
					marginTop: -25
				});
			}else{
				$('#joiningBenefits .joining-benefits').css({
					position: 'absolute',
					top: "auto",
					marginTop: totalOffset-580
				});
			}
		}else{
			$('#joiningBenefits .joining-benefits').css({
				position: 'unset',
				top: "auto",
				marginTop: -25
			});
		}
	}
}


function show_element(action_elem, e){
	$(e).hide();
	$(action_elem).show();
}

function getUpImg(photoElem) {
    var fileName = $(photoElem).val().replace(/C:\\fakepath\\/i, '');
    return fileName;
}