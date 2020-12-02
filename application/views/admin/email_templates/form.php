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
            <small>Form of <?php echo $this->module_title; ?>.</small>
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
<form id="validate" class="form-horizontal validate"
      action="<?php echo admin_url($this->module_route . (!empty($row->id) ? '/update/' . $row->id : '/add')); ?>"
      method="post" enctype="multipart/form-data">

    <input type="hidden" name="id" id="id" class="id" value="<?php echo $row->id; ?>"/>

    <div class="panel panel-default">
            <div class="panel-heading">
                <h6 class="panel-title"><i class="icon-bubble4"></i>
                    <?php echo $this->module_title; ?> - Form
                </h6>
            </div>
            <?php
            echo get_form_actions($form_btns);
            ?>
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-9">
                        <div class="form-group">
                            <label class="col-sm-2 control-label text-right">Name : <span class="mandatory">*</span></label>

                            <div class="col-sm-7">
                                <input type="text" name="name" id="name" class="form-control validate[required]" <?php echo ($row->id > 0 ? 'readonly': '');?> value="<?php echo $row->name;?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label text-right">Subject : <span class="mandatory">*</span></label>

                            <div class="col-sm-7">
                                <input type="text" name="subject" id="subject" class="form-control validate[required]" value="<?php echo $row->subject ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label text-right">Status : <span class="mandatory">*</span></label>

                            <div class="col-sm-7">
                                <select name="status" id="status" class="select">
                                    <?php
                                    $_status = get_enum_values($this->table,'status');
                                    echo selectBox($_status, $row->status);?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-12">
                                <textarea name="message" id="message" cols="30" rows="40" class="editor col-sm-12"><?php echo stripslashes($row->message); ?></textarea>
                            </div>
                        </div>

                        <div class="widget form-horizontal panel">
                            <div class="panel-heading border-bottom">
                                <h6 class="panel-title"><i class="icon-mobile2"></i>SMS</h6>
                            </div>
                            <div class="panel-body">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label text-right">SMS Status : <span class="mandatory">*</span></label>

                                    <div class="col-sm-7">
                                        <select name="sms_status" id="sms_status" class="select">
                                            <?php
                                            $_status = get_enum_values($this->table,'sms_status');
                                            echo selectBox($_status, $row->sms_status);?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label text-right">SMS Message : <span class="mandatory">*</span></label>
                                    <div class="col-sm-10">
                                        <textarea name="sms_message" id="sms_message" cols="30" rows="10" data-limit="256" class="counter form-control col-sm-12"><?php echo stripslashes($row->sms_message); ?></textarea>
                                        <span class="help-block" id="limit-text"></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-sm-3">
                            <?php
                            $_tags = array(
                                'Basic Tags' => array(
                                    'config' => array('title' => 'Basic Tags', 'icon' => 'icon-home'),

                                    'site_title' => 'site_title',
                                    'phone_number' => 'phone_number',
                                    'contact_email' => 'contact_email',
                                    'copyright' => 'copyright',
                                    'site_url' => 'site_url',
                                    'base_url' => 'base_url',
                                    'admin_url' => 'admin_url',
                                ),
                                'Member Tags' => array(
                                    'config' => array('title' => 'Member Tags', 'icon' => 'icon-user'),

                                    'id' => 'id',
                                    'username' => 'username',
                                    'password' => 'password (Use only signup)',
                                    'first_name' => 'first_name',
                                    'last_name' => 'last_name',
                                    /*'photo' => 'photo',
                                    'cnic' => 'cnic',*/
                                    'email' => 'email',
                                    'phone' => 'phone',
                                    'address' => 'address',
                                    'city' => 'city',
                                    'country' => 'country',
                                    'zip_code' => 'zip_code',
                                    'created' => 'created',
                                    'status' => 'status',
                                    'token_num' => 'Token # (Use only forget)'
                                ),

                            );
                            ?>
                            <div class="accordion" id="accordion">
                                <?php
                                $t = 0;
                                foreach ($_tags as $tags) {
                                    $t++;
                                    $config = $tags['config'];
                                    unset($tags['config']);
                                    ?>
                                    <div class="panel-group block" id="accordion">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h6 class="panel-title">
                                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne<?php echo $t;?>">
                                                        <i class="<?php echo $config['icon'];?>"></i> <?php echo $config['title'];?>
                                                    </a>
                                                </h6>
                                            </div>
                                    <div id="collapseOne<?php echo $t;?>" class="panel-collapse collapse <?php echo ($t == 1 ? 'in' : '');?>">
                                        <div class="panel-body">
                                        <?php
                                        foreach($tags as $tag => $tag_value){
                                            echo '<p class="field-'.$tag.'"><a href="javascript: void(0);" onclick="tinymce.activeEditor.execCommand(\'mceInsertContent\', false, \'['.$tag.']\');">['.$tag_value.']</a></p>';
                                        }
                                        ?>
                                        </div>
                                    </div>
                                </div>
                                <?php } ?>
                            </div>


                    </div>
                </div>
            </div>
        </div>



    <div class="form-actions text-right">
        <button type="submit" class="btn btn-info">Submit</button>
        <button type="reset" class="btn">Reset</button>
    </div>
</form>