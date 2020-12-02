<?php
/**
 * Naufil khan
 * E: developer.systech@gmail.com
 * P: +923472565746
 * S: naufil_khan13@hotmail.com

 * @copyright 2019 * @date 17-09-2019 */
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

$grid->hide_fields = array($this->id_field);

$grid->image_fields = array('image');
$grid->image_path = 'assets/front/products/';

$grid->center_fields = array('ordering','status');
$grid->custom_func = array('status' => 'status_options','is_in_stock'=>'status_options','product_image'=>'product_image');
$grid->form_buttons = array('new', 'edit', 'delete', 'view','refresh','print');
$grid->grid_buttons = array('edit', 'delete', 'duplicate', 'status');
echo $grid->showGrid();
?>
<!-- End Grid -->