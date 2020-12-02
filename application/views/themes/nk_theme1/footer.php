<footer class="site-footer" role="contentinfo">
    <div class="container">
        <div class="footer-top">
            <div class="row">

                <div id="footer_newsletter" class="col-sm-12 col-xs-12 text-center">
                    <img src="<?php echo media_url('img/horn64d2.png');?>" alt="Emerce">
                    <section class="newsletter">
                        <div class="block-title">
                            <h3>
                                <span>Join our newsletter</span>
                            </h3>
                        </div>
                        <div class="block-content">
                            <form action="<?php echo site_url('customer/subscriber')?>" method="post" class="input-group">
                                <input type="email" name="email" placeholder="Enter your email address" class="input-group-field" aria-label="Email Address">
                                <span class="input-group-btn">
                                    <button type="submit" class="btn" name="subscribe"><i class="newsletter_icon"></i></button>
                                </span>
                            </form>
                        </div>
                    </section>
                </div>

                <div class="col-sm-12 col-xs-12 footer_menu">
                    <ul>
                        <?php
                        $menu_config = array(
                            'parent_li_start' => '<li id="menu-{id}" class="menu-item-{id}  menu-type-{menu_type} {active_class}"><a href="{href}">{title} <span class="xicon icon-angle-down"></span></a>',
                        );
                        echo get_nav(4, $menu_config); ?>
                    </ul>
                </div>

                <div class="col-sm-12 col-xs-12 social_menu">
                    <?php
                    $block = $this->cms->get_block('footer-social-icons', true);
                    if($block->id > 0){
                        echo $block->content;
                    } ?>
                </div>


            </div>
        </div>
    </div>
    <div class="footer-bottom  wow fadeInUp" data-wow-delay="500ms">
        <?php
        $block = $this->cms->get_block('footer-bottom', true);
        if($block->id > 0){
            echo $block->content;
        } ?>
    </div>
</footer>
</div>

<!--[if lt IE 9]>
<script src="<?php echo media_url('js/html5shiv.min.js') ; ?>"></script>
<script src="<?php echo media_url('respond.min.js') ; ?>"></script>
<![endif]-->

<script src="<?php echo media_url('js/bootstrap.min.js');?>" type="text/javascript"></script>
<script src="<?php echo media_url('js/selection.js');?>" type="text/javascript"></script>
<script src="<?php echo media_url('js/function.js');?>" type="text/javascript"></script>
<script src="<?php echo media_url('js/owl.carousel.min.js');?>" type="text/javascript"></script>
<script src="<?php echo media_url('js/jquery.jcarousel.latest.min.js');?>" type="text/javascript"></script>
<script src="<?php echo media_url('js/jcarousellite.min.js');?>" type="text/javascript"></script>
<script src="<?php echo media_url('js/jquery.elevateZoom-3.0.8.min.js');?>" type="text/javascript"></script>

<script src="<?php echo media_url('js/jquery.fancybox.pack.js');?>" type="text/javascript"></script>
<script src="<?php echo media_url('js/jquery.fakecrop.js');?>" type="text/javascript"></script>
<script src="<?php echo media_url('js/jquery.countdown.min.js');?>" type="text/javascript"></script>
<script src="<?php echo media_url('js/modernizr.custom.js');?>" type="text/javascript"></script>
<script src="<?php echo media_url('js/classie.js');?>" type="text/javascript"></script>
<script src="<?php echo media_url('js/wow.min.js');?>" type="text/javascript"></script>
<script src="<?php echo media_url('js/slick.js');?>" type="text/javascript"></script>
<script src="<?php echo media_url('js/validation/jquery.validate.js');?>" type="text/javascript"></script>

<?php echo get_option('google_analytics_js'); ?>
  <?php
                                include "includes/quick_buy.php";
                                ?>
<script>

    $(document).ready(function () {



        $('.main-slider').slick({
            dots: false,
            infinite: true,
            speed: 300,
            arrows:true,
            slidesToShow: 1,
            adaptiveHeight: true,
            autoplay: true,
            autoplaySpeed: 2000,
        });


        $('.rght-slider').slick({
            dots: false,
            infinite: true,
            arrows:true,
            speed: 300,
            slidesToShow: 1,
            adaptiveHeight: true,
            autoplay: true,
            autoplaySpeed: 3000,
        });

        $('.lft-slider').slick({
            dots: false,
            infinite: true,
            arrows:true,
            speed: 300,
            slidesToShow: 1,
            adaptiveHeight: true,
            autoplay: true,
            autoplaySpeed: 3000,
        });

        $('.pro-slider').slick({
            dots: true,
            infinite: true,
            speed: 300,
            slidesToShow: 4,
            slidesToScroll: 4,
            responsive: [
                {
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 3,
                        infinite: true,
                        dots: true
                    }
                },
                {
                    breakpoint: 600,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                }
                // You can unslick at a given breakpoint now by adding:
                // settings: "unslick"
                // instead of a settings object
            ]
        });

    });
</script>


