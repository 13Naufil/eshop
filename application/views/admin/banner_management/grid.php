<?php
/**
 * Adnan Bashir
 * E: developer.adnan@gmail.com
 * P: +923323103324
 * S: developer.adnan
 * @copyright 2014 * @date 18-09-2014
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

$grid->hide_fields = array($this->id_field,'title');
$grid->image_fields = array('image');
$grid->image_path = 'assets/front/banners/';
$grid->center_fields = array('ordering');
$grid->custom_func = array('status' => 'status_field');
$grid->form_buttons = array('new', 'edit', 'delete', 'view', 'refresh', 'print');
$grid->grid_buttons = array('edit', 'delete', 'status' => array('status'));
echo $grid->showGrid();
?>
<!-- End Grid -->