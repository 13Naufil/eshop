<?php
if(empty($order->track_number)){
?>
<div class="with-padding">
    <div class="callout callout-info fade in">
      <h5>Order Number: <?php echo $order->order_number;?></h5>
      <!--<p></p>-->
    </div>
</div>
<div class="info-buttons">
    <div class="row block">
        <div class="col-md-4 col-md-offset-4">
            <a class="book_packet" href="<?php echo admin_url('orders/courier_options/' .$id . '/book_packet');?>"><i class="icon-truck"></i> <span>LCS Book Packet</span></a>
        </div>
    </div>
</div>
<?php } else{
    if ($LCS->status == 1) {
        ?>
        <table class="table">
            <tr>
                <td align="center">
                    FROM<h4><?php echo $LCS->packet_list[0]->origin_city_name;?></h4>
                </td>
                <td colspan="2" align="center" class="text-center">
                    <img src="http://www.leopardscod.com/images/statusImages/van.png" alt="">
                </td>

                <td align="center">
                    TO<h4><?php echo $LCS->packet_list[0]->destination_city_name;?></h4>
                </td>
            </tr>
            <tr>
                <th>Tracking #:</th>
                <td><?php echo $LCS->packet_list[0]->track_number;?></td>
                <th>Reference # / Order ID:</th>
                <td><?php echo $LCS->packet_list[0]->booked_packet_order_id;?></td>
            </tr>
            <tr>
                <th>No. of Pieces:</th>
                <td><?php echo $LCS->packet_list[0]->booked_packet_no_piece;?></td>
                <th>Packet Weight:</th>
                <td><?php echo $LCS->packet_list[0]->booked_packet_weight;?></td>
            </tr>
            <tr>
                <th>Shipper Name:</th>
                <td><?php echo $LCS->packet_list[0]->shipment_name_eng;?></td>
                <th>Consignee Name:</th>
                <td><?php echo $LCS->packet_list[0]->consignment_name_eng;?></td>
            </tr>
            <tr>
                <th>Shipper Address:</th>
                <td><?php echo $LCS->packet_list[0]->shipment_address;?></td>
                <th>Consignee Address:</th>
                <td><?php echo $LCS->packet_list[0]->consignment_address;?></td>
            </tr>
        </table>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th width="20%">Activity Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <?php
            foreach($LCS->packet_list as $list){
                ?>
                <tr>
                    <td><?php echo $list->activity_date;?></td>
                    <td><?php echo $list->status_remarks;?></td>
                </tr>
                <?
            }
            ?>
        </table>
    <?php }
} ?>