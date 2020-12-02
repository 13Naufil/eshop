<?php
/**
 * Naufil khan
 * E: developer.systech@gmail.com
 * P: +923472565746
 * S: naufil_khan13@hotmail.com
 * @copyright 2019 * @date 07-11-2019
 */
if (!defined('BASEPATH')) exit('No direct script access allowed');
?>
<!-- Page header -->
<div class="page-header">
    <div class="page-title">
        <h3>
            <?php echo getModuleDetail()->module_icon; ?>
            <?php echo $this->module_title; ?>
            <small><?php echo $this->module_title; ?>.</small>
        </h3>
    </div>
</div>
<!-- /page header -->

<?php
include dirname(__FILE__) . "/../includes/breadcrumb.php";
?>

<!-- New invoice template -->
    <div class="panel panel-default">
      <div class="panel-heading">
        <h6 class="panel-title"><i class="icon-coin"></i>invoice #: <?php echo $row->invoice_num;?></h6>
        <div class="dropdown pull-right"> <a href="#" class="dropdown-toggle panel-icon" data-toggle="dropdown"> <i class="icon-cog3"></i> <b class="caret"></b> </a>
          <ul class="dropdown-menu icons-right dropdown-menu-right">
            <li><a href="#"><i class="icon-print2"></i> Print invoice</a></li>
            <li><a href="#"><i class="icon-file-pdf"></i> View .pdf</a></li>
          </ul>
        </div>
      </div>
      <div class="panel-body">
        <div class="row invoice-header">
          <div class="col-sm-6">
            <h3><?php echo trim($member->first_name . ' ' . $member->last_name);?></h3>
            <span>&nbsp;</span>
          </div>
          <div class="col-sm-6">
            <ul class="invoice-details">
              <li>Invoice # <strong class="text-danger"><?php echo $row->invoice_num;?></strong></li>
              <li>Transaction Date: <strong><?php echo mysql2date($row->transaction_date);?></strong></li>
            </ul>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-8">
            <h6>Invoice To:</h6>
            <ul>
              <li><?php echo get_option('admin_title');?></li>
              <li><a href="mailto:<?php echo get_option('contact_email');?>"><?php echo get_option('contact_email');?></a></li>
              <?php
              $address = explode(',', get_option('address'));
              foreach($address as $add){
                  echo '<li>'.trim($add).'</li>';
              }
              ?>
              <li><a href="tel:<?php echo get_option('phone_number');?>"><?php echo get_option('phone_number');?></a></li>
            </ul>
          </div>
          <div class="col-sm-4">
            <h6>Invoice From:</h6>
            <ul>
              <li><?php echo trim($member->first_name . ' ' . $member->last_name);?></li>
                <?php if (!empty($member->email)) { ?>
                <li><a href="mailto:<?php echo $member->email;?>"><?php echo $member->email;?></a></li>
                <?php } ?>
                <?php
                  $address = explode(',', $member->address);
                  foreach($address as $add){
                      echo '<li>'.trim($add).'</li>';
                  }
                  ?>
                <?php if (!empty($member->phone)) { ?>
                <li><a href="tel:<?php echo $member->phone;?>"><?php echo $member->phone;?></a></li>
                <?php } ?>
            </ul>
          </div>
        </div>
      </div>
      <div class="table-responsive">
          <table class="table table-striped table-bordered">
          <thead>
          <tr>
              <th>Item name</th>
              <th width="120">Item Price</th>
              <th width="100">Quantity</th>
              <th width="120">Total</th>
          </tr>
          </thead>
          <tbody id="product-list">
          <?php
          $subtotal = $tax_amount = $total_amount = 0;
          foreach($order_detail as $ord){

              $ord->qty = (!empty($ord->qty) ? $ord->qty : 1);
              $subtotal += ($ord->price * $ord->qty);
              $tax_amount += ((($ord->price * $ord->tax) / 100) * $ord->qty);
              ?>
              <tr>
                  <td><?php echo $ord->product_name; ?></td>
                  <td><?php echo number_format($ord->price,2); ?></td>
                  <td align="center"><?php echo number_format($ord->qty); ?></td>
                  <td align="center"><?php echo number_format($ord->price * $ord->qty,2); ?></td>
              </tr>
          <?
          }
          $total_amount = ($subtotal + $tax_amount);
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
            <h6>Total:</h6>
            <table class="table">
              <tbody>
                <!--<tr>
                  <th>Subtotal:</th>
                  <td class="text-right"><?php /*echo number_format($subtotal,2);*/?></td>
                </tr>
                <tr>
                  <th>Tax:</th>
                  <td class="text-right"><?php /*echo number_format($tax_amount,2);*/?></td>
                </tr>-->
                <tr>
                  <th>Total:</th>
                  <td class="text-right text-danger"><h6><?php echo number_format($total_amount,2);?></h6></td>
                </tr>
              </tbody>
            </table>

          </div>
        </div>
          <?php

          if(!empty($row->note)) {
              ?>
              <h6>Notes &amp; Information:</h6>
              <?php
              echo $row->note;
        }
        ?>
      </div>
    </div>
    <!-- /new invoice template -->