<?php
//$product_reviews = getValues('cms_reviews', '*', "product_id='" . $product->product_id . "' AND `status`='1' ORDER BY `posted_date_time` DESC", TRUE);

/*$total_reviews = count($product_reviews);
if (count($product_reviews) > 0) {
    foreach ($product_reviews as $reviews) {
        $total_review_points += $reviews->score;

    }
}*/
$product_ratting = '';
$total_reviews = 30;
$total_review_points = 100;

$rate = round(($total_review_points / ($total_reviews * 5)) * 5);
for ($i = 1; $i <= 5; $i++) {
    if ($i <= $rate) {
        $product_ratting .= '<img align="" src="' . template_url('assets/img/small-star.png') . '" alt="' . $i . '"/>';
    } else {
        $product_ratting .= '<img align="" src="' . template_url('assets/img/small-blank-star.png') . '" alt="' . $i . '"/>';
    }
}
echo $product_ratting . ' <span class="count-reviews">' . $total_reviews . ' Reviews</span>';
?>