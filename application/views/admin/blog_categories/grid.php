<?php
/**
 * Naufil khan
 * E: developer.systech@gmail.com
 * P: +923472565746
 * S: naufil_khan13@hotmail.com

 * @copyright 2019 * @date 04-10-2019 */
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
$grid->title = $this->module_title .' - List';
$grid->limit = 25;
$grid->search_box = TRUE;
$grid->id_field = $this->id_field;

$grid->hide_fields = array('id');
$grid->center_fields = array('display_order');
$grid->form_buttons = array('new', 'delete', 'print');
$grid->grid_buttons = array('edit', 'delete', 'status');
echo $grid->showGrid();
?>
<!-- End Grid -->
