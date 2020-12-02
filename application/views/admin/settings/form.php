<?php
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
                  action="<?= site_url(ADMIN_DIR . $this->module_route . '/update'); ?>"
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
                                <label class="control-label">Option :</label>

                                <div class="controls">
                                    <input type="text" name="option_name" id="option_name"
                                           class="input-xlarge validate[required]"
                                           value="<?= $row->option_name ?>"/>&nbsp;<span
                                        class="req">*</span></div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Value :</label>

                                <div class="controls">
                                    <textarea name="option_value" id="option_value" cols="60" rows="6"
                                              class="textarea validate[required]"><?= stripslashes($row->option_value); ?></textarea>&nbsp;<span
                                        class="req">*</span></div>
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
