<?php echo get_header(); ?>
<div id="main">
    <div class="bg-container page-padding">
    <div class="page-content container">

        <div class="row">
            <div class="col-sm-3">
                <?php
                include "account_nav.php";
                ?>
            </div>
            <div class="col-sm-9">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">MY ORDERS</h3>
                    </div>
                    <div class="panel-body">

                        <!--product-listing-block-->
                        <?php
                        if (count($orders) > 0) {
                            ?>
                            <table class="table table-bordered table-striped" id="my-orders-table">
                                <!--<colgroup>
                                    <col width="1">
                                    <col width="1">
                                    <col>
                                    <col width="1">
                                    <col width="1">
                                    <col width="1">
                                </colgroup>-->
                                <thead>
                                <tr class="first last">
                                    <th>Order #</th>
                                    <th>Date</th>
                                    <th>Ship To</th>
                                    <th><span class="nobr">Order Total</span></th>
                                    <th>Status</th>
                                    <th>&nbsp;</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                foreach ($orders as $key => $row) {
                                ?>
                                <tr class="">
                                    <td><?php echo $row->order_number;?></td>
                                    <td><?php echo mysql2date($row->created);?></td>
                                    <td><?php echo $row->full_name;?></td>
                                    <td><span class="price">PKR. <?php echo number_format($row->total_amount);?></span></td>
                                    <td><em><?php echo $row->status;?></em></td>
                                    <td>
                                        <!--<a data-toggle="modal" data-target="#order-detail" href="<?php /*echo site_url('customer/order/view/?id=' . $row->id);*/?>">View Order</a>-->
                                        <a href="#" onclick="popupwindow('<?php echo site_url('customer/order/view/?id=' . $row->id);?>', 'View Order', 860, 500)">View Order</a>
                                    </td>
                                </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                        <?php } else { ?>
                            <p>You have placed no orders.</p>
                        <?php } ?>
                        <!--product-listing-block-->
                        <p>&nbsp;</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<!-- Modal -->
<div class="modal fade" id="order-detail" tabindex="-1" role="dialog" aria-labelledby="order-detail">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Order Detail</h4>
      </div>
      <div class="modal-body"></div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<?php echo get_footer(); ?>