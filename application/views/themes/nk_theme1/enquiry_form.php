<button type="button" class="btn btn-inverse btn-sm btn-enquiry" data-toggle="modal" data-target="#enquiry_form">
    FeedBack
</button>

<div class="modal fade" id="enquiry_form" tabindex="-1" role="dialog" aria-labelledby="enquiry_form">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="validate" class="validate" action="<?php echo site_url('do_enquiry'); ?>" method="post" enctype="multipart/form-data">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Enquiry</h4>
            </div>
            <div class="modal-body">
                <?php
                echo show_validation_errors();
                ?>
                <div class="form-group">
                    <label class="control-label">Name : <span class="mandatory">*</span></label>
                    <input type="text" name="name" id="name" class="form-control  validate[required]" value="<?php echo $row->name ?>"/>

                </div>
                <div class="form-group">
                    <label class="control-label">Email : <span class="mandatory">*</span></label>
                    <input type="text" name="email" id="email" class="form-control  validate[required,custom[email]]" value="<?php echo $row->email ?>"/>

                </div>
                <div class="form-group">
                    <label>Department: <span class="mandatory">*</span></label>
                    <select data-placeholder="Select department" class="required select-full" name="department" tabindex="2">
                      <?php echo selectBox(get_enum_values('enquiries', 'department'), '');?>
                    </select>
                </div>
                <div class="form-group">
                    <label class="control-label">Message : </label>
                    <textarea name="message" id="message" rows="10" class="form-control col-sm-12"><?php echo $row->message; ?></textarea>
                </div>
            </div>
                <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Submit</button>
                      </div>

            </form>
        </div>
    </div>
</div>