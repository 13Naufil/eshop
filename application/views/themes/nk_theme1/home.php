<?php
$right = $this->db->query("SELECT * FROM teaser_boxes WHERE teaser_boxes.position = 'right' AND teaser_boxes.status = 'Active'")->row();

$left_top_1 = $this->db->query("SELECT * FROM teaser_boxes WHERE teaser_boxes.position = 'left' AND teaser_boxes.type = 'Homepage-top-images' AND teaser_boxes.status = 'Active' AND ordering = 1")->row();
$left_top_2 = $this->db->query("SELECT * FROM teaser_boxes WHERE teaser_boxes.position = 'left' AND teaser_boxes.type = 'Homepage-top-images' AND teaser_boxes.status = 'Active' AND ordering = 2")->row();

$left_bottom_1 = $this->db->query("SELECT * FROM teaser_boxes WHERE teaser_boxes.position = 'left' AND teaser_boxes.type = 'Homepage-bottom-images' AND teaser_boxes.status = 'Active' AND ordering = 1")->row();
$left_bottom_2 = $this->db->query("SELECT * FROM teaser_boxes WHERE teaser_boxes.position = 'left' AND teaser_boxes.type = 'Homepage-bottom-images' AND teaser_boxes.status = 'Active' AND ordering = 2")->row();

?>
<Style>
     @media (max-width: 768px){
               
           .hidden-xs{
               display:none;
           }
           .left-child{
               width:50%;
           }
           
            }
</Style>
<div id="shopify-section-grid-section" class="shopify-section">
    <div class="main-section-grid">
        <div class="left-grid">
            <div class="left-child">
                <div class="animate"><a href="<?php echo $left_top_1->link ?>"><img src="<?php echo asset_url('front/teaser_boxes/'.$left_top_1->image)?>" alt="" /></a></div>
                <div class="cstm_btn"><span><?php echo $left_top_1->title; ?></span> <button class="btn" type="button">Shop Now</button></div>
            </div>
            <div class="left-child">
                <div class="animate"><a href="<?php echo $left_top_2->link ?>"><img src="<?php echo asset_url('front/teaser_boxes/'.$left_top_2->image)?>" alt="" /></a></div>
                <div class="cstm_btn"><span><?php echo $left_top_2->title; ?></span> <button class="btn" type="button">Shop Now</button></div>
            </div>
            <div class="left-child">
                <div class="animate"><a href="<?php echo $left_bottom_1->link ?>"><img src="<?php echo asset_url('front/teaser_boxes/'.$left_bottom_1->image)?>" alt="" /></a></div>
                <div class="cstm_btn"><span><?php echo $left_bottom_1->title; ?></span> <button class="btn" type="button">Shop Now</button></div>
            </div>
            <div class="left-child ">
                <div class="animate"><a href="<?php echo $left_bottom_2->link ?>"><img src="<?php echo asset_url('front/teaser_boxes/'.$left_bottom_2->image)?>" alt="" /></a></div>
                <div class="cstm_btn"><span><?php echo $left_bottom_2->title; ?></span> <a class="btn" >Shop Now</a></div>
            </div>
        </div>
        <div class="right-grid">
            <div class="right-child">
                <div class="animate"><a href="<?php echo $right->link ?>"><img src="<?php echo asset_url('front/teaser_boxes/'.$right->image)?>" alt="" /></a></div>
                <div class="cstm_btn"><span><?php echo $right->title; ?></span> <button class="btn" type="button">Shop Now</button></div>
            </div>
        </div>
    </div>
</div>
