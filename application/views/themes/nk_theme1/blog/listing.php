<?php get_header(); ?>
    <link href="<?php echo media_url('css/blog.css'); ?>" rel="stylesheet">

<?php
include __DIR__ . "/categories_menu.php"; ?>

    <div class="main-container">
        <div class="container">
            <!--BLOG -->
            <div class="row">
                <div class="col-sm-12">
                    <h2 class="with-breaker animate-me fadeInUp"><?php echo $page->title; ?>
                        <?php if (!empty($page->tagline)) {
                            echo "<span>{$page->tagline}</span>";
                        } ?>
                    </h2>

                    <div class="blog-grid row">
                        <!-- BLOG POST -->
                        <?php
                        if (count($posts) > 0) {
                            foreach ($posts as $post) {
                                ?>
                                <div class="col-sm-4 col-xs-12">
                                    <div class="blog-post" data-eq-height="post">
                                        <?php if(file_exists('assets/front/blog_imgs/' . $post->featured_image)) { ?>
                                            <div class="blog-thumbnail">
                                                <a href="<?php echo site_url('blog/' . ($post->category_slug) . '/' . ($post->slug)); ?>">
                                                    <img src="<?php echo _img('assets/front/blog_imgs/' . $post->featured_image,600, 450); ?>" alt="<?php echo $post->title; ?>" class="img-responsive">
                                                </a>
                                            </div>
                                        <?php } ?>
                                        <div class="blog-content">
                                            <a href="<?php echo site_url('blog/' . ($post->category_slug) . '/' . ($post->slug)); ?>"
                                               class="blog-post-title">
                                                <h2><?php echo $post->title; ?></h2>
                                            </a>
                                            <ul class="post-metadatas list-inline">
                                                <li>
                                                    <i class="fa fa-clock-o"></i> <?php echo date('M d,Y', strtotime($post->datetime)); ?>
                                                </li>
                                                <li><i class="fa fa-thumb-tack"></i>
                                                    <?php echo $post->categories; ?>
                                                </li>
                                                <li><i class="fa fa-tags"></i><?php echo $post->tags; ?></li>
                                            </ul>
                                            <p>&nbsp;</p>
                                            <!--<p class="blog-sum-up"><?php /*echo substr(strip_tags($post->content), 0, 300); */?>...</p>
                                            <div class="blog-button">
                                                <a href="<?php /*echo site_url('blog/' . ($post->category_slug) . '/' . ($post->slug)); */?>"
                                                   class="btn btn-success"><i class="fa fa-arrow-right"></i> Read More</a>
                                            </div>-->
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                        }
                        ?>
                    </div>
                    <div class="blog-next-page center animate-me zoomIn">
                        <?php echo $pagination_links;?>
                        <!--<a href="blog.html" class="btn btn-default"><i class="fa fa-hand-o-right"></i> Next Page</a>-->
                    </div>

                </div>

               <!-- <div class="col-sm-3">
                    <?php /*include "blog_right.php";*/?>
                </div>-->

            </div>
        </div>
    </div>


<?php get_footer(); ?>
