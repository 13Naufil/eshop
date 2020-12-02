<div class="modal fade" id="ask-ques-modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="<?php echo site_url('product_catalog/submit_question'); ?>" method="post" class="validate">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Ask a question</h4>
                </div>
                <div class="modal-body">


                    <input type="hidden" name="brand_id" id="brand_id" value="<?= $product->brand_id; ?>"/>
                    <input type="hidden" name="product_id" id="product_id" value="<?= $product->id; ?>"/>



                        <div class="row">
                            <div class="col-sm-6">
                                Question title *<br>
                                <input type="text" name="title" id="title" class="form-control validate[required]"/>
                                <i>Example: How to use</i>
                                <br>
                                <br>
                                Question <span class="color-red">*</span><br>
                                <textarea name="question" id="question" class="col-sm-12 form-control validate[required]" cols="50" rows="10"></textarea>
                            </div>
                            <div class="col-sm-6">
                                <div class="border with-padding" style="margin-top: 20px;">
                                    <?php echo $this->cms->get_block('question-area'); ?>
                                </div>
                            </div>
                        </div>

                        <div class="clearfix"></div>

                        <div class="row">
                            <div class="col-sm-12">
                                <h3>Tell Other Customers About Yourself and Connect.</h3>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-horizontal col-sm-8">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label text-right">Nickname : <span class="mandatory">*</span></label>

                                    <div class="col-sm-6">
                                        <input type="text" name="nickname" id="nickname"
                                               class="form-control  validate[required]"
                                               value="<?php echo $row->nickname ?>"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label text-right">Email : <span
                                            class="mandatory">*</span></label>

                                    <div class="col-sm-6">
                                        <input type="text" name="email" id="email"
                                               class="form-control  validate[required,custom[email]]"
                                               value="<?php echo $row->email ?>"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label text-right">Gender : </label>

                                    <div class="col-sm-6">
                                        <select name="gender" id="gender" class="select ">
                                            <?php echo selectBox(array('Male' => 'Male', 'Femaile' => 'Femaile'), $row->gender); ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>



                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <input type="submit" name="submit" value="Submit" class="btn btn-success btn-margin"/>
                    </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div><!-- /.modal -->