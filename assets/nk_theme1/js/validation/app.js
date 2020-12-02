(function ($) {
        $(document).ready(function () {


            $('.index-deals-box').slick({
                dots: false,
                infinite: false,
                speed: 300,
                slidesToShow: 1,
                slidesToScroll: 1,
                autoplay: true
            });

            $('.deal-slider').slick({
                dots: false,
                infinite: false,
                autoplay: true,
                speed: 300,
                slidesToShow: 6,
                slidesToScroll: 1,
                responsive: [
                    {
                        breakpoint: 1024,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 1,
                            infinite: true,
                            dots: true
                        }
                    },
                    {
                        breakpoint: 600,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 1
                        }
                    },
                    {
                        breakpoint: 480,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1
                        }
                    }
                ]
            });

            $('.latest-product').slick({
                dots: false,
                infinite: false,
                autoplay: true,
                speed: 300,
                slidesToShow: 3,
                slidesToScroll: 1,
                responsive: [
                    {
                        breakpoint: 1024,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 2,
                            infinite: true,
                            dots: true
                        }
                    },
                    {
                        breakpoint: 480,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1
                        }
                    }
                ]
            });

            $('.related-products').slick({
                dots: false,
                infinite: false,
                autoplay: true,
                speed: 300,
                slidesToShow: 4,
                slidesToScroll: 1,
                responsive: [
                    {
                        breakpoint: 1024,
                        settings: {
                            slidesToShow: 3,
                            slidesToScroll: 1,
                            infinite: true,
                            dots: true
                        }
                    },
                    {
                        breakpoint: 600,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 1
                        }
                    },
                    {
                        breakpoint: 480,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1
                        }
                    }
                ]
            });

            $('.cat-menu-slider').slick({
                dots: false,
                infinite: false,
                variableWidth: true,
                adaptiveHeight: true,
                speed: 300,
                slidesToShow: 6,
                slidesToScroll: 1,
                responsive: [
                    {
                        breakpoint: 1024,
                        settings: {
                            slidesToShow: 4,
                            slidesToScroll: 1,
                            infinite: true,
                            dots: true
                        }
                    },
                    {
                        breakpoint: 600,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 1
                        }
                    },
                    {
                        breakpoint: 480,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1
                        }
                    }
                ]
            });

            /*$('.images-slider').slick({
                dots: false,
                appendArrows: false,
                prevArrows: $('.slick-prev'),
                nextArrows: $('.slick-next'),
                //centerMode: true,
                vertical: true,
                verticalSwiping: true,
                infinite: false,
                speed: 300,
                slidesToShow: 4,
                slidesToScroll: 1
            });*/

            $('.images-slider').slick({
                dots: false,
                infinite: false,
                speed: 300,
                slidesToShow: 4,
                slidesToScroll: 1,
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
                ]
            });


            $(".validate").validationEngine();

    //===== Fancy box (lightbox plugin) =====//

            $(".lightbox").fancybox({
                padding: 1,
                'transitionIn': 'elastic',
                'transitionOut': 'elastic',
                'speedIn': 600,
                'speedOut': 200,
                'overlayShow': false

            });


            /* # Select2 dropdowns
             ================================================== */


            //===== Datatable select =====//

            $(".dataTables_length select").select2({
                minimumResultsForSearch: "-1"
            });


            //===== Default select =====//

            $(".select").select2({
                minimumResultsForSearch: "-1",
                width: 200
            });


            //===== Liquid select =====//

            $(".select-liquid").select2({
                minimumResultsForSearch: "-1",
                width: "off"
            });


            //===== Full width select =====//

            $(".select-full").select2({
                minimumResultsForSearch: "-1",
                width: "100%"
            });


            //===== Select with filter input =====//

            $(".select-search").select2({
                width: '100%'
            });


            //===== Multiple select =====//

            $(".select-multiple").select2({
                width: "100%"
            });


            //===== Loading data select =====//

            $("#loading-data").select2({
                placeholder: "Enter at least 1 character",
                allowClear: true,
                minimumInputLength: 1,
                query: function (query) {
                    var data = {results: []}, i, j, s;
                    for (i = 1; i < 5; i++) {
                        s = "";
                        for (j = 0; j < i; j++) {
                            s = s + query.term;
                        }
                        data.results.push({id: query.term + i, text: s});
                    }
                    query.callback(data);
                }
            });


            //===== Select with maximum =====//

            $(".maximum-select").select2({
                maximumSelectionSize: 3,
                width: "100%"
            });


            //===== Allow clear results select =====//

            $(".clear-results").select2({
                placeholder: "Select a State",
                allowClear: true,
                width: 200
            });


            //===== Select with minimum =====//

            $(".minimum-select").select2({
                minimumInputLength: 2,
                width: 200
            });


            //===== Multiple select with minimum =====//

            $(".minimum-multiple-select").select2({
                minimumInputLength: 2,
                width: "100%"
            });


            //===== Disabled select =====//

            $(".select-disabled").select2(
                "enable", false
            );

            $(document).on('click', '.yamm .dropdown-menu', function (e) {
                e.stopPropagation();
            });

            $('.highlights-list li,.equal-h').matchHeight();

            $('[data-eq-height]').each(function (index) {
                $('[data-eq-height='+$(this).data('eq-height')+']').matchHeight()
            });

            $('.main-category > li > a.category-tab').hover(function () {
                var _id = $(this).attr('aria-controls');

                $('.tab-content .tab-pane, li.menu-main-category').removeClass('active');
                //$('.tab-content .tab-pane').removeClass('active');
                $(this).parent('li').addClass('active');
                $('.tab-content #' + _id).addClass('active');

            });

            $('#page-menu a').smoothScroll({afterScroll: function(e) {
                $('#page-menu li.active').removeClass('active');
                $(this).parent('li').addClass('active');
            }});

            $(".slides").flickity({cellAlign: "left", contain: true, prevNextButtons: false});

            $('.free-shipping-area img').addClass('animated bounceInLeft').css({
                '-webkit-animation-duration': '5s',
                '-webkit-animation-iteration-count': 'infinite',
                '-webkit-animation-timing-function': 'linear',
                '-webkit-animation-delay': '0s'
            });

            $('.panel-trigger').click(function(e){
                e.preventDefault();
                $(this).toggleClass('active');
            });

            $(".styled, .multiselect-container input").uniform({ radioClass: 'choice', selectAutoWidth: false });

            $(document).on('change', '.product-filter .attribute', function () {
                $('.product-filter-form').submit();
            });

        });
    })(jQuery)


    function popupwindow(url, title, w, h) {
      var left = (screen.width/2)-(w/2);
      var top = (screen.height/2)-(h/2);
      return window.open(url, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left);
    }

    $(function(){
        function onScrollInit( items, trigger ) {
            items.each( function() {

            var osElement = $(this),
                osAnimationClass = osElement.attr('data-animation'),
                osAnimationDelay = osElement.attr('data-animation-delay');

                osElement.css({
                    '-webkit-animation-delay':  osAnimationDelay,
                    '-moz-animation-delay':     osAnimationDelay,
                    'animation-delay':          osAnimationDelay
                });
                var osTrigger = ( trigger ) ? trigger : osElement;

                osTrigger.waypoint(function() {
                    osElement.addClass('animated').addClass(osAnimationClass).css('visibility', 'visible');
                    },{
                        triggerOnce: true,
                        offset: '100%'
                });
            });
        }
        onScrollInit( $('[data-animation]') );
        //onScrollInit( $('.staggered-animation'), $('.staggered-animation-container') );
    });//]]>

    function resizeBanner() {
        var body_h = $(window).height();
        var header_h = $('header').height();
        var header_mar = $('header').css('margin-top').replace('px', '');
        var margin = ($('.free-shipping-area').height());
        var total_h = (body_h - (header_h + parseFloat(header_mar) + parseFloat(margin)));
        var img_height = $('.banner-area img:eq(0)').height();
        /*if(img_height < total_h){
            total_h = img_height;
        }else{
            total_h = img_height;
        }*/
        console.log(total_h);
        $('.banner-area').height(total_h).css('line-height', (total_h) + 'px');
        $('.banner-area img').css({
                'height': (total_h) + 'px',
                'min-height': (total_h) + 'px',
        });
    }
    $(document).ready(function () {
        //resizeBanner();

        $(window).resize(function () {
            //resizeBanner();
        });
    });