<?php 
require_once "core/init.php";
include "includes/head.php";

$settings_query=$db->query("SELECT * FROM settings");
$settings_result=mysqli_fetch_assoc($settings_query);
?>
<div style="overflow: hidden;">
	<div style="z-index:1;position:relative;">
		<img src="che.png" id="loading" style="width: 500px; height: auto; margin-left: -250px ;opacity: 0.8" >
	</div>

	<div style="z-index:2;position:relative;">
		
		<img src="stra.png" id="loading" style="width: 250px; height: auto; opacity: 0.8; margin-top: -250px;margin-left: 150px;">
	</div>



	<div class="container-fluid" style="z-index:3; position:relative; ">
		<div class="row text-center" style="padding-top:30px;margin-top: -500px">
			
				<img src="<?=$settings_result['logo'];?>" class="image-thumb img-responsive shadow" style="width:auto; height: 110px; margin: 0% auto;border-radius:10px">

		</div>
		<div class="row text-center" style="padding-top: 15px">
			<div class="col-md-6 col-sm-12 col-xs-12 text-center" style="padding: 15px">
				<a href="main.php?type=1">
					<button class="btn shadow" style="width: 225px; height: 75px; background-color: red; border-radius: 45px;">
						<h3 class="text-center" style="color: white;margin-top: 5px "><b>Eat In</b></h3>
					</button>
				</a>

			</div>
			<div class="col-md-6 col-sm-12 col-xs-12 text-center" style="padding: 15px">
				<a href="main.php?type=2">
					<button class="btn shadow" style="width: 225px; height: 75px; background-color: red; border-radius: 45px;">
							<h3 class="text-center" style="color: white; margin-top: 5px "><b>Take Out</b></h3>
					</button>
				</a>
			</div>
		</div>
		<div class="row text-center" style="padding-top:10px">
			<img src="logo2.png" class="image-thumb img-responsive" style="width:200px; height:auto ; margin: 0% auto;">
		</div>
	</div>

</div>
