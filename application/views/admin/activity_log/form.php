<?php
/**
 * Naufil khan
 * E: developer.systech@gmail.com
 * P: +923472565746
 * S: naufil_khan13@hotmail.com
 */
$form_btns = array('save', 'reset', 'back');
?>
<div id="form_content">
    <div class="wrapper">

        <div class="page-header">
            <h5 class="widget-name">
                <i class="icon"><img width="22"
                                     src="<?= base_url('assets/admin/img/icons/22_' . getModuleDetail()->icon); ?>"
                                     alt=""/></i>
                <?= $this->module_title; ?>
            </h5>
        </div>
        <?php
        echo show_validation_errors();
        ?>
        <div class="row-fluid">
            <!-- START -->
            <form id="validate" class="form-horizontal validate"
                  action="<?= admin_url($this->module_route . (!empty($row->id) ? '/update/' . $row->id : '/add')); ?>"
                  method="post" enctype="multipart/form-data">
                <input type="hidden" name="id" id="id" class="id" value="<?= $row->id; ?>"/>

                <fieldset>
                    <div class="widget">
                        <div class="navbar">
                            <div class="navbar-inner"><h6><?= $this->module_title; ?> - Form</h6></div>
                        </div>
                        <?php
                        echo get_form_actions($form_btns);
                        ?>
                        <div class="well row-fluid">
                            <input type="hidden" name="id" id="id" class="id " value="<?= $row->id; ?>"/>

                            <div class="control-group">
                                <label class="control-label">Income By :</label>

                                <div class="controls">
                                    <select name="income_by" id="income_by" class="styled validate[required]">
                                        <option value="">-- Select --</option>
                                        <!-- <? /*=selectBox("select * from income_by",$row->income_by);*/ ?> -->
                                    </select>&nbsp;<span class="req">*</span></div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Title :</label>

                                <div class="controls">
                                    <input type="text" name="title" id="title" class="input-xlarge validate[required]"
                                           value="<?= $row->title ?>"/>&nbsp;<span class="req">*</span></div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Income Head :</label>

                                <div class="controls">
                                    <input type="text" name="income_head" id="income_head" class="input-xlarge "
                                           value="<?= $row->income_head ?>"/></div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Date :</label>

                                <div class="controls">
                                    <input type="text" name="date" id="date"
                                           class="input-xlarge validate[required] datepicker"
                                           value="<?= $row->date ?>"/>&nbsp;<span class="req">*</span></div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Amount :</label>

                                <div class="controls">
                                    <input type="text" name="amount" id="amount"
                                           class="input-xlarge validate[required,custom[number]]"
                                           value="<?= $row->amount ?>"/>&nbsp;<span class="req">*</span></div>
                            </div>
                            <div class="form-actions align-right">
                                <button type="submit" class="btn btn-info">Submit</button>
                                <button type="reset" class="btn">Reset</button>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
</div>