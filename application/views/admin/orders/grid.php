<?php
/**
 * Naufil khan
 * E: developer.systech@gmail.com
 * P: +923472565746
 * S: naufil_khan13@hotmail.com
 * @copyright 2019 * @date 03-08-2019
 */
if (!defined('BASEPATH')) exit('No direct script access allowed');
?>
<!-- Page header -->
<div class="page-header">
    <div class="page-title">
        <h3>
            <?php echo getModuleDetail()->module_icon; ?>
            <?php echo $this->module_title; ?>
            <small>Listing of <?php echo $this->module_title; ?>.</small>
        </h3>
    </div>
</div>
<!-- /page header -->

<?php
include dirname(__FILE__) . "/../includes/breadcrumb.php";
?>
<!-- Start Grid -->
<?php

$grid = new grid();
$grid->query = $query;
$grid->title = $this->module_title . ' - List';
$grid->limit = 25;
$grid->search_box = TRUE;
$grid->id_field = $this->id_field;

$grid->hide_fields = array($this->id_field);
//$grid->to_from_fields = array('created' => 'date', 'total_amount' => 'range');
$grid->to_from_fields = array('created' => 'date');
$grid->center_fields = array('ordering');
$grid->custom_func = array('status' => 'status_options');
$grid->form_buttons = array('new', 'delete', 'view', 'refresh', 'print');
$grid->grid_buttons = array('view', 'edit', 'delete','courier_options');
echo $grid->showGrid();
?>
<!-- End Grid -->
<!-- Modal with remote path -->
<div id="ajax_modal" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"><i class="icon-target"></i> Tracking Information
            <a href="#" target="_blank" class="pull right btn btn-danger btn-sm btn-slip">Print Slip</a>
        </h4>

      </div>
      <div class="modal-body with-padding"></div>
      <div class="modal-footer"></div>
    </div>
  </div>
</div>
<!-- /modal with remote path -->

<script>
    (function ($) {
        $(document).ready(function () {
            $(document).on('click', '[action=courier_options]', function (e) {
                e.preventDefault();
                var url=$(this).attr('href');
                $.ajax({
                    type: "POST",
                    url: url,
                    dataType: 'json',
                    data: {rnd: Math.random()},
                    complete: function (data) {
                        var json = $.parseJSON(data.responseText);
                        if(json.track_number != null){
                            $('#ajax_modal .modal-header .btn-slip').show(0).attr('href', json.slip_link);
                        }else{
                            $('#ajax_modal .modal-header .btn-slip').hide(0);
                        }
                        $('#ajax_modal .modal-body').html(json.html);
                        $('#ajax_modal').modal('show');
                    }
                });
            });
            $(document).on('click', '.book_packet', function (e) {
                e.preventDefault();
                var url=$(this).attr('href');
                bootbox.confirm("Are you sure do you want to book packet?", function (confirmed) {
                    if (confirmed) {
                        window.location = url;
                    }
                });
            });
        });
    })(jQuery)
</script>