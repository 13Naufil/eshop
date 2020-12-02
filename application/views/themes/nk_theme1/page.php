<?php get_header(); ?>

<div class="main" style="padding-top: 120px;">
<?php if(isset($page->show_title) && $page->show_title === '1') { ?>
    <div class="welcome-bar for-category">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <h2 class="welcome-msg"><?php echo $page->title; ?></h2>
                    <?php if (!empty($page->tagline)) {
                        echo "<p>{$page->tagline}</p>";
                    } ?>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<div class="page-content container">
    <div class="row">
        <div class="col-sm-12 page-post-content">

            <?php
            if(file_exists(ROOT . '/assets/front/uploads/' . $page->thumbnail) && !empty($page->thumbnail)){
                echo '<div class="col-sm-12"><img class="img-responsive" src="'.asset_url('front/uploads/' . $page->thumbnail).'"></div>';
            }
            echo do_shortcode(stripslashes($page->content)); ?>
        </div>
    </div>
</div>
</div>
<?php  get_footer(); ?>