<script>
    $(".applogo").html("");
    var heightHeader = jQuery('.site-header').outerHeight() - jQuery('.nav-bar').outerHeight();
    var heightTop = jQuery('.site-header').outerHeight();

    jQuery(window).scroll(function() {
        if (jQuery(".visible-phone").is(":hidden")) {
            var scrollTop = jQuery(this).scrollTop();
            var w = window.innerWidth;
            if (scrollTop > heightHeader) {
                if (w > 767) {
                    jQuery('.header-bottom').addClass('on');
                    jQuery('.nav-search').removeClass('on');
                    jQuery('.main-content').css('padding-top', heightHeader);
                    jQuery('.toolbar').addClass('sticky');
                    jQuery('.toolbar').addClass('container');
                    jQuery('.toolbar').removeClass('unsticky');
                } else {
                    jQuery('.header-bottom').removeClass('on');
                    jQuery('.nav-search').addClass('on');
                    jQuery('.main-content').css('padding-top', 0);
                    jQuery('.toolbar').removeClass('sticky');
                    jQuery('.toolbar').removeClass('container');
                    jQuery('.toolbar').addClass('unsticky');
                }
            } else {
                jQuery('.header-bottom').removeClass('on');
                jQuery('.nav-search').addClass('on');
                jQuery('.main-content').css('padding-top', 0);
                jQuery('.toolbar').removeClass('sticky');
                jQuery('.toolbar').removeClass('container');
                jQuery('.toolbar').addClass('unsticky');
            }
        }
    });
</script>
<div class="newsletterwrapper">
    <div id="email-modal">
        <div class="modal-overlay"></div>
        <div class="modal-window">
            <div class="window-window">
                <div class="window-content">
                    <a class="btn close" title="Close"">Close</a>
                    <div class="left">
                        <h1 class="title">Join Our Mailing List </h1>
                        <p class="sub-title"></p>
                        <div id="mailchimp-email-subscibe">
                            <div id="mc_embed_signup">
                                <form action="" method="post" name="mc-embedded-subscribe-form" target="_blank" class="input-group">
                                    <input type="email" value="" placeholder="Enter your email address" name="EMAIL" class="input-group-field" aria-label="Email Address">
                                    <span class="input-group-btn">
                                                <button type="submit" class="btn popup" name="subscribe">
                                                Subscribe
                                                </button>
                                        <!--     < input  value=" Subscribe"  >  -->
                                             </span>
                                </form>
                            </div>
                        </div>
                        <h2 class="message">Be the first to know about our new arrivals, exclusive offers and the latest fashion updates.</h2>
                        <div class="icon-social">
                            <ul>
                                <li class="social-1"><a title="FaceBook" href="javascript:;">FaceBook</a></li>
                                <li class="social-6"><a title="Instagram" href="javascript:;">Instagram</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="right">
                        <img src="<?php echo media_url('img/bg_newsletter.jpg')?>" alt="" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="back-top" style="display: none;"><a class="nav_up" href="#top">Back to top</a></div>
</div>

<!-- Modal -->

<script type="text/javascript">
    $(function() {
        setTimeout(function() {

            if ($(window).width() > 767) {
                $(".default .carousel").jCarouselLite({
                    btnNext: ".default .next",
                    btnPrev: ".default .prev",
                    visible: 5,
                    circular: false,
                    vertical: true,
                    responsive: true
                });
            } else {
                $(".default .carousel").jCarouselLite({
                    btnNext: ".default .next",
                    btnPrev: ".default .prev",
                    visible: 3,
                    circular: false,
                    vertical: true,
                    responsive: true
                });
                $("#mobileSearch").click(function() {
                    $('.header-panel-top .nav-search').toggle();
                });
            }

        }, 3000);
        $(".header-bottom .top-cart").click(function(){
            $("#dropdown-cart").toggle();
        });
        $(".icon-search").click(function(){
            $(".search-bar").toggle();
            $(".icon-search").toggleClass("x");
        });

$(".dropdown-toggle").click(function(){
	urls=$(this).attr('href');
	str=urls.includes("#")

	if(str==false && urls!=""){
	window.location.replace(urls);
	}

});
$('ul #sub-menu-menu li a').each(function(){
	if($(this).attr("href")=='javascript:void(0)'){ 
	<!--console.log(window.getComputedStyle(this,':before').content);-->
	$(this).addClass("plussign");
	}
 });


    });
    
    
</script>
<style>
#return-to-top {
  position: fixed;
  z-index:1000;
  bottom: 20px;
  right: 20px;
  background: #25D366;
  background: #25D366;
  width: 50px;
  height: 50px;
  display: block!important;
  text-decoration: none;
  -webkit-border-radius: 35px;
  -moz-border-radius: 35px;
  border-radius: 35px;
  display: none;
  -webkit-transition: all 0.3s linear;
  -moz-transition: all 0.3s ease;
  -ms-transition: all 0.3s ease;
  -o-transition: all 0.3s ease;
  transition: all 0.3s ease;
}
#return-to-top i {
  color: #fff;
  margin: 0;
  position: relative;
  left: 16px;
  top: 13px;
  font-size: 24px;
  -webkit-transition: all 0.3s ease;
  -moz-transition: all 0.3s ease;
  -ms-transition: all 0.3s ease;
  -o-transition: all 0.3s ease;
  transition: all 0.3s ease;
}

</style>
<a href="https://wa.me/923000704252?text=I'm%20interested%20in%20your%20Product%20for%20sale" id="return-to-top"><i class="fa fa-whatsapp"></i></a>

</body>
</html>