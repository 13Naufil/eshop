<?php
/**
 * Developed by Naufil khan.
 * Email: developer.systech@gmail.com
 * Autour: Naufil khan
 * Date: 9/5/2019
 * Time: 9:34 PM
 */
?>
<ul>
    <li><?php echo $billing->full_name; ?></li>
    <li><a href="mailto:<?php echo $billing->email; ?>"><?php echo $billing->email; ?></a></li>
    <?php
    $address = explode(',', $billing->address);
    foreach ($address as $add) {
        echo '<li>' . trim($add) . '</li>';
    }
    ?>
    <li><a href="tel:<?php echo $billing->phone; ?>"><?php echo $billing->phone; ?></a></li>
</ul>
