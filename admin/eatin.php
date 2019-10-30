<?php

require_once "../core/init.php";
include "includes/head.php";

///////////to handle when the done button is pressed//////////
if ((isset($_GET['done'])&&!empty($_GET['done']))) {
	$done_id=sanitize($_GET['done']);
	$wait_time=sanitize($_GET['time']);
	$end_query=$db->query("SELECT * FROM orders WHERE id='$done_id'");
	$end_result=mysqli_fetch_assoc($end_query);
	if ($end_result['takeout_items']=='""') {
		$db->query("UPDATE orders SET order_status=2, takeout_status=2, wait_time='$wait_time' WHERE id='$done_id'");
	}
	else{
		$db->query("UPDATE orders SET order_status=2, wait_time='$wait_time' WHERE id='$done_id'");
	}
	
	header('Location: eatin.php');
}
//////////////////////////////////////////////////////////////

////////////check to see how many orders are being processed//////////////////////
$empty="";
$order_processed_num_query=$db->query("SELECT * FROM orders WHERE order_status=1 AND items!='$empty'");
$order_processed_num=mysqli_num_rows($order_processed_num_query);
//////////////////////////////////////////////////////////////////////////////////
if (isset($_GET['add'])&&!empty($_GET['add'])) {
	$add_id=sanitize($_GET['add']);
	$sess_query=$db->query("SELECT * FROM orders WHERE id='$add_id'");
	$sess=mysqli_fetch_assoc($sess_query);
	$sess_id=$sess['session_id'];
	$add_query=$db->query("UPDATE orders SET order_status=1 WHERE id='$add_id'");
	end_session($sess_id);
	header("Location: eatin");

}
////////Update the mini status when the finish button is clicked////////////////////////////////
if(isset($_GET['finish'])&&!empty($_GET['finish'])){
	$order_id=sanitize($_GET['finish']);
	$processed_id=sanitize($_GET['item']);
	$finish_order_query=$db->query("SELECT * FROM orders WHERE id='$order_id'");
	$finish_result=mysqli_fetch_assoc($finish_order_query);
	$finish_items=json_decode($finish_result['items'],true);
	//var_dump($finish_items);
	$finish_items[$processed_id]['mini_status']=1;
	//var_dump($finish_items[$processed_id]['mini_status']);
		/*$check=1;
		foreach($finish_items as $fin_item){
			if ($check==$processed_id) {
				$finish_items[]['mini_status']=1;
				break;
			}
			$check++;
		}*/
	$finish_items=json_encode($finish_items);
	var_dump($finish_items);
	$db->query("UPDATE orders SET items='$finish_items' WHERE id='$order_id'");
	header('Location: eatin');
}
////////////////////////////////////////////////////////////////////////////////////
///////////to add orders from the queued section to the processing section//////////
/*if ($order_processed_num<5) {
	$limit=5-$order_processed_num;
	
	$limit_select_query=$db->query("SELECT * FROM orders WHERE order_status=0 LIMIT ".$limit);
	//echo mysqli_num_rows($limit_select_query);
	while($orders_processed_result=mysqli_fetch_assoc($limit_select_query)):
		$sess_id=$orders_processed_result['session_id'];
		$or_id=$orders_processed_result['id'];
		$db->query("UPDATE orders SET order_status=1 WHERE id='$or_id'");
		end_session($sess_id);
	endwhile;
}*/
/////////////////////////////////////////////////////////////////////////////////////

/////////////////queries to display orders on the queued and processed sections////////
$order_queued_query=$db->query("SELECT * FROM orders WHERE order_status=0");
$order_processed_query=$db->query("SELECT * FROM orders WHERE order_status=1");
//$queued_js_index=8;
$process_js_index=8;

?>
<div class="container-fluid">
<div class="row" style="padding-top: 75px; padding-bottom: 50px;">
	
	<div class="col-md-6" id="ord">



	</div>

	<div class="col-md-6" id="pro">


		
	</div>
</div>

<?php 
include "includes/footer.php";
include "includes/navigation.php";
?>