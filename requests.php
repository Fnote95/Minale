<?php
require_once "core/init.php";
include "includes/head.php";

	
if (isset($_POST['r_waiter'])) {
	$table_no=sanitize($_POST['table_no']);

	$errors=array();
	if ($table_no=='') {
		$errors[]="You must enter a table number before you could send a request!";	
	}
	if (!empty($errors)) {
		 echo display_errors($errors);
	}
	else{

		$type='waiter';
		$db->query("INSERT INTO requests (request_type,table_no) VALUES ('$type','$table_no')");
		header('Location: req_success.php');
	}
}
if (isset($_POST['r_bill'])) {
	$table_no=sanitize($_POST['table_no']);

	$errors=array();
	if ($table_no=='') {
		$errors[]="You must enter a table number before you could send a request!";	
	}
	if (!empty($errors)) {
		 echo display_errors($errors);
	}
	else{

		$type='bill';
		$db->query("INSERT INTO requests (request_type,table_no) VALUES ('$type','$table_no')");
		header('Location: req_success.php');
	}
}


?>
<div class="container-fluid">
	<form action="requests.php" method="post" enctype="multipart/form-data">
		<div class="row front_nav">
			<div class="col-md-1 col-sm-1 col-xs-1 pull-left" style="padding: 5px">
					<a id="back"><i class="fa fa-arrow-left" style="font-size: 25px; color: red;"></i></a>
			</div>
			<div class="col-md-10 col-sm-10 col-xs-10 text-center" style="padding: 5px">
					<h3 class="text-center" style="color: red;"><b>Request</b></h3>
			</div>

			<div class="col-md-1 col-sm-1 col-xs-1 " style="padding: 5px">
				<a href="#">
					<i class="fa fa-bars" onclick="review();" style="font-size: 25px; color: red;"></i>
				</a>
			</div>
		</div>
		<div class="row text-center">
			<div style="padding-top: 20px">
				<img src="images/graphics/request.png" style="width: 150px; height: auto">
			</div>
			<div class="text-left review shadow" style="padding-top: 20px; padding-left: 20px; padding-right: 20px; padding-bottom: 20px">
				<p style="color: white;"><span class="glyphicon glyphicon-certificate"></span><b> If you wish to request a waiter or ask for your bill, enter your table number below.</b></p>
			</div>
		</div>
		<div class="row" style="padding-top: 15px;padding-bottom: 15px;background-image:linear-gradient(to top, rgba(252,84,4,1) 1%, rgba(255,0,0,1) 100%);">
			<div class="col-md-8 col-sm-8 col-xs-8" style="padding-right: 5px">
				<h4 style="color: white; margin-top: 5px"><b>Enter your table number</b></h4>
			</div>
			<div class="col-md-4 col-sm-4 col-xs-4" style="padding-left: 5px">
				<input type="text" name="table_no" class="form-control text-center" value="<?=(isset($_GET['edit']))? $orders['table_no']:'';?>" style="color: #000" placeholder="Table no.">
			</div>
		</div>
		<div class="row" style="padding-top: 15px;padding-bottom: 15px">
			<div class="col-md-6 col-sm-6 col-xs-6">
				<button type="submit" name="r_bill" class="btn btn-danger form-control" style="background-color: rgba(252,84,4,1);color:white;border-radius: 3px;">Request Bill</button>
			</div>
			<div class="col-md-6 col-sm-6 col-xs-6">
				<button type="submit" name="r_waiter" class="btn btn-danger form-control" style="background-color: rgba(252,84,4,1);color:white;border-radius: 3px;">Request waiter</button>
			</div>
		</div>
	</form>
</div>
<?php 
include "includes/footer.php";
?>