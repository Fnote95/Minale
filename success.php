<style type="text/css">
	#body{
		background-color: white;
	}
</style>
<?php 
require_once "core/init.php";
include "includes/head.php";
?>
<div class="container-fluid" style="background-color: white">
	<div class="row text-center">
		<div style="padding-top: 30px">
			<img src="min.png" style="width: 150px; height: auto">
		</div>
		<div style="padding-top:10%; padding-left: 10px;padding-right: 10px">
			<h3 style="color: red;"><b>Your order has been added to</b></h3>
			<h3 style="color: red;"><b>My orders!!</b></h3>
		</div>
		<div class="row" style="padding-right: 15px;padding-left: 15px;padding-top: 10%">
			<div class="col-md-6 col-sm-6 col-xs-6">
				<a href="main" class="btn form-control" style="background-color: red; color: white;"><b>Back to Menu</b></h4></a>
			</div>
			<div class="col-md-6 col-sm-6 col-xs-6">
				<a href="review" class="btn form-control" style="background-color: red; color: white;"><b>My orders</b></a>
			</div>
		</div>
	</div>
</div>
<?php
include "includes/footer.php";
?>