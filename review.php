<?php
require_once "core/init.php";
include "includes/head.php";
if (!isset($_SESSION['type'])) {
	header('Location: index.php');
}


if (isset($_SESSION['order'])&&!empty($_SESSION['order'])) {
	$or_id=sanitize($_SESSION['order']);

	$check_query=$db->query("SELECT * FROM orders WHERE id='$or_id' AND (order_status=3 OR order_status=0)");
	$check=mysqli_num_rows($check_query);
	$check2=mysqli_fetch_assoc($check_query);
}
if (isset($_GET['del_eatin'])) {
	$delete_id=sanitize($_GET['del_eatin']);

	$order_query_delete=$db->query("SELECT * FROM orders WHERE id='$or_id'");
	$order_delete=mysqli_fetch_assoc($order_query_delete);
	$order_json_delete=json_decode($order_delete['items'],true);
	array_splice($order_json_delete, $delete_id,1);

	$order_json_delete=json_encode($order_json_delete);
	if ($order_json_delete=="[]") {
		$order_json_delete='""';
	}

	$db->query("UPDATE orders SET items='$order_json_delete' WHERE id='$or_id' AND (order_status=3 OR order_status=0)");
	header('Location: review');
	
}



if (isset($_POST['submit'])) {
////////////////////////////////////
	if (!isset($_SESSION['order'])) {
		header('Location: review');
	}
	else{
	$table_no=$_POST['table_no'];
	$errors=array();
	if($table_no==''){
		$errors[]='You must enter your table number!';
	}
	
	$post_array=array();
	$new_quantity=array();
	foreach ($_POST as $po) {
		$post_array[]=$po;
	}
	$array_size=sizeof($post_array)-2;
	if ($array_size==0) {
		$errors[]='You must add orders first! There are no orders yet!';
	}
	for($i=0;$i<$array_size;$i++){
		$new_quantity[]=$post_array[$i];
	}

	
///////////////////////////////////////
	$order_id=sanitize($_SESSION['order']);
	$order_query=$db->query("SELECT * FROM orders WHERE id='$order_id' AND (order_status=3 OR order_status=0)");
	$order=mysqli_fetch_assoc($order_query);

	$items=json_decode($order['items'],true);	
	$takeout_items=json_decode($order['takeout_items'],true);
	if ($items!="") {
		$items_size=sizeof($items);
	}
	else{
		$items_size=0;
	}
	if ($takeout_items!="") {
		$takeout_size=sizeof($takeout_items);
	}
	else{
		$takeout_size=0;
	}


	$index=0;
	$take_index=0;
	$new_items=array();
	$new_takeouts=array();
	if ($items=="") {
		$new_items="";
	}
	else{
		foreach($items as $item){
			$new_items[$index]['item_id']=$item['item_id'];
			$new_items[$index]['quantity']=$new_quantity[$index];
			$new_items[$index]['custom_id']=$item['custom_id'];
			$new_items[$index]['mini_status']=0;
			$index++;
		}
	}
	if ($takeout_items=="") {
		$new_takeouts="";
	}
	else{
		
		foreach($takeout_items as $tk){
			$new_takeouts[$take_index]['item_id']=$tk['item_id'];
			$new_takeouts[$take_index]['quantity']=$new_quantity[$index];
			$new_takeouts[$take_index]['custom_id']=$tk['custom_id'];
			$new_takeouts[$take_index]['mini_status']=0;
			$index++;
			$take_index++;
		}
				
	}


	if (!empty($errors)) {
		 echo display_errors($errors);
	}
	else
	{
	$new_takeouts=json_encode($new_takeouts);
	$new_items=json_encode($new_items);

		$db->query("UPDATE orders SET items='$new_items', takeout_items='$new_takeouts', order_status=0, table_no='$table_no' WHERE id='$order_id' AND (order_status=3 OR order_status=0)");
		header('Location: review');
	}
}
}

?>
<div class="container-fluid">
	<div class="row front_nav">
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
	<?php if(isset($_SESSION['order'])&&$check2['order_status']==0){ 

		$orders_before_query=$db->query("SELECT * FROM orders WHERE order_status=0 AND id<'$or_id'");
		$orders_before=mysqli_num_rows($orders_before_query);

		if(isset($_GET['edit'])||$check2['order_status']==3){

			display_regular();

		}
		else{

		?>
		<div class="row" style="padding: 10px; background-color: #fff;margin-top: 2px">
			<div class="col-md-12 col-sm-12 col-xs-12 text-center">
				<img src="images/graphics/order_in.png" style="width: auto; height: 200px">
			</div>
		</div> 
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12 review" style="color: red; padding-top: 10px">
				<p style="font-size: 15px; color: white;"><b><i class="glyphicon glyphicon-ok"></i>  Your order is added to the kitchen</b></p>
				<p style="font-size: 15px;color: white;"><b><i class="fa fa-users"></i>  There are -<?=$orders_before;?>- orders before you</b></p>
						
			</div>
		</div>
		<div class="col-md-12 col-sm-12 col-xs-12" style="padding-top: 15px;">
			<a href="review?edit=1" class="btn btn-white form-control" style="background-color: rgba(252,84,4,1);color:white;border-radius: 3px;">Edit or add more orders</a>
		</div>
		</div>
			

<?php
}}
else{ display_regular();}?>


