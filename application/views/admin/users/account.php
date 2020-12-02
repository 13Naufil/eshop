<?php
/**
 * Naufil khan
 * E: developer.systech@gmail.com
 * P: +923472565746
 * S: naufil_khan13@hotmail.com
 */

?>
<div id="form_content">
    <div class="wrapper">

        <div class="page-header">
            <h5 class="widget-name">
                <i class="icon">
                    <img width="22" src="<?= base_url('assets/admin/img/icons/22_' . getModuleDetail()->icon); ?>" alt=""/>
                </i>
                <strong class="color-red"><a href="<?=admin_url('users/view/'.$row->id) ; ?>"><?=$row->first_name . ' ' . $row->last_name; ?> (<?=$row->email ; ?>)</a></strong> : Account

                <a href="#" onclick="window.history.back()" class="back-btn btn pull-right" ><i class="icon-step-backward"></i> &nbsp;Back</a>
            </h5>
        </div>
        <?php
        echo show_validation_errors();
        ?>
        <div class="row-fluid">
            <!-- START -->
            <form id="validate" class="form-horizontal validate"
                  action="<?= admin_url($this->module_route . '/account/' .$row->id . '/' . $account->id); ?>"
                  method="post" enctype="multipart/form-data">

                <input type="hidden" name="action" id="action" value="<?= ($account->id) > 0 ? 'Update' : 'Add' ?>"/>
                <input type="hidden" name="id" id="id" class="id" value="<?= $account->id; ?>"/>

                <fieldset>
                    <div class="widget">
                        <div class="navbar">
                            <div class="navbar-inner"><h6>Add Credit Form</h6></div>
                        </div>
                        <div class="well row-fluid">
                            <div class="control-group">
                                <label class="control-label">Payment Mothod :</label>

                                <div class="controls">
                                    <select name="payment_method" id="payment_method" class="styled validate[required]">
                                        <?php
                                        $payment_methods = get_enum_values('user_accounts','payment_method');
                                        echo selectBox($payment_methods, $account->payment_method);
                                        ?>
                                    </select>
                                    &nbsp;<span class="req">*</span>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Date :</label>

                                <div class="controls">
                                    <input readonly type="text" name="date" id="date" class="validate[required] datepicker" value="<?= $account->date ?>"/>
                                    &nbsp;<span class="req">*</span>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Amount :</label>

                                <div class="controls">
                                    <input type="text" name="amount" id="amount" class="validate[required,custom[number]] " value="<?= $account->amount ?>"/>
                                    &nbsp;<span class="req">*</span>
                                </div>
                            </div>
                            <div class="control-group type-Payorder type-Demond_Draft type-Online_Transfer__Telegraphic hide">
                                <label class="control-label">Bank Drawn On :</label>

                                <div class="controls">
                                    <input type="text" name="bank_drawn_on" id="bank_drawn_on" class="validate[required] required-Payorder required-Demond_Draft required-Online_Transfer__Telegraphic input-xlarge " value="<?= $account->bank_drawn_on ?>"/>
                                    &nbsp;<span class="req">*</span>
                                </div>
                            </div>

                            <div class="control-group type-Cheque hide">
                                <label class="control-label">Cheque Number :</label>

                                <div class="controls">
                                    <input type="text" name="cheque_no" id="cheque_no" class="input-xlarge required-Cheque" value="<?= $account->cheque_no ?>"/>
                                    &nbsp;<span class="req">*</span>
                                </div>
                            </div>

                            <div class="control-group type-Credit type-Payorder hide">
                                <label class="control-label">Note :</label>

                                <div class="controls">
                                    <textarea name="note" id="note" cols="30" rows="6" class="span8 required-Credit"><?= stripslashes($account->note) ?></textarea>
                                    &nbsp;<span class="req">*</span>
                                </div>
                            </div>


                            <div class="form-actions align-right">
                                <button type="submit" class="btn btn-info">Submit</button>
                                <button type="reset" class="btn">Reset</button>
                            </div>
                        </div>
                </fieldset>
            </form>
        </div>


        <br/>
        <h5 class="widget-name">Account Details <span class="badge badge-important pull-right">Current Balance: <?=$row->credit_amount;?></span></h5>

        <div class="row-fluid">
        <?php
        $grid = new grid();
        $grid->query = $account_list;

        $grid->title = $row->first_name . ' ' . $row->last_name . ' (' .$row->email .')';
        $grid->limit = 999;


        $grid->selectAllCheckbox = false;
        $grid->show_paging_bar = false;
        $grid->show_validation_errors = false;
        $grid->sorting = false;
        //$grid->search_box = TRUE;

        $grid->hide_fields = array('user_id');
        $grid->center_fields = array('ordering');
        $grid->grid_action_privilege = 'public';
        $grid->grid_buttons = array('edit_account');
        echo $grid->showGrid();
        ?>
        </div>

    </div>
</div>

<script type="text/javascript">
    $('#payment_method').live('change', function () {
        var field = $(this).val().replace(/\s/g,'_').replace(/[^a-zA-Z0-9_-]/g,'');

        if($('.type-' + field).length > 0){
            $('.type-' + field).show();
            $('.type-' + field).find('required-' + field).addClass('validate[required]');

            $('.hide').not('.type-' + field).hide();
            $('.hide').not('.type-' + field).find('input,select,textarea').removeClass('validate[required]').val('');
        }else{
            $('.hide').hide();
            $('.hide').find('validate[required]').removeClass('validate[required]');
        }
    });

    $('#payment_method').trigger('change')
</script>