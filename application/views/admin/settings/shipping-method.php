<?php
$_shipping = unserialize(get_option('shipping'));
?>
<div class="tab-pane fade" id="shipping-method">
    <!--<div class="form-group">
        <label class="col-sm-2 control-label">Status:</label>
        <div class="col-sm-10">
            <select name="setting[shipping][status]" id="shipping_status" class="select">
                <?php
/*                $_shipping_status = array(
                    '1' => 'Yes',
                    '0' => 'No',
                );
                echo selectBox($_shipping_status, $_shipping['status']);*/?>
            </select>
        </div>
    </div>-->
    <div class="form-group">
        <label class="col-sm-2 control-label">Shipping Title:</label>
        <div class="col-sm-10">
            <input type="text" name="setting[shipping][title]" class="form-control" value="<?php echo $_shipping['title']; ?>">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">Shipping Charges:</label>
        <div class="col-sm-10">
            <input type="text" name="setting[shipping][amount]" class="form-control" value="<?php echo $_shipping['amount']; ?>">
        </div>
    </div>

    <div class="panel-heading border-bottom">
        <h6 class="panel-title"><i class="icon-flag3"></i>TCS COD API Setting</h6>
    </div>
    <br>
    <div class="form-group">
        <label class="col-sm-2 control-label">API Mode:</label>
        <div class="col-sm-10">
            <select name="setting[shipping][mode]" id="mode" class="select">
                <?php echo selectBox(array_combine(array('Test','Live'),array('Test','Live')), $_shipping['mode']);?>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">API Key:</label>
        <div class="col-sm-10">
            <input type="text" name="setting[shipping][api_key]" class="form-control" value="<?php echo $_shipping['api_key']; ?>">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">Private Key:</label>
        <div class="col-sm-10">
            <input type="text" name="setting[shipping][private_key]" class="form-control" value="<?php echo $_shipping['private_key']; ?>">
        </div>
    </div>
</div>