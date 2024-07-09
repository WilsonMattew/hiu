<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-primary" data-collapsed="0">
			<div class="panel-heading">
				<div class="panel-title">
					<?php echo get_phrase('edit_sub_category'); ?>
				</div>
			</div>
			<div class="panel-body">
				<form action="<?php echo site_url('admin/categories/update/'.$sub_category['category_id']); ?>" method="post" enctype="multipart/form-data" role="form" class="form-horizontal form-groups-bordered">

					<div class="form-group">
						<label for="name" class="col-sm-3 control-label"><?php echo get_phrase('category_title'); ?></label>

						<div class="col-sm-7">
							<input type="text" class="form-control" name="title" id="name" placeholder="<?php echo get_phrase('provide_category_name'); ?>" value="<?php echo $sub_category['title']; ?>" required>
						</div>
					</div>

					<div class="form-group" id = "icon-picker-area">
						<label for="font_awesome_class" class="col-sm-3 control-label"><?php echo get_phrase('icon_picker'); ?> <span class="text-10 text-muted">(<?php echo get_phrase('optional'); ?>)</span></label>
						<div class="col-sm-7">
							<input type="text" name="icon_class" class="form-control icon-picker" autocomplete="off" value="<?php echo $sub_category['icon_class']; ?>">
						</div>
					</div>

					<div class="col-sm-offset-3 col-sm-5" style="padding-top: 10px;">
						<button type="submit" class="btn btn-info"><?php echo get_phrase('update_category'); ?></button>
					</div>
				</form>
			</div>
		</div>
	</div><!-- end col-->
</div>

<script type="text/javascript">
	$(function() {
		$('.icon-picker').iconpicker();
	});
	function checkCategoryType(category_type) {
		if (category_type > 0) {
			$('#thumbnail-picker-area').hide();
		}else {
			$('#thumbnail-picker-area').show();
		}
	}
</script>
