<?php
/**
 * Naufil khan
 * E: developer.systech@gmail.com
 * P: +923472565746
 * S: naufil_khan13@hotmail.com
 */
$form_btns = array('save', 'reset', 'back');
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

<?php
$grid = new grid();
$grid->query = $query;
$grid->title = $this->module_title . ' - List';
$grid->limit = 25;
$grid->search_box = TRUE;
$grid->id_field = $this->id_field;

$grid->custom_func = array('status' => 'status_field', 'sms_status' => 'status_field');
$grid->hide_fields = array($this->id_field, 'message');
$grid->center_fields = array('ordering');
$grid->form_buttons = array('new', 'edit', 'delete', 'view', 'refresh', 'print');
$grid->grid_buttons = array('edit', 'view', 'status' => array('status'), 'delete');
echo $grid->showGrid();
?>
