<?php
/**
 * Naufil khan
 * E: developer.systech@gmail.com
 * P: +923472565746
 * S: naufil_khan13@hotmail.com
 */
$form_btns = array('save', 'reset', 'back');
?>
<style>
    input[type=checkbox], input[type=radio] {
  
    display: none;
}
</style>
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
            <?php 
            if(!isset($row)){ ?>
                <div class="tab-pane fade in" id="categories-tab">
                             <div class="form-group">
                            <label class="col-sm-2 control-label text-right">Category : <span class="mandatory">*</span></label>

                            <div class="col-sm-7">
                                <select name="" id="category_id" class="form-control">
                                    <?php
                                    echo selectBox('SELECT id, title FROM categories', $row->id);
                                    ?>
                                </select>
                            </div>
                        </div>
                    
                    
                       
                    <div class="form-group">
                           <label class="col-sm-2 control-label text-right">Select Product : <span class="mandatory">*</span></label>

                <div class="col-sm-7">
                   
                    <select class="form-control productdd" name="product_id">
                        
                    </select>
                </div>
                    </div>
                    <?php
            }
            else{
                    ?>
               <input type="hidden" name="product_id" value="<?php echo $row->product_id ?>">       
                    <?php
            }
                    ?>
              <div class="form-group">
               
                <label class="col-sm-2 control-label text-right">Apperance Order : <span class="mandatory">*</span></label>

                <div class="col-sm-7">
                    <input type="text" name="order" id="order" class="form-control validate[required]" value="<?php echo $row->order ?>"/>
                </div>
            </div>
            

    </div>
    </div>
    <div class="form-actions text-right well">
        <button type="submit" class="btn btn-info">Submit</button>
        <button type="reset" class="btn">Reset</button>
    </div>
</form>
<script>
$(".productdd").append("<option>Select a Product</option>");
    $("#category_id").change(function(){
        $(".productdd").empty();
        $(".productdd").append("<option>Select a Product</option>");
        category=$(this).val();
      
        $.ajax({
                type: "POST",
                url: "<?php echo admin_url($this->module_route . '/getproduct'); ?>", 
                 data: {category:category},
                  dataType: 'json',
                success: 
                    function(response){
                 
                        for(i=0;i<response.length;i++){
                             $(".productdd").append("<option value='"+response[i].id+"'>"+response[i].name+", "+response[i].SKU+"</option>")
                        }
                        // alert(response[0].name); 
                        
                    }

            });
    })
</script>