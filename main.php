<?php
require_once "core/init.php";
include "includes/head.php";


$sub_menu_query=$db->query("SELECT * FROM category");
?>
<div class="container-fluid">
		<div class="row" style="padding: 10px; background-color: #fff">
			<div class="col-md-10 col-sm-10 col-xs-10 pull-left">
				
					<a id="back"><i class="fa fa-arrow-left" style="font-size: 25px; color: red;"></i></a>
			
			</div>
			<div class="col-md-1 col-sm-1 col-xs-1 ">
				<a href="#">
					<i class="fa fa-bars" onclick="review();" style="font-size: 25px; color: red;"></i>
				</a>
			</div>
		</div>

		<div class="row" style="padding: 10px;color: red;">
			<h3 class="text-center"><b>Main Menu</b></h3>
		</div>

		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
			<?php while($sub_cat=mysqli_fetch_assoc($sub_menu_query)): ?>
				<div class="col-md-6 col-sm-6 col-xs-6" style="padding: 5px">
					<a href="eatin?sub=<?=$sub_cat['id'];?>">
						<div class="text-center" style="margin-bottom: 5px;padding:25px;background-color: white; box-shadow: 1px 1px 1px 1px rgba(0, 0, 0, 0.1);">
							<i class="fa fa-arrow-left" style="font-size: 25px; color: red;"></i>
							<h5 style="padding-top: 5px"><b><?=$sub_cat['cat_name'];?></b></h5>
						</div>
					</a>
				</div>
			<?php endwhile;?>
			</div>
		</div>


</div>
<?php
include "includes/footer.php";
?>