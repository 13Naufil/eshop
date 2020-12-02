<?php
/**
 * Adnan Bashir
 * E: developer.adnan@gmail.com
 * P: +923323103324
 * S: developer.adnan
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
<style>

    /* Menu Items */
    .menu-items { margin: 0; padding: 0; }
    .menu-items .panel { margin-bottom: 5px;}
    .menu-items li{ list-style: none; margin: 0; padding: 0; }
    .menu-items .widget { width: 80%; margin-bottom: 15px; }
    .menu-items .widget .navbar-inner:hover {
        background: #fafafa;
        background: -moz-linear-gradient(top, #ffffff, #fafafa);
        background: -webkit-gradient(linear, 0 0, 0 100%, from(#ffffff), to(#fafafa));
        background: -webkit-linear-gradient(top, #ffffff, #fafafa);
        background: -o-linear-gradient(top, #ffffff, #fafafa);
        background: linear-gradient(to bottom, #ffffff, #fafafa);
        filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ffffff', endColorstr='#fafafa',GradientType=0 );
    }
    .menu-items .widget .navbar-inner:hover .menu-label { color: #4285A7; }
    .menu-items .title-bar { padding: 9px 36px 9px 0; position: relative; cursor: move; }
    .menu-items .title-bar .menu-label { /*width: 182px;*/ float: left; font-family: 'Open Sans', sans-serif; font-weight: 600; font-size: 13px; }
    .menu-items .title-bar .menu-type { /*width: 55px;*/ float: right; text-align: right; color: #999999; }
    .menu-items .title-bar .menu-icon { position: absolute; right: 4px; top: 0; width: 30px; margin: 0; height: 26px; padding-top: 12px; cursor: pointer; }
    .menu-items li.placeholder { margin-bottom: 15px; border: 1px dashed #cccccc; background-color: #fefadd; width: 398px; }

</style>
<div class="row">
    <div class="col-sm-3">
        <?php if ($create_menu || $set_menu) { ?>

            <?php if ($create_menu) { ?>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h6 class="panel-title"><i class="icon-point-up"></i>Create Menu</h6>
                    </div>
                    <div class="panel-body">
                        <form action="" method="post">
                            <div class="mgbt15">
                                <input type="text" placeholder="Menu Name" name="type_name" id="menu_name" class="form-control" value="<?php echo set_value('type_name'); ?>" />
                            </div>
                            <br>
                            <button type="submit" name="create" class="btn btn-primary col-sm-12">Create</button>
                        </form>
                    </div>
                </div>
            <?php } ?>

            <?php
            if ($set_menu) { ?>
                <div class="panel-group block widget" id="accordion-loc">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h6 class="panel-title"><a data-toggle="collapse" data-parent="#accordion-loc" href="#loc-1" class="collapsed">Theme Locations</a></h6>
                        </div>
                        <div id="loc-1" class="panel-collapse collapse">
                            <form action="<?php echo admin_url($this->module_route . '/set-menu'); ?>" method="post" id="set-menu-form">
                                <div class="mgbt15 full-width-selectbox">
                                    <label>Header Navigation</label>
                                    <select name="option[header_nav]" class="styled">
                                        <option value="0">None</option>
                                        <?php echo option_list($menus, $this->option->header_nav); ?>
                                    </select>
                                </div>

                                <div class="mgbt15 full-width-selectbox">
                                    <label>Footer Navigation</label>
                                    <select name="option[footer_nav]" class="styled">
                                        <option value="0">None</option>
                                        <?php echo option_list($menus, $this->option->footer_nav); ?>
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
                                            //alert_success('Theme locations updated!');
                                            $.jGrowl('Theme locations updated!');
                                        });
                                    });
                                });
                            </script>
                        </div>
                    </div>
                </div>
            <?php } ?>

        <?php } ?>


        <style type="text/css">
            #menu-types { margin-bottom: 20px; }
            #menu-types .accordion-inner .checkbox-list { height: 192px; overflow-y: auto; }
        </style>

        <div class="panel-group block accordion" id="menu-types">
            <?php foreach ($menu_types as $i => $row) { ?>
                <?php if (count($row['listing']) == 0) continue; ?>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h6 class="panel-title"><a data-toggle="collapse" data-parent="#menu-types" href="#<?php echo $row['name']; ?>_menu" class="collapsed"><?php echo $row['title']; ?></a></h6>
                    </div>
                    <div id="<?php echo $row['name']; ?>_menu" class="panel-collapse collapse">
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

                            <div class="pull-left"><button type="button" class="btn btn-primary add-to-menu">Add to Menu</button></div>

                            <div class="pull-right" style="padding-top: 10px;">
                                <a class="select-all" href="javascript:void(0);">Select All</a>
                                <a class="unselect-all" href="javascript:void(0);" style="display: none;">Unselect All</a>
                            </div>

                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
            <?php } ?>

            <script type="text/javascript">
                $(function(){
                    // Toggle Selector
                    $(document).on('click', '.select-all', function () {
                        var $parent = $(this).parents('.panel');
                        $('.checkbox .id-field', $parent).prop('checked', true);
                        $('.checkbox .checker span', $parent).addClass('checked');
                        $('.unselect-all', $parent).show();
                        $(this).hide();
                    });

                    $(document).on('click', '.unselect-all', function () {
                        var $parent = $(this).parents('.panel');
                        $('.checkbox .id-field', $parent).prop('checked', false);
                        $('.checkbox .checker span', $parent).removeClass('checked');
                        $('.select-all', $parent).show();
                        $(this).hide();
                    });

                    // Selected Items Add to Menu
                    $(document).on('click', '.add-to-menu', function () {
                        var $parent, $label, $new_item, menu_type, url_base, id_field, title_field, alias_field;

                        $parent = $(this).parents('.panel');
                        menu_type = $('.menu-type', $parent).val();
                        url_base = $('.url-base', $parent).val();

                        $('.id-field:checked', $parent).each(function(){
                            $label = $(this).parents('.checkbox');
                            id_field = $(this).val();
                            title_field = $('.title-field', $label).text();
                            alias_field = $('.alias-field', $label).val();
                            $new_item = $('.menu-item-demo').clone(true, true).removeClass('menu-item-demo');
                            $('.menu-type', $new_item).text(menu_type);
                            $('.menu-label,.panel-title', $new_item).text(title_field);
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

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h6 class="panel-title"><a data-toggle="collapse" data-parent="#menu-types" href="#custom-menu" class="collapsed">Custom Links</a></h6>
                </div>
                <div id="custom-menu" class="panel-collapse collapse">
                    <div class="panel-body">

                        <label class="control-label">Label</label>
                        <input type="text" id="menu-custom-label" class="form-control" placeholder="Menu item">

                        <label class="control-label">URL</label>
                        <input type="text" id="menu-custom-url" class="form-control" placeholder="Enter url here">
                        <br>
                        <br>
                        <div class="txtright"><button type="button" id="menu-custom-add" class="btn btn-primary col-sm-12">Add to Menu</button></div>

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

    <div class="<?php echo ($create_menu || $set_menu) ? 'col-sm-9' : 'col-sm-9'; ?>">
        <div class="widget">
            <div class="tabbable">
                <ul class="nav nav-tabs">
                    <?php foreach ($menus as $menu_id => $menu_title) { ?>
                        <li <?php if ($menu_id == $selected_menu) echo 'class="active"'; ?>>
                            <a href="<?php echo admin_url($this->module_route . '?m=' . $menu_id); ?>"><?php echo $menu_title; ?></a>
                        </li>
                    <?php } ?>
                </ul>
                <div class="tab-content with-padding">
                    <div class="tab-pane active" style="padding: 14px;">
                        <ol style="display: none;">
                            <li class="menu-custom-demo">
                                <div class="panel panel-default item">
                                    <div class="panel-heading">
                                        <a href="#" class="btn-link" data-panel="collapse">
                                            <h6 class="panel-title"><span class="menu-label"></span> - <small class="menu-type">Custom</small></h6>
                                        </a>
                                        <div class="panel-icons-group">
                                            <a href="#" data-panel="close" class="btn btn-link remove btn-icon"><i class="icon-remove"></i></a>
                                            <a href="#" data-panel="collapse" class="btn btn-link btn-icon"><i class="icon-arrow-down9"></i></a>
                                        </div>
                                    </div>

                                    <div class="panel-body" style="display: none;">
                                        <input type="hidden" class="menu-id" value="0">
                                        <div class="mgbt15">
                                            <label>Navigation Label</label>
                                            <input type="text" class="form-control menu-title" placeholder="Menu item" value="<?php echo $item['menu_title']; ?>">
                                        </div>
                                        <div class="mgbt15">
                                            <label>URL</label>
                                            <input type="text" class="form-control menu-url" placeholder="Enter url here" value="<?php echo $item['menu_link']; ?>">
                                        </div>
                                        <div class="text-right">
                                            <a href="javascript:void(0);" class="remove red-link"><i class="icon-remove"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </li>


                            <li class="menu-item-demo">
                                <div class="panel panel-default item">
                                    <div class="panel-heading">
                                        <a href="#" class="btn-link" data-panel="collapse"><h6 class="panel-title"><?php echo $item['menu_title']; ?> - <small class="menu-type"><?php echo ucwords(str_replace('_', ' ', $item['menu_type'])); ?></small></h6></a>
                                        <div class="panel-icons-group">
                                            <a href="#" data-panel="close" class="btn btn-link remove btn-icon"><i class="icon-remove"></i></a>
                                            <a href="#" data-panel="collapse" class="btn btn-link btn-icon"><i class="icon-arrow-down9"></i></a>
                                        </div>
                                    </div>

                                    <div class="panel-body" style="display: none;">
                                        <input type="hidden" class="menu-id" value="0">
                                        <div class="mgbt15">
                                            <label>Navigation Label</label>
                                            <input type="text" class="form-control menu-title" placeholder="Menu item" value="<?php echo $item['menu_title']; ?>">
                                        </div>
                                        <?php if ($item['menu_type'] == 'custom') { ?>
                                            <div class="mgbt15">
                                                <label>URL</label>
                                                <input type="text" class="form-control menu-url" placeholder="Enter url here" value="<?php echo $item['menu_link']; ?>">
                                            </div>
                                        <?php } else { ?>
                                            <div style="margin: 8px 0;">
                                                <span class="menu-type"><?php echo ucwords(str_replace('_', ' ', $item['menu_type'])); ?></span> :
                                                <a href="<?php echo $item['link_url']; ?>" target="_blank" class="menu-link"><?php echo $item['link_title']; ?></a>
                                                <input type="hidden" class="id-field" value="<?php echo $item['menu_link']; ?>">
                                            </div>
                                        <?php } ?>
                                        <!--<div class="text-right">
                                            <a href="javascript:void(0);" class="remove red-link"><i class="icon-remove"></i></a>
                                        </div>-->
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
                                        <div class="panel panel-default item">
                                            <div class="panel-heading">
                                                <a href="#" class="btn-link" data-panel="collapse"><h6 class="panel-title"><?php echo $item['menu_title']; ?> - <small class="menu-type"><?php echo ucwords(str_replace('_', ' ', $item['menu_type'])); ?></small></h6></a>
                                                <div class="panel-icons-group">
                                                    <a href="#" data-panel="close" class="btn btn-link remove btn-icon"><i class="icon-remove"></i></a>
                                                    <a href="#" data-panel="collapse" class="btn btn-link btn-icon"><i class="icon-arrow-down9"></i></a>
                                                </div>
                                            </div>

                                            <div class="panel-body" style="display: none;">
                                                <input type="hidden" class="menu-id" value="0">
                                                <div class="mgbt15">
                                                    <label>Navigation Label</label>
                                                    <input type="text" class="form-control menu-title" placeholder="Menu item" value="<?php echo $item['menu_title']; ?>">
                                                </div>
                                                <?php if ($item['menu_type'] == 'custom') { ?>
                                                    <div class="mgbt15">
                                                        <label>URL</label>
                                                        <input type="text" class="form-control menu-url" placeholder="Enter url here" value="<?php echo $item['menu_link']; ?>">
                                                    </div>
                                                <?php } else { ?>
                                                    <div style="margin: 8px 0;">
                                                        <span class="menu-type"><?php echo ucwords(str_replace('_', ' ', $item['menu_type'])); ?></span> :
                                                        <a href="<?php echo $item['link_url']; ?>" target="_blank" class="menu-link"><?php echo $item['link_title']; ?></a>
                                                        <input type="hidden" class="id-field" value="<?php echo $item['menu_link']; ?>">
                                                    </div>
                                                <?php } ?>
                                                <!--<div class="text-right">
                                                    <a href="javascript:void(0);" class="remove red-link"><i class="icon-remove"></i></a>
                                                </div>-->

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
        $(document).ready(function () {
            // Menu Sorting
            $('.menu-items').nestedSortable({ forcePlaceholderSize: true, placeholder: 'placeholder', handle: '.panel-heading', toleranceElement: '> .item', maxLevels: 8, items: 'li' });

            // Dropdown Toggle
            $('.menu-items .menu-icon').on('click', function(){
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
            $(document).on('click', '.menu-items .remove', function(e){
                e.preventDefault();
                var $parent = $(this).parents('.item').parent();
                //$('.navbar .navbar-inner', $parent).css('background', '#FF6359');
                $parent.fadeOut(function(){
                    $(this).remove();
                });
            });

            // Menu Label Update
            $('.menu-items .menu-title').on('keyup', function(){
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