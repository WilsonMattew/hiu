
<!--Right Modal(OFF canvas)-->
<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
  <div class="offcanvas-header">
    <h5 id="offcanvasRightLabel">Offcanvas right</h5>
    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">
    ...
  </div>
</div>
<!--Right modal-->


<div class="custom-modal custom-modal-effect-1" id="customModal">
  <div class="custom-modal-content">
    <button class="custom-modal-closed"><i class="bi bi-x"></i></button>
    <div id="customModalBody" class="w-100">
      <div class="w-100 text-center"><img src="<?php echo base_url('assets/global/gif/preloader1.gif'); ?>" width="200px"></div>
    </div>
  </div>
</div>

<div class="custom-modal custom-modal-effect-1 mw-1100px" id="largeModal">
  <div class="custom-modal-content">
    <button class="custom-modal-closed"><i class="bi bi-x"></i></button>
    <div id="largeModalBody" class="w-100">
      <div class="w-100 text-center"><img src="<?php echo base_url('assets/global/gif/preloader1.gif'); ?>" width="200px"></div>
    </div>
  </div>
</div>

<div class="custom-modal custom-modal-effect-1" id="deleteModal">
  <div class="custom-modal-content">
    <button class="custom-modal-closed"><i class="bi bi-x"></i></button>
    <div class="w-100 text-center p-5" id="deleteModalContentBody">
      <p class="text-center"><?php echo get_phrase('are_you_sure_to_delete'); ?>?</p>
      <a href="javascript:;" onclick="$('.custom-modal').removeClass('custom-modal-show');" class="btn btn-secondary me-2"><?php echo get_phrase('cancel'); ?></a>
      <!--Append here the delete button-->
    </div>
  </div>
</div>
<div class="custom-modal-overlay"></div>


<script type="text/javascript">
  "use strict";
  
  // //Custom modal
  // function sign_up_modal(is){
  //   //document.body.style.overflow = 'hidden';
  //   if('<?php echo get_settings('signin_with_google') ?>' == '1' && '<?php echo $page_name; ?>' != 'sign_in' && '<?php echo $page_name; ?>' != 'sign_up'){
  //     $('#sign_up_modal').addClass('custom-modal-show');
  //   }else{
  //     location.replace('<?php echo site_url('signup'); ?>')
  //   }
  // }

  function showAjaxModal(url){
    var loader = '<div class="col-12 w-100"><div class="w-100 text-center"><img src="<?php echo base_url('assets/global/gif/preloader1.gif'); ?>" width="200px"></div></div>';
    $('#customModalBody').html(loader);
    
    $('#customModal').addClass('custom-modal-show');
    $.ajax({
      type: 'get',
      url: url,
      success: function(response){
        $('#customModalBody').html(response);
      }
    });
  }

  function showLargeModal(url){
    $('#largeModal').addClass('custom-modal-show');
    $.ajax({
      type: 'get',
      url: url,
      success: function(response){
        $('#largeModalBody').html(response);
      }
    });
  }

  $('.custom-modal-closed, .custom-modal-overlay').on('click', function(){
    //document.body.style.overflow = 'auto';
    $('.custom-modal').removeClass('custom-modal-show');
  });
</script>
