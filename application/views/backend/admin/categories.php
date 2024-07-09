<div class="row ">
  <div class="col-lg-12">
    <a href="<?php echo site_url('admin/add_category'); ?>" class="btn btn-primary alignToTitle"><i class="entypo-plus"></i><?php echo get_phrase('add_parent_category'); ?></a>
  </div><!-- end col-->
</div>
<div class="gallery-env">
  <div class="row">
    <?php foreach ($parent_categories->result_array() as $category):
      $sub_categories = $this->crud_model->get_sub_categories($category['category_id'])->result_array(); ?>
      <div class="col-md-4 on-hover-action" id = "<?php echo $category['category_id']; ?>">
        <article class="album">
          <header>
            <a href="javascript:void(0)">
              <img src="<?php echo get_category_thumbnail($category['thumbnail'], 'optimized'); ?>" />
            </a>
          </header>

          <section class="album-info">
            <h3><a href="javascript:;"><i class="<?php echo $category['icon_class']; ?>"></i> <?php echo $category['title']; ?></a></h3>
            <p><?php echo count($sub_categories).' '.get_phrase('sub_categories'); ?></p>
          </section>

          <?php foreach ($sub_categories as $sub_category): ?>
            <footer class="on-hover-action" id = "<?php echo $sub_category['category_id']; ?>">
              <div class="album-images-count">
                <i class="<?php echo $sub_category['icon_class']; ?>"></i> <?php echo $sub_category['title']; ?>
              </div>

              <div class="album-options d-hidden" id = "subcategory-action-btn-<?php echo $sub_category['category_id']; ?>">
                <a href="javascript:;" onclick="showAjaxModal('<?php echo site_url('admin/edit_sub_category/'.$sub_category['category_id']); ?>', '<?php echo $sub_category['title']; ?>')">
                  <i class="entypo-pencil"></i>
                </a>

                <a href="#" onclick="confirm_modal('<?php echo site_url('admin/categories/delete/'.$sub_category['category_id']); ?>');">
                  <i class="entypo-trash"></i>
                </a>
              </div>
            </footer>
          <?php endforeach; ?>
          <div class="category-actions">
            <a href = "javascript:;" class="btn btn-red d-hidden mr-6px float-right" id = "category-delete-btn-<?php echo $category['category_id']; ?>" onclick="confirm_modal('<?php echo site_url('admin/categories/delete/'.$category['category_id']); ?>')" data-toggle="tooltip" data-placement="top" title="<?php echo get_phrase('delete'); ?>">
              <?php echo get_phrase('delete'); ?></a>
            <a href = "<?php echo site_url('admin/edit_category/'.$category['category_id']); ?>" class="btn btn-info d-hidden mr-6px float-right" id = "category-edit-btn-<?php echo $category['category_id']; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo get_phrase('edit'); ?>">
              <?php echo get_phrase('edit'); ?></a>
              <a href = "javascript:;"onclick="showAjaxModal('<?php echo site_url('admin/add_sub_category/'.$category['category_id']); ?>', '<?php echo $category['title']; ?>')" class="btn btn-primary d-hidden mr-6px float-right" id = "category-add-btn-<?php echo $category['category_id']; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo get_phrase('add_sub_category'); ?>">
              <?php echo get_phrase('add'); ?></a>
          </div>
        </article>
      </div>
    <?php endforeach; ?>
  </div>
</div>

<script type="text/javascript">
$('.on-hover-action').mouseenter(function() {
  var id = this.id;
  $('#category-add-btn-'+id).show();
  $('#category-delete-btn-'+id).show();
  $('#category-edit-btn-'+id).show();
  $('#subcategory-action-btn-'+id).show();
});
$('.on-hover-action').mouseleave(function() {
  var id = this.id;
  $('#category-add-btn-'+id).hide();
  $('#category-delete-btn-'+id).hide();
  $('#category-edit-btn-'+id).hide();
  $('#subcategory-action-btn-'+id).hide();
});
</script>
