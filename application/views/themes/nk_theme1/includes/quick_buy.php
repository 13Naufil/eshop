    <style>
    
/* The Modal (background) */
#quickmodel {
  display:none;
  position: fixed; /* Stay in place */
  z-index: 1000; /* Sit on top */
  padding-top: 150px; /* Location of the box */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

/* Modal Content */
.modal-content {
  background-color: #fefefe;
  margin: auto;
  padding: 0px;
  border: 1px solid #888;
  width: 40%;
}

/* The Close Button */
.close {
  color: white!important;
  float: right;
  font-size: 28px;
  right:2%;
  opacity:1!important;
  font-weight: bold;
}

.close:hover,
.close:focus {
  color: gray;
  text-decoration: none;
  cursor: pointer;
}
.model-header{
    background-color:black;
    padding:2% 4%;
}
.model-header p{
    font-size:18px;
    color:white;
}
.model-body{
    padding:2% 4%;
}
@media (max-width: 900px)
.modal-content {
    width: 80%!important;
}
</style>


 <div id="quickmodel" class="quickmodel">

  <!-- Modal content -->
  <div class="modal-content">
     <div class="model-header">
           <span class="close">&times;</span>
    <p>Quick Buy</p>
     </div>
     <div class="model-body">
         <form method="post" action="http://emerce.pk/admin/quick_order/add">
         <div class="row">
             
             <div class="form-group col-md-12">
                
                 <input type="hidden" name="product_id" id="product_id">
                 <label>Name</label>
                 <input type="text" required=""  placeholder="Type Here" name="customer_name" class="form-control">
             </div>
               <div class="form-group col-md-6">
                 <label>Email</label>
                 <input type="email" required="" placeholder="Type Here" name="customer_email" class="form-control">
             </div>
                <div class="form-group col-md-6">
                 <label>Mobile</label>
                 <input type="text" required="" placeholder="Type Here" name="customer_mobile" class="form-control">
             </div>
               <div class="form-group col-md-12">
                 <label>Address</label>
                 <input type="text" required=""  placeholder="Type Here" name="delivery_address" class="form-control">
             </div>
               <div class="form-group col-md-12">
                 <label>City</label>
                 <input type="text" required=""  placeholder="Type Here" name="delivery_city" class="form-control">
             </div>
             <div class="form-group col-md-12 size">
                 <label>Select a Size</label>
                 <select class="form-control sizeselect" name="size">
                     
                 </select>
             </div>
                <div class="form-group col-md-12 color">
                 <label>Select a Color</label>
                 <select class="form-control colorselect" name="color">
                   
                 </select>
             </div>
                 <div class="form-group col-md-12">
                 
                 <input type="submit" class="btn" value="Submit">
             </div>
         </div>
     </div>
  </form>
  </div>

</div>


<script>

$(".quick_buy").click(function(e){
    e.preventDefault();
    product_id=$(this).attr("data-id");
    $("#product_id").val(product_id);
    size=$(this).attr("data-size");
    if(size!=""){
        $(".sizeselect").empty();
    $(".size").show(); 
    var sizearray = size.split(',');
    $(".sizeselect").append("<option value='Default'>Select Size</option>");
        for(i=0;i<sizearray.length;i++){
            if(sizearray[i]!=""){
            $(".sizeselect").append("<option value='"+sizearray[i]+"'>"+sizearray[i]+"</option>");
            }
        }
    }
    else{
       $(".size").hide(); 
    }
     color=$(this).attr("data-color");
    if(color!=""){
        $(".colorselect").empty();
    $(".color").show(); 
    
     var colorarray = color.split(',');
     
   $(".colorselect").append("<option value='Default'>Select Color</option>");
    for(j=0;j<colorarray.length;j++){
        if(colorarray[i]!=""){
        $(".colorselect").append("<option value='"+colorarray[j]+"'>"+colorarray[j]+"</option>");
        }
    }
    }
    else{
       $(".color").hide(); 
    }
  
    $("#quickmodel").css("display","block"); 
});

$(".close").click(function(){
    $("#quickmodel").css("display","none"); 
});

// $(document).click(function (event) 
// {
//   if(!$(event.target).closest('#quickmodel').length && !$(event.target).is('#quickmodel')) {
//       $("#quickmodel").css("display","none"); 
//   }     
// });

// window.onclick = function(event) {
//   if (event.target == modal) {
//     modal.style.display = "none";
//   }
// }
// // Get the modal
// var modal = document.getElementById("myModal");

// // Get the button that opens the modal
// var btn = document.getElementsByClassName("myBtn");

// // Get the <span> element that closes the modal
// var span = document.getElementsByClassName("close")[0];

// // When the user clicks the button, open the modal 
// btn.onclick = function() {
//   modal.style.display = "block";
// }

// // When the user clicks on <span> (x), close the modal
// span.onclick = function() {
//   modal.style.display = "none";
// }

// // When the user clicks anywhere outside of the modal, close it
// window.onclick = function(event) {
//   if (event.target == modal) {
//     modal.style.display = "none";
//   }
// }
</script>
