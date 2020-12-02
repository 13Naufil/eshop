<?php get_header(); ?>


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

    <div class="page-content container">
        <div class="row">
            <div class="col-sm-12 page-post-content">
                <?php
                if ($page_row->layout == 'Web') {
                    ?>
                    <div class="container">
                        <div class="row-fluid">
                            <div class="col-sm-<?= (($right_panel) ? 8 : 12); ?>">
                                <div class="content">
                                    <? echo $content; ?>
                                </div>
                            </div>
                            <?php
                            if ($right_panel) {
                                echo '<div class="col-sm-4  visible-desktop">
                                        <div class="content">
                                            ' . (stripslashes(str_replace("../../../assets/editor_img/", "assets/editor_img/", $page_row->right_side_text))) . '
                                        </div>
                                    </div>';
                            }
                            ?>
                        </div>
                    </div>
                <?
                } else {
                    ?>
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-9">
                                <div class="content">
                                    <?php
                                    if (count($posts) > 0) {
                                        foreach ($posts as $post) {
                                            echo '<h3 class="color-1"><a class="blog_title" href="' . site_url('blog/'.($post->category_slug).'/'.($post->slug)) . '/">' . ($post->title) . '</a></h3>';
                                            if(!empty($post->featured_image) && $type == 'post'){
                                                echo '<div class="text-center with-padding">';
                                                echo '<img style="display: inline-block;" src="' . base_url('assets/front/blog_imgs/' . $post->featured_image) . '" class="img-responsive">';
                                                echo '</div>';
                                            }
                                            if(!empty($post->featured_image) && $type != 'post'){
                                            echo '<div class="row">';
                                            echo '<div class="col-sm-3">';
                                            echo '<img src="' . _img('assets/front/blog_imgs/' . $post->featured_image, 200) . '" class="img-responsive">';
                                            echo '</div>';
                                            echo '<div class="col-sm-9">';
                                            }else{
                                                echo '<div class="row">';
                                                echo '<div class="col-sm-12">';
                                            }
                                            echo '<p><span class="icon-calendar"></span> &nbsp;&nbsp;Posted on ' . date('M d,Y', strtotime($post->datetime)) . ' By Admin</p>';
                                            if($type == 'post'){
                                                echo do_shortcode(stripslashes($post->content));
                                            }else {
                                                echo '<p>' . do_shortcode(substr(strip_tags(stripslashes($post->content)), 0, 300)) . '... ';
                                                echo '<a class="" href="' . site_url('blog/' . ($post->category_slug) . '/' . ($post->slug)) . '/">Read More</a></p>';
                                            }
                                            //echo '<a class="btn btn-inovi" href="' . site_url('blog/'.($post->category_slug).'/'.($post->slug)) . '/">Read More</a>';
                                            echo '<br><br>';
                                            echo '</div>';
                                            echo '<div class="col-sm-12">';
                                            echo '<p><strong>Posted in</strong> <span class="icon-stack"></span> &nbsp;' . $post->categories . ' &nbsp;&nbsp;<span class="icon-tag"></span> &nbsp;<strong>Tagged</strong>' . $post->tags . '</p>';
                                            echo '<p><br/><hr/>';
                                            echo '</div>';
                                            echo '</div>';
                                        }
                                        echo $pagination_links;
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="col-sm-3 blog-right">
                                <div class="content">
                                    <?php
                                    if (count($categories) > 0) {
                                        echo '<ul>
                                <li><h2>Categories</h2>
                                <ul>';
                                        foreach ($categories as $cat) {
                                            echo '<li><a href="' . site_url('blog/category/' . $cat->slug) . '/">' . $cat->category . '</a></li>';
                                        }
                                        echo '</ul></li></ul>';
                                    }
                                    if (count($archives) > 0) {
                                        echo '<ul>
                                        <li><h2>Archives</h2>
                                        <ul>';
                                        foreach ($archives as $archive) {
                                            echo '<li><a href="' . site_url('blog/' . str_replace(' ', '/', $archive->link_archive)) . '/">' . $archive->archive . '</a></li>';
                                        }
                                        echo '</ul></li></ul>';
                                    }

                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?
                }
                ?>
                <?php //echo do_shortcode(stripslashes($page->content)); ?>
            </div>
        </div>
    </div>


<?php  get_footer(); ?>