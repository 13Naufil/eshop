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

<!-- START -->
<?php
$grid = new grid();
$grid->query = $query;
$grid->title = $this->module_title . ' - List';
$grid->limit = 25;
$grid->search_box = TRUE;
$grid->hide_fields = array('id');
$grid->center_fields = array('ordering');
$grid->form_buttons = array('new', 'delete', 'print');
$grid->grid_buttons = array('edit', 'delete', 'status');
echo $grid->showGrid();
?>
<!-- END -->
