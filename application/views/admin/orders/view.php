<?php
/**
 * Naufil khan
 * E: developer.systech@gmail.com
 * P: +923472565746
 * S: naufil_khan13@hotmail.com
 */
$form_btns = array('reset', 'back');
?>
<!-- Page header -->
<div class="page-header">
    <div class="page-title">
        <h3>
            <?php echo getModuleDetail()->module_icon; ?>
            <?php echo $this->module_title; ?>
            <small>Viwing of <?php echo $this->module_title; ?>.</small>
        </h3>
    </div>
</div>
<!-- /page header -->

<?php
include dirname(__FILE__) . "/../includes/breadcrumb.php";
?>

<?php
echo show_validation_errors();

?>
<style>
    /*.panel-body {
        padding-top: 0;
    }

    .invoice-header {
        padding-top: 15px;
        background-color: black;
        color: white;
    }*/
</style>
<!-- New invoice template -->
<div class="panel <?php echo ($order->status == 'Paid' ? 'panel-success' : 'panel-default');?>">
    <div class="panel-heading">
        <h6 class="panel-title"><i class="icon-coin"></i>invoice #: <?php echo $order->order_number; ?></h6>

        <div class="dropdown pull-right">
            <a href="#" class="dropdown-toggle panel-icon" data-toggle="dropdown"> <i class="icon-cog3"></i> <b class="caret"></b> </a>
            <ul class="dropdown-menu icons-right dropdown-menu-right">
                <li><a href="javascript: popupwindow('<?php echo admin_url($this->module_route . '/print_invoice/' . $order->id);?>', 'View Order', 860, 500);" class=""><i class="icon-print2"></i> Print invoice</a></li>
                <li><a data-toggle="modal" role="button" href="#status_modal"><i class="icon-lightning"></i> Update Status</a></li>
                <!--<li><a href="#"><i class="icon-file-pdf"></i> View .pdf</a></li>-->
            </ul>
        </div>
    </div>
    <?php
    //echo get_form_actions($form_btns);
    ?>
    <div class="panel-body invoice">
        <div class="row invoice-header">
            <div class="col-sm-6">
                <img src="<?php echo asset_url('admin/img/admin_logo.png'); ?>" alt="<?php echo get_option('site_tile'); ?>">
            </div>
            <div class="col-sm-6">
                <ul class="invoice-details">
                    <li>Invoice # <strong class="text-danger"><?php echo $order->order_number; ?></strong></li>
                    <li>Date of Invoice: <strong><?php echo mysql2date($order->created); ?></strong></li>
                    <li>Status: <strong><?php echo status_field($order->status, $order);?></strong></li>
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-8">
                <h6>Billing Info:</h6>
                <ul>
                    <li><?php echo $billing->full_name; ?></li>
                    <li><a href="mailto:<?php echo $billing->email; ?>"><?php echo $billing->email; ?></a></li>
                    <?php
                    $address = explode(', ', $billing->full_address);
                    foreach ($address as $add) {
                        echo '<li>' . trim($add) . '</li>';
                    }
                    ?>
                    <li><a href="tel:<?php echo $billing->phone; ?>"><?php echo $billing->phone; ?></a></li>
                </ul>
            </div>
            <div class="col-sm-4">
                <h6>Shipping Info:</h6>
                <ul>
                    <li><?php echo $shipping->full_name; ?></li>
                    <li><a href="mailto:<?php echo $shipping->email; ?>"><?php echo $shipping->email; ?></a></li>
                    <?php
                    $address = explode(', ', $shipping->full_address);
                    foreach ($address as $add) {
                        echo '<li>' . trim($add) . '</li>';
                    }
                    ?>
                    <li><a href="tel:<?php echo $shipping->phone; ?>"><?php echo $shipping->phone; ?></a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>Item Image</th>
                <th>Item name</th>
                <th width="120">Item Price</th>
                <th width="100">Quantity</th>
                <th width="120">Total</th>
            </tr>
            </thead>
            <tbody id="product-list">
            <?php
            $subtotal = $tax_amount = $_total_amount = 0;
            foreach ($order_detail as $ord) {

                $ord->qty = (!empty($ord->qty) ? $ord->qty : 1);
                $subtotal += ($ord->price * $ord->qty);
                $tax_amount += ((($ord->price * $ord->tax) / 100) * $ord->qty);
                ?>
                <tr>
                    <td style="width: 100px;">
                        <img src="<?php echo _img('assets/front/products/'.$ord->image,'100','150');?>" alt="<?php echo $ord->name; ?>">
                    </td>
                    <td>
                        <?php echo $ord->name; ?>
                        <br>
                        <small><?php echo $ord->attributes; ?></small>
                    </td>
                    <td><?php echo number_format($ord->price, 2); ?></td>
                    <td align="center"><?php echo number_format($ord->qty); ?></td>
                    <td align="center"><?php echo number_format($ord->price * $ord->qty, 2); ?></td>
                </tr>
                <?
            }
            $_total_amount = ($subtotal + $tax_amount);
            ?>

            </tbody>
        </table>
    </div>
    <div class="panel-body">
        <div class="row invoice-payment">
            <div class="col-sm-8">
                <!--<h6>Payment method:</h6>-->

            </div>
            <div class="col-sm-4">
                <br>

                <table class="table">
                    <tbody>
                    <tr>
                        <th>Subtotal:</th>
                        <td class="text-right"><?php echo CURRENCY . number_format($subtotal, CURRENCY_DECIMALS); ?></td>
                    </tr>
                    <!--<tr>
                  <th>Tax:</th>
                  <td class="text-right"><?php /*echo number_format($tax_amount,2);*/ ?></td>
                </tr>-->
                    <tr>
                        <th>Delivery Charges:</th>
                        <td align="right" class="text-right">
                                <?php
                                if ($order->shipping_amount == 0) {
                                    echo 'Free Delivery';
                                } else {
                                    echo CURRENCY . number_format($order->shipping_amount, CURRENCY_DECIMALS);
                                }
                                ?>
                            </td>
                    </tr>
                    <?php if ($order->discount > 0) { ?>
                        <tr>
                            <th>Discount:</th>
                            <td align="right"><?php echo CURRENCY . '-' . number_format($order->discount, CURRENCY_DECIMALS); ?></td>
                        </tr>
                    <?php } ?>
                    <tr>
                        <th>Total:</th>
                        <td class="text-right text-danger"><h6><?php echo CURRENCY . number_format($order->total_amount, CURRENCY_DECIMALS); ?></h6></td>
                    </tr>
                    </tbody>
                </table>

            </div>
        </div>
        <?php
        if (!empty($row->note)) {
            ?>
            <h6>Notes &amp; Information:</h6>
            <?php
            echo $row->note;
        }
        ?>
    </div>
