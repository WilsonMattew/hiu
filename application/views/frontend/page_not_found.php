<!DOCTYPE html>
<html lang="en">
<head>
	<title><?php echo get_settings('system_title'); ?> | <?php echo get_settings('system_name'); ?></title>
	<?php include "top_css.php"; ?>
</head>

<body>
	<style type="text/css">
		
		* {margin: 0px; padding: 0px; box-sizing:border-box;}

		::-moz-selection {
		  color: white;
		  text-shadow: none;
		  background: #222222;
		}
		::selection {
		  color: white;
		  text-shadow: none;
		  background: #222222;
		}
		img::selection {
		  color: white;
		  background: transparent;
		}
		img::-moz-selection {
		  color: white;
		  background: transparent;
		}
		body{
			margin:0;
			font-family: 'Roboto', sans-serif;
			font-weight:300;
			overflow-x:hidden;
			color:#fff;
			font-size:14px;
			
		}
		html,
		body {
		  height: 100%;
		  width: 100%;
		  background: -webkit-linear-gradient(to top, #002333, #00ff84); 
		  background: linear-gradient(to top, #002333, #00ff84);
		  letter-spacing: 1px;
		}
		a {
		  -webkit-transition: all 0.35s;
		  -moz-transition: all 0.35s;
		  transition: all 0.35s;
		  color: #00ff84;
		}
		a:hover,
		a:focus {
		  color: #00ff84;
		  text-decoration:none;
		}
		hr {
		  width: 100%;
		  margin: 20px 0;
		  border-top:2px dashed #dedede;
		}
		hr.light {
		  border-color: white;
		}
		h1,
		h2,
		h3,
		h4,
		h5,
		h6 {
		  font-family: 'Roboto', sans-serif;
		  font-weight: normal;
		  letter-spacing: 1px;
		  color: #fff;
		}
		p {
		  font-size: 20px;
		  line-height: 1.5;
		  margin-bottom: 20px;
		}

		.brand{
		  color: #fff;
		}
		.brand span{
		  margin-top:50px;
		  font-size: 40px;
		}
		.brand h3{
		  font-weight: 300;
		  margin: 10px 0 0 0;
		}
		h1.head{
		  font-size: 250px;
		  font-weight: 900;
		  letter-spacing: 25px;
		  margin: 10px 0 0 0;
		}
		h1.head span {
		  position: relative;
		  display: inline-block;
		}
		h1.head span:before, h1.head span:after{
		  position: absolute;
		  top:50%;
		  width: 50%;
		  height: 1px;
		  background: #fff;
		  content: '';
		}
		h1.head span:before{
		  left: -55%;
		}
		h1.head span:after{
		  right: -55%;
		}
		.btn-outline{
			border: 2px solid #00ff84;
		    color: #00ff84;
		    padding: 12px 40px;
		    border-radius: 25px;
		    margin-top: 25px;
		    display: inline-block;
		    font-weight: 600;
		}
		.btn-outline:hover{
			color: #002333;
    		background: #00ff84;
		}
		.bwt-footer-copyright { font-size:14px; padding:10px 0; line-height:20px; margin-top:50px;}
		.bwt-footer-copyright .left-text{ text-align:left; margin:10px 0;}
		.bwt-footer-copyright .right-text{ text-align:right; margin:10px 0;}
		.bwt-footer-copyright a{ color: #fff; font-weight: 500; }

		@media (max-width: 1024px) {
		  
		h1.head {
		  font-size: 200px;
		  letter-spacing: 25px;
		}

		}

		@media (max-width: 768px) {
		  
		h1.head {
		  font-size: 150px;
		  letter-spacing: 25px;
		}
		.bwt-footer-copyright .left-text{ text-align:center; margin:10px 0;}
		.bwt-footer-copyright .right-text{ text-align:center; margin:10px 0;}

		}

		@media (max-width: 640px) {
		  
		h1.head {
		  font-size: 150px;
		  letter-spacing: 0;
		}

		}

		@media (max-width: 480px) {

		.brand h3 {
		    font-size: 20px;
		}
		  h1.head {
		  font-size: 130px;
		  letter-spacing: 0;
		}
		h1.head span:before, h1.head span:after {
		    width: 40%;
		}
		h1.head span:before {
		    left: -45%;
		}
		h1.head span:after {
		    right: -45%;
		}
		p {
		    font-size: 18px;
		}

		}

		@media (max-width: 320px) {

		.brand h3 {
		    font-size: 16px;
		}
		  h1.head {
		  font-size: 100px;
		  letter-spacing: 0;
		}
		h1.head span:before, h1.head span:after {
		    width: 25%;
		}
		h1.head span:before {
		    left: -30%;
		}
		h1.head span:after {
		    right: -30%;
		}

		}
	</style>
	<div class="container text-center">
		
		<h1 class="head text-white ff-gt-pro"><span>404</span></h1>
		<p class="ff-gt-pro"><?php echo get_phrase('Oops').'! '.get_phrase('page_not_found'); ?>!</p>
		<div class="brand">
			<span class="glyphicon glyphicon-king" aria-hidden="true"></span>
			<h3 class="text-uppercase text-white ff-gt-pro"><?php echo get_settings('system_title'); ?></h3>
			<span class="text-14 text-white ff-gt-pro"><?php echo get_settings('system_name'); ?></span>
		</div>
		<a href="<?php echo site_url(); ?>" class="btn-outline btn ff-gt-pro"><?php echo get_phrase('back_to_home'); ?></a>
	</div>

   <?php include "bottom_scripts.php"; ?>
</body>
</html>	