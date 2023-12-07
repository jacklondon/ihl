<?php 
$gelen_id = re('id');
$table = re('q');
?>

<?php 
    mysql_query("update $table set status = 2 where id = '".$gelen_id."'");
    echo '<script>javascript:history.go(-1)</script>';
?>
