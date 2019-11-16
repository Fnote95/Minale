<?php
require_once "../../core/init.php";
$order_queued_query=$db->query("SELECT * FROM orders WHERE order_status=0");
$take_queued_query=$db->query("SELECT * FROM orders WHERE  takeout_status=3");
$eatin_num=mysqli_num_rows($order_queued_query);
$takeout_num=mysqli_num_rows($take_queued_query);
$num_array=array();
$num_array[0]=$eatin_num;
$num_array[1]=$takeout_num;
ob_start();?>
<?=$num_array[0].','.$num_array[1];?>
<?php echo ob_get_clean();?>