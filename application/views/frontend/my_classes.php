<div class="container">
	<h2 class="pb-1 pt-5 ff-gt-pro"><?php echo get_phrase('my_classes'); ?></h2>
	<div class="class-custom-collapse">
		<div class="collapse-menu">
			<a href="javascript:;" onclick="my_classes(this, 'saved_classes')" class="<?php if(!isset($_GET['type']) || $_GET['type'] == 'saved_classes')echo 'active'; ?>"><?php echo get_phrase('all_saved_classes'); ?></a>
			<a href="javascript:;" onclick="my_classes(this, 'watch_history', 'reviews')"  class="<?php if(isset($_GET['type']) && $_GET['type'] == 'watch_history')echo 'active'; ?>"><?php echo get_phrase('watch_history'); ?></a>
		</div>
	</div>
	<hr class="bg-body my-5 w-100">
	<div class="" id="myClassBody">
		<?php
		if(isset($_GET['type']) && $_GET['type'] == 'watch_history'){
			include "my_watch_history.php";
		}else{
			include "my_saved_classes.php";
		}
		?>
	</div>
</div>