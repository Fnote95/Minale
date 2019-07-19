<?php
require_once "core/init.php";
include "includes/head.php";

////////////
$menu_query=$db->query("SELECT * FROM menu");
?>
<div class="container-fluid">
	<div class="row" style="padding-top: 20px; padding-left: 5px ">
		<div class="col-md-2 col-sm-2 col-xs-2">
			<img src="images.jpg" alt="Logo" style="width: 50; height: 50px">
		</div>
		<div class="col-md-10 col-sm-10 col-xs-10">
			<!--<h3>&nbsp&nbsp&nbsp&nbsp<b>Main Menu</b></h3>-->
		</div>
	</div>
	<div class="row text-center" style="padding-top: 5px">
		<div class="col-md-12 col-sm-12 col-xs-12 scrolling_wrapper" style="padding-top: 15px;padding-bottom: 15px; height: 500px">
			<?php while($menu_item=mysqli_fetch_assoc($menu_query)): ?>
			<a href="details?item=<?=$menu_item['id'];?>">
				<div class="col-md-12 col-sm-12 col-xs-12" style="margin-top:10px;background-size: auto 350px;background-image: url('<?=$menu_item['item_pic'];?>'); border: 1px solid #f0f0f0;box-shadow: 0 1px 4px 0 rgba(0, 0, 0, 0.14);height: 200px;overflow: hidden;">
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
