<?php
require_once "core/init.php";
include "includes/head.php";


if (isset($_GET['item'])&&!empty($_GET['item'])) {
	$item_id=sanitize($_GET['item']);

	$item_query=$db->query("SELECT * FROM menu WHERE id='$item_id'");

	$item=mysqli_fetch_assoc($item_query);
	$item_name=$item['item_name'];
	$item_pic=$item['item_pic'];
	$item_price=$item['price'];
	$item_composition=json_decode($item['composition'],true);
	$orders_array=array();
	//var_dump($item_composition);
	////////////////check to see if the user already customized
	if (isset($_GET['custom'])&&!empty($_GET['custom'])) {
		$custom_id=sanitize($_GET['custom']);
		$custom_query=$db->query("SELECT * FROM customize WHERE id='$custom_id'");
		$custom_array=mysqli_fetch_assoc($custom_query);
		$item_composition=json_decode($custom_array['composition'],true);
	}

}

if (isset($_POST['submit'])) {
	$orders_array[0]['item_id']=$item_id;
	$orders_array[0]['quantity']=sanitize($_POST['quantity']);
	$orders_array[0]['custom_id']=(isset($_GET['custom']))? $custom_id : 'none';
	$session_id=session_id();
	$orders_json=json_encode($orders_array,true);

	
	if (isset($_SESSION['order'])) {
		$order_id=sanitize($_SESSION['order']);
		$o_query=$db->query("SELECT * FROM orders WHERE id='$order_id'");
		$orders_list=mysqli_fetch_assoc($o_query);
		$orders_session=json_decode($orders_list['items'],true);
		$orders_json=json_encode(array_merge($orders_session,$orders_array));
		$db->query("UPDATE orders SET items='$orders_json' WHERE id='$order_id'");

	}
	else{
		$db->query("INSERT INTO orders (items,session_id) VALUES ('$orders_json','$session_id')");
		$order_id=$db->insert_id;
		$_SESSION['order']=$order_id;
	}

}
?>
<div class="container-fluid">
<div class="row" style="padding-top: 20px; padding-left: 5px ">
	<div class="col-md-2 col-sm-2 col-xs-2">
		<img src="images.jpg" alt="Logo" style="width: 50; height: 50px">
	</div>
</div>
<form action="details?item=<?=(isset($_GET['custom']))?$item_id.'&custom='.$custom_id : $item_id;?>" method="post" enctype="multipart/form-data">
	<div class="row" style="padding-top: 5px">
		<div class="col-md-12 col-sm-12 col-xs-12 text-center">
			<img src="images/item_image/hamburger.jpg" alt="Logo" style="width: 200px; height: 200px;">
		</div>
		<div class="col-md-6 col-sm-6 col-xs-6">
			<h4 class="text-center"><b>Composition</b></h4>
			<ul>
				<?php foreach ($item_composition as $comp): ?>
					<li><?=$comp['quantity'].' '.$comp['comp'];?></li>
				<?php endforeach;?>
			</ul>
		</div>		
		<div class="col-md-6 col-sm-6 col-xs-6">
			<h4 class="text-center"><b>Quantity</b></h4>
			<input type="number" name="quantity" class="form-control">
			<h4 class="text-center"><b>Price</b></h4>
			<h4 class="text-center" style="color: green;"><?=cash($item_price);?></h4>
		</div>
	</div>
	<div class="row" style="padding: 15px">
		<div class="col-md-6 col-sm-6 col-xs-6">
			<a href="customize?customize=<?=(isset($_GET['custom']))?$item_id.'&custom='.$custom_id : $item_id;?>" class="btn btn-success form-control">Customize</a>
		</div>
		<div class="col-md-6 col-sm-6 col-xs-6">
			<button type="submit" name="submit" class="btn btn-danger form-control">Add to order</button>
		</div>
	</div>
</form>
</div>