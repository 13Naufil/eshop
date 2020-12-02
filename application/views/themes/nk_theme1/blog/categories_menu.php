<nav class="navbar navbar-default navbar-inverse -navbar-fixed-top blog-nav"  data-spy="affix" data-offset-top="137">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#"><span class="visible-xs">Categories</span></a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <?php
                $_nav = array(
                    'active_link' => getUri(2),
                    'url' => site_url('blog') . '/category/',
                    'title_Column' => 'category',
                    'link_Column' => 'slug',
                    'query' => 'SELECT
                                    cat.id
                                    , cat.category
                                    , cat.slug
                                    , cat.parent_id
                                    , p_cat.category AS parent
                                FROM blog_categories AS cat
                                    LEFT JOIN blog_categories AS p_cat ON (cat.id = p_cat.parent_id)
                                ORDER BY cat.ordering,id ASC',
                );
                echo get_nav(0, $_nav);
                ?>
            </ul>
            <!--<ul class="nav navbar-nav navbar-right">
                <li><a href="../navbar/">Default</a></li>
                <li><a href="../navbar-static-top/">Static top</a></li>
                <li class="active"><a href="./">Fixed top <span class="sr-only">(current)</span></a></li>
            </ul>-->
        </div><!--/.nav-collapse -->
    </div>
</nav>