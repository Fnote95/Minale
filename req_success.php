<?php
require_once "core/init.php";
include "includes/head.php";
?>
<div class="container-fluid">
	<div class="row front_nav">
		<div class="col-md-1 col-sm-1 col-xs-1 pull-left" style="padding: 5px">
				<a id="back"><i class="fa fa-arrow-left" style="font-size: 25px; color: red;"></i></a>
		</div>
		<div class="col-md-10 col-sm-10 col-xs-10 text-center" style="padding: 5px">
				
		</div>

		<div class="col-md-1 col-sm-1 col-xs-1 " style="padding: 5px">
			<a href="#">
				<i class="fa fa-bars" onclick="review();" style="font-size: 25px; color: red;"></i>
			</a>
		</div>
	</div>
	<div class="row text-center">
		<div style="padding-top: 20px">
			<img src="images/graphics/success.png" style="width: 150px; height: auto">
		</div>
	</div>
	<div class="row text-center" style="padding-top: 30px;padding-left: 10px;padding-left: 10px">
		<h3 style="color: red"><b>Our waiters are on their way to your table, Stand by.</b></h3>
	</div>
	<div class="row text-center" style="padding-top: 30px">
		<a href="index" class="btn btn-lg btn_orange shadow"><span class="glyphicon glyphicon-home"></span> Home</a>
	</div>
</div>