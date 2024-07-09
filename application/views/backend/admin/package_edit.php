<form action="<?php echo site_url('admin/package_edit/updated/'.$package['package_id']); ?>" method="post" enctype="multipart/form-data">
	<div class="row mb-15px">
		<label class="col-sm-3 control-label text-right pt-5px"><?php echo get_phrase('package_type'); ?>*</label>
		<div class="col-sm-7">
			<input type="text" value="<?php echo get_phrase($package['package_type']); ?>" class="form-control" readonly required>
		</div>
	</div>

	<?php if($package['package_type'] == 'days'): ?>
		<div class="row mb-15px">
			<label for="package_limitation" class="col-sm-3 control-label text-right pt-5px"><?php echo get_phrase('limitation_days'); ?>*</label>
			<div class="col-sm-7">
				<input type="number" step="0.01" value="<?php echo get_phrase($package['days']); ?>" class="form-control" name="days" id="package_limitation" placeholder="<?php echo get_phrase('emter_number_of_days'); ?>" required>
			</div>
		</div>
	<?php endif; ?>

	<div class="row mb-15px">
		<label for="price" class="col-sm-3 control-label text-right pt-5px"><?php echo get_phrase('price'); ?>(<?php echo currency(''); ?>)*</label>
		<div class="col-sm-7">
			<input type="number" step="0.01" value="<?php echo get_phrase($package['price']); ?>" class="form-control" name="price" id="price" placeholder="<?php echo get_phrase('enter_package_price'); ?>" required>
		</div>
	</div>

	<div class="row mb-15px">
		<label class="col-sm-3 control-label text-right pt-5px"></label>
		<div class="col-sm-7">
			<button class="btn btn-primary" type="submit"><?php echo get_phrase('save_changes'); ?></button>
		</div>
	</div>
</form>