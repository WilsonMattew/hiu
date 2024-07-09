<?php $text_align = null; ?>
<?php
  $user_name = $this->session->userdata('user_name');
  $user_role = $this->session->userdata('user_role');
  $website_title = get_settings('system_title');
?>
<!DOCTYPE html>
<html lang="en" dir="<?php if ($text_align == 'right-to-left') echo 'rtl';?>">
<head>

  <title><?php echo $page_title;?> | <?php echo get_settings('system_title'); ?></title>
  <!-- all the meta tags -->
  <?php include 'metas.php'; ?>
  <!-- all the css files -->
  <?php include 'includes_top.php';?>

</head>
<body class="page-body" >
  <div class="top-progress-bar"></div>
  <div class="page-container <?php if ($text_align == 'right-to-left') echo 'right-sidebar';?>" >
    <!-- SIDEBAR -->
    <?php include $user_role.'/'.'navigation.php' ?>
    <div class="main-content">

      <!-- Topbar Start -->
      <?php include 'header.php'; ?>

      <h3 style="margin:20px 0px;" class="hidden-print">
        <i class="entypo-right-circled"></i>
        <?php echo $page_title; ?>
      </h3>

      <!-- Start Content-->
      <?php include $user_role.'/'.$page_name.'.php';?>
      <!-- Footer starts here -->
      <?php include 'footer.php'; ?>
    </div>
  </div>
  <!-- all the js files -->
  <?php include 'includes_bottom.php'; ?>
  <?php include 'modal.php'; ?>
  <?php include 'common_scripts.php'; ?>
</body>
</html>
