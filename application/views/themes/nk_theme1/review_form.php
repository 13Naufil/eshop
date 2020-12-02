<div class="modal fade" id="write-review-modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="<?php echo site_url('product_catalog/submit_reviews'); ?>" method="post" class="validate">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Write a review</h4>
                </div>
                <div class="modal-body">

                    <div class="review_toggle">

                        <input type="hidden" name="brand_id" id="brand_id" value="<?= $product->brand_id; ?>"/>
                        <input type="hidden" name="product_id" id="product_id" value="<?= $product->id; ?>"/>

                            <div class="row">
                                <div class="col-sm-12">
                                    <?php
                                    if(count($product_rating_types) > 0){
                                        echo '<ul class="rating_types">';
                                        foreach($product_rating_types as  $rating_types){
                                            ?>
                                            <li>
                                                <h4><?php echo $rating_types->rating_name;?></h4>
                                                <div class="rating-types" data-field="score[<?php echo $rating_types->id;?>]" data-readonly="false" data-score="0" id="rating-<?php echo url_title($rating_types->rating_name,'-', true);?>"></div>
                                            </li>
                                            <?
                                        }
                                        echo '</ul>';
                                    }
                                    ?>
                                </div>
                            </div>
                            <hr class="sm">
                            <div class="row">
                                <div class="col-sm-12">
                                    I would recommend this product to a friend <span class="color-red">*</span>
                                </div>
                                <div class="col-sm-12">
                                    <label class="radio-inline checkbox-success">
                                        <input type="radio" name="recommend" value="Yes" id="recommend" class="form-input validate[required]" <? //= set_radio('recommend', 'Yes'); ?>/>
                                        Yes
                                    </label>
                                    &nbsp;&nbsp;&nbsp;
                                    <label class="radio-inline radio-success">
                                    <input type="radio" name="recommend" value="No" id="recommend" class="form-input validate[required]" <? //= set_radio('recommend', 'No', true); ?>/>
                                        No
                                    </label>
                                </div>
                            </div>
                            <hr class="sm">

                            <div class="clearfix"></div>
                            <h3>Share Your Opinion With Others and Write a Detailed Review.</h3>

                            <div class="row">
                                <div class="col-sm-6">
                                    Review title *<br>
                                    <input type="text" name="title" id="title" class="form-control validate[required]"
                                           size="55"/>
                                    <i>Example: Best Purchase Ever</i>
                                    <br>
                                    <br>
                                    Review <span class="color-red">*</span><br>
                                    <textarea name="review" id="review"
                                              class="col-sm-12 form-control validate[required]" cols="50"
                                              rows="10"></textarea>

                                    <i>You must write at least 50 characters for this field.</i>
                                </div>
                                <div class="col-sm-6">
                                    <div class="border with-padding" style="margin-top: 20px;">
                                        <?php echo $this->cms->get_block('review-area'); ?>
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
                                    <label class="col-sm-3 control-label text-right">Age : </label>

                                    <div class="col-sm-2">
                                        <input type="text" name="age" id="age" class="form-control  "
                                               value="<?php echo $row->age ?>"/>
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


                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <input type="submit" name="submit" value="Submit Review" class="btn btn-success btn-margin"/>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div><!-- /.modal -->