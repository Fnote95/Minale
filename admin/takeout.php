<?php
require_once "../core/init.php";
include "includes/head.php";


//////////handle when the done button is pressed///////
if ((isset($_GET['done'])&&!empty($_GET['done']))) {
	$done_id=sanitize($_GET['done']);
	$wait_time=sanitize($_GET['time']);
	$end_query=$db->query("SELECT * FROM orders WHERE id='$done_id'");
	$end_result=mysqli_fetch_assoc($end_query);
	$sess_id=$end_result['session_id'];
	if ($end_result['items']=='""') {
		$db->query("UPDATE orders SET order_status=2, takeout_status=2, wait_time='$wait_time' WHERE id='$done_id'");
	}
	else{
		$db->query("UPDATE orders SET takeout_status=2, wait_time='$wait_time' WHERE id='$done_id'");
	}
	
	end_session($sess_id);
	header('Location: takeout.php');
}
///////////////////////////////////////////////////////////
if(isset($_GET['finish'])&&!empty($_GET['finish'])){
	$order_id=sanitize($_GET['finish']);
	$processed_id=sanitize($_GET['item']);
	$finish_order_query=$db->query("SELECT * FROM orders WHERE id='$order_id'");
	$finish_result=mysqli_fetch_assoc($finish_order_query);
	$finish_items=json_decode($finish_result['takeout_items'],true);

	$finish_items[$processed_id]['mini_status']=1;

	$finish_items=json_encode($finish_items);
	
	$db->query("UPDATE orders SET takeout_items='$finish_items' WHERE id='$order_id'");
	header('Location: takeout');
}
////////////////////////////////////////////////////////////////////////

$order_queued_query=$db->query("SELECT * FROM orders WHERE takeout_status=0 OR takeout_status=3");

$process_js_index=8;
?>
<div class="container-fluid">
<div class="row" style="padding-top: 75px; padding-bottom: 50px;">
	<div class="col-md-8" id="take_out">
		

	</div>
</div>
</div>
<?php include "includes/navigation.php";
include "includes/footer.php";
?>