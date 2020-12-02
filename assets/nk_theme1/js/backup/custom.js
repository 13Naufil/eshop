(function ($) {
    $(document).ready(function () {
        var sourceSwap = function () {
            var $this = $(this);
            var newSource = $this.data('alt-src');
            $this.data('alt-src', $this.attr('src'));
            $this.attr('src', newSource);
        }

        $(function () {
            $('img.xyz').hover(sourceSwap, sourceSwap);
        });

        $(".highlights-list li,.equal-h").matchHeight(), e("[data-eq-height]").each(function (i) {
            $("[data-eq-height=" + $(this).data("eq-height") + "]").matchHeight()
        })
    });
})(jQuery)
