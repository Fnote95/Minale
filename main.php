<?php
require_once "core/init.php";

include "includes/head.php";


if (isset($_GET['type'])&&!empty($_GET['type'])) {
	$type=sanitize($_GET['type']);
	$_SESSION['type']=$type;
}
else{
	session_error_redirect();
}
if(!isset($_SESSION['type'])){
	session_error_redirect();
}
$sub_menu_query=$db->query("SELECT * FROM category");
?>
<div class="container-fluid">
	<div class="row" style="padding: 10px; background-color: #fff">
		<div class="col-md-1 col-sm-1 col-xs-1 pull-left" style="padding: 5px">
				<a id="back"><i class="fa fa-arrow-left" style="font-size: 25px; color: red;"></i></a>
		</div>
		<div class="col-md-10 col-sm-10 col-xs-10 text-center" style="padding: 5px">
				<h3 class="text-center" style="color: red;"><b>Main Menu</b></h3>
		</div>

		<div class="col-md-1 col-sm-1 col-xs-1 " style="padding: 5px">
			<a href="#">
				<i class="fa fa-bars" onclick="review();" style="font-size: 25px; color: red;"></i>
			</a>
		</div>
	</div>

		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
			<?php while($sub_cat=mysqli_fetch_assoc($sub_menu_query)): 
				$su_cat_id=$sub_cat['id'];
				$img_query=$db->query("SELECT * FROM menu WHERE cat_id='$su_cat_id'");
				$img=mysqli_fetch_assoc($img_query);

				?>
				<a href="eatin?sub=<?=$sub_cat['id'];?>">
				<div class="col-md-6 col-sm-6 col-xs-6" style="height: 125px;margin-top: 10px;padding: 5px;overflow: hidden;background-image: url('<?=$img['item_pic'];?>');background-size: auto 175px;border: 1px solid #f0f0f0;box-shadow: 0 1px 4px 0 rgba(0, 0, 0, 0.14);">
				
						<!------------------------------------>
						<div class="pull-left" style="margin-top: -44px; margin-left: -75px; height: 88px; width: 150px; border-radius: 50%; background-color: red;box-shadow: 5px 5px 5px 0 rgba(0, 0, 0, 0.3);">
							<h6 class="text-left" style="color:white;margin-top: 49px;margin-left: 75px;"><b><?=$sub_cat['cat_name'];?></b></h6>
									
						</div>
						<!-------------------------------------->
				</div>
			</a>
			<?php endwhile;?>
			</div>
		</div>


</div>
<?php
include "includes/footer.php";
?>