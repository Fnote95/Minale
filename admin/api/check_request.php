<?php
require_once "../../core/init.php";
$req_query=$db->query("SELECT * FROM requests");

ob_start();?>
<?php while ($req=mysqli_fetch_assoc($req_query)):?>

<div class="col-md-3 col-sm-12 col-xs-12" id="req" class="shadow">
	<div class="col-md-12 col-sm-12 col-xs-12" style="margin-top:10px;background-color: #fff; border: 1px solid #f0f0f0;box-shadow:0 4px 10px 0 rgba(0, 0, 0, 0.12), 0 2px 10px 0 rgba(0, 0, 0, 0.12); border-radius: 10px;padding: 20px">
		<div class="col-md-12">
			<h4>Table no. <?=$req['table_no'];?></h4>
		</div>
		<div class="col-md-12">
			<h4>Requesting a <?=$req['request_type'];?></h4>
		</div>
	</div>
</div>


<?php endwhile;?>
<?php echo ob_get_clean();?>