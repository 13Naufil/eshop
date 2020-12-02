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
            <small>Report of <?php echo $this->module_title; ?>.</small>
        </h3>
    </div>
</div>
<!-- /page header -->

<?php
include dirname(__FILE__) . "/../includes/breadcrumb.php";
?>

<form id="validate" class="form-horizontal validate" action="" method="post">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h6 class="panel-title"><i class="icon-bubble4"></i>
                <?php echo $this->module_title; ?> - Stock
            </h6>
        </div>
        <?php
        echo get_form_actions($form_btns);
        ?>
        <div class="panel-body">
            <div class="form-group not-staff-field customer-field supplier-field">
                <label class="col-sm-2 control-label text-right">Dealer : </label>

                <div class="col-sm-7">
                    <select name="dealer_id" id="dealer_id" class="select-search">
                        <option value="">- Select One -</option>
                        <?php echo selectBox("SELECT id, business_name FROM dealers WHERE 1 " . $where, $row->dealer_id); ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <div class="text-center col-sm-7 col-sm-offset-2">-OR-</div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label text-right">Country : </label>

                <div class="col-sm-7">
                    <input type="text" list="countries" name="country" id="country" class="form-control" value="<?php echo $row->country ?>"/>
                    <datalist id="countries">
                        <?php echo selectBox("SELECT country FROM dealers GROUP BY country", '', '<option value="{country}">'); ?>
                    </datalist>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label text-right">State :</label>

                <div class="col-sm-7">
                    <input type="text" list="states" name="state" id="state" class="form-control" value="<?php echo $row->state ?>"/>
                    <datalist id="states">
                        <?php echo selectBox("SELECT state FROM dealers GROUP BY state", '', '<option value="{state}">'); ?>
                    </datalist>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label text-right">City : </label>

                <div class="col-sm-7">
                    <input type="text" list="cities" name="city" id="city" class="form-control" value="<?php echo $row->city ?>"/>
                    <datalist id="cities">
                        <?php echo selectBox("SELECT city FROM dealers GROUP BY city", '', '<option value="{city}">'); ?>
                    </datalist>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label text-right">Area : </label>

                <div class="col-sm-7">
                    <input type="text" name="area" id="area" class="form-control" value="<?php echo $row->area ?>"/>
                    <datalist id="cities">
                        <?php echo selectBox("SELECT area FROM dealers GROUP BY area", '', '<option value="{area}">'); ?>
                    </datalist>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label text-right">Market : </label>

                <div class="col-sm-7">
                    <input type="text" name="market" id="market" class="form-control " value="<?php echo $row->market ?>"/>
                </div>
            </div>


            <!--<div class="form-group">
                <label class="col-sm-2 control-label text-right">From Date: </label>

                <div class="col-sm-2">
                    <input type="text" name="from_date" id="from_date" class="form-control datepicker" value="<?php /*echo $row->from_date */?>"/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label text-right">To Date : </label>

                <div class="col-sm-2">
                    <input type="text" name="to_date" id="to_date" class="form-control datepicker" value="<?php /*echo $row->to_date */?>"/>
                </div>
            </div>-->


        </div>
    </div>
    <div class="form-actions text-center well">
        <button type="submit" class="btn btn-info">Preview</button>
        <button type="submit" class="btn btn-danger">Print</button>
        <button type="reset" class="btn">Reset</button>
    </div>
</form>