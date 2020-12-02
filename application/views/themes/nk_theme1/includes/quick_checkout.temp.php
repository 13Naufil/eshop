<?php
/*
<a href="#" class="btn btn-primary" data-toggle="modal" data-target="#quick-checkout">Quick Checkout</a>
*/
?>

<!-- Modal -->
<div class="modal fade" id="quick-checkout" tabindex="-1" role="dialog" aria-labelledby="quick-checkout">
    <div class="modal-dialog modal-sm-" role="document">
        <form action="<?php echo site_url('cart/addcart');?>" method="post">
            <input type="hidden" name="id" id="id" value="<?php echo $product->id;?>"/>
            <input type="hidden" name="cart_type" id="cart_type" value="Quick Checkout"/>

            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel">QUICK ORDER FORM</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <h2 class="product-title"><?php echo $product->name; ?> <small class="pull-right">| <?php echo $category->title; ?></small></h2>
                        <strong class="text-uppercase color-1">Model : <?php echo $product->SKU; ?></strong>
                    </div>
                    <div class="form-group">
                        <input name="name" type="text" class="form-control validate[required]" id="name" placeholder="Name" required="" aria-required="true">
                    </div>
                    <div class="form-group">
                        <input name="email" type="email" class="form-control validate[required,custom[emial]]" id="email" placeholder="Email Address" required="" aria-required="true">
                    </div>
                    <div class="form-group">
                        <input name="phone" type="phone" class="form-control validate[required,custom[phone]]" id="phone" placeholder="Phone #" maxlength="11" required="" aria-required="true">
                    </div>
                    <div class="form-group">
                        <textarea name="address" rows="3" class="form-control validate[required]" id="address" placeholder="Delivery Address" required="" aria-required="true"></textarea>
                    </div>
                    <div class="form-group">
                        <select name="qty" class="form-control validate[required]" id="qty" required="" aria-required="true">
                            <option value="">Select Quantity</option>
                            <option value="1" selected>1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <select name="city" class="form-control validate[required]" id="city" required="" aria-required="true">
                            <?php echo selectBox("SELECT name, name AS _city FROM lcs_cities", '');?>
                        </select>
                    </div>

                    <div class="form-group">
                        <input name="city" type="text" class="form-control" id="cityname" placeholder="Enter City Name" style="display: none;">
                    </div>
                    <script type="text/javascript">
                        $('#cityname').hide();
                        $('#cityname').val($('#city').val());
                        $('#city').on('change', function () {
                            var city = $('#city').val();
                            if (city == 'OTHER') {
                                $('#cityname').show();
                            } else {
                                $('#cityname').hide();
                                $('#cityname').val($('#city').val());
                            }
                        });
                    </script>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" name="buynow" class="btn btn-sm btn-primary buynow">BUY NOW</button>
                </div>
            </div>
        </form>
    </div>
</div>
