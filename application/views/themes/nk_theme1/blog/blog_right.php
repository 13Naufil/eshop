<?php
$SQL = "SELECT * FROM blog_categories";
$categories = $this->db->query($SQL)->result();

$SQL = "SELECT DATE_FORMAT(`datetime`,'%b %Y') AS `archive`, DATE_FORMAT(`datetime`,'%Y %m') AS `link_archive` FROM `blog_posts` GROUP BY DATE_FORMAT(`datetime`,'%b %Y')";
$archives = $this->db->query($SQL)->result();
?>
<div class="right-content">
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
    /*if (count($archives) > 0) {
        echo '<ul>
                                        <li><h2>Archives</h2>
                                        <ul>';
        foreach ($archives as $archive) {
            echo '<li><a href="' . site_url('blog/' . str_replace(' ', '/', $archive->link_archive)) . '/">' . $archive->archive . '</a></li>';
        }
        echo '</ul></li></ul>';
    }*/

    ?>
</div>
