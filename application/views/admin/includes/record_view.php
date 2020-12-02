<?php
/**
 * Naufil khan
 * E: developer.systech@gmail.com
 * P: +923472565746
 * S: naufil_khan13@hotmail.com
 * @copyright 2019 * @date 18-09-2019
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


    <!-- START -->
<div class="panel panel-default">
    <div class="panel-heading">
        <h6 class="panel-title"><i class="icon-page-break"></i> <?php echo $this->module_title; ?></h6>
    </div>
<?php
if (!$config['buttons']) {
    $config['buttons'] = array('new', 'refresh', 'back');
}
echo get_form_actions($config['buttons']);
unset($config['buttons']);
?>

    <div class="table-responsive">
    <?php
    $view = new record_view();
    $view->query = $query;

    if(count($config)){
        foreach($config as $conf_key => $conf){
            $view->{$conf_key} = $conf;
        }
    }
    echo $view->showView();
    ?>
</div>
<!-- END -->
