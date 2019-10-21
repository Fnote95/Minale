<?php
require_once "core/init.php";

include "includes/head.php";

/*if (!isset($_SESSION['type'])) {
	header('Location: index.php');
}*/

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
	<div class="row front_nav">
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
			<div class="row" style="padding-left: 20px; padding-right: 20px">
			<?php while($sub_cat=mysqli_fetch_assoc($sub_menu_query)): 
				$su_cat_id=$sub_cat['id'];
				$img_query=$db->query("SELECT * FROM menu WHERE cat_id='$su_cat_id'");
				$img=mysqli_fetch_assoc($img_query);

				?>
				<a href="eatin?sub=<?=$sub_cat['id'];?>">
				<div class="col-md-6 col-sm-6 col-xs-6" style="padding-left: 5px; padding-right: 5px">
					<div style="height: 125px;margin-top: 10px;padding: 5px;overflow: hidden;background-image: url('<?=$img['item_pic'];?>');background-size: auto 175px;box-shadow:0 4px 10px 0 rgba(0, 0, 0, 0.30), 0 2px 10px 0 rgba(0, 0, 0, 0.30); border-radius: 10px;">
						<!------------------------------------>
						<div class="pull-left" style="margin-top: -44px; margin-left: -75px; height: 88px; width: 150px; border-radius: 50%; background-color: red;box-shadow: 5px 5px 5px 0 rgba(0, 0, 0, 0.3);">
							<h6 class="text-left" style="color:white;margin-top: 49px;margin-left: 75px;"><b><?=$sub_cat['cat_name'];?></b></h6>
									
						</div>
						<!-------------------------------------->
					</div>
						
				</div>
			</a>
			<?php endwhile;?>
			</div>
		</div>


</div>
<?php
include "includes/footer.php";
?>