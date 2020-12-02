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
    <li><?php echo $shipping->full_name; ?></li>
    <li><a href="mailto:<?php echo $shipping->email; ?>"><?php echo $shipping->email; ?></a></li>
    <?php
    $address = explode(',', $shipping->address);
    foreach ($address as $add) {
        echo '<li>' . trim($add) . '</li>';
    }
    ?>
    <li><a href="tel:<?php echo $shipping->phone; ?>"><?php echo $shipping->phone; ?></a></li>
</ul>