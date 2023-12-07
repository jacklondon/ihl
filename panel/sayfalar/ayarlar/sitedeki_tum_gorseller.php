<?php
$dirname = "../images/";
$images = glob($dirname."*.png");


foreach($images as $image) { ?>

   <img src=<?= $image ?> style="width: 32%; height:150px; margin:2px;" />
 <?php }
?>

