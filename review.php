<?php
require_once "core/init.php";
include "includes/head.php";

if (isset($_SESSION['order'])&&!empty($_SESSION['order'])) {
	$or_id=sanitize($_SESSION['order']);

	$check_query=$db->query("SELECT * FROM orders WHERE id='$or_id' AND (order_status=3 OR order_status=0)");
	$check=mysqli_num_rows($check_query);
	$check2=mysqli_fetch_assoc($check_query);
}
if (isset($_GET['delete'])) {
	$delete_id=sanitize($_GET['delete']);

	$order_query_delete=$db->query("SELECT * FROM orders WHERE id='$or_id'");
	$order_delete=mysqli_fetch_assoc($order_query_delete);
	$order_json_delete=json_decode($order_delete['items'],true);
	array_splice($order_json_delete, $delete_id,1);

	$order_json_delete=json_encode($order_json_delete);

	$db->query("UPDATE orders SET items='$order_json_delete' WHERE id='$or_id' AND (order_status=3 OR order_status=0)");
	header('Location: review');
	
}



if (isset($_POST['submit'])) {
////////////////////////////////////
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

	$index=0;
	$new_items=array();
	foreach($items as $item){
		$new_items[$index]['item_id']=$item['item_id'];
		$new_items[$index]['quantity']=$new_quantity[$index];
		$new_items[$index]['custom_id']=$item['custom_id'];
		$index++;
	}
	if (!empty($errors)) {
		 echo display_errors($errors);
	}
	else
	{
	$new_items=json_encode($new_items);
	$db->query("UPDATE orders SET items='$new_items', order_status=0, table_no='$table_no' WHERE id='$order_id' AND (order_status=3 OR order_status=0)");
	header('Location: review');
	}
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
				<img src="min.png" style="width: 120px">
			</div>

			<div class="col-md-12 col-sm-12 col-xs-12" style="color: red; padding-top: 10px">
				<h4 style="font-size: 15px"><b><i class="glyphicon glyphicon-time"></i>  Your order is in the waiting area</b></h4>
				<h4 style="font-size: 15px"><b><i class="fa fa-users"></i>  There are -<?=$orders_before;?>- orders before you</b></h4>	
			</div>
			<div class="col-md-12 col-sm-12 col-xs-12" style="padding-top: 15px">
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
	<div class="row text-center" style="padding-top: 10px">
		<?php
		if (isset($_SESSION['order'])&&($check>0)) {
			$order_id=sanitize($_SESSION['order']);
			
			$order_query=$db->query("SELECT * FROM orders WHERE id='$order_id' AND (order_status=0 OR order_status=3)");
			$orders=mysqli_fetch_assoc($order_query);
		
			$order_array=json_decode($orders['items'],true);

			$index=1;
			$delenex=0;
			foreach($order_array as $order): 
			$item_id=$order['item_id'];
			$quantity=$order['quantity'];
			$custom_id=$order['custom_id'];
			$item_query=$db->query("SELECT * FROM menu WHERE id='$item_id'");
			$item=mysqli_fetch_assoc($item_query);
			$price=(int)$item['price']*(int)$quantity;

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
						<span class="input-group-btn" onclick="decrement(<?=$index;?>);update_price(<?=$price;?>,<?=$index;?>);">
							<button class="btn btn-white bootstrap-touchspin-down" type="button" style="color:red;"><b>-</b></button>
						</span>
						<span class="input-group-addon bootstrap-touchspin-prefix" style="display: none;"></span>
						<input class="touchspin1 form-control text-center" id="quan<?=$index;?>" type="text" value="<?=$quantity;?>" name="demo<?=$index;?>" style="color: black;">
						<span class="input-group-addon bootstrap-touchspin-postfix" style="display: none;"></span>
						<span class="input-group-btn" onclick="increment(<?=$index;?>);update_price(<?=$price;?>,<?=$index;?>);">
							<button class="btn btn-white bootstrap-touchspin-up" type="button" style="color:red;">
								<b>+</b>
							</button>
						</span>
					</div>

				</div>
				<div class="col-md-3 col-sm-3 col-xs-3">
					<div class="text-right">
						<a href="review?delete=<?=$delenex;?>" onClick="return confirm('Are you sure you want to remove this item from you orders?')" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-remove" style="color: red"></span></a>
						<h5 id="price<?=$index;?>" style="padding-top: 50%"><b><?=cash($price);?></b></h5>
					</div>
				</div>
			</div>		
		</div>
		<?php 
		$index++;
		$delenex++;
		endforeach;?>
	</div>

	<div class="row" style="margin-top: 20px;padding-top: 15px;padding-bottom: 15px;background-image:linear-gradient(to top, rgba(252,84,4,1) 1%, rgba(255,0,0,1) 100%);">
		<div class="col-md-8 col-sm-8 col-xs-8" style="padding-right: 5px">
			<h4 style="color: white; margin-top: 5px"><b>Enter your table number</b></h4>
		</div>
		<div class="col-md-4 col-sm-4 col-xs-4" style="padding-left: 5px">
			<input type="text" name="table_no" class="form-control text-center" value="<?=(isset($_GET['edit']))? $orders['table_no']:'';?>" style="color: #000">
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
 	<div class="row" style="padding-top: 10px;color: red;">
		<h3 class="text-center"><b>No Orders Yet</b></h3>
	</div>

	<div class="row" style="padding-top: 15px;padding-bottom: 15px">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<a href="main" class="btn btn-success form-control" style="background-color: rgba(252,84,4,1);color:white; border-radius: 3px;">BACK TO MENU</a>
		</div>
		
	</div>
</div>
<?php }
}
include "includes/footer.php";
 ?>
 

