<?php

require_once "../core/init.php";
include "includes/head.php";

///////////to handle when the done button is pressed//////////
if ((isset($_GET['done'])&&!empty($_GET['done']))) {
	$done_id=sanitize($_GET['done']);

	$db->query("UPDATE orders SET order_status=2 WHERE id='$done_id'");
	header('Location: eatin.php');
}
//////////////////////////////////////////////////////////////

////////////check to see how many orders are being processed//////////////////////
$order_processed_num_query=$db->query("SELECT * FROM orders WHERE order_status=1");
$order_processed_num=mysqli_num_rows($order_processed_num_query);
//////////////////////////////////////////////////////////////////////////////////

///////////to add orders from the queued section to the processing section//////////
if ($order_processed_num<5) {
	$limit=5-$order_processed_num;
	
	$limit_select_query=$db->query("SELECT * FROM orders WHERE order_status=0 AND order_type=1 LIMIT ".$limit);
	//echo mysqli_num_rows($limit_select_query);
	while($orders_processed_result=mysqli_fetch_assoc($limit_select_query)):
		$sess_id=$orders_processed_result['session_id'];
		$or_id=$orders_processed_result['id'];
		$db->query("UPDATE orders SET order_status=1 WHERE id='$or_id'");
		end_session($sess_id);
	endwhile;
}
/////////////////////////////////////////////////////////////////////////////////////

/////////////////queries to display orders on the queued and processed sections////////
$order_queued_query=$db->query("SELECT * FROM orders WHERE order_status=0 AND order_type=1");
$order_processed_query=$db->query("SELECT * FROM orders WHERE order_status=1 AND order_type=1");
//$queued_js_index=8;
$process_js_index=8;

?>
<div class="container-fluid">
<div class="row" style="padding-top: 75px; padding-bottom: 50px;">
	
	<div class="col-md-6" id="ord">



	</div>

	<div class="col-md-6" id="pro">
		<h2 class="text-center"><b>Orders Being Processed</b></h2>
		<?php while($order_processed=mysqli_fetch_assoc($order_processed_query)): 
			$cust_array=json_decode($order_processed['items'],true);
			$cust_check=0;
			foreach ($cust_array as $cust) {
				if ($cust['custom_id']!='none') {
					$cust_check++;
				}
			}?>
			<div class="col-md-12" style="padding:10px; margin: 15px; background-color: #f9f9f9; border: 1px solid #f0f0f0;box-shadow: 0 1px 4px 0 rgba(0, 0, 0, 0.14);">
				<div class="col-md-12" style="border-bottom: 1px solid #d8d8d8">
					 <div class="col-md-2"><h4 style="color: red"><b>#<?=$order_processed['id'];?></b></h4></div>
						<div class="col-md-3"><h5><b>Table No. <?=$order_processed['table_no'];?></b></h5></div>
					<div class="col-md-4"><h5 style="color: green"><b><?=($cust_check>0)? $cust_check.' Customized orders':'All Regular';?></b></h5></div>
				</div>
			<div class="col-md-12" style="padding: 5px">
				<?php
    				$items_array=json_decode($order_processed['items'],true);
    				$num=1;
    				foreach($items_array as $items):
    					
    					$items_id=$items['item_id'];
    					$items_query=$db->query("SELECT * FROM menu WHERE id='$items_id'");
    					$menu_item=mysqli_fetch_assoc($items_query);
    					$custom_id=$items['custom_id'];
    					$custom_query=$db->query("SELECT * FROM customize WHERE id='$custom_id'");
    					$custom=mysqli_fetch_assoc($custom_query);
    					$custom_items=json_decode($custom['composition'],true);
    			?>
					<div class="col-md-4 col-sm-4 text-center">
						<img src="<?='../'.$menu_item['item_pic'];?>" class="image" style="width:50px; height:50px">
						<h5><b><?=$menu_item['item_name'];?> <span style="color: red">X <?=$items['quantity'];?></b></span></h5>
						<p style="color: green"><b><?=($items['custom_id']=='none')?'Regular':'Customized';?></b></p>
						<?php 
	        				if ($items['custom_id']=='none') {
	        				}
	        				else{
	        				?>
	        				<table class="table table-striped">
	        					<thead>
	        				
	        					</thead>
	        					<tbody>
	        						<?php foreach($custom_items as $cus_items): ?>
	        						<tr>
	        							
	        								<td><?=$cus_items['comp'];?></td>
	        								<td><?=$cus_items['quantity'];?></td>
	        							
	        						</tr>
	        						<?php endforeach; ?>
	        					</tbody>
	        				</table>
	        				<?php }?>
					</div>
				<?php endforeach;?>
				<div class="col-md-12 col-sm-12 col-xs-12 text-center">
					<a href="eatin?done=<?=$order_processed['id'];?>" onClick="return confirm('Are you sure you are done?')" class="btn btn-primary" >Done</a>
				</div>
			</div>
		</div>

	<?php endwhile;?>
</div>
</div>

<?php 
include "includes/footer.php";
include "includes/navigation.php";
?>