<?php 
function display_regular(){
	global $check;
	global $db;
?>
	<form action="review<?=isset($_GET['edit'])?'?edit=1':'';?>" method="post" enctype="multipart/form-data">
	<div class="row text-center">
		<?php
		if (isset($_SESSION['order'])&&($check>0)) {
			$order_id=sanitize($_SESSION['order']);
			
			$order_query=$db->query("SELECT * FROM orders WHERE id='$order_id' AND (order_status=0 OR order_status=3)");
			
			$orders=mysqli_fetch_assoc($order_query);

			$order_items=json_decode($orders['items'],true);
			$takeout_items=json_decode($orders['takeout_items'],true);
			$take_index=0;
			$eatin_index=0;
			$takeout_array=array();
			$order_array=array();
			if ($order_items=="") {
				# code...
			}else{
				foreach ($order_items as $ot) {
				$order_array[$eatin_index]['item_id']=$ot['item_id'];
				$order_array[$eatin_index]['quantity']=$ot['quantity'];
				$order_array[$eatin_index]['custom_id']=$ot['custom_id'];
				$order_array[$eatin_index]['takeout']="false";
				$eatin_index++;
			
				}
			}
			if ($takeout_items=="") {
				
			}
			else{
				foreach ($takeout_items as $tk) {
					$takeout_array[$take_index]['item_id']=$tk['item_id'];
					$takeout_array[$take_index]['quantity']=$tk['quantity'];
					$takeout_array[$take_index]['custom_id']=$tk['custom_id'];
					$takeout_array[$take_index]['takeout']="true";
					$take_index++;
				}
			}

			$order_array=array_merge($order_array,$takeout_array);
			//var_dump($order_array);
			$num_rows=sizeof($order_array);
			$index=1;
			$delenex=0;
			$total=0;
			foreach($order_array as $order): 
				$item_id=$order['item_id'];
				$quantity=$order['quantity'];
				$custom_id=$order['custom_id'];
				$item_query=$db->query("SELECT * FROM menu WHERE id='$item_id'");
				$item=mysqli_fetch_assoc($item_query);
				$real_price=$item['price'];
				$price=(int)$item['price']*(int)$quantity;
				$total=$total+$price;

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
						<span class="input-group-btn" onclick="decrement(<?=$index;?>);update_price(<?=$real_price;?>,<?=$index;?>);update_total(<?=$num_rows;?>);">
							<button class="btn btn-white bootstrap-touchspin-down" type="button" style="color:red;"><b>-</b></button>
						</span>

						<span class="input-group-addon bootstrap-touchspin-prefix" style="display: none;"></span>
						<input class="touchspin1 form-control text-center" id="quan<?=$index;?>" type="text" value="<?=$quantity;?>" name="<?=($order['takeout']=="true")? "takeout":"eatin";?><?=$index;?>" style="color: black;">
						<span class="input-group-addon bootstrap-touchspin-postfix" style="display: none;"></span>
						<span class="input-group-btn" onclick="increment(<?=$index;?>);update_price(<?=$real_price;?>,<?=$index;?>);update_total(<?=$num_rows;?>);">
							<button class="btn btn-white bootstrap-touchspin-up" type="button" style="color:red;">
								<b>+</b>
							</button>
						</span>
					</div>

				</div>
				<div class="col-md-3 col-sm-3 col-xs-3">
					<div class="text-right">
						<a href="review?del_<?=($order['takeout']=="true")? "takeout":"eatin";?>=<?=$delenex;?>" onClick="return confirm('Are you sure you want to remove this item from you orders?')" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-remove" style="color: red"></span></a>
						<h5 id="price<?=$index;?>" style="padding-top: 50%"><?=cash($price);?></h5>
					</div>
				</div>
			</div>		
		</div>
		<?php 
		$index++;
		$delenex++;
		endforeach;?>
	</div>
	<div class="row" style="padding: 10px">
		<h4 class="text-right"><b>Total = <span id="total" onload="update_total(<?=$num_rows;?>);" style="color: green"><?=cash($total);?></span></b></h4>
	</div>
	<div class="row" style="padding-top: 15px;padding-bottom: 15px;background-image:linear-gradient(to top, rgba(252,84,4,1) 1%, rgba(255,0,0,1) 100%);">
		<div class="col-md-8 col-sm-8 col-xs-8" style="padding-right: 5px">
			<h4 style="color: white; margin-top: 5px"><b>Enter your table number</b></h4>
		</div>
		<div class="col-md-4 col-sm-4 col-xs-4" style="padding-left: 5px">
			<input type="text" name="table_no" class="form-control text-center" value="<?=(isset($_GET['edit']))? $orders['table_no']:'';?>" style="color: #000" placeholder="Table no.">
		</div>
	</div>
	<div class="row" style="padding-top: 15px;padding-bottom: 15px">
		<div class="col-md-6 col-sm-6 col-xs-6">
			<a href="main" class="btn btn-success form-control" style="background-color: rgba(252,84,4,1);color:white; border-radius: 3px;">BACK TO MENU</a>
		</div>
		<div class="col-md-6 col-sm-6 col-xs-6">
			<button type="submit" name="submit" class="btn btn-danger form-control" style="background-color: rgba(252,84,4,1);color:white;border-radius: 3px;">FINISH ORDER</button>
		</div>
	</div>

</form>


<?php
 }else{?>
 	<div class="row" style="padding-top: 20px;">
 		<img src="images/graphics/No Order yet-03.png" style="width: 150px; height: auto">
 	</div>
 	<div class="row" style="padding-top: 10px;color: red;">
		<h3 class="text-center"><b>No Orders Yet</b></h3>
	</div>

	<div class="row" style="padding-top: 15px;padding-bottom: 15px">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="col-md-2 col-sm-2 col-xs-2">
				
			</div>
			<div class="col-md-8 col-sm-8 col-xs-8">
				<a href="main" class="btn btn-success form-control shadow" style="background-color: rgba(252,84,4,1);color:white; border-radius: 3px;">BACK TO MENU</a>
			</div>
			<div class="col-md-2 col-sm-2 col-xs-2">
				
			</div>
			
		</div>
		
	</div>
</div>
<?php }
}
include "includes/footer.php";
 ?>
 

