<?php
require_once "../core/init.php";
include "includes/head.php";

$current_date=date("Y-m-d h:i:s");
$current_date2=date("Y-m-d");
$orders_query=$db->query("SELECT * FROM orders WHERE (order_status=2 OR takeout_status=2) AND order_date LIKE '$current_date2%'");

?>

<div class="container-fluid">
	<div class="row" style="padding-top: 75px; padding-bottom: 30px;">
		<h1 class="text-center" style="font-family: 'Rockwell'; font-size: 3em"><b>Orders Report</b></h1>
	</div>
	<div class="row" style="padding: 20px">
		<div class="sparkline8-graph">
		<div class="static-table-list scrolling_wrapper">
		<table class="table table-striped">
			<thead>
				<th>Order No.</th>
				<th>Orders</th>
				<th>Total quantity</th>
				<th>Sub total</th>
				<th>15% Vat</th>
				<th>2% Service</th>
				<th>Total</th>
				<th>Order time stamp</th>
			</thead>
			<tbody>
				<?php 
					$total_quantity=0;
					$total_sub_total=0;
					$total_vat_total=0;
					$total_service=0;
					$total_total=0;
				while($orders=mysqli_fetch_assoc($orders_query)): 
					$items=json_decode($orders['items'],true);
					$takeouts=json_decode($orders['takeout_items'],true);
					///////////////////
					
				?>
					<tr>
						<td><?=$orders['id'];?></td>
						<td><?=orders_parser($items);orders_parser($takeouts);?></td>
						<td><?=orders_quantity_parser($items)+orders_quantity_parser($takeouts);?></td>
						<td><?php $sub_total_array=orders_price_parser($items);
								  $sub_total_takeout=orders_price_parser($takeouts);
								  $sub_total=$sub_total_array['sub_total'];
								  $sub_total_tk=$sub_total_takeout['sub_total'];
								  $sub_total=$sub_total+$sub_total_tk;
								  echo cash(round($sub_total,2));	 
						?></td>
						<td><?php $sub_total_array=orders_price_parser($items);
								  $sub_total_takeout=orders_price_parser($takeouts);
								  $vat_total=$sub_total_array['vat'];
								  $vat_total_tk=$sub_total_takeout['vat'];
								  $vat_total=$vat_total+$vat_total_tk;
								  echo cash(round($vat_total,2));	 
						?></td>
						<td><?php $sub_total_array=orders_price_parser($items);
								  $sub_total_takeout=orders_price_parser($takeouts);
								  $ser_total=$sub_total_array['service'];
								  $ser_total_tk=$sub_total_takeout['service'];
								  $ser_total=$ser_total+$ser_total_tk;
								  echo cash(round($ser_total,2));	 

						?></td>
						<td><?php $sub_total_array=orders_price_parser($items);
								  $sub_total_takeout=orders_price_parser($takeouts);
								  $tot_total=$sub_total_array['total'];
								  $tot_total_takeout=$sub_total_takeout['total'];
								  $tot_total=$tot_total+$tot_total_takeout;
								  echo cash(round($tot_total,2));	 
						?></td>
						<td><?=pretty_date($orders['order_date']);?></td>
					</tr>
				<?php 
				$total_quantity+=orders_quantity_parser($items)+orders_quantity_parser($takeouts);
				$total_sub_total+=$sub_total;
				$total_vat_total+=$vat_total;
				$total_service+=$ser_total;
				$total_total+=$tot_total;
				endwhile;?>
			</tbody>
			<tfoot>
				<tr>
					<td></td>
					<td></td>
					<th><?=round($total_quantity);?></th>
					<th><?=cash(round($total_sub_total,2));?></th>
					<th><?=cash(round($total_vat_total,2));?></th>
					<th><?=cash(round($total_service,2));?></th>
					<th><?=cash(round($total_total,2));?></th>
					<td></td>
					<td></td>
				</tr>
			</tfoot>
		</table>
	</div>
</div>
	</div>
</div>
<?php
include "includes/footer.php";
include "includes/navigation.php";
?>