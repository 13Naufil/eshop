function popupwindow(e, i, t, s) {
    var o = screen.width / 2 - t / 2, l = screen.height / 2 - s / 2;
    return window.open(e, i, "toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width=" + t + ", height=" + s + ", top=" + l + ", left=" + o)
}

(function ($) {
    $(document).ready(function () {
        /*if ($('.sticky-bar').length > 0) {
            $('.sticky-bar').affix({offset: {top: $('.sticky-bar').offset().top}});
        }*/

        var sourceSwap = function () {
            var $this = $(this);
            var newSource = $this.data('alt-src');
            $this.data('alt-src', $this.attr('src'));
            $this.attr('src', newSource);
        };

        $('img.xyz').hover(sourceSwap, sourceSwap);

        $('.rating-types').each(function (index) { /*var _id = $(this).attr('id');*/
            var score = $(this).data('score');
            var readonly = $(this).data('readonly');
            var scoreField = $(this).data('field');
            /*$(this).raty({
                score: score,
                readOnly: readonly,
                starHalf: template_url + 'assets/img/red-line.png',
                starOff: template_url + 'assets/img/gray-line.png',
                starOn: template_url + 'assets/img/red-line.png',
                scoreName: scoreField/!* click: function(score, evt) { }*!/
            });*/
        });

        $(".validate").validationEngine();
        $('.main-banner').slick({
            autoplay: true,
            infinite: true,
            slidesToShow: 1,
            /*adaptiveHeight: true*/
        });


        $(".lightbox").fancybox({
            padding: 1,
            'transitionIn': 'elastic',
            'transitionOut': 'elastic',
            'speedIn': 600,
            'speedOut': 200,
            'overlayShow': false

        });

        $(".highlights-list li,.equal-h").matchHeight();
        $("[data-eq-height]").each(function (i) {
            $("[data-eq-height=" + $(this).data("eq-height") + "]").matchHeight()
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


        /*$('.gallery-main').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: true,
            fade: true,
            asNavFor: '.images-slider'
        });
        $('.images-slider').slick({
            slidesToShow: 3,
            slidesToScroll: 1,
            asNavFor: '.gallery-main',
            dots: false,
            centerMode: true,
            focusOnSelect: true
        });*/



        var isFlickity = false;
        var gallery_main;
        var gallery_nav;
        //var is_color_opt = ($('.add-to-cart .color-box').length > 0 ? true : false);
        var is_color_opt = ($('.add-to-cart .color-select').length > 0 ? true : false);
        if(is_color_opt) {
            $('#img-box-clone').hide(0).append($('#img-overview .gallery-main,#img-overview .gallery-nav').clone());
            var img_box_clone = $('#img-box-clone');
        }
        //$(document).on('change', '.add-to-cart .color-box input', function () {
        $(document).on('change', '.add-to-cart .color-select', function () {
            //console.log('color-select');

            //var color_id = $(this).val();
            var color_id = $('option:selected',this).data('id');

            if (isFlickity) {
                $('#img-overview .gallery-main').flickity('destroy');
                $('#img-overview .gallery-nav').flickity('destroy');
            }
            isFlickity = true;
            $('#img-overview .gallery-main,#img-overview .gallery-nav').html('');

            if(img_box_clone.find('.gallery-cell[img-color-id="'+color_id+'"]').length == 0){
                color_id = 0;
            }
            //console.log(color_id);
            img_box_clone.find('.gallery-cell[img-color-id="'+color_id+'"]').clone().show(0).appendTo('#img-overview .gallery-main');
            img_box_clone.find('.img-box[img-color-id-sm="'+color_id+'"]').clone().show(0).appendTo('#img-overview .gallery-nav');
            //console.log($('#img-overview .gallery-main'));


            $('#img-overview .gallery-main').flickity({
                pageDots: false,
                setGallerySize: false
            });
            $('#img-overview .gallery-nav').flickity({
                asNavFor: '#overview .gallery-main',
                contain: true,
                pageDots: false
            });
        });


        if(is_color_opt){
            //$('.add-to-cart .color-box input:checked').trigger('change');
            $('.add-to-cart .color-select').trigger('change');
        }else{
            $('#overview .gallery-main').flickity({
                pageDots: false,
                setGallerySize: false

            });
            $('#overview .gallery-nav').flickity({
                asNavFor: '#overview .gallery-main',
                contain: true,
                pageDots: false
            });
        }


        if(is_color_opt) {
            var destroy = Flickity.prototype.destroy;
            Flickity.prototype.destroy = function () {
                destroy.call(this);
                if (jQuery && this.$element) {
                    jQuery.removeData(this.element, 'flickity');
                }
            };
        }
        $('.f_brands .carousel').flickity({
            pageDots: false,
            contain: true,
            autoPlay: true,
            wrapAround: true
        });

        $(document).on('click', '[data-href]', function () {
            var href = $(this).data('href');
            window.location = href;
        })

        $(".styled, .multiselect-container input").uniform({
            radioClass: "choice",
            selectAutoWidth: !1
        });
        
        $(document).on("change", ".product-filter-form .attribute", function () {
            $(".product-filter-form").submit()
        })
    });
})(jQuery);

