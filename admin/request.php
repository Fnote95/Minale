<?php
require_once "../core/init.php";
include "includes/head.php";

if (isset($_GET['delete'])&&!empty($_GET['delete'])) {
	$delete_id=sanitize($_GET['delete']);
	$db->query("DELETE FROM requests WHERE id='$delete_id'");
	//$_SESSION['success']='The user has been deleted';
	header('Locataion: request.php');
}
?>
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12 col-sm-12">
	</div>
	<div class="row" style="padding-top: 75px; padding-bottom: 30px;">
		<h2 class="text-center" style="font-family: 'Rockwell'; font-size: 3em"><b>Customer requests</b></h2><hr>
	</div>
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12" id="req">

		</div>
	</div>

</div>
<?php 
include "includes/footer.php";
include "includes/navigation.php";
?>