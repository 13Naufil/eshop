<?php
/**
 * Naufil khan
 * E: developer.systech@gmail.com
 * P: +923472565746
 * S: naufil_khan13@hotmail.com
 */
//$form_btns = array('reset', 'back');
?>
<!-- Page header -->
<div class="page-header">
    <div class="page-title">
        <h3>
            <?php echo getModuleDetail()->module_icon; ?>
            <?php echo $this->module_title; ?>
            <small>Listing of <?php echo $this->module_title; ?>.</small>
        </h3>
    </div>
</div>
<!-- /page header -->

<?php
include dirname(__FILE__) . "/../includes/breadcrumb.php";
?>

<?php
echo show_validation_errors();
?>
        <div class="row">
            <?php if ($create_menu || $set_menu) { ?>
                <div class="col-sm-3">
                    <?php if ($create_menu) { ?>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h6 class="panel-title">Create Menu</h6>
                            </div>
                            <div class="">
                                <form action="" method="post">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label for="menu_name">Menu Name</label>
                                            <input type="text" name="type_name" id="menu_name" class="form-control" value="<?php echo set_value('type_name'); ?>" />
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <br/>
                                    <div class="form-group">
                                        <button type="submit" name="create" class="btn">Create</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    <?php } ?>

                    <?php
                    if ($set_menu) { ?>
                        <div class="widget">
                            <div class="navbar">
                                <div class="navbar-inner"><h6>Theme Locations</h6></div>
                            </div>
                            <div class="well body">
                                <form action="<?php echo admin_url($this->module_route . '/set-menu'); ?>" method="post" id="set-menu-form">
                                    <div class="mgbt15 full-width-selectbox">
                                        <label>Header Navigation</label>
                                        <select name="option[header_nav]" class="styled">
                                            <option value="0">None</option>
                                            <?php echo selectBox($menus, $this->option->header_nav); ?>
                                        </select>
                                    </div>

                                    <div class="mgbt15 full-width-selectbox">
                                        <label>Footer Navigation</label>
                                        <select name="option[footer_nav]" class="styled">
                                            <option value="0">None</option>
                                            <?php echo selectBox($menus, $this->option->footer_nav); ?>
                                        </select>
                                    </div>

                                    <div>
                                        <button type="button" id="set-menu" class="btn">Save</button>
                                        <!--<img src="assets/backend/img/elements/loaders/5s.gif" style="display: none;" class="loader" alt=""> &nbsp;-->
                                    </div>
                                </form>

                                <script type="text/javascript">
                                    var $smloader, $smform;
                                    $(function(){
                                        $('#set-menu').click(function(){
                                            $('#set-menu').attr('disabled', 'disabled').text('Saving...');
                                            var $form = $('#set-menu-form');
                                            $.post($form.attr('action'), $form.serialize(), function(){
                                                $('#set-menu').removeAttr('disabled').text('Save');
                                                $.jGrowl('Theme locations updated!');
                                            });
                                        });
                                    });
                                </script>
                            </div>
                        </div>
                    <?php } ?>

            <?php } ?>



                <div class="accordion" id="menu-types">
                    <?php foreach ($menu_types as $i => $row) { ?>
                        <?php if (count($row['listing']) == 0) continue; ?>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h6 class="panel-title"><a class="accordion-toggle" data-toggle="collapse" data-parent="#menu-types" href="#<?php echo $row['name']; ?>_menu"><?php echo $row['title']; ?></a></h6>
                            </div>
                            <div id="<?php echo $row['name']; ?>_menu" class="panel-collapse collapse <?php if ($i == 0) echo 'in'; ?>">
                                <div class="panel-body">
                                    <input type="hidden" class="menu-type" value="<?php echo ucwords(str_replace('_', ' ', $row['name'])); ?>" />
                                    <input type="hidden" class="url-base" value="<?php echo $row['url_base']; ?>" />

                                    <div class="checkbox-list controls mgbt15">
                                        <?php foreach ($row['listing'] as $item) { ?>
                                            <label class="checkbox">
                                                <input type="hidden" class="alias-field" value="<?php echo $item['alias']; ?>">
                                                <input type="checkbox" class="id-field styled" value="<?php echo $item['id']; ?>">
                                                <span class="title-field"><?php echo $item['title']; ?></span>
                                            </label>
                                        <?php } ?>
                                    </div>

                                    <div class="pull-left"><button type="button" class="btn add-to-menu">Add to Menu</button></div>

                                    <div class="pull-right" style="padding-top: 10px;">
                                        <a class="select-all" href="javascript:void(0);">Select All</a>
                                        <a class="unselect-all" href="javascript:void(0);" style="display: none;">Unselect All</a>
                                    </div>

                                </div>
                            </div>
                        </div>
                    <?php } ?>

                    <script type="text/javascript">
                        $(function(){
                            // Toggle Selector
                            $('.select-all').click(function(){
                                var $parent = $(this).parents('.accordion-inner');
                                $('.checkbox .id-field', $parent).prop('checked', true);
                                $('.checkbox .checker span', $parent).addClass('checked');
                                $('.unselect-all', $parent).show();
                                $(this).hide();
                            });

                            $('.unselect-all').click(function(){
                                var $parent = $(this).parents('.accordion-inner');
                                $('.checkbox .id-field', $parent).prop('checked', false);
                                $('.checkbox .checker span', $parent).removeClass('checked');
                                $('.unselect-all', $parent).show();
                                $(this).hide();
                            });

                            // Selected Items Add to Menu
                            $('.add-to-menu').click(function(){
                                var $parent, $label, $new_item, menu_type, url_base, id_field, title_field, alias_field;

                                $parent = $(this).parents('.accordion-inner');
                                menu_type = $('.menu-type', $parent).val();
                                url_base = $('.url-base', $parent).val();

                                $('.id-field:checked', $parent).each(function(){
                                    $label = $(this).parents('.checkbox');
                                    id_field = $(this).val();
                                    title_field = $('.title-field', $label).text();
                                    alias_field = $('.alias-field', $label).val();
                                    $new_item = $('.menu-item-demo').clone(true, true).removeClass('menu-item-demo');
                                    $('.menu-type', $new_item).text(menu_type);
                                    $('.menu-label', $new_item).text(title_field);
                                    $('.menu-link', $new_item).text(title_field).attr('href', url_base + alias_field);
                                    $('.menu-title', $new_item).val(title_field);
                                    $('.id-field', $new_item).val(id_field);
                                    $('.menu-items').append($new_item);
                                    $(this).removeAttr('checked');
                                    $(this).parent().removeClass('checked');
                                });

                                if ($('.menu-items li').length > 0) {
                                    $('#menu-actions').show();
                                    $('#menu-msg').hide();
                                }
                            });
                        });
                    </script>

                    <div class="accordion-group">
                        <div class="accordion-heading">
                            <a class="accordion-toggle" data-toggle="collapse" data-parent="#menu-types" href="#custom-menu">Custom Links</a>
                        </div>
                        <div id="custom-menu" class="accordion-body collapse">
                            <div class="accordion-inner">
                                <div class="mgbt15">
                                    <label>Label</label>
                                    <input type="text" id="menu-custom-label" class="input-block-level" placeholder="Menu item">
                                </div>

                                <div class="mgbt15">
                                    <label>URL</label>
                                    <input type="text" id="menu-custom-url" class="input-block-level" placeholder="Enter url here">
                                </div>

                                <div class="txtright"><button type="button" id="menu-custom-add" class="btn">Add to Menu</button></div>

                                <script type="text/javascript">
                                    $(function(){
                                        $('#menu-custom-add').click(function(){
                                            var menu_custom_url = $('#menu-custom-url').val();
                                            var menu_custom_label = $('#menu-custom-label').val();
                                            if (menu_custom_label != '') {
                                                var $new_item = $('.menu-custom-demo').clone(true, true).appendTo('.menu-items').removeClass('menu-custom-demo');
                                                $('.menu-label', $new_item).text(menu_custom_label);
                                                $('.menu-title', $new_item).val(menu_custom_label);
                                                $('.menu-url', $new_item).val(menu_custom_url);
                                                $('#menu-custom-url').val('');
                                                $('#menu-custom-label').val('');
                                                $('#menu-actions').show();
                                                $('#menu-msg').hide();
                                            }
                                        });
                                    })
                                </script>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="<?php echo ($create_menu || $set_menu) ? 'col-sm-9' : 'col-sm-12'; ?>">
                <div class="widget">
                    <div class="tabbable">
                        <ul class="nav nav-tabs">
                            <?php foreach ($menus as $menu_id => $menu_title) { ?>
                                <li <?php if ($menu_id == $selected_menu) echo 'class="active"'; ?>>
                                    <a href="<?php echo admin_url($this->module_route . '?m=' . $menu_id); ?>"><?php echo $menu_title; ?></a>
                                </li>
                            <?php } ?>
                        </ul>
                        <div class="tab-content" style="padding: 0;border: 1px solid #d5d5d5;">
                            <div class="tab-pane active" style="padding: 14px;">
                                <ol style="display: none;">
                                    <li class="menu-custom-demo">
                                        <div class="widget item">
                                            <div class="navbar">
                                                <div class="navbar-inner">
                                                    <div class="title-bar">
                                                        <span class="menu-label"></span>
                                                        <span class="menu-type">Custom</span>
                                                        <span class="menu-icon icon-caret-down"></span>
                                                        <div class="clearfix"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="collapse">
                                                <div class="well well-smoke body">
                                                    <input type="hidden" class="menu-id" value="0">
                                                    <div class="mgbt15">
                                                        <label>Navigation Label</label>
                                                        <input type="text" class="input-block-level menu-title" placeholder="Menu item" value="">
                                                    </div>
                                                    <div class="mgbt15">
                                                        <label>URL</label>
                                                        <input type="text" class="input-block-level menu-url" placeholder="Enter url here" value="">
                                                    </div>
                                                    <div class="txt-right">
                                                        <a href="javascript:void(0);" class="remove red-link">Remove</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>

                                    <li class="menu-item-demo">
                                        <div class="widget item">
                                            <div class="navbar">
                                                <div class="navbar-inner">
                                                    <div class="title-bar">
                                                        <span class="menu-label"></span>
                                                        <span class="menu-type"></span>
                                                        <span class="menu-icon icon-caret-down"></span>
                                                        <div class="clearfix"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="collapse">
                                                <div class="well well-smoke body">
                                                    <input type="hidden" class="menu-id" value="0">
                                                    <div class="mgbt15">
                                                        <label>Navigation Label</label>
                                                        <input type="text" class="input-block-level menu-title" placeholder="Menu item" value="">
                                                    </div>
                                                    <div style="margin-bottom: 8px;">
                                                        <span class="menu-type"></span> : <a href="#" target="_blank" class="menu-link"></a>
                                                        <input type="hidden" class="id-field" value="">
                                                    </div>
                                                    <div class="txt-right">
                                                        <a href="javascript:void(0);" class="remove red-link">Remove</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ol>

                                <?php if (count($menu_items) == 0) { ?>
                                    <div id="menu-msg" class="alert">No items in this menu</div>
                                <?php } ?>

                                <ol class="menu-items">
                                    <?php if (count($menu_items) > 0) display_menu_items($menu_items); ?>

                                    <?php function display_menu_items($items) { ?>
                                        <?php foreach ($items as $item) {

                                            ?>
                                            <li>
                                                <div class="widget item">
                                                    <div class="navbar">
                                                        <div class="navbar-inner">
                                                            <div class="title-bar">
                                                                <span class="menu-label"><?php echo $item['menu_title']; ?></span>
                                                                <span class="menu-type"><?php echo ucwords(str_replace('_', ' ', $item['menu_type'])); ?></span>
                                                                <span class="menu-icon icon-caret-down"></span>
                                                                <div class="clearfix"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="collapse">
                                                        <div class="well well-smoke body">
                                                            <input type="hidden" class="menu-id" value="0">
                                                            <div class="mgbt15">
                                                                <label>Navigation Label</label>
                                                                <input type="text" class="input-block-level menu-title" placeholder="Menu item" value="<?php echo $item['menu_title']; ?>">
                                                            </div>
                                                            <?php if ($item['menu_type'] == 'custom') { ?>
                                                                <div class="mgbt15">
                                                                    <label>URL</label>
                                                                    <input type="text" class="input-block-level menu-url" placeholder="Enter url here" value="<?php echo $item['menu_link']; ?>">
                                                                </div>
                                                            <?php } else { ?>
                                                                <div style="margin-bottom: 8px;">
                                                                    <span class="menu-type"><?php echo ucwords(str_replace('_', ' ', $item['menu_type'])); ?></span> :
                                                                    <a href="<?php echo $item['link_url']; ?>" target="_blank" class="menu-link"><?php echo $item['link_title']; ?></a>
                                                                    <input type="hidden" class="id-field" value="<?php echo $item['menu_link']; ?>">
                                                                </div>
                                                            <?php } ?>
                                                            <div class="txt-right">
                                                                <a href="javascript:void(0);" class="remove red-link">Remove</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php if (isset($item['sub_items'])) { ?>
                                                    <ol>
                                                        <?php display_menu_items($item['sub_items']); ?>
                                                    </ol>
                                                <?php } ?>
                                            </li>
                                        <?php } ?>
                                    <?php } ?>
                                </ol>
                            </div>

                            <div id="menu-actions" class="form-actions" style="display: <?php echo count($menu_items) > 0 ? 'block' : 'none'; ?>;">
                                <div class="controls">
                                    <button type="button" id="menu-save" class="btn btn-danger">Save Menu</button> &nbsp;
                                    <?php if ($delete_menu) { ?>
                                        <button type="button" id="menu-delete" class="btn">Delete</button>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript" src="<?php echo asset_url('admin/js/nested-sortable.js');?>"></script>
<script type="text/javascript">
    $(function(){
        // Menu Sorting
        $('.menu-items').nestedSortable({ forcePlaceholderSize: true, placeholder: 'placeholder', handle: '.navbar', toleranceElement: '> .widget', maxLevels: 2, items: 'li' });

        // Dropdown Toggle
        $('.menu-items .menu-icon').live('click', function(){
            var $parent = $(this).parents('.item');
            if ($(this).hasClass('icon-caret-down')) {
                $('.collapse', $parent).addClass('in');
                $(this).removeClass('icon-caret-down').addClass('icon-caret-up');
            } else {
                $('.collapse', $parent).removeClass('in');
                $(this).removeClass('icon-caret-up').addClass('icon-caret-down');
            }
        });

        // Menu Item Delete
        $('.menu-items .remove').live('click', function(){
            var $parent = $(this).parents('.item').parent();
            $('.navbar .navbar-inner', $parent).css('background', '#FF6359');
            $parent.fadeOut(function(){
                $(this).remove();
            });
        });

        // Menu Label Update
        $('.menu-items .menu-title').live('keyup', function(){
            $(this).parents('.item').find('.menu-label').text($(this).val());
        });

        // Confirm Delete
        $("#menu-delete").click(function(){
            bootbox.confirm('Are you sure, you want to delete?', function(status){
                if (status == true) {
                    window.location = '<?php echo admin_url($this->module_route . '/delete/' . $selected_menu); ?>';
                }
            });
        });

        //Save menu
        $('#menu-save').click(function(){
            $('#menu-save').attr('disbaled', 'disbaled').text('Saving...');
            var items = getMenuItems($('.menu-items > li'));
            $.post('<?php echo admin_url($this->module_route . '/add/' . $selected_menu); ?>', { items: items }, function() {
                $('#menu-save').removeAttr('disbaled').text('Save Menu');
                bootbox.alert('Menu saved successfully!');
            });
        });
    });

    function getMenuItems(obj)
    {
        var $menu_item, $sub_items, item_id, item_title, item_type, item_link, sub_items = [], items = [];

        obj.each(function(){
            $menu_item = $('.item', this);
            item_id = $('.menu-id', $menu_item).val();
            item_title = $('.menu-title', $menu_item).val();
            item_type = $('.menu-type', $menu_item).first().text();
            item_type = item_type.toLowerCase();

            if (item_type == 'custom') {
                item_link = $('.menu-url', $menu_item).val();
            } else {
                item_link = $('.id-field', $menu_item).val();
            }

            $sub_items = $('> ol > li', this);
            if ($sub_items.length > 0) {
                sub_items = getMenuItems($sub_items);
            } else {
                sub_items = [];
            }

            items.push({ item_id: item_id, item_title: item_title, item_type: item_type, item_link: item_link, sub_items: sub_items });
        });

        return items;
    }
</script>