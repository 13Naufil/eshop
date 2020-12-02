<?php
$reviews = $product_reviews['reviews'];
$total_recommend = 0;
if (count($reviews) > 0) {
    foreach ($reviews as $review) {
        if($review->recommend == 'Yes') $total_recommend++;
    }
}
?>
<div class="row">
    <div class="col-sm-12">
        <h2><?php echo number_format(count($reviews));?> Reviews</h2>
    </div>
    <div class="">
        <div class="col-sm-4">
            <div class="overall-rating"></div>
            <p><?php echo number_format(($total_recommend * 100) / count($reviews),2);?>% recommend this item</p>
        </div>
        <div class="col-sm-8">
            <?php
            if(count($product_rating_types) > 0){
                echo '<ul class="rating_types">';
                foreach($product_rating_types as  $rating_types){
                    ?>
                    <li>
                        <h4><?php echo $rating_types->rating_name;?></h4>
                        <div class="rating-types" data-readonly="true" data-score="<?php echo $rating_types->total_score;?>" id="rating-<?php echo url_title($rating_types->rating_name,'-', true);?>"></div>
                    </li>
                    <?
                }
                echo '</ul>';
            }
            ?>
        </div>
    </div>
    <p>&nbsp;</p>
    <div class="">
        <div class="col-sm-6">
            <a href="javascript: void(0);" data-toggle="modal" data-target="#write-review-modal" class="btn btn-app review_btn recommend display-block"><span>Write a review</span></a>
        </div>
        <div class="col-sm-6 text-right">
            <!--<button class="btn btn-default btn-large"><strong>sort by <span class="caret"></span></strong></button>-->
        </div>
    </div>
</div>
<hr class="sm">
<div class="row">
    <?php
    $reviews = $product_reviews['reviews'];
    if(count($reviews) > 0){
        foreach ($reviews as $review) {
            ?>
            <div class="clearfix">
                <div class="col-sm-8" style="border-right: 1px solid #eee;">
                    <div class="review">
                        <h3><?php echo $review->title; ?></h3>
                        <p>
                            <i class="glyphicon glyphicon-ok"></i> <span class="text-uppercase">Yes i recommend this product</span>
                        </p>
                        <p style="height: 5px;">&nbsp;</p>

                        <p><?php echo stripslashes($review->review); ?></p>
                    </div>
                </div>
                <div class="col-sm-4">
                    <p><?php echo mysql2date($review->posted_date_time); ?></p>
                    <p>Posted By: <strong><i><?php echo $review->nickname; ?></i></strong> </p>
                    <p>&nbsp;</p>
                    <?php
                    $reviews_rating = $this->catalog->product_rating_types("AND product_reviews.review_id='{$review->review_id}'");
                    if(count($reviews_rating) > 0){
                        foreach($reviews_rating as $r_rating){
                            ?>
                            <div>
                                <strong><?php echo $r_rating->rating_name;?></strong> <small><?php echo number_format($r_rating->total_score,2);?> / 5</small>
                                <div class="rating-types inline pull-right" data-readonly="true" data-score="<?php echo $r_rating->total_score;?>"></div>
                            </div>
                            <hr class="sm" style="margin: 4px auto">
                            <?
                        }
                    }
                    ?>
                </div>
            </div>
            <hr class="sm">
        <?php
        }
    }
    ?>
</div>

<?php
include "review_form.php";
?>