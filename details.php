<?php
require_once "core/init.php";
include "includes/head.php";

$cust_check_query=$db->query("SELECT * FROM settings");
$cust_check_result=mysqli_fetch_assoc($cust_check_query);
$cust_status=$cust_check_result['customize'];


if (!isset($_SESSION['type'])) {
	header('Location: index.php');
}

if (isset($_GET['item'])&&!empty($_GET['item'])) {
	$item_id=sanitize($_GET['item']);

	$item_query=$db->query("SELECT * FROM menu WHERE id='$item_id'");

	$item=mysqli_fetch_assoc($item_query);
	$item_name=$item['item_name'];
	$item_pic=$item['item_pic'];
	$item_price=$item['price'];
	$ing_type=$item['ing_type'];
	if ($ing_type==3) {
		$item_composition=$item['composition'];
	}
	else{
		$item_composition=json_decode($item['composition'],true);
		$orders_array=array();
	}

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
	$orders_array[0]['mini_status']=0;
	$session_id=session_id();
	$orders_json=json_encode($orders_array,true);
	$order_type=$_SESSION['type'];
	////////////////////////////////////////check to see if the customer is looking to add another order
	if (isset($_SESSION['order'])) {

		$order_id=sanitize($_SESSION['order']);
		$o_query=$db->query("SELECT * FROM orders WHERE id='$order_id'");
		$orders_list=mysqli_fetch_assoc($o_query);
		$orders_eatin_session=json_decode($orders_list['items'],true);
		$orders_takeout_session=json_decode($orders_list['takeout_items'],true);
		//$orders_json=json_encode(array_merge($orders_session,$orders_array));

	

		if ($order_type==1) {
			/////////////////////////////////update the eatin items
			if ($orders_eatin_session!='') {
				$orders_json=json_encode(array_merge($orders_eatin_session,$orders_array));
			}
			$db->query("UPDATE orders SET items='$orders_json' WHERE id='$order_id' AND (order_status=0 OR order_status=3)");
			/////////////////////////////////update the custom id
			if (isset($_GET['custom'])&&!empty($_GET['custom'])) {
				$db->query("UPDATE customize SET order_id='$order_id' WHERE id='$custom_id'");
			}

			header('Location: success');	
		}
		elseif($order_type==2){
			///////////////////////////////update the takeout items
			if ($orders_takeout_session!=0) {
				$orders_json=json_encode(array_merge($orders_takeout_session,$orders_array));
			}
			$db->query("UPDATE orders SET takeout_items='$orders_json' WHERE id='$order_id' AND (order_status=0 OR order_status=3)");
			
			if (isset($_GET['custom'])&&!empty($_GET['custom'])) {
				$db->query("UPDATE customize SET order_id='$order_id' WHERE id='$custom_id'");
			}

			header('Location: success');	
		}
	
	}
	else{
		if ($order_type==1) {
			$db->query("INSERT INTO orders (items,session_id) VALUES ('$orders_json','$session_id')");
			$order_id=$db->insert_id;
			if (isset($_GET['custom'])&&!empty($_GET['custom'])) {
				$db->query("UPDATE customize SET order_id='$order_id' WHERE id='$custom_id'");
			}
			$_SESSION['order']=$order_id;
			header('Location: success');
		}
		elseif ($order_type==2) {
			$db->query("INSERT INTO orders (takeout_items,session_id) VALUES ('$orders_json','$session_id')");
			$order_id=$db->insert_id;
			if (isset($_GET['custom'])&&!empty($_GET['custom'])) {
				$db->query("UPDATE customize SET order_id='$order_id' WHERE id='$custom_id'");
			}
			$_SESSION['order']=$order_id;
			header('Location: success');
		}

	}

}
?>

