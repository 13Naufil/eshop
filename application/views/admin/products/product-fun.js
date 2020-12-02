/**
 * Naufil khan
 * Email: developer.systech@gmail.com
 */

$(document).ready(function () {

    $(document).on('change', '#attributes-' + color_attr_id, function () {
        var color_opt = $(this);
        var selected = $(':selected',this);
        //var option = '<option value="">- Select color -</option>';

        $.each(selected,function (k, option) {
            var val = $(this).val();

            if($('select.color_img:eq(0) option[value=' + val + ']').val() == undefined){
                $('select.color_img').append(color_opt.find('option[value='+val+']').clone());
            }
        });



    });

    $('#attribute_group_id').on('change', function () {
        var attribute_group_id = $(this).val();
        $.ajax({
            type: "POST",
            url: module_route_url + '/AJAX/get_attribute_form',
            dataType: 'json',
            async: false,
            data: {attribute_group_id: attribute_group_id, product_id: product_id, attributes_data: attributes},
            complete: function (data) {
                var json = $.parseJSON(data.responseText);
                $('.attributes-form').html(json.product_attr_form);
                //$(".validate").validationEngine();
            }
        });
    });
    $('#attribute_group_id').trigger('change');


    var tree = $("#categories-tree").jstree({
        plugins: ['checkbox']
        , "checkbox": {"three_state": false}
    });

    tree.on("changed.jstree", function (e, data) {
        if (data.action == 'deselect_node') {
            tree.jstree("close_node", "#" + data.node.id);
        }
        else {
            tree.jstree("open_node", "#" + data.node.id);
        }
    });

    /*$('.jstree input[type=checkbox]').each(function () {
        var li = $(this).parent().parent('li');
        var id = li.attr('id');
        if ($(this).is(':checked')) {
            tree.jstree("check_node", "#" + id);
        } else {
            tree.jstree("uncheck_node", "#" + id);
        }
    });*/

    $('.tree-form').on('submit', function (e) {
        $('.jstree input[type=checkbox]', this).each(function () {
            $(this).prop('checked', false);
        });
        $('.jstree-undetermined', this).each(function () {
            $(this).parent().find('input').prop('checked', true);
        });
        $('.jstree-clicked', this).each(function () {
            $(this).parent('li').find('input').prop('checked', true);
        });
    });


    $('#brand_id').on('change', function () {
        var brand_id = $(this).val();
        $.ajax({
            type: "POST",
            dataType: "JSON",
            url: module_route_url + '/AJAX/get_brand_cats',
            data: {brand_id: brand_id, 'selected_categories': '<?php echo $selected_categories;?>'},
            complete: function (data) {
                var json = $.parseJSON(data.responseText);
                console.log(json);
                $.jstree.destroy();

                $("#categories-tree").html(json.categories);
                $("#categories-tree").jstree({
                    plugins: ['checkbox']
                });

                $("#categories-tree").on("changed.jstree", function (e, data) {

                    $('input[type=checkbox]', this).prop('checked', false);
                    var chkd = (data.action == 'select_node') ? true : false;
                    if (data.selected.length > 0) {
                        $.each(data.selected, function (index, value) {
                            $('li#' + value).find('a:eq(0) input[type=checkbox]').prop('checked', 1);
                        });
                        $('li#' + data.node.id).find('input[type=checkbox]').prop('checked', chkd);
                    }
                    if (data.node.parents.length > 0) {
                        $.each(data.node.parents, function (index, value) {
                            if (value != '#') {
                                $('li#' + value).find('a:eq(0) input[type=checkbox]').prop('checked', 1);
                            }
                        });
                    }
                });
            }
        });
    });


    $(document).on('click', '.table-controls a[action="file_delete"]', function (e) {
        e.preventDefault();
        var url = $(this).attr('href');
        bootbox.confirm("Are you sure do you want to delete?", function (confirmed) {
            if (confirmed) {
                $.ajax({
                    type: "POST",
                    dataType: "JSON",
                    url: url,
                    data: {id: 1},
                    complete: function (data) {
                        var json = $.parseJSON(data.responseText);
                        console.log(json);
                    }
                });
            }
        });
    });
});