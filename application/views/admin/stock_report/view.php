<?php
/**
 * Naufil khan
 * E: developer.systech@gmail.com
 * P: +923472565746
 * S: naufil_khan13@hotmail.com
 * @copyright 2019 * @date 25-10-2019
 */
if (!defined('BASEPATH')) exit('No direct script access allowed');
?>
<!-- Page header -->
<div class="page-header">
    <div class="page-title">
        <h3>
            <?php echo getModuleDetail()->module_icon; ?>
            <?php echo $this->module_title; ?>
            <small>Report of <?php echo $this->module_title; ?>.</small>
        </h3>
    </div>
</div>
<!-- /page header -->

<?php
include dirname(__FILE__) . "/../includes/breadcrumb.php";
?>
<!-- Start Grid -->
<div class="print">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h6 class="panel-title"><i class="icon-insert-template"></i><?php echo $this->module_title; ?></h6>
        </div>
        <div class="row">
            <div class="col-sm-8">
                <div class="with-padding">
                    <?php
                    $from_date = ($from_date == '0000-00-00' ? $rows[0]->transaction_date : mysql2date($from_date,'d/m/Y'));
                    $to_date = ($to_date == '0000-00-00' ? $rows[(end($rows) - 1)]->transaction_date : mysql2date($to_date,'d/m/Y'));
                    ?>
                    <!--<strong>Dealer: <?php /*echo $dealer->business_name;*/?></strong><br/>
                    <strong>Model : <?php /*echo $product->name;*/?></strong><br/>-->
                    <!--<strong>From Date: <?php /*echo $from_date;*/?></strong><br/>
                    <strong>To Date: <?php /*echo $to_date;*/?></strong><br/>-->
                </div>
            </div>
            <div class="col-sm-4">
                <div class="with-padding">
                    Print Date: <?php echo date('d/m/Y h:i:s A');?><br/>
                    Printed By: <?php echo user_info('first_name') . ' ' . user_info('last_name'); ?><br/>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="xgrid table ">
                <thead style="border-top: 1px solid #ddd;">
                <tr>
                    <!--<th class="">Date</th>-->
                    <th class="">Product</th>
                    <th class="" width="140">Opening - Qty</th>
                    <th class="" width="140">Sell In - Qty</th>
                    <th class="" width="140">Sell Thro - Qty</th>
                    <th class="" width="140">Balance Units</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $total_inv_val = 0;
                //$balance = $avg_rate = 0;
                $total_opn_qty = $total_ord_qty = $total_sell_qty = 0;
                if(count($rows) > 0){
                    foreach($rows as $row){

                        $total_opn_qty += intval($row->opn_qty);
                        $total_ord_qty += intval($row->ord_qty);
                        $total_sell_qty += intval($row->sell_qty);

                        $balance = $row->opn_qty;
                        $balance += $row->ord_qty;
                        $balance -= $row->sell_qty;
                        
                        ?>
                        <tr class="grid_row">
                            <!--<td valign="middle" class=""><?php /*echo mysql2date($row->transaction_date,'d/m/Y');*/?></td>-->
                            <td valign="middle" class=""><?php echo $row->name;?></td>
                            <td valign="middle" class="text-right"><?php echo if_null(number_format($row->opn_qty),'-',0);?></td>
                            <td valign="middle" class="text-right"><?php echo if_null(number_format($row->ord_qty,2),'-',0);?></td>
                            <td valign="middle" class="text-right"><?php echo if_null(number_format($row->sell_qty,2),'-',0);?></td>
                            <td valign="middle" class="text-right"><?php echo if_null(number_format($balance),'-',0);?></td>
                        </tr>
                        <?
                    }
                }
                ?>
                </tbody>
                <tfoot>
                <tr>
                    <td colspan="1" class="text-right"><strong>Total:</strong></td>
                    <td class="text-right"><strong><?php echo number_format($total_opn_qty);?></strong></td>
                    <td class="text-right"><strong><?php echo number_format($total_ord_qty);?></strong></td>
                    <td class="text-right"><strong><?php echo number_format($total_sell_qty);?></strong></td>
                    <td>&nbsp;</td>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<?php
/*$grid = new grid();
$grid->query = $query;
$grid->title = $this->module_title;
$grid->limit = 9999;
$grid->show_paging_bar = FALSE;
$grid->search_box = FALSE;
$grid->is_front = true;
$grid->sorting = false;
$grid->selectAllCheckbox = FALSE;
$grid->id_field = 'id';
$grid->order_column = 'products.name';

$grid->hide_fields = array('id');
$grid->center_fields = array('product_status', 'quantity');
$grid->custom_func = array('product_status' => 'status_field');
$grid->form_buttons = array('print');
$grid->grid_buttons = array();
echo $grid->showGrid();*/
?>
<!-- End Grid -->