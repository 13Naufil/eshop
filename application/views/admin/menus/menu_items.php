<li>
    <div class="portlet">
        <?php
        if($item['menu_type'] == 'custom'){
            ?>
            <h3 class="portlet-title navbar-inner">
                <span class="menu-label"><?=stripslashes($item['menu_title']);?></span> - <span class="menu-type">Custom</span>
                <span class="portlet-toggle"><span class="caret"></span></span>
            </h3>
            <div class="portlet-content gray">
                <input type="hidden" class="menu-id" value="<?=$item['id'];?>">
                <label>Navigation Label</label><input type="text" class="form-control menu-title" placeholder="Menu item" value="<?=htmlentities(stripslashes($item['menu_title']));?>">
                <label>URL</label><input type="text" class="form-control menu-url" placeholder="Enter url here" value="<?=$item['menu_link'];?>">
                <div class="text-right"><a href="javascript:void(0);" class="icon-trash remove">&nbsp;</a></div>
            </div>
            <?php
        }elseif($item['menu_type'] == 'page'){

            ?>

            <h3 class="portlet-title navbar-inner">
                <span class="menu-label"><?=stripslashes($item['menu_title']);?></span> - <span class="menu-type">Page</span>
                <span class="portlet-toggle"><span class="caret"></span></span>
            </h3>
            <div class="portlet-content gray">
                <input type="hidden" class="menu-id" value="<?=$item['id'];?>">
                <label>Navigation Label</label><input type="text" class="form-control menu-title" placeholder="Menu item" value="<?=htmlentities(stripslashes($item['menu_title']));?>">
                Page: <a href="<?=$item['page_link'];?>" target="_blank" class="menu-page-link"><?=$item['page_title'];?></a>
                <input type="hidden" class="menu-page-id" value="<?=$item['menu_link'];?>">
                <div class="text-right"><a href="javascript:void(0);" class="icon-trash remove">&nbsp;</a></div>
            </div>
            <?php
        }elseif($item['menu_type'] == 'category'){
            ?>
            <h3 class="portlet-title navbar-inner">
                <span class="menu-label"><?=stripslashes($item['menu_title']);?></span> - <span class="menu-type">Category</span>
                <span class="portlet-toggle"><span class="caret"></span></span>
            </h3>
            <div class="portlet-content gray">
                <input type="hidden" class="menu-id" value="<?=$item['id'];?>">
                <label>Navigation Label</label><input type="text" class="input-block-level menu-title" placeholder="Menu item" value="<?=htmlentities(stripslashes($item['menu_title']));?>">
                Category: <a href="<?=$item['cate_link'];?>" target="_blank" class="menu-cate-link"><?=$item['cate_title'];?></a>
                <input type="hidden" class="menu-cate-id" value="<?=$item['link'];?>">
                <div class="txtright"><a href="javascript:void(0);" class="icon-trash remove">&nbsp;</a></div>
            </div>
        <? } ?>
    </div>
    <?php
    if(count($item['sub_items']) > 0){
        ?>
        <ol>
            <?php
            foreach ($item['sub_items'] as $sub_item) {
                $this->load->view(ADMIN_DIR . $this->module_name . '/menu_items', array('item' => $sub_item));
                //include dirname(__FILE__)."/menu_items.php";
            }
            ?>
        </ol>
    <? } ?>
</li>