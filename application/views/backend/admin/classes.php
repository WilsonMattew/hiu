<div class="row ">
  <div class="col-lg-12">
    <a href="<?php echo site_url('admin/add_class'); ?>" class="btn btn-primary alignToTitle"><i class="entypo-plus"></i><?php echo get_phrase('add_new_class'); ?></a>
  </div><!-- end col-->
</div>

<div class="row">
  <div class="col-lg-12">
    <div class="panel panel-primary" data-collapsed="0">
      <div class="panel-heading">
        <div class="panel-title">
          <?php echo get_phrase('all_classes'); ?>
        </div>
      </div>
      <div class="panel-body p-0">
        <div class="table-responsive text-nowrap">
          <table class="table responsive table-bordered datatable m-0" id="classes_server_side_data">
            <thead>
              <tr>
                <th>#</th>
                <th><?php echo get_phrase('title');?></th>
                <th><?php echo get_phrase('category');?></th>
                <th><?php echo get_phrase('lessons');?></th>
                <th><?php echo get_phrase('status');?></th>
                <th><?php echo get_phrase('option');?></th>
              </tr>
            </thead>
            <tbody></tbody>
          </table>
        </div>
      </div>
    </div>
  </div><!-- end col-->
</div>

<a href="#" onclick="refreshServersideTable('classes_server_side_data')">Refresh</a>
<script>
  $(document).ready(function () {
     var table = $('#classes_server_side_data').DataTable({
      responsive: true,
      "processing": true,
      "serverSide": true,
      "ajax":{
        "url": "<?php echo base_url('admin/classes_server_side_data') ?>",
        "dataType": "json",
        "type": "POST",
        "data":{  '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>' }
      },
      "columns": [
        { "data": "key" },
        { "data": "title" },
        { "data": "category" },
        { "data": "total_lesson" },
        { "data": "status" },
        { "data": "action" }
      ]   
    });
   });

  function refreshServersideTable(tableId){
    $('#'+tableId).DataTable().ajax.reload();
  }
</script>