<!DOCTYPE html>
<html lang="<?php echo substr(get_settings('language'),0,2); ?>" dir="ltr">
<head>
	<?php include "metas.php"; ?>
	<?php include "top_css.php"; ?>
</head>
<body>
	<div class="top-loader-bar"></div>
	<?php
		$user_image = $this->session->userdata('user_image');
		$login_type = $this->session->userdata('login_type');
		$user_role = $this->session->userdata('user_role');
		$user_name = $this->session->userdata('user_name');
		$user_id = $this->session->userdata('user_id');
	?>
	<?php include "header.php"; ?>

	<?php include $page_name.".php"; ?>

	<?php include "footer.php"; ?>

	<?php include "modal.php"; ?>
	<?php include "bottom_scripts.php"; ?>
	<?php include "common_scripts.php"; ?>
	<?php include "toast.php"; ?>
</body>
</html>