<?php echo get_header(); ?>

<div class="main" id="checkout-page" style="padding-top: 60px;">
<div class="container page-padding">

    <?php if(show_validation_errors() != ''){
        echo '<p>&nbsp;</p>';
        echo show_validation_errors();
    }?>

    <div class="row">
        <div class="col-sm-12">
            <br>
            <h2>CHECKOUT</h2>
            <div class="panel-group checkout-tabs" id="accordion" role="tablist" aria-multiselectable="false">
                <?php
                $i = 0;
                foreach ($checkout_tabs as $tab_file => $title) { $i++;
                    if($tab_file != 'checkout_method' && $i < 3){
                        echo '<form id="form-validate" class="checkout-form" method="post" action="'.site_url('cart/confirm').'">';
                    }
                    ?>
                    <div class="panel panel-default <?php echo 'panel-' . $tab_file . ' ' . ($tab_file == 'shipping_info' ? 'skip' : '');?>">
                        <div class="panel-heading" role="tab" id="headingOne">
                            <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#<?php echo $tab_file;?>" aria-expanded="<?php echo ($i == (!$customer_login ? 1 : 2) ? 'true' : 'false');?>" aria-controls="<?php echo $tab_file;?>">
                                    <i class="icon icon-checkmark-circle" style="<?php echo ($tab_file == 'checkout_method' && $customer_login ? 'color: rgb(247, 148, 29);': '')?>;">&nbsp;<?php /*echo $i;*/?></i> <?php echo $title;?>
                                </a>
                            </h4>
                        </div>
                        <div id="<?php echo $tab_file;?>" class="panel-collapse collapse <?php echo (($i == (!$customer_login ? 1 : 2)) ? 'in' :'');?>" role="tabpanel" aria-labelledby="<?php echo $tab_file;?>">
                            <div class="panel-body">
                                <?php include('tabs/' . $tab_file . '.php');?>
                            </div>
                        </div>
                    </div>
                    <?
                }
                ?>
                </form>
            </div>
        </div>
        <!--<div class="col-sm-3">
            <h3>YOUR CHECKOUT PROGRESS</h3>
            <?php
            /*foreach ($checkout_tabs as $tab_file => $title) {
                if($tab_file != 'checkout_method'){
                    echo '<p>'.$title.'</p>';
                }
            }
            */?>
        </div>-->
    </div>
</div>
</div>
<?php echo get_footer(); ?>
<script>
    (function ($) {
        $(document).ready(function () {
            $(".panel-order_review").hide();
            var validator = $("#form-validate").validate();

            $(document).on('click', '.btn-continue', function (e) {
                e.preventDefault();
                var _panel = $(this).parents('.panel');
                _panel.find("label.error").remove();


                copy_past_fields();
                var valid = true;
                var $inputs = _panel.find("input,textarea,select");

                $inputs.each(function() {
                    if (!validator.element(this) && valid) {
                        valid = false;
                    }
                });

                if (valid)
                {
                    _panel.find('.panel-collapse').collapse('hide').hide();
                    _panel.find('.icon-checkmark-circle').css({color:'#f7941d'});

                    var next_panel = _panel.next();

                    if(next_panel.hasClass('validate')){
                        next_panel = next_panel.find('.panel:eq(0)');
                    }
                    if(next_panel.hasClass('skip')){
                        next_panel = next_panel.next();
                    }

                    next_panel.find('.panel-heading [role=tabpanel]').attr('aria-expanded', true);
                    next_panel.find('.panel-collapse').collapse('show').show();
                }
            });

            $(document).on('click', '.btn-guest-continue', function (e) {
                e.preventDefault();
                var _panel = $(this).parents('.panel');
                _panel.find("label.error").remove();


                copy_past_fields();
                _panel.find('.panel-collapse').collapse('hide').hide();
                _panel.find('.icon-checkmark-circle').css({color:'#f7941d'});

                var next_panel = _panel.next();

                if(next_panel.hasClass('validate')){
                    next_panel = next_panel.find('.panel:eq(0)');
                }
                if(next_panel.hasClass('skip')){
                    next_panel = next_panel.next();
                }

                next_panel.find('.panel-heading [role=tabpanel]').attr('aria-expanded', true);
                next_panel.find('.panel-collapse').collapse('show').show();
            });

            $('#accordion').on('show.bs.collapse', function (e) {
                var _target = e.target;
                var button = $(_target).parents('.panel').find('.panel-heading [role=button]');
                if(button.attr('aria-expanded') != 'true'){
                    e.preventDefault();
                }
            });

            $(document).on('click', 'input[name=checkout_method]', function () {
                var checkout_method = $(this).val();
                if(checkout_method == 'guest'){
                    $('div#billing_info').find('#billing_password').parent().parent().addClass('hide').find('input').attr('disabled', true);
                }else{
                    $('div#billing_info').find('#billing_password').parent().parent().removeClass('hide').find('input').attr('disabled', false);
                }

                $('.checkout-form #_checkout_method').remove();
                $('.checkout-form').append('<input type="hidden" name="checkout_method" id="_checkout_method" value="'+checkout_method+'">');
            });

            $(document).on('click', 'input[name=use_for_shipping]', function () {
                var use_for_shipping = $(this).val();
                if(use_for_shipping == 1){
                    $('div.panel-shipping_info').addClass('skip');
                    copy_billig();
                }else{
                    $('div.panel-shipping_info').removeClass('skip');
                }
            });

            function copy_billig(){
                var billing = $('div.panel-billing_info');
                var shipping = $('div.panel-shipping_info');

                billing.find('input,select,textarea').each(function (index) {
                    var _id = $(this).attr('id').replace('billing', 'shipping');
                    var val = $(this).val();

                    if(shipping.find('#' + _id)){
                        shipping.find('#' + _id).val(val)
                    }
                });
            }

            $(document).on('keyup', '[id^=copy-]', function () {
                var past_id = $(this).attr('id').replace('copy-', '');
                $('#' + past_id).val($(this).val());
            });

            function copy_past_fields(){
                $('[id^=copy-]').each(function(){
                    var past_id = $(this).attr('id').replace('copy-', '');
                    $('#' + past_id).val($(this).val());
                });
            }

        });
    })(jQuery)
</script>