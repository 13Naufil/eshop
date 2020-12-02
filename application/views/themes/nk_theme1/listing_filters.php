<div class="toolbar unsticky">
    <div class="filter-sortby btn-group">
        <form action="" method="get" class="product-filter-form">
        <?php
        $filters = getVar('filter', true, false);
        if (count($filtering_attributes) > 0) { ?>
        <div class="col-xs-4 cstm_filter_box">
            <label class="filter_btn">Filter Products</label>
            <div class="col-xs-3 sidebar collection-sidebar">

                <div class="sidebar-block">

                    <?php foreach ($filtering_attributes as $k => $listing_attr) { ?>
                    <div class="sidebar-custom sidebar-tag size">

                        <div class="widget-title ct-<?php echo $k + 1; ?>">
                            <h3>
                                <span><?php echo $listing_attr[0]->attr_label; ?> </span>
                            </h3>
                        </div>
                        <div class="widget-content s-ct-<?php echo $k + 1; ?>">
                            <?php if (count($listing_attr) > 0) {?>
                            <ul>
                                <?php foreach ($listing_attr as $attr_val) { ?>
                                <li>
                                    <input type="checkbox" class="attribute styled" name="filter['<?php echo $attr_val->type; ?>']['<?php echo $attr_val->id; ?>'][]" value="<?php echo $search_val._checkbox($filters[$attr_val->type][$attr_val->id],$attr_val->attr_value); ?>" />
                                    <label><?php echo $attr_val->attr_value; ?></label>
                                </li>
                                <?php } ?>
                            </ul>
                            <?php } ?>
                        </div>
                    </div>

                    <?php } ?>

                </div>
                <div class="refined-widgets">
                    <a href="javascript:void(0)" class="clear-all" style="display:none" >
                        Clear All
                    </a>
                </div>
            </div>
        </div>
        <?php } ?>
        </form>
        <div class="col-xs-3 sortby-btn"><button class="btn">SORT BY</button>
            <ul class="sortby-menu" role="menu">

                <li class="active"><a href="javascript:;" >Date, new to old</a></li>
                <li><a href="javascript:;" >Featured</a></li>

                <li><a href="javascript:;" >Best Selling</a></li>
                <li><a href="javascript:;" >Price, low to high</a></li>
                <li><a href="javascript:;" >Price, high to low</a></li>

            </ul>
        </div>

        <div class="hide_sortby">
            <label for="sort-by"  >Sort by</label>
            <button class="btn btn-2 dropdown-toggle" data-toggle="dropdown">
                <i class="icon-exchange"></i>
                <span >Date, new to old</span>
                <i class="icon-chevron-down"></i>
            </button>

            <ul class="dropdown-menu" role="menu">
                <li class="active"><a href="javascript:;" >Date, new to old</a></li>
                <li><a href="javascript:;" >Featured</a></li>
                <li><a href="javascript:;" >Best Selling</a></li>
                <li><a href="javascript:;" >Price, low to high</a></li>
                <li><a href="javascript:;" >Price, high to low</a></li>

            </ul>
        </div>
    </div>
    <!--<a class="viewall_link" href="javascript:;">VIEW ALL</a>-->
</div>

<script>
    $(".cstm_filter_box label").click(function(){
        $(".sidebar").toggle();
        $(".sortby-menu").hide();
    });


    $(".ct-1 span").click(function(){
        $(".s-ct-1").toggle();
    });

    $(".ct-2 span").click(function(){
        $(".s-ct-2").toggle();
    });

    $(".ct-3 span").click(function(){
        $(".s-ct-3").toggle();
    });

    $(".ct-4 span").click(function(){
        $(".s-ct-4").toggle();
    });

    $(".sortby-btn button").click(function(){
        $(".sortby-menu").toggle();
    });

    $(".sortby-btn button").click(function(){
        $(".sidebar").hide();
    });

    $(".header-bottom .top-cart").click(function(){
        $("#dropdown-cart").toggle();
    });
    $(".icon-search").click(function(){
        $(".search-bar").toggle();
        $(".icon-search").toggleClass("x");
    });
    
    $(document).on('change', '.product-filter-form .attribute', function () {
        debugger;
        $('.product-filter-form').submit();
    });
</script>