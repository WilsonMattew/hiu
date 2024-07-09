<div class="custom-bootstrap-toast position-fixed bottom-0 end-0 p-3">
  <div id="bootstrapToastSuccess" class="toast hide" data-bs-delay="6000" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="toast-header text-white bg-success">
      <i class="bi bi-check2-circle me-2"></i>
      <strong class="me-auto"><?php echo get_phrase('Congratulations'); ?> !</strong>
      <small><!-- 11 mins ago --></small>
      <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
    <div class="toast-body"></div>
  </div>

  <div id="bootstrapToastInfo" class="toast hide" data-bs-delay="6000" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="toast-header text-white bg-info">
      <i class="bi bi-exclamation-circle me-2"></i>
      <strong class="me-auto"><?php echo get_phrase('attention_please'); ?>!</strong>
      <small><!-- 11 mins ago --></small>
      <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
    <div class="toast-body"></div>
  </div>

  <div id="bootstrapToastError" class="toast hide" data-bs-delay="6000" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="toast-header text-white bg-danger">
      <i class="bi bi-question-circle me-2"></i>
      <strong class="me-auto"><?php echo get_phrase('oops').'! '.get_phrase('attention_please'); ?>.</strong>
      <small><!-- 11 mins ago --></small>
      <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
    <div class="toast-body"></div>
  </div>
</div>

<script>
  function success_message(msg){
    $('#bootstrapToastSuccess .toast-body').html(msg);
    var bootstrapToast =document.getElementById('bootstrapToastSuccess');//select id of toast
    var bsToast = new bootstrap.Toast(bootstrapToast);//inizialize it
    bsToast.show();
  }
  function info_message(msg){
    $('#bootstrapToastInfo .toast-body').html(msg);
    var bootstrapToast =document.getElementById('bootstrapToastInfo');//select id of toast
    var bsToast = new bootstrap.Toast(bootstrapToast);//inizialize it
    bsToast.show();
  }
  function error_message(msg){
    $('#bootstrapToastError .toast-body').html(msg);
    var bootstrapToast =document.getElementById('bootstrapToastError');//select id of toast
    var bsToast = new bootstrap.Toast(bootstrapToast);//inizialize it
    bsToast.show();
  }
</script>

<?php if($this->session->flashdata('success')): ?>
  <script>success_message('<?php echo $this->session->flashdata('success'); ?>')</script>
<?php endif; ?>
<?php if($this->session->flashdata('info')): ?>
  <script>info_message('<?php echo $this->session->flashdata('info'); ?>')</script>
<?php endif; ?>
<?php if($this->session->flashdata('error')): ?>
  <script>error_message('<?php echo $this->session->flashdata('error'); ?>')</script>
<?php endif; ?>