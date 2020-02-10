<?php
require_once "../../core/init.php";

$id=sanitize($_POST['id']);

$order_query=$db->query("SELECT * FROM orders WHERE id='$id'");

$orders_result=mysqli_fetch_assoc($order_query);

$eatin_orders=json_decode($orders_result['items'], true);
$takeout_orders=json_decode($orders_result['takeout_items'],true);