<?php
require_once "core/init.php";
include "includes/head.php";
if (!isset($_SESSION['type'])) {
	header('Location: index.php');
}


if (isset($_GET['customize'])&&!empty($_GET['customize'])) {
	$item_id=sanitize($_GET['customize']);
	$item_query=$db->query("SELECT * FROM menu WHERE id='$item_id'");
	$pic_query=$db->query("SELECT * FROM menu WHERE id='$item_id'");
	if (isset($_GET['custom'])&&!empty($_GET['custom'])) {
		$custom_id=sanitize($_GET['custom']);
		$item_query=$db->query("SELECT * FROM customize WHERE id='$custom_id'");
	}
	$item=mysqli_fetch_assoc($item_query);
	$item2=mysqli_fetch_assoc($pic_query);
	$ing_type=$item2['ing_type'];
	if ($ing_type==3) {
		$item_composition=$item['composition'];
	}
	else{
		$item_composition=json_decode($item['composition'],true);
	}
	

	if (isset($_POST['customize'])&&!empty($_POST['customize'])) {
		$items=array();
		$i=0;
		if ($ing_type==3) {
			$items_json=sanitize($_POST['comments']);
		}
		elseif ($ing_type==2) {
			foreach ($item_composition as $comp) {
				$items[$i]['comp']=$comp['comp'];
				if (isset($_POST[$comp['comp']])) {
					$items[$i]['needed']="true";
				}
				else{
					$items[$i]['needed']="false";
				}
				$i++;
			}
			$items_json=json_encode($items,true);
		
		}
		else{
			foreach ($item_composition as $comp) {
				$items[$i]['comp']=$comp['comp'];
				$items[$i]['quantity']=$_POST[$comp['comp']];
				$i++;
			}
			$items_json=json_encode($items,true);
		}

		if (isset($_GET['custom'])&&!empty($_GET['custom'])) {
			$db->query("UPDATE customize SET composition='$items_json' WHERE id='$custom_id'");
			var_dump($items_json);
		}
		else{
		$db->query("INSERT INTO customize (composition, item_id) VALUES('{$items_json}','{$item_id}')");
			$custom_id=$db->insert_id;
		
		}
		
		header('Location: details?item='.$item_id.'&custom='.$custom_id);
	}
}

?>
<div class="container-fluid">
	<div class="row front_nav">
		<div class="col-md-1 col-sm-1 col-xs-1 pull-left" style="padding: 5px">
				<a id="back"><i class="fa fa-arrow-left" style="font-size: 25px; color: red;"></i></a>
		</div>
		<div class="col-md-10 col-sm-10 col-xs-10 text-center" style="padding: 5px">
				<!--<h3 class="text-center" style="color: red;"><b>Customize</b></h3>-->
				<h4 style="color: red;"><b>Customizing <?=$item2['item_name'];?></b></h4>
		</div>

		<div class="col-md-1 col-sm-1 col-xs-1 " style="padding: 5px">
			<a href="#">
				<i class="fa fa-bars" onclick="review();" style="font-size: 25px; color: red;"></i>
			</a>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12" style="background-size: auto 300px;background-image: url('<?=$item2['item_pic'];?>');  height: 300px;overflow: hidden;">
		<div class="pull-left" style="margin-top: -88px; margin-left: -150px; height: 176px; width: 300px; border-radius: 50%; background-color: red; box-shadow: 5px 1px 4px 0 rgba(0, 0, 0, 0.5);">
			<h4 class="text-left" style="color:white;margin-top: 98px;margin-left: 150px;"><b><?=$item2['item_name'];?></b></h4>
			<h3 class="text-left" id="price1" style="color: white;margin-top: 0px; margin-left: 150px;"><b><?=cash($item2['price']);?></b></h3>			
		</div>
				
		</div>
	</div>

	<div class="row text-center" style="padding-top: 10px">

		<div>
			<h4 style="color: red"><b>Ingredients</b></h4>
		</div>
		<form action="customize?customize=<?=(isset($_GET['custom']))?$item_id.'&custom='.$custom_id : $item_id;?>" method="post" enctype="multipart/form-data">

		<?php 
		if($ing_type!=3){
		$index=1;
		foreach($item_composition as $comp): ?>
			<div class="col-md-12 review shadow" style="padding-top: 5px; padding-bottom: 5px">
				<div class="row" style="padding-top: 5px;padding-bottom: 5px;">
					<div class="col-md-4 col-sm-4 col-xs-4">
						<h4><b><?=$comp['comp'];?></b></h4>
					</div>
					<div class="col-md-3 col-sm-3 col-xs-3"></div>
					<div class="col-md-5 col-sm-5 col-xs-5 text-right">
						<?php if($ing_type==1){?>
						<div class="input-group bootstrap-touchspin">
							<span class="input-group-btn" onclick="decrement(<?=$index;?>)">
								<button class="btn btn-white bootstrap-touchspin-down" type="button" style="color:red;"><b>-</b></button>
							</span>
							<span class="input-group-addon bootstrap-touchspin-prefix" style="display: none;"></span>
							<input class="touchspin1 form-control text-center" id="quan<?=$index;?>" type="text" value="<?=$comp['quantity'];?>" name="<?=$comp['comp'];?>" style="color: black;">
							<span class="input-group-addon bootstrap-touchspin-postfix" style="display: none;"></span>
							<span class="input-group-btn" onclick="increment(<?=$index;?>);">
								<button class="btn btn-white bootstrap-touchspin-up" type="button" style="color:red;">
									<b>+</b>
								</button>
							</span>
						</div>
					<?php }else{?>
						<div class="form-check">
						  <input class="form-check-input" name="<?=$comp['comp'];?>" type="checkbox" id="defaultCheck1" style="width: 20px;height: 20px; border: 1px solid red;border-radius: 5px;" checked="true">
						</div>
					<?php }?>

					</div>
					
				</div>
			</div>
		<?php
		$index++;
		endforeach; 
		}else{
		?>
			<div class="col-md-12 review btn_orange shadow" style="padding: 5px">
				<div class="row" style="padding: 5px">
					<div class="col-md-12 col-sm-12 col-xs">
						<h5 class="text-center"><b>Describe how you want your <?=$item2['item_name'];?> In the text area below</b></h5>
					</div>
					<div class="col-md-12 col-sm-12 col-xs-12" style="padding: 10px">
						<div style="margin-right: 15px; margin-left: 15px;">
							<textarea name="comments" class="form-control" style="color: black;"></textarea>
						</div>
						
					</div>
							
				</div>
			</div>
		<?php } ?>
		</div>
	<div class="row" style="padding: 5px;padding-top: 10px">
		<div class="col-md-6 col-sm-6 col-xs-6">
			<a href="details?item=<?=$item_id;?>" class="btn btn-danger form-control btn_orange shadow">Cancel</a>
		</div>
		<div class="col-md-6 col-sm-6 col-xs-6">
			<input type="submit" name="customize" value="Finish Customizing" class="btn btn-danger form-control btn_orange shadow">
		</div>
	</div>
	</form>
</div>
<?php include "includes/footer.php";?>