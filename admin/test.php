<?php
require_once "../core/init.php";

$current_date=date("Y-m-d");
$takeout_query=$db->query("SELECT * FROM orders WHERE (takeout_status=1 OR takeout_status=0) AND order_date LIKE '$current_date%'");
$total_takeout=0;
while ($takeout_stat=mysqli_fetch_assoc($takeout_query)) {
	$items=json_decode($takeout_stat['takeout_items'],true);

	$total_takeout+=orders_quantity_parser($items);
}
var_dump($total_takeout);