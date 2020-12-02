<?php
/**
 * Naufil khan
 * E: developer.systech@gmail.com
 * P: +923472565746
 * S: naufil_khan13@hotmail.com
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
    .attributes{list-style: none; margin: 0; padding: 0;}
    .attributes li{list-style: none; margin: 10px 0;}
    .attribute-set > li{ width: 45%; margin: 0 2%;  display: inline-table; /*float: left;*/}
    .attribute-set li > h6{padding: 0 0 10px 0}
</style>
<!-- START -->
<form id="validate" class="form-horizontal validate"
      action="<?php echo admin_url($this->module_route . (!empty($row->id) ? '/update/' . $row->id : '/add')); ?>"
      method="post" enctype="multipart/form-data">
    <input type="hidden" name="id" id="id" class="id" value="<?php echo $row->id; ?>"/>

    <div class="panel panel-default">
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
                <label class="col-sm-2 control-label text-right">Group Name : <span class="mandatory">*</span></label>

                <div class="col-sm-7">
                    <input type="text" name="group_name" id="group_name" class="form-control  validate[required]"
                           value="<?php echo $row->group_name ?>"/>
                </div>
            </div>
        </div>
    </div>


    <div class="panel panel-default">
        <div class="panel-heading">
            <h6 class="panel-title"><i class="icon-wand"></i>Attributes</h6>
        </div>
        <div class="panel-body">
            <section class="panel bg-none">

                <?php
                $set_title = '';
                $other_set = new stdClass();
                $other_set->id = 0;
                $other_set->set_title = 'Other';
                $attribute_sets = array_merge($attribute_sets,array($other_set));
                if (count($attribute_sets) > 0) {
                    echo '<ul class="attribute-set">';
                    foreach ($attribute_sets as $i => $attr_set) {

                        echo '<li class="list-group-item ">';
                        echo "<h6 class='border-bottom' >{$attr_set->set_title}</h6>";
                        $attributes = $this->db->get_where('attributes', array('attribute_set_id' => $attr_set->id));
                        if($attributes->num_rows > 0){
                            echo '<ul class="attributes">';
                            foreach ($attributes->result() as $attribute) {
                                echo '<li class="">';
                                echo '<input type="checkbox" name="attribute_group_rel[]" class="styled" value="' . $attribute->id . '" '._checkbox($selected_attribute, $attribute->id).'>';
                                echo $attribute->admin_label;
                                echo '</li>';
                            }
                            echo '</ul>';
                        }
                    }
                    echo '</ul>';
                }
                ?>

            </section>
        </div>
    </div>
    <div class="form-actions text-right well">
        <button type="submit" class="btn btn-info">Submit</button>
        <button type="reset" class="btn">Reset</button>
    </div>
</form>