<div class="container-fluid">
	<div class="row front_nav">
		<div class="col-md-10 col-sm-10 col-xs-10 pull-left">
			
				<a id="back"><i class="fa fa-arrow-left" style="font-size: 25px; color: red;"></i></a>
		
		</div>
		<div class="col-md-1 col-sm-1 col-xs-1 ">
			<a href="#">
				<i class="fa fa-bars" onclick="review();" style="font-size: 25px; color: red;"></i>
			</a>
		</div>
	</div>
	<form action="details?item=<?=(isset($_GET['custom']))?$item_id.'&custom='.$custom_id : $item_id;?>" method="post" enctype="multipart/form-data">
		<div class="row shadow">
			<div class="col-md-12 col-sm-12 col-xs-12" style="background-size: auto 300px;background-image: url('<?=$item_pic;?>');  height: 300px;overflow: hidden;">
				
		
					<div class="pull-left" style="margin-top: -88px; margin-left: -150px; height: 176px; width: 300px; border-radius: 50%; background-color: red; box-shadow: 5px 1px 4px 0 rgba(0, 0, 0, 0.5);">
						<h4 class="text-left" style="color:white;margin-top: 98px;margin-left: 150px;"><b><?=$item_name;?></b></h4>
						<h3 class="text-left" id="price1" style="color: white;margin-top: 0px; margin-left: 150px;"><b><?=cash($item_price);?></b></h3>			
					</div>
							
			</div>

			<div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: -1px;color:white; padding-top: 25px;padding-bottom:25px;background-image:linear-gradient(to top, rgba(252,84,4,1) 1%, rgba(255,0,0,1) 100%) ;">
				<?php if(isset($_GET['custom'])): ?>
					<div class="row" style="margin-top: -10px;">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<h5 class="pull-right" style="color: #fff;padding: 5px; padding-right: 10px; padding-left: 10px; background-color: #fc5404; margin-right: -5%"><b>Customized</b></h5>
						</div>
						
					</div>
				<?php endif;?>
				<div class="col-md-12 col-sm-12 col-xs-12" >
					<h4 class="text-center"><b>Ingredients</b></h4>
					<p class="text-center">
						<?php if ($ing_type==3) {?>
							<i><?=$item_composition;?></i>
						<?php }elseif($ing_type==2&&isset($_GET['custom'])){ foreach ($item_composition as $comp): ?>
							<i><?=$comp['comp'].(($comp['needed']=='false')?'-removed':'').',';?></i>
						<?php endforeach; }else{ foreach ($item_composition as $comp): ?>
							<i><?=$comp['comp'].(($comp['quantity']=='NA')?'':'-'.$comp["quantity"]).',';?></i>
						<?php endforeach; }?>
					</p>
				</div>
				<div class="col-md-3 col-sm-3 col-xs-3"></div>		
				<div class="col-md-6 col-sm-6 col-xs-6">
					<h4 class="text-center"><b>Quantity</b></h4>
					<div class="input-group bootstrap-touchspin shadow">
						<span class="input-group-btn" onclick="decrement(1);update_price(<?=$item_price;?>,1);">
							<button class="btn btn-white bootstrap-touchspin-down" type="button" style="color:red;"><b>-</b></button>
						</span>
						<span class="input-group-addon bootstrap-touchspin-prefix" style="display: none;"></span>
						<input class="touchspin1 form-control text-center" id="quan1" type="text" value="<?=1;?>" name="quantity" style="color: black;">
						<span class="input-group-addon bootstrap-touchspin-postfix" style="display: none;"></span>
						<span class="input-group-btn" onclick="increment(1);update_price(<?=$item_price;?>,1);">
							<button class="btn btn-white bootstrap-touchspin-up" type="button" style="color:red;">
								<b>+</b>
							</button>
						</span>
					</div>
				</div>
				<div class="col-md-3 col-sm-3 col-xs-3"></div>
			</div>
					
		</div>
		<div class="row" style="padding-top: 15px;padding-bottom: 15px">
			<div class="col-md-6 col-sm-6 col-xs-6">
				<?php if($cust_status==1):?>
					<a href="customize?customize=<?=(isset($_GET['custom']))?$item_id.'&custom='.$custom_id : $item_id;?>" class="btn btn-success form-control btn_orange shadow" >CUSTOMIZE</a>
				<?php endif;?>
			</div>
			<div class="col-md-6 col-sm-6 col-xs-6">
				<button type="submit" name="submit" class="btn btn-danger form-control btn_orange shadow">ADD TO ORDER</button>
			</div>
		</div>


	</form>
</div>

<?php
include "includes/footer.php";
?>