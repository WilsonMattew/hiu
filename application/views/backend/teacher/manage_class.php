<a href="<?php echo site_url('teacher/classes'); ?>" class="btn btn-primary alignToTitle"><i class="fa fa-reply"></i> <?php echo get_phrase('back_to_list'); ?></a>
<div class="panel panel-primary" data-collapsed="0">
	<div class="panel-heading">
		<div class="panel-title">
			<?php echo $class_details['class_title']; ?>
		</div>
	</div>

	<div class="paned-body">
		<ul class="nav nav-tabs" role="tablist">
			<li role="presentation" class="active"><a href="#lessons" aria-controls="lessons" role="tab" data-toggle="tab"><?php echo get_phrase('lessons'); ?></a></li>
			<li role="presentation"><a href="#class_information" aria-controls="class_information" role="tab" data-toggle="tab"><?php echo get_phrase('class_information'); ?></a></li>
		</ul>

		<!-- Tab panes -->
		<div class="tab-content">
			<div role="tabpanel" class="tab-pane active" id="lessons">
				<?php include 'lessons.php'; ?>
			</div>
			<div role="tabpanel" class="tab-pane" id="class_information">
				<?php include 'edit_class.php'; ?>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	'use strict';
	function load_class_info(type){
		var class_id = <?php echo $class_details['class_id']; ?>;
		$.ajax({
			type: 'post',
			url: "<?php echo site_url('teacher/load_class_info/'); ?>"+type+'/'+class_id,
			success: function(response){
				$('#'+type).html(response);
			}
		});
	}
</script>