</div>
<div class="panel panel-default">
  <div class="panel-heading">
    <h6 class="panel-title">Order History</h6>
    <div class="panel-icons-group">
        <a href="#" data-panel="collapse" class="btn btn-link btn-icon"><i class="icon-arrow-down9"></i></a>
    </div>
  </div>
  <div class="-panel-body" style="display: none;">
      <?php
      $grid = new grid();
      $grid->query = $order_history_sql;
      $grid->title = '';
      $grid->limit = 9999;
      //$grid->serial = true;
      $grid->sorting = false;
      $grid->selectAllCheckbox = false;
      $grid->show_paging_bar = false;
      $grid->show_validation_errors = false;
      $grid->id_field = 'id';
      $grid->hide_fields = array('id');
      $grid->center_fields = array('ordering');
      echo $grid->showGrid();
      ?>
  </div>
</div>
<!-- /new invoice template -->

<!-- Form modal -->
<div id="status_modal" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">
            <i class="icon-podium"></i> invoice #: <?php echo $order->order_number; ?>
            <span class="pull-right">
                Current Status: <?php echo str_replace('div', 'span', status_field($order->status,$order));?>&nbsp;&nbsp;
            </span>
        </h4>
      </div>
      <!-- Form inside modal -->
      <form action="<?php echo admin_url($this->module_route . '/status/' . $order->id);?>" role="form" method="post">
        <div class="modal-body with-padding">
          <div class="block-inner text-danger">
            <h6 class="heading-hr">Change Order Status!
                <small class="display-block">Please select new status and comment.</small></h6>
          </div>
          <div class="form-group">
            <label>New Status:</label>
            <select name="status" id="status" data-placeholder="Choose a status..." class="select-full" tabindex="2">
                <option value=""></option>
                <?php echo selectBox("SELECT `status_code`, `status_title` FROM `order_statuses`", $order->status);?>
            </select>
          </div>
          <div class="form-group">
            <label>Comment</label>
            <textarea name="comment" id="comment" cols="30" rows="5" class="form-control col-sm-12"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Submit form</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- /form modal -->

<script>
    (function ($) {
        $(document).ready(function () {

            $(document).on('click', '.btn-print', function (e) {
                e.preventDefault();
                $(".invoice").printElement();
            });
        });
    })(jQuery)
</script>