<?php
$reviews = $product_reviews['reviews'];
$total_recommend = 0;
if (count($reviews) > 0) {
    foreach ($reviews as $review) {
        if($review->recommend == 'Yes') $total_recommend++;
    }
}
?>
<div class="container">
    <hr>
    <div class="col-sm-7">
        <h3>Reviews (<?php echo number_format(count($reviews));?>)</h3>
        <?php
        $reviews = $product_reviews['reviews'];
        if(count($reviews) > 0){
            foreach ($reviews as $review) {
                ?>
                <div class="reviewww">
                    <span class="star-rating"></span>
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
                    <span class="review-author"><?php echo $review->nickname; ?></span>
                    <span class="review-date"><?php echo mysql2date($review->posted_date_time); ?></span>

                    <div class="review_text">
                        <p><?php echo stripslashes($review->review); ?></p>
                    </div>
                </div>

                <?php
            }
        }
        ?>
    </div>

    <!-- submit review-->
    <div class="col-sm-5">
        <h3>Submit a Review</h3>
        <form class="review_form" method="post" action="<?php echo site_url('product_catalog/submit_reviews'); ?>">
            <input type="hidden" name="brand_id" id="brand_id" value="<?php echo $product->brand_id; ?>"/>
            <input type="hidden" name="product_id" id="product_id" value="<?php echo $product->id; ?>"/>

            <div class="form-group">
                <label for="name">Your Name</label>
                <input type="text" name="nickname" class="form-control">
            </div>
            <div class="form-group">
                <label for="email">Your Email Address</label>
                <input type="text" name="email" class="form-control">
            </div>

            <div class="form-group">
                <?php
                if(count($product_rating_types) > 0){
                    echo '<ul class="rating_types">';
                    foreach($product_rating_types as  $rating_types){
                        ?>
                        <li>
                            <h4><?php echo $rating_types->rating_name;?></h4>
                            <div class="rating-types" data-field="score[<?php echo $rating_types->id;?>]" data-readonly="false" data-score="0" id="rating-<?php echo url_title($rating_types->rating_name,'-', true);?>"></div>
                        </li>
                        <?
                    }
                    echo '</ul>';
                }
                ?>
            </div>

            <div class="form-group">
                <label for="email">Comments</label>
                <textarea name="review" class="form-control" cols="20" rows="5"></textarea>
            </div>



            <!--<div class="rat_radio">
                <label class="form-check-label">
                    <input class="form-check-input" type="radio" name="rating" value="option1"> 1
                </label>

                <label class="form-check-label">
                    <input class="form-check-input" type="radio" name="rating" value="option1"> 2
                </label>

                <label class="form-check-label">
                    <input class="form-check-input" type="radio" name="rating" value="option1"> 3
                </label>
            </div>-->

            <div class="clearfix"></div>
            <div class="minigap"></div>
            <button type="submit" class="btn btn-secondary btn-lg">Submit Review</button>
        </form>
    </div>
</div>