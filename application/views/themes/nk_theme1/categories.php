<?php get_header(); ?>

    <div class="bg-container">
        <div class="page-content container">
            <!--breadcrumb-sort-block-->
            <div class="row breadcrumb-sort-block ">
                <!-- Breadcrumbs line -->
                <div class="col-sm-6  breadcrumb-line">
                    <?php
                    include dirname(__FILE__) . "/includes/breadcrumb.php";
                    ?>
                </div>
                <!-- /breadcrumbs line -->
                <div class="col-sm-6 pull-right text-right">
                    <ul class="breadcrumb">
                        <li><a href="javascript: window.history.back();"><&nbsp;&nbsp;Return to Previous Page</a></li>
                    </ul>
                </div>
            </div>
            <!--breadcrumb-sort-block-->

            <div class="welcome-bar for-category">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="top-category-box">
                            <h2 class="welcome-msg">
                                <span class="brand-title"><?php echo $brand->title; ?></span>&nbsp;
                                <span class="category-title"><?php echo $category->title; ?></span>
                            </h2>
                            <?php
                            if (strip_tags($category->description) != '') {
                                echo '<p>' . substr(strip_tags(stripslashes($category->description)), 0, 100) . '</p>';
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>

            <!--category-block-->

            <div class="row listing-row">
                <div class="col-sm-12">
                    <p>&nbsp;</p>
                    <!--product-listing-block-->
                    <?php
                    if (count($sub_categories) > 0) {
                        ?>
                        <div class="product-listing-block">
                            <?php
                            foreach ($sub_categories as $sub_category) {
                                $sub_category = array2object($sub_category);
                                ?>
                                <div class="col-sm-3 col-xs-6 box-border">
                                    <div class="box category-box text-center">
                                        <div class="product-img">
                                            <a href="<?php echo site_url($parent_url . $sub_category->friendly_url . get_option('url_ext')); ?>">
                                                <img width="230"
                                                     src="<?php echo _img('assets/admin/img/' . $sub_category->thumb, 230); ?>"
                                                     alt="<?php echo $sub_category->title; ?>"/>
                                            </a>
                                        </div>

                                        <div class="product-desc">
                                            <a href="<?php echo site_url($parent_url . $sub_category->friendly_url . get_option('url_ext')); ?>">
                                                <h3><?php echo $sub_category->title; ?></h3></a>
                                            <?php
                                            if (!empty($sub_category->description)) {
                                                echo '<p> ' . substr(strip_tags(stripslashes($sub_category->description)), 0, 100) . '</p>';
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>

                        </div>
                    <?php } ?>
                    <!--product-listing-block-->
                </div>
            </div>
            <div class="clearfix"></div>
            <p class="widget-space">&nbsp;</p>

        </div>

    </div>


<?php get_footer(); ?>