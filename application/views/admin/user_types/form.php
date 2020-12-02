<?php
/**
 * Naufil khan
 * Email:  developer.systech@gmail.com
 */
$form_btns = array('save', 'reset', 'back');
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

    .tree-module input[type=checkbox]{
        margin-left: 200px;
        position: absolute;
        display: none;
    }
</style>

<!-- START -->
<form id="validate" class="form-horizontal validate tree-form"
      action="<?php echo admin_url($this->module_route . (!empty($row->id) ? '/update' : '/add')); ?>"
      method="post" enctype="multipart/form-data">
    <input type="hidden" name="id" id="id" value="<?= $row->id; ?>"/>


    <div class="panel panel-default">
        <!-- Form validation -->
        <div class="panel-heading">
            <h6 class="panel-title"><i class="icon-bubble4"></i>
                <?php echo $this->module_title; ?> - Form
            </h6>
        </div>
        <?php
        echo get_form_actions($form_btns);
        ?>
        <div class="panel-body">

            <div class="form-group">
                <label class="col-sm-2 control-label text-right">User Type : <span class="mandatory">*</span></label>

                <div class="col-sm-7">
                    <input type="text" class="validate[required] form-control" name="user_type" id="user_type"
                           value="<?= $row->user_type; ?>"/>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-2 control-label text-right">Modules: </label>

                <div class="col-sm-10">

                    <div id="tree-module" class="tree-module">
                        <?php

                        $check_sql = "SELECT id, parent_id, module, module_title, `actions` FROM modules where `status`='1' order by ordering";
                        $result = $this->db->query($check_sql);

                        $menu = array(
                            'items' => array(),
                            'parents' => array()
                        );
                        foreach ($result->result_array() as $items) {
                            $menu['items'][$items['id']] = $items;
                            $menu['parents'][$items['parent_id']][] = $items['id'];

                        }
                        function buildModuleCheckBox($parent, $menu, $modules, $selected_action)
                        {

                            $html = "";
                            if (isset($menu['parents'][$parent])) {
                                $html .= "<ul>\n";

                                foreach ($menu['parents'][$parent] as $itemId) {
                                    if (!isset($menu['parents'][$itemId])) {
                                        $actions = '';
                                        $actions_ar = explode('|', str_replace(',', '|', ($menu['items'][$itemId]['actions'])));


                                        if (count($actions_ar) > 0) {
                                            $actions .= '<ul class="module_action">';
                                            foreach ($actions_ar as $act) {

                                                if ($act != '') {
                                                    $actions .= '<li data-jstree=\'{ "icon" : "icon-accessibility2" '. (in_array($act, $selected_action[$menu['items'][$itemId]['id']]) ? ', "selected":true  ' : '') .'}\'>';
$actions .= "<input class='' type='checkbox'
" . (in_array($act, $selected_action[$menu['items'][$itemId]['id']]) ? ' checked ' : '') . "
name='actions[" . $menu['items'][$itemId]['id'] . "][]' id='a' value='" . $act . "' title='" . ucwords(str_replace('_', ' ', $act)) . "'> " . ucwords(str_replace('_', ' ', $act)) . " </li>";
                                                }
                                            }
                                            $actions .= '</ul>';

                                        }
                                        $html .= '<li data-jstree=\'{ '.((in_array($menu['items'][$itemId]['id'], $modules)) ? '"opened": true, "selected":true ' : '').' }\'>';
                                        //$html .= '<li>';
                                        $html .= "\n
                                        <input type='checkbox'
                                                                        " . ((in_array($menu['items'][$itemId]['id'], $modules)) ? 'checked' : '') . "
                                                                        name='modules[]' value='" . $menu['items'][$itemId]['id'] . "' class=' multi_checkbox '>
                                                                        " . $menu['items'][$itemId]['module_title'] . $actions . "
                                                                        </li>";
                                    }
                                    if (isset($menu['parents'][$itemId])) {


$html .= '<li data-jstree=\'{ '.((in_array($menu['items'][$itemId]['id'], $modules)) ? '"opened": true, "selected":true ' : '').' }\'>';
//$html .= '<li>';

$html .= "<input " . ((in_array($menu['items'][$itemId]['id'], $modules)) ? 'checked' : '') . "
type='checkbox' name='modules[]' value='" . $menu['items'][$itemId]['id'] . "' class=' multi_checkbox '>
" . $menu['items'][$itemId]['module_title'];


                                        $html .= buildModuleCheckBox($itemId, $menu, $modules, $selected_action);
                                        $html .= "\n</li>";
                                    }
                                }
                                $html .= "\n</ul>";
                            }
                            return $html;
                        }


                        echo buildModuleCheckBox(0, $menu, $modules, $selected_action);

                        ?>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="form-actions text-right well">
        <button type="submit" class="btn btn-info">Submit</button>
        <button type="reset" class="btn">Reset</button>
    </div>
    <!-- /form validation -->
</form>

<!-- END -->

<!-- /content -->
<script type="text/javascript">
    (function ($) {

        var tree = $("#tree-module").jstree({
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

        $(document).ready(function () {
            $('.tree-form').on('submit', function (e) {
                $('.jstree input[type=checkbox]', this).each(function () {
                    $(this).prop('checked', false).removeAttr('checked');
                });
                $('.jstree-undetermined', this).each(function () {
                    $(this).parent().find('input').prop('checked', true);
                });
                $('.jstree-clicked', this).each(function () {
                    $(this).find('input').prop('checked', true);
                });
            });
        });
    })(jQuery)
</script>