<!-- Page header -->
<div class="page-header">
    <div class="page-title">
        <!--<i class="icon"><img width="22" src="<? /*= base_url('assets/admin/img/icons/22_' . getModuleDetail()->icon); */ ?>"/></i>-->
        <h3>
            <i class="icon-users"></i>
            <?php echo $this->module_title; ?>
            <small>Listing of <?php echo $this->module_title; ?>.</small>
        </h3>
    </div>
</div>
<!-- /page header -->

<?php
include dirname(__FILE__) . "/../includes/breadcrumb.php";
?>

<!-- Datatable with selectable rows -->
<?php
$grid = new grid();
$grid->query = $query;
$grid->id_field = $this->id_field;
$grid->title = $this->module_title . ' - List';
$grid->limit = 25;
$grid->search_box = TRUE;
$grid->hide_fields = array('id', 'status');
$grid->center_fields = array('ordering');
$grid->form_buttons = array('new', 'delete', 'print');
$grid->grid_buttons = array('edit', 'delete', 'status' => array('status'));
echo $grid->showGrid();
?>
<!-- END -->