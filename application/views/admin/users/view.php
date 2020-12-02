<?php
/**
 * Naufil khan
 * E: developer.systech@gmail.com
 * P: +923472565746
 * S: naufil_khan13@hotmail.com
 * @copyright 2019 * @date 18-09-2019
 */
if (!defined('BASEPATH')) exit('No direct script access allowed');
?>
    <!-- Page header -->
    <div class="page-header">
        <div class="page-title">
            <h3>
                <?php echo getModuleDetail()->module_icon; ?>
                <?php echo $this->module_title; ?>
                <small>Listing of <?php echo $this->module_title; ?>.</small>
            </h3>
        </div>
    </div>
    <!-- /page header -->

<?php
include dirname(__FILE__) . "/../includes/breadcrumb.php";
?>

<div class="panel panel-default">
    <div class="panel-heading"><h6 class="panel-title">
        <i class="icon-page-break"></i> <?php echo $this->module_title; ?> - View</h6>
        <div class="pull-right">
            <?php
            echo status_field($user_row['status'], $user_row, '');
            ?>
            <strong>Change Status: </strong>
            <select name="status" id="status" class="select" onchange="window.location='<?=admin_url($this->module_route.'/status/'.$user_row['id']);?>/?status=' + this.value">
                <?php
                $_status = get_enum_values('users', 'status');
                echo selectBox($_status, $user_row['status']);
                ?>
            </select>
        </div>
    </div>

    <div class="table-responsive">

        <table class="table table-bordered table-view">
            <?php

            if($user_row['user_type'] == 'Admin'){
                unset($user_row['membership_type'], $user_row['credit_amount']);
            }else{
                unset($user_row['membership_type']);
            }

            $created_by_id  = $user_row['created_by_id'];
            unset($user_row['created_by_id']);
            foreach ($user_row as $field => $val) {
                switch ($field) {
                    case 'created_by':
                        $val = '<a class="" href="' . admin_url('users/view/' . $created_by_id ) . '">' . $val . '</a>';
                        break;
                    case 'status':
                        $val = status_field($val, $row, '');
                        break;
                    case 'photo':
                        $photo = '<a href="' . base_url('assets/admin/img/users/' . $val) . '" class="lightbox">
                                    <img src="' . _img('assets/admin/img/users/' . $val, 100, 100, './assets/front/uploads/user.jpg') . '" alt="" align="center"/>
                                </a>';
                        $val = $photo;
                        break;
                }
                ?>
                <tr>
                    <th class="span2"><?= ucwords(str_replace('_', ' ', $field)); ?>:</th>
                    <td><?php echo stripslashes(($val)); ?></td>
                </tr>
            <?
            }
            ?>
        </table>


    </div>
</div>
