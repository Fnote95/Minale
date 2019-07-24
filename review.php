
<?php
require_once "core/init.php";
include "includes/head.php";

if (isset($_SESSION['order'])) {
	$order_id=sanitize($_SESSION['order']);
	$order_query=$db->query("SELECT * FROM orders WHERE id='$order_id' AND order_status=3");
	$order=mysqli_fetch_assoc($order_query);
	$order_array=json_decode($order['items'],true);

//var_dump($order_array);
?>
<div class="container-fluid">
 	<div class="row" style="padding-top: 20px;">
		<div class="col-md-2 col-sm-2 col-xs-2">
			<img src="images.jpg" alt="Logo" style="width: 50; height: 50px">
		</div>
		<div class="col-md-10 col-sm-10 col-xs-10">
			<h3>&nbsp&nbsp&nbsp&nbsp<b>Review</b></h3>
		</div>
	</div>
	<div class="row text-center" style="padding-top: 20px">
		<?php foreach($order_array as $order): 
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
					<div class="input-group bootstrap-touchspin"><span class="input-group-btn"><button class="btn btn-white bootstrap-touchspin-down" type="button" style="color:red;"><b>-</b></button></span><span class="input-group-addon bootstrap-touchspin-prefix" style="display: none;"></span><input class="touchspin1 form-control" type="text" value="<?=$quantity;?>" name="demo1" style="display: block;"><span class="input-group-addon bootstrap-touchspin-postfix" style="display: none;"></span><span class="input-group-btn"><button class="btn btn-white bootstrap-touchspin-up" type="button" style="color:red;"><b>+</b></button></span></div>
				</div>
				<div class="col-md-3 col-sm-3 col-xs-3">
					<div class="text-right">
						<a href="customize.php?customize=<?=($custom_id=='none')?$item_id : $item_id.'&custom='.$custom_id;?>" class="btn btn-xs btn-success"><span class="glyphicon glyphicon-pencil"></span></a>
						<a href="review" onClick="return confirm('Delete This Product?')" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-remove"></span></a>
					</div>
				</div>
			</div>		
		</div>
		<?php endforeach; }?>
	</div>
<div class="row" style="padding: 15px">
	<div class="col-md-6 col-sm-6 col-xs-6">
		<a href="customize.php" class="btn btn-success form-control">Back to Menu</a>
	</div>
	<div class="col-md-6 col-sm-6 col-xs-6">
		<a href="#"  class="btn btn-danger form-control">Finish order</a>
	</div>
</div>
</div>

