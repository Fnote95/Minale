<?php
require_once "../core/init.php";
include "includes/head.php";

$current_date=date("Y-m-d h:i:s");

$orders_query=$db->query("SELECT * FROM orders WHERE order_status=2");

?>
	<div class="row" style="padding-top: 75px; padding-bottom: 30px;">
		<h1 class="text-center" style="font-family: 'Rockwell'; font-size: 3em"><b>Orders Report</b></h1>
	</div>
<div class="container-fluid">
	<div class="row" style="padding: 20px">
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
					///////////////////
					
				?>
					<tr>
						<td><?=$orders['id'];?></td>
						<td><?=orders_parser($items);?></td>
						<td><?=orders_quantity_parser($items);?></td>
						<td><?php $sub_total_array=orders_price_parser($items);
								  $sub_total=$sub_total_array['sub_total'];
								  echo cash(round($sub_total));	 
						?></td>
						<td><?php $sub_total_array=orders_price_parser($items);
								  $vat_total=$sub_total_array['vat'];
								  echo cash(round($vat_total));	 
						?></td>
						<td><?php $sub_total_array=orders_price_parser($items);
								  $ser_total=$sub_total_array['service'];
								  echo cash(round($ser_total));	 

						?></td>
						<td><?php $sub_total_array=orders_price_parser($items);
								  $tot_total=$sub_total_array['total'];
								  echo cash(round($tot_total));	 
						?></td>
						<td><?=pretty_date($orders['order_date']);?></td>
					</tr>
				<?php 
				$total_quantity+=orders_quantity_parser($items);
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
					<th><?=cash(round($total_sub_total));?></th>
					<th><?=cash(round($total_vat_total));?></th>
					<th><?=cash(round($total_service));?></th>
					<th><?=cash(round($total_total));?></th>
					<td></td>
					<td></td>
				</tr>
			</tfoot>
		</table>
	</div>
</div>
<?php
include "includes/footer.php";
include "includes/navigation.php";
?>