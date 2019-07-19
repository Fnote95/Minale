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
		<div class="col-md-12 col-sm-12 col-xs-12 scrolling_wrapper" style="padding-top: 15px; height: 640px">
			<?php while($menu_item=mysqli_fetch_assoc($menu_query)): ?>
			<a href="details?item=<?=$menu_item['id'];?>">
				<div class="col-md-6 col-sm-6 col-xs-6">
					<img src="<?=$menu_item['item_pic'];?>" alt="" style="width: 75px; height: auto; padding-top: 10px">
					<p class="text-center"><b><?=$menu_item['item_name'];?></b></p>
					<p class="text-center" style="color: green"><?=cash($menu_item['price']);?></p>
				</div>
			</a>
			<?php endwhile;?>
		</div>
	</div>
</div>
