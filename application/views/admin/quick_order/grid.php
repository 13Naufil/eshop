<?php
/**
 * Naufil khan
 * E: developer.systech@gmail.com
 * P: +923472565746
 * S: naufil_khan13@hotmail.com
 * @copyright 2019 * @date 19-09-2019
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
$grid->to_from_fields = array('Order Date' => 'date');
$grid->hide_fields = array($this->id_field);


$grid->custom_func = array('Status' => 'status_options');

$grid->form_buttons = array('new', 'edit', 'delete', 'view', 'refresh', 'print');
$grid->grid_buttons = array('edit', 'delete', 'status', 'view');
echo $grid->showGrid();
?>
<!-- End Grid -->