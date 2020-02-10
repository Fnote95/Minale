<?php
require_once "../core/init.php";
include "includes/head.php";

$orders_query=$db->query("SELECT * FROM orders WHERE order_status=2 AND takeout_status=2");
?>
<div class="container-fluid">
	<div class="row" style="padding-top: 70px">
		<div class="col-md-12 col-sm-12">
			
			<div class="col-md-6 shadow" style="height: 100vh;padding:20px; border-radius: 5px">
				<div class="col-md-12 col-sm-12" style="height: 90vh;border: solid 1px #c3c3c3; border-radius: 5px">
					<h4 style="padding-top: 10px" class="text-center"><b>Orders Detail</b></h4>
					<h5><b>Order No.:</b></h5>
					<h5><b>Table No.:</b></h5><hr>
					<table class="table table-striped table-condensed">
						<thead>
							<th class="text-center">Items</th>
							<th class="text-center">Order type</th>
							<th class="text-center">Quantity</th>
							<th class="text-center">Add ons</th>
						</thead>
						<tbody id="details">

						</tbody>
					</table>
				</div>
				
				
			</div>
			<div class="col-md-6" style="height: 100vh;">
				<div class="row">
					<div class="col-md-12">
						<h3 class="text-center">List of orders to process</h3><hr>
						<?php while($order_result=mysqli_fetch_assoc($orders_query)): 
								$order_number=$order_result['id'];
								$table_number=$order_result['table_no'];
							?>
							<div class="col-md-6 col-sm-12 col-xs-12" id="req" class="shadow" style="margin-bottom: 15px">

								<div class="col-md-12 col-sm-12 col-xs-12" style="margin-top:10px;background-color: #fff; border: 1px solid #f0f0f0;box-shadow:0 4px 10px 0 rgba(0, 0, 0, 0.12), 0 2px 10px 0 rgba(0, 0, 0, 0.12); border-radius: 10px;padding: 20px">
									<div class="col-md-12 col-sm-12 col-xs-12 text-right" style="margin-top: -10px; margin-right: -40px;">		
									</div>
									<div class="col-md-12">
										<p><b>Order No.:</b> <span style="font-size: 15px;"><?=$order_number;?></span></p>
									</div>
									<div class="col-md-12">
										<p><b>Table No.:</b> <span style="font-size: 15px;"><?=$table_number;?></span></p>
									</div>
									<div class="col-md-12 col-sm-12 col-xs-12 text-right">
										<button class="btn btn-primary btn-sm shadow" style="margin-right: -20px;margin-bottom: -10px" onclick="process(<?=$order_number;?>)">Process</button>
									</div>
								</div>

							</div>
						<?php endwhile;?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
include "includes/footer.php";
include "includes/navigation.php";
?>