<?php echo get_header(); ?>
<div id="main">
    <div class="bg-container page-padding">
        <div class="page-content container">

            <div class="row">
                <div class="col-sm-3">
                    <?php
                    include "account_nav.php";
                    ?>
                </div>
                <div class="col-sm-9">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">ACCOUNT INFORMATION</h3>
                            <a class="pull-right btn btn-sm btn-info" style="margin: -26px -10px;" href="<?php echo site_url('customer/account/edit'); ?>">Edit Profile</a>
                        </div>
                        <div class="panel-body">

                            <?php
                            echo get_email_template($customer, '', $this->cms->get_block('customer-account'));?>

                            <div class="row">
                                <div class="col-sm-12">
                                    <table class="table table-bordered table-view">
                                        <tbody>
                                        <tr>
                                            <th class="span2">First Name:</th>
                                            <td><?php echo $customer->first_name; ?></td>
                                        </tr>
                                        <tr>
                                            <th class="span2">Last Name:</th>
                                            <td><?php echo $customer->last_name; ?></td>
                                        </tr>
                                        <tr>
                                            <th class="span2">Company:</th>
                                            <td><?php echo $customer->company; ?></td>
                                        </tr>
                                        <tr>
                                            <th class="span2">Email:</th>
                                            <td><?php echo $customer->email; ?></td>
                                        </tr>
                                        <tr>
                                            <th class="span2">Address:</th>
                                            <td><?php echo $customer->address; ?></td>
                                        </tr>
                                        <tr>
                                            <th class="span2">City:</th>
                                            <td><?php echo $customer->city; ?></td>
                                        </tr>
                                        <tr>
                                            <th class="span2">State:</th>
                                            <td><?php echo $customer->state; ?></td>
                                        </tr>
                                        <tr>
                                            <th class="span2">Zip:</th>
                                            <td><?php echo $customer->zip; ?></td>
                                        </tr>
                                        <tr>
                                            <th class="span2">Country:</th>
                                            <td><?php echo $customer->contry; ?></td>
                                        </tr>
                                        <tr>
                                            <th class="span2">Phone:</th>
                                            <td><?php echo $customer->phone; ?></td>
                                        </tr>
                                        <tr>
                                            <th class="span2">Fax:</th>
                                            <td><?php echo $customer->fax; ?></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php echo get_footer(); ?>