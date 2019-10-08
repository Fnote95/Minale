<?php
require_once "core/init.php";
include "includes/head.php";

////////////
if (isset($_GET['sub'])&&!empty($_GET['sub'])) {
	$sub_id=sanitize($_GET['sub']);
}
$cat_query=$db->query("SELECT * FROM category WHERE id='$sub_id'");
$cat=mysqli_fetch_assoc($cat_query);
$menu_query=$db->query("SELECT * FROM menu WHERE cat_id='$sub_id'");
?>
<div class="container-fluid">
	<div class="row" style="padding: 10px; background-color: #fff">
		<div class="col-md-1 col-sm-1 col-xs-1 pull-left" style="padding: 5px">
				<a id="back"><i class="fa fa-arrow-left" style="font-size: 25px; color: red;"></i></a>
		</div>
		<div class="col-md-10 col-sm-10 col-xs-10 text-center" style="padding: 5px">
				<h3 class="text-center" style="color: red;"><b><?=$cat['cat_name'];?></b></h3>
		</div>

		<div class="col-md-1 col-sm-1 col-xs-1 " style="padding: 5px">
			<a href="#">
				<i class="fa fa-bars" onclick="review();" style="font-size: 25px; color: red;"></i>
			</a>
		</div>
	</div>


	<div class="row text-center">
		<div class="col-md-12 col-sm-12 col-xs-12 scrolling_wrapper" style="padding-top: 15px;padding-bottom: 15px; height: 500px">
			<?php while($menu_item=mysqli_fetch_assoc($menu_query)): ?>
			<a href="details?item=<?=$menu_item['id'];?>">
				<div class="col-md-12 col-sm-12 col-xs-12" style="margin-top:10px;background-size: auto 350px;background-image: url('<?=$menu_item['item_pic'];?>');box-shadow:0 4px 10px 0 rgba(0, 0, 0, 0.30), 0 2px 10px 0 rgba(0, 0, 0, 0.30); border-radius: 10px;height: 200px;overflow: hidden;">
					<!--<div style="width:75px; height:auto ; margin: 0% auto; border-radius: 50%; margin-top: 5px;border: 2px solid #f0f0f0;box-shadow: 0 1px 4px 0 rgba(0, 0, 0, 0.14);overflow: hidden;">
						<img src="<?=$menu_item['item_pic'];?>" alt="" style="width:75px; height:auto; ">
					</div>-->
					
					<div class="pull-left" style="margin-top: -88px; margin-left: -150px; height: 176px; width: 300px; border-radius: 50%; background-color: red;box-shadow: 5px 5px 5px 0 rgba(0, 0, 0, 0.3);">
						<h4 class="text-left" style="color:white;margin-top: 98px;margin-left: 150px;"><b><?=$menu_item['item_name'];?></b></h4>
						<h3 class="text-left" style="color: white;margin-top: 0px; margin-left: 150px;"><b><?=cash($menu_item['price']);?></b></h3>			
					</div>
							
				</div>
			</a>
			<?php endwhile;?>
		</div>
	</div>
</div>
<?php include "includes/footer.php";?>