<?php
require_once "core/init.php";
include "includes/head.php";

if (isset($_SESSION['order'])&&!empty($_SESSION['order'])) {
	$or_id=sanitize($_SESSION['order']);
	$check_query=$db->query("SELECT * FROM orders WHERE id='$or_id' AND order_status=3 OR order_status=0");
	$check=mysqli_num_rows($check_query);
}



if (isset($_POST['submit'])) {
////////////////////////////////////
	$post_array=array();
	$new_quantity=array();
	foreach ($_POST as $po) {
		$post_array[]=$po;
	}
	$array_size=sizeof($post_array)-1;
	for($i=0;$i<$array_size;$i++){
		$new_quantity[]=$post_array[$i];
	}

	
///////////////////////////////////////
	$order_id=sanitize($_SESSION['order']);
	$order_query=$db->query("SELECT * FROM orders WHERE id='$order_id' AND order_status=3");
	$order=mysqli_fetch_assoc($order_query);

	$items=json_decode($order['items'],true);

	$index=0;
	$new_items=array();
	foreach($items as $item){
		$new_items[$index]['item_id']=$item['item_id'];
		$new_items[$index]['quantity']=$new_quantity[$index];
		$new_items[$index]['custom_id']=$item['custom_id'];
		$index++;
	}
	$new_items=json_encode($new_items);
	
	$db->query("UPDATE orders SET items='$new_items', order_status=0 WHERE id='$order_id' AND order_status=3");
	header('Location: review');
}

?>
<div class="container-fluid">
	<div class="row" style="padding: 10px; background-color: #fff">
		<div class="col-md-1 col-sm-1 col-xs-1 pull-left" style="padding: 5px">
				<a id="back"><i class="fa fa-arrow-left" style="font-size: 25px; color: red;"></i></a>
		</div>
		<div class="col-md-10 col-sm-10 col-xs-10 text-center" style="padding: 5px">
				<h3 class="text-center" style="color: red;"><b>Review</b></h3>
		</div>

		<div class="col-md-1 col-sm-1 col-xs-1 " style="padding: 5px">
			<a href="#">
				<i class="fa fa-bars" onclick="review();" style="font-size: 25px; color: red;"></i>
			</a>
		</div>
	</div>
	<form action="review" method="post" enctype="multipart/form-data">
	<div class="row text-center" style="padding-top: 10px">
		<?php
		if (isset($_SESSION['order'])&&($check>0)) {
			$order_id=sanitize($_SESSION['order']);
			$order_query=$db->query("SELECT * FROM orders WHERE id='$order_id' AND order_status=0 OR order_status=3");
			$order=mysqli_fetch_assoc($order_query);
			$order_array=json_decode($order['items'],true);

			$index=1;
			foreach($order_array as $order): 
			$item_id=$order['item_id'];
			$quantity=$order['quantity'];
			$custom_id=$order['custom_id'];
			$item_query=$db->query("SELECT * FROM menu WHERE id='$item_id'");
			$item=mysqli_fetch_assoc($item_query);

		?>
		<div class="col-md-12 review">
			<div class="row" style="padding: 5px">
				<div class="col-md-4 col-sm-4 col-xs-4">
					<div style="border: 3px solid rgba(252,84,4,1);width:86px; height:auto ; margin: 0% auto; border-radius: 50%; overflow: hidden;">
						<img src="<?=$item['item_pic'];?>" style="width: 80px; height: 80px;">
					</div>
					
				</div>
				<div class="col-md-5 col-sm-5 col-xs-5 text-center">
					<h5><b><?=$item['item_name'];?></b></h5>

					<div class="input-group bootstrap-touchspin">
						<span class="input-group-btn" onclick="decrement(<?=$index;?>)">
							<button class="btn btn-white bootstrap-touchspin-down" type="button" style="color:red;"><b>-</b></button>
						</span>
						<span class="input-group-addon bootstrap-touchspin-prefix" style="display: none;"></span>
						<input class="touchspin1 form-control text-center" id="quan<?=$index;?>" type="text" value="<?=$quantity;?>" name="demo<?=$index;?>" style="color: black;">
						<span class="input-group-addon bootstrap-touchspin-postfix" style="display: none;"></span>
						<span class="input-group-btn" onclick="increment(<?=$index;?>);">
							<button class="btn btn-white bootstrap-touchspin-up" type="button" style="color:red;">
								<b>+</b>
							</button>
						</span>
					</div>

				</div>
				<div class="col-md-3 col-sm-3 col-xs-3">
					<div class="text-right">
						<!--<a href="customize.php?customize=<?=($custom_id=='none')?$item_id : $item_id.'&custom='.$custom_id;?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-pencil" style="color: red"></span></a>-->
						<a href="review" onClick="return confirm('Delete This Product?')" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-remove" style="color: red"></span></a>
					</div>
				</div>
			</div>		
		</div>
		<?php 
		$index++;
		endforeach;?>
	</div>

	<div class="row" style="padding-top: 15px;padding-bottom: 15px">
		<div class="col-md-6 col-sm-6 col-xs-6">
			<a href="customize?customize=<?=(isset($_GET['custom']))?$item_id.'&custom='.$custom_id : $item_id;?>" class="btn btn-success form-control" style="background-color: rgba(252,84,4,1);color:white; border-radius: 3px;">BACK TO MENU</a>
		</div>
		<div class="col-md-6 col-sm-6 col-xs-6">
			<button type="submit" name="submit" class="btn btn-danger form-control" style="background-color: rgba(252,84,4,1);color:white;border-radius: 3px;">FINISH ORDER</button>
		</div>
	</div>
</form>
</div>
<?php
 }else{?>
 	<div class="row" style="padding-top: 10px;color: red;">
		<h3 class="text-center"><b>No Orders Yet</b></h3>
	</div>

	<div class="row" style="padding-top: 15px;padding-bottom: 15px">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<a href="index" class="btn btn-success form-control" style="background-color: rgba(252,84,4,1);color:white; border-radius: 3px;">BACK TO MENU</a>
		</div>
		
	</div>

 <?php } include "includes/footer.php";?>

