<?php

require_once "../core/init.php";
include "includes/head.php";
///////////////////////////////////////////////////////////////////////////////////
if(!is_logged_in()){
header('Location: login.php');
}
///////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////
if(isset($_SESSION['SBuser'])){
	$user_id=$_SESSION['SBuser'];
}

$resp_query=$db->query("SELECT * FROM waiters WHERE user_id='$user_id'");
$resp=mysqli_fetch_assoc($resp_query);
$tables=explode('-', $resp['resp_table']);

$orders_query=$db->query("SELECT * FROM orders WHERE (table_no BETWEEN '$tables[0]' AND '$tables[1]') AND (order_status=2 || takeout_status=2)");
?>
<div class="container-fluid">
	<div class="row" style="padding-top: 75px;padding-left:10px;padding-right:10px;">
		<?php while($orders=mysqli_fetch_assoc($orders_query)):?>
			<div class="col-md-12 col-sm-12 col-xs-12" style="padding-top:10px;margin-top:10px;background-color: #fff; border: 1px solid #f0f0f0;box-shadow:0 4px 10px 0 rgba(0, 0, 0, 0.12), 0 2px 10px 0 rgba(0, 0, 0, 0.12); border-radius: 10px;">
				<div class="col-md-12 col-sm-12 col-xs-12" style="border-bottom: 1px solid #d8d8d8">
						<h4 class="text-center"><span><b>Table Number: </b></span><b><?=$orders['table_no'];?></b></h4>
				</div>
				
				<?php
						if ($orders['items']=='""' && $orders['takeout_items']=='""') {
								continue;	
						}
						elseif($orders['items']!=='""'&&$orders['takeout_items']=='""'){
							$eatin_items_array=json_decode($orders['items'],true);
							$items_array=$eatin_items_array;
						}
						elseif ($orders['items']=='""'&&$orders['takeout_items']!=='""'){
							$takeout_items_array=json_decode($orders['takeout_items'],true);
							$items_array=$takeout_items_array;
						}			
	    				elseif($orders['items']!=='""'&&$orders['takeout_items']!=='""'){
	    					$eatin_items_array=json_decode($orders['items'],true);
	    					$takeout_items_array=json_decode($orders['takeout_items'],true);
	    					$items_array=array_merge($eatin_items_array,$takeout_items_array);
	    				}
	    				
	    				
	    				$num=1;
	    				foreach($items_array as $items):
	    					
	    					$items_id=$items['item_id'];
	    					$items_query=$db->query("SELECT * FROM menu WHERE id='$items_id'");
	    					$menu_item=mysqli_fetch_assoc($items_query);
	    					$custom_id=$items['custom_id'];
	    					$custom_query=$db->query("SELECT * FROM customize WHERE id='$custom_id'");
	    					$custom=mysqli_fetch_assoc($custom_query);
	    					$custom_items=json_decode($custom['composition'],true);
	    			?>
	    				<div class="col-md-4 col-sm-6 col-xs-6 text-center" style="padding-top: 10px">
							<div style="border: 3px solid red;width:86px; height:auto ; margin: 0% auto; border-radius: 50%; overflow: hidden; background-color: white; box-shadow:0 4px 10px 0 rgba(0, 0, 0, 0.30), 0 2px 10px 0 rgba(0, 0, 0, 0.30);">
								<img src="<?='../'.$menu_item['item_pic'];?>" class="image" style="width:80px; height: 80px; padding-top: 5px">
							</div>

							<div style="padding-top: 5px">
								<h5><b><?=$menu_item['item_name'];?></b><span style="color: red"><b>X<?=$items['quantity'];?></b></span></h5>
								<p style="color: green"><b><?=($items['custom_id']=='none')?'Regular':'Customized';?></b></p>
							</div>
						</div>
	    			<?php endforeach;?>
				<div class="col-md-12 col-sm-12 col-xs-12 text-right" style="padding-bottom: 15px; padding-top: 5px;">
					<a href="" id="done<?=$orders['id'];?>"  onClick="return confirm('Are you sure you are done?')"  class="btn btn-primary" style="box-shadow:0 4px 10px 0 rgba(0, 0, 0, 0.30), 0 2px 10px 0 rgba(0, 0, 0, 0.30);">Done</a>
				</div>	 
			</div> 
		<?php endwhile;?>
	</div>
</div>
<?php include "includes/navigation.php";
include "includes/footer.php";
?>