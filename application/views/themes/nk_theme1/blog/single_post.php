<?php get_header(); ?>
<link href="<?php echo media_url('css/blog.css'); ?>" rel="stylesheet">
<?php include __DIR__ . "/categories_menu.php"; ?>

    <div class="main-container">
        <div class="container">


                    <div class="row single-post">
                        <div class="col-lg-8">
                            <h2 class="with-breaker animate-me fadeInUp">
                                <?php echo $post->title;?>
                            </h2>
                            <ul class="post-metadatas center">
                                <li><i class="fa fa-clock-o"></i> <?php echo date('M d,Y', strtotime($post->datetime)); ?></li>
                                <!--<li><i class="fa fa-comments-o"></i> <a href="">4 comments</a></li>-->
                                <?php if(!empty($post->categories)) { ?><li><i class="fa fa-thumb-tack"></i><?php echo $post->categories; ?></li><?php } ?>
                                <?php if(!empty($post->tags)) { ?><li><i class="fa fa-tags"></i><?php echo $post->tags; ?></li><?php } ?>
                            </ul>
                            <?php if(file_exists('assets/front/blog_imgs/' . $post->featured_image)) { ?>
                                <div class="flexslider image-slider">
                                    <ul class="slides">
                                        <li><a href="<?php echo base_url('assets/front/blog_imgs/' . $post->featured_image);?>" class="fancybox"><img src="<?php echo base_url('assets/front/blog_imgs/' . $post->featured_image);?>" alt="<?php echo $post->title; ?>" class="img-responsive"></a></li>
                                    </ul>
                                </div>
                            <?php } ?>
                            <!--POST DETAILS -->
                            <div class="blog-content">
                                <?php echo do_shortcode($post->content);?>
                            </div>
                            <hr>
                            <!--SHARE BUTTONS -->

                        </div>
                        <div class="col-sm-4 sidebar">
                            <?php $block = $this->cms->get_block('blog-right', true);
                            if($block->id > 0){
                            ?>
                            <div class="widget widget_text"><h3 class="widget-title"><?php echo $block->block_title;?></h3>
                                <div class="textwidget"><p style="text-align: center;">
                                    <?php echo $block->content;?>
                                </div>
                            </div>
                            <?php } ?>
                            <div class="widget widget_text"><h3 class="widget-title">Share</h3>
                                <div class="textwidget">
                                    <ul class="share-buttons animate-me fadeInUp">
                                        <script>function fbs_click() {u=location.href;t=document.title;window.open('http://www.facebook.com/sharer.php?u='+encodeURIComponent(u)+'&t='+encodeURIComponent(t),'sharer','toolbar=0,status=0,width=626,height=436'); return false;}</script>
                                        <li><a rel="nofollow" href="http://www.facebook.com/share.php?u=<?php echo current_url();?>" onclick="return fbs_click()" target="_blank" class="btn btn-default button-facebook" ><i class="fa fa-facebook"></i> Share it</a></li>
                                        <li><a href="http://twitter.com/home/?status=<?php echo current_url();?>" target="_blank" class="btn btn-default button-twitter"><i class="fa fa-twitter"></i> Tweet it</a></li>
                                    </ul>
                                    <br>
                                </div>
                            </div>
                            <br>

                            <div class="widget widget_text">
                                <!--<h3 class="widget-title">Share</h3>-->
                                <div class="textwidget">

                                    <div>

                                        <!-- Nav tabs -->
                                        <ul class="nav nav-tabs" role="tablist">
                                            <li role="presentation" class="active"><a href="#Recent" aria-controls="Recent" role="tab" data-toggle="tab">Recent</a></li>
                                            <li role="presentation"><a href="#Popular" aria-controls="Popular" role="tab" data-toggle="tab">Popular</a></li>
                                            <li role="presentation"><a href="#Must-Read" aria-controls="Must-Read" role="tab" data-toggle="tab">Must-Read</a></li>
                                        </ul>

                                        <!-- Tab panes -->
                                        <div class="tab-content">
                                            <div role="tabpanel" class="tab-pane active" id="Recent">
                                                <ul class="none-list">
                                                    <?php
                                                    if (count($recent) > 0) {
                                                        foreach ($recent as $r_post) {
                                                            ?>
                                                            <li>
                                                                <div class="row">
                                                                    <div class="col-xs-3">
                                                                        <a href="<?php echo site_url('blog/' . ($r_post->category_slug) . '/' . ($r_post->slug)); ?>">
                                                                            <img src="<?php echo _img('assets/front/blog_imgs/' . $r_post->featured_image, 50,50);?>" alt="<?php echo $r_post->title;?>" align="left" class="img-responsive">
                                                                        </a>
                                                                    </div>
                                                                    <div class="col-xs-9">
                                                                        <p><a href="<?php echo site_url('blog/' . ($r_post->category_slug) . '/' . ($r_post->slug)); ?>"><?php echo $r_post->title;?></a></p>
                                                                        <small><i class="fa fa-clock-o"></i> <?php echo date('M d,Y', strtotime($r_post->datetime)); ?></small>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                            <?php
                                                        }
                                                    }
                                                    ?>

                                                </ul>
                                            </div>
                                            <div role="tabpanel" class="tab-pane" id="Popular">
                                                <ul class="none-list">
                                                <?php
                                                if (count($Popular) > 0) {
                                                    foreach ($Popular as $r_post) {
                                                        ?>
                                                        <li>
                                                            <div class="row">
                                                                <div class="col-xs-3">
                                                                    <a href="<?php echo site_url('blog/' . ($r_post->category_slug) . '/' . ($r_post->slug)); ?>">
                                                                    <img src="<?php echo _img('assets/front/blog_imgs/' . $r_post->featured_image, 50,50);?>" alt="<?php echo $r_post->title;?>" align="left" class="img-responsive">
                                                                    </a>
                                                                </div>
                                                                <div class="col-xs-9">
                                                                    <p><a href="<?php echo site_url('blog/' . ($r_post->category_slug) . '/' . ($r_post->slug)); ?>"><?php echo $r_post->title;?></a></p>
                                                                    <small><i class="fa fa-clock-o"></i> <?php echo date('M d,Y', strtotime($r_post->datetime)); ?></small>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                                </ul>
                                            </div>
                                            <div role="tabpanel" class="tab-pane" id="Must-Read">
                                                <?php echo $this->cms->get_block('blog-Must-Read');?>
                                            </div>
                                        </div>

                                    </div>

                                    <br>
                                </div>
                            </div>
                            <br>


                        </div>
                        <!--POST CONTENT -->

                    </div>


            <!--<hr>
            <div class="blog-post-naviagation center animate-me fadeInUp">
                <a href="#" class="btn btn-default"><i class="fa fa-hand-o-left"></i> Previous Post</a>
                <a href="#" class="btn btn-default"><i class="fa fa-hand-o-right"></i> Next Post</a>
            </div>-->
        </div>
        <!-- COMMENTS CONTAINER -->
        <?php //include "comments.php";?>

    </div>
<?php get_footer(); ?>