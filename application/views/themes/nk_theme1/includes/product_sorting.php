<div class="filter">
    <label for="limit" class="text-uppercase">Show: </label>
    <select name="limit" id="limit" onchange="window.location='<?php echo generate_url('limit');?>&limit='+this.value">
        <?php
            $_limit = array(
                '' => 'All',
                '12' => '12',
                '15' => '15',
                '22' => '22',
            );
            echo selectBox($_limit, $limit);
            ?>
    </select>
    <label for="limit" class="text-uppercase">Sort By: </label>
    <select name="sort" id="sort" onchange="window.location='<?php echo generate_url('order');?>&order='+this.value">
        <?php
        $_order = array(
            'Newest' => 'Newest',
            'Oldest' => 'Oldest',
            'Ratings' => 'Ratings',
        );
        echo selectBox($_order, getVar('order'));
        ?>
    </select>
    <?php
    $_dir = 'asc';
    $_dir_icon = 'up4';
    if(getVar('dir') == 'asc'){
        $_dir = 'desc';
        $_dir_icon = 'down4';
    }
    ?>
    <a href="<?php echo generate_url('dir');?>&dir=<?php echo $_dir;?>"><em class="icon-arrow-<?php echo $_dir_icon;?>"></em></a>
</div>
