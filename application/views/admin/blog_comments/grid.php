<?php
/**
 * Naufil khan
 * Email: developer.systech@gmail.com
 */
include  dirname(__FILE__) . "/../includes/head.php";
include  dirname(__FILE__) . "/../includes/header.php";
include dirname(__FILE__) . "/../includes/left_side_bar.php";

?>
    <!-- Content -->
    <div id="content">
        <div class="wrapper">

            <div class="page-header">
                <h5 class="widget-name"><i class="icon-user"></i><?php echo $this->module_title;?></h5>
            </div>
            <div class="row-fluid">
                <!-- START -->

                <?php
                $grid = new grid();
                $grid->query = $query;
                $grid->title = $this->module_title .' - List';
                $grid->limit = 25;
                $grid->search_box = TRUE;
                $grid->id_field = $this->id_field;

                $grid->hide_fields = array('id','comment_post_id');
                $grid->center_fields = array();
                $grid->form_buttons = array('new', 'delete', 'print');
                $grid->grid_buttons = array('edit', 'delete', 'status');
                echo $grid->showGrid();
                ?>
                <!-- END -->
            </div>
        </div>
    </div>
    <!-- /content -->
<?php
include  dirname(__FILE__) . "/../includes/footer.php";
?>