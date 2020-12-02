<?php
/**
 * Naufil khan
 * Email: developer.systech@gmail.com
 */
include  dirname(__FILE__) . "/../includes/head.php";
include  dirname(__FILE__) . "/../includes/header.php";
include dirname(__FILE__) . "/../includes/left_side_bar.php";

$form_btns = array('save', 'reset', 'back');
?>
<link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap-datetimepicker.min.css');?>"/>
<script type="text/javascript" src="<?php echo base_url('assets/js/bootstrap-datetimepicker.min.js');?>"></script>
    <!-- Content -->
    <div id="form_content">
        <div class="wrapper">

            <div class="page-header">
                <h5 class="widget-name"><i class="icon-user"></i><?php echo $this->module_title;?></h5>
            </div>
            <div class="row-fluid">
                <!-- START -->
                <form id="validate" class="form-horizontal validate"
                      action="<?php echo site_url(ADMIN_DIR . $this->module_name . (!empty($row->id) ? '/update' : '/add')) ; ?>"
                      method="post" enctype="multipart/form-data">
                    <input type="hidden" name="id" id="id" value="<?php echo $row->id; ?>"/>

                    <fieldset>

                        <!-- Form validation -->
                        <div class="widget">
                            <div class="navbar">
                                <div class="navbar-inner"><h6><?php echo $this->module_title;?> - Form</h6></div>
                            </div>
                            <?php
                            echo get_form_actions($form_btns);
                            echo show_validation_errors();
                            ?>
                            <div class="well row-fluid">

                                <div class="control-group">
                                    <label class="control-label">Title: </label>

                                    <div class="controls">
                                        <input type="text" class="validate[required] input-large" name="title"
                                               id="title" value="<?php echo $row->title; ?>"/>
                                        <span class="text-error">*</span>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Post Name: </label>

                                    <div class="controls">
                                        <input type="text" class="validate[required]" name="post_name"
                                               id="post_name" value="<?php echo $row->post_name; ?>"/>
                                        <span class="text-error">*</span>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Content: </label>

                                    <div class="controls">
                                        <textarea name="content" id="content" cols="120" rows="50" class="editor">
                                            <?php echo stripslashes($row->content) ; ?>
                                        </textarea>
                                        <span class="text-error">*</span>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Published Date time: </label>

                                    <div class="controls">

                                          <div id="datetimepicker1" class="input-append date">
                                            <input data-format="dd/MM/yyyy hh:mm:ss" type="text" value="<?php echo $row->datetime;?>" >
                                            <span class="add-on">
                                              <i data-time-icon="icon-time" data-date-icon="icon-calendar">
                                              </i>
                                            </span>
                                          </div>

                                        <!--<div class="well">
                                            <div id="datetimepicker1" class="input-append date">
                                                <input type="text" readonly="" data-format="dd/MM/yyyy hh:mm:ss" class="" value="<?php/*=$row->datetime;*/?>" name="datetime" id="datetime"/>
                                            <span class="add-on">
                                              <i data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
                                            </span>
                                            </div>
                                        </div>-->

                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Post Status: </label>

                                    <div class="controls">
                                        <select name="status" id="status" class="styled">
                                            <?php
                                            $status = array(
                                                'publish' => 'Publish',
                                                'unpublish' => 'Unpublish',
                                                'draft' => 'Draft'
                                            );
                                            echo selectBox($status, $row->status);
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Comment Status: </label>

                                    <div class="controls">
                                        <select name="comment_status" id="comment_status" class="styled">
                                            <?php
                                            $status = array(
                                                'active' => 'Active',
                                                'inactive' => 'Inactive'
                                            );
                                            echo selectBox($status, $row->comment_status);
                                            ?>
                                        </select>
                                    </div>
                                </div>


                                <div class="form-actions align-right">
                                    <button type="submit" class="btn btn-info">Submit</button>
                                    <button type="reset" class="btn">Reset</button>
                                </div>

                            </div>

                        </div>
                        <!-- /form validation -->

                    </fieldset>
                </form>

                <!-- END -->
            </div>
        </div>
    </div>
    <!-- /content -->
<?php
include  dirname(__FILE__) . "/../includes/footer.php";
?>
<script type="text/javascript">
  $(function() {
    $('#datetimepicker1').datetimepicker({

    });
  });
</script>