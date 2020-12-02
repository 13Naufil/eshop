<?php
/**
 * Naufil khan
 * E: developer.systech@gmail.com
 * P: +923472565746
 * S: naufil_khan13@hotmail.com
 */
$form_btns = array('save', 'reset', 'back');
?>
<!-- Page header -->
<div class="page-header">
    <div class="page-title">
        <h3>
            <?php echo getModuleDetail()->module_icon; ?>
            <?php echo $this->module_title; ?>
            <small>Profile page.</small>
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

<!-- START -->
<form id="validate" class="form-horizontal validate" action="" method="post" enctype="multipart/form-data">

    <div class="panel panel-default">
        <!-- Form validation -->
        <div class="panel-heading">
            <h6 class="panel-title"><i class="icon-bubble4"></i>
                <?php echo $this->module_title; ?> - General Information Form
            </h6>
        </div>
        <?php
        echo get_form_actions($form_btns);
        ?>

        <div class="panel-body">

            <div class="form-group">
                <label class="col-sm-2 control-label text-right">First Name : <span class="mandatory">*</span></label>

                <div class="col-sm-7">
                    <input type="text" name="first_name" id="first_name"
                           class="form-control validate[required]" value="<?= $row->first_name ?>"/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label text-right">Last Name : <span class="mandatory">*</span></label>

                <div class="col-sm-7">
                    <input type="text" name="last_name" id="last_name"
                           class="form-control validate[required]" value="<?= $row->last_name ?>"/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label text-right">Photo :</label>

                <div class="col-sm-5">
                    <input type="file" name="photo" id="photo" class="styled " value="<?= $row->photo; ?>"/>
                </div>
                    <?php
                    if (!empty($row->photo)) {
                        ?>
                    <div class="col-sm-2 " style="">
                        <div class="block">
                            <div class="thumbnail thumbnail-boxed">
                                <div class="thumb">
                                    <img src="<?= base_url('assets/admin/img/users/' . $row->photo); ?>" alt="" align="center" class="img-responsive"/>

                                    <div class="thumb-options">
                                        <span>
                                          <a href="<?php echo base_url('assets/admin/img/users/' . $row->photo); ?>" class="btn btn-icon btn-success lightbox"><i class="icon-eye2"></i></a>
                                          <a href="<?php echo admin_url($this->module_route . '/AJAX/delete_img/' . $row->id . '/' . $row->photo); ?>" class="btn btn-icon btn-success"><i class="icon-remove"></i></a>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <? } ?>

                </div>
            <div class="form-group">
                <label class="col-sm-2 control-label text-right">CNIC : <span class="mandatory">*</span></label>

                <div class="col-sm-7">
                    <input type="text" name="cnic" id="cnic" class="form-control validate[required,minSize[15],maxSize[15]]" value="<?= $row->cnic ?>" data-mask="99999-9999999-9"/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label text-right">Email : <span class="mandatory">*</span></label>

                <div class="col-sm-7">
                    <input type="text" name="email" id="email"
                           class="form-control validate[required,custom[email],funcCall[checkEmail]]"
                           value="<?= $row->email ?>"/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label text-right">Phone :</label>

                <div class="col-sm-7">
                    <input type="text" name="phone" id="phone" class="form-control " value="<?= $row->phone ?>" data-mask="+99-999-999-9999"/>
                    <span class="help-block">+92-332-310-3324</span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label text-right">Address : <span class="mandatory">*</span></label>

                <div class="col-sm-7">
                    <input type="text" name="address" id="address"
                           class="form-control validate[required]"
                           value="<?= $row->address ?>"/>
                </div>
            </div>

            
        </div>
    </div>
<br/>

    <div class="panel panel-default">
            <div class="panel-heading">
                <h6 class="panel-title"><i class="icon-key2"></i> Login Detail</h6>
            </div>
        <div class="panel-body">

            <div class="form-group">
                <label class="col-sm-2 control-label text-right">Username : <span class="mandatory">*</span></label>

                <div class="col-sm-7">
                    <input type="text" name="username" class="form-control validate[required,funcCall[checkUserName]]" value="<?= $row->username ?>">
                    <span class="help-inline">Alpha, numerics and underscores are allowed only.</span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label text-right">Password:</label>

                <div class="col-sm-7">
                    <input type="password" name="password" class="form-control validate[minSize[6],maxSize[12]]">
                    <span class="help-inline">Length must be 6 to 12 characters.</span>
                    <?php
                    if($row->id > 0){
                    ?>
                    <br>
                    <span class="help-block color-red">Note: If you would like to change the password type a new one. Otherwise leave this blank.</span>
                    <? } ?>
                </div>
            </div>
        </div>
</div>

<div class="form-actions text-right well">
   <button type="submit" class="btn btn-info">Submit</button>
   <button type="reset" class="btn">Reset</button>
</div>
</form>

<script>

    $('#user_type_id').on('click', function () {
        if ($(this).val() != '<?=get_option('admin_user_type');?>') {
            $('.admin-not-field').show().find('input').addClass('validate[required]');
        } else {
            $('.admin-not-field').hide().find('input').removeClass('validate[required]');
        }
        if ($(this).val() == '<?=get_option('client_type_id');?>') {
            $('.member-field').show().find('input').addClass('validate[required]');
        } else {
            $('.member-field').hide().find('input').removeClass('validate[required]');
        }
        if ($(this).val() == '<?=get_option('group_breed_worden_id');?>') {
            $('.gbw-field').show().find('select').addClass('validate[required]');
        } else {
            $('.gbw-field').hide().find('select').removeClass('validate[required]');
        }
    });

    $(document).ready(function () {
        $('#user_type_id').trigger('click');
    });

    function checkEmail(field, rules, i, options) {
        if (field.val() != "") {
            var data = {};
            var check_email_msg = '';

            data.value = field.val();
            <?php if ($row->id > 0) { ?>
            data.id = <?php echo $row->id; ?>;
            <?php } ?>

            $.ajax({
                url: '<?php echo admin_url('users/validate/email'); ?>',
                dataType: 'json',
                async: false,
                data: data,
                success: function (data) {
                    if (data != null) {
                        check_email_msg = data.message;
                    }
                }
            });

            if (check_email_msg != '') {
                return check_email_msg;
            }
        }
    }

    function checkUserName(field, rules, i, options) {
        if (field.val() != "") {
            var data = {};
            var check_username_msg = '';

            data.value = field.val();
            <?php if ($row->id > 0) { ?>
            data.id = <?php echo $row->id; ?>;
            <?php } ?>

            $.ajax({
                url: '<?php echo admin_url('users/validate/username'); ?>',
                dataType: 'json',
                async: false,
                data: data,
                success: function (data) {
                    if (data != null) {
                        check_username_msg = data.message;
                    }
                }
            });

            if (check_username_msg != '') {
                return check_username_msg;
            }
        }
    }
</script>