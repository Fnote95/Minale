<?php 
require_once "core/init.php";
include "includes/head.php";
?>
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
		<div style="padding-top: 20px">
			<img src="images/graphics/success.png" style="width: 150px; height: auto">
		</div>
		<div style="padding-top:10%; padding-left: 10px;padding-right: 10px">
			<h3 style="color: red;"><b>Your order has been added to</b></h3>
			<h3 style="color: red;"><b>My orders for review.</b></h3>
		</div>
		<div class="text-left review shadow" style="padding-top: 20px; padding-left: 20px; padding-right: 20px; padding-bottom: 20px">
			<p style="color: white;"><span class="glyphicon glyphicon-certificate"></span><b> If you wish to review and finalize your order, press "My orders"</b><p>
			<p style="color: white;"><span class="glyphicon glyphicon-certificate"></span><b> If you want to add another item to your orders, press "Back to menu"</b></p>
		</div>
		
	</div>
	<div class="row" style="padding-top: 10px; padding-bottom: 15px">
		<div class="col-md-6 col-sm-6 col-xs-6">
			<a href="main" class="btn form-control shadow" style="background-color: red; color: white;"><b>Back to Menu</b></a>
		</div>
		<div class="col-md-6 col-sm-6 col-xs-6">
			<a href="review" class="btn form-control shadow" style="background-color: red; color: white;"><b>My orders</b></a>
		</div>
	</div>
</div>
<?php
include "includes/footer.php";
?>