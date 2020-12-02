<?php
$cilent_type_id = get_option('client_type_id');
$admin_type_id = get_option('admin_user_type');

$total_members = $this->db->query("SELECT COUNT(id) AS total FROM customers WHERE 1")->row()->total;
$today_registor_members = $this->db->query("SELECT COUNT(id) AS total FROM customers WHERE 1 AND DATE(`created`)>=CURDATE()")->row()->total;

$__products = $this->db->count_all_results('products');

?>

<!-- Page header -->
<div class="page-header">
    <div class="page-title">
        <h3>Dashboard
            <small>
                Welcome <?php echo user_info('first_name') . ' ' . user_info('last_name'); ?>.
            </small>
        </h3>
    </div>
    <div id="reportrange" class="range">
        <div class="visible-xs header-element-toggle"><a class="btn btn-primary btn-icon"><i class="icon-calendar"></i></a>
        </div>
        <div class="date-range"></div>
        <span class="label label-danger">9</span>
    </div>
</div>
<!-- /page header -->

<!-- Action tabs -->

<div class="panel panel-default">
    <div class="panel-heading">
        <h6 class="panel-title"><i class="icon-stats2"></i> Statistics</h6>
        <div class="panel-icons-group">
            <a href="#" data-panel="collapse" class="btn btn-link btn-icon"><i class="icon-arrow-up9"></i></a>
            <!--<a href="#" data-panel="close" class="btn btn-link btn-icon"><i class="icon-cancel-circle"></i></a>-->
        </div>
    </div>
    <div class="panel-body">

        <div id="block">
            <ul class="statistics">
                <li>
                    <div class="statistics-info">
                        <a href="#" title="" class="bg-success"><i class="icon-user-plus"></i></a>
                        <strong><?= number_format($today_registor_members); ?></strong>
                    </div>
                    <div class="progress progress-micro">
                        <div class="progress-bar progress-bar-success"
                             style="width: <?= (($today_registor_members / $total_members) * 100); ?>%;"></div>
                    </div>
                    <span>Today Registor Customers</span>
                </li>

                <li>
                    <div class="statistics-info">
                        <a href="#" title="" class="bg-warning"><i class="icon-point-up"></i></a>
                        <strong><?= number_format($total_members); ?></strong>
                    </div>
                    <div class="progress progress-micro">
                        <div class="progress-bar progress-bar-success" style="width: 100%;"></div>
                    </div>
                    <span>Total Customers</span>
                </li>

                <li>
                    <div class="statistics-info">
                        <a href="#" title="" class="bg-primary"><i class="icon-bell"></i></a>
                        <strong><?= number_format($__products); ?></strong>
                    </div>
                    <div class="progress progress-micro">
                        <div class="progress-bar progress-bar-success" style="width: 100%;"></div>
                    </div>
                    <span>Total Products</span>
                </li>


            </ul>
        </div>
    </div>
</div>


    <!-- /action tabs -->
