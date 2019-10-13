<?php
require_once "../core/init.php";

if(!is_logged_in()){
header('Location: login.php');
}
include "includes/head.php";
/////////////////////////////////////////////////////////////////////////////
$current_date=date("Y-m-d");
/////////////////////////////////////////////////////////////////////////////

$orders_stat_query=$db->query("SELECT * FROM orders WHERE (order_status=2 OR takeout_status=2) AND order_date LIKE '$current_date%'");
$total_total=0;
while ($order_stat=mysqli_fetch_assoc($orders_stat_query)) {
	$items=json_decode($order_stat['items'],true);
	$takeout_items=json_decode($order_stat['takeout_items'],true);
	if ($items=="") {
		$sub_total_array=0;
	}
	else{
		$sub_total_array=orders_price_parser($items);
	}
	if ($takeout_items==""){
		$sub_takeout_array=0;
	}
	else{
		$sub_takeout_array=orders_price_parser($takeout_items);
	}
	
	
	$tot_total=$sub_total_array['total']+$sub_takeout_array['total'];
	$total_total+=$tot_total;
}
/////////////////////////////////////////////////////////////////
$eatin_query=$db->query("SELECT * FROM orders WHERE (order_status=1 OR order_status=0) AND order_date LIKE '$current_date%'");

$total_eatin=0;
while ($eatin_stat=mysqli_fetch_assoc($eatin_query)) {
	$items=json_decode($eatin_stat['items'],true);
	if ($items=="") {
		$total_eatin+=0;
	}
	else{
		$total_eatin+=orders_quantity_parser($items);
	}
	
}
/////////////////////////////////////////////////////////////////////////////
$takeout_query=$db->query("SELECT * FROM orders WHERE (takeout_status=1 OR takeout_status=3) AND order_date LIKE '$current_date%'");
$total_takeout=0;
while ($takeout_stat=mysqli_fetch_assoc($takeout_query)) {
	$items=json_decode($takeout_stat['takeout_items'],true);
	if ($items=="") {
		$total_takeout+=0;
	}
	else{
		$total_takeout+=orders_quantity_parser($items);
	}
	
}
////////////////////////////////////////////////////////////////////////////
$total_orders_query=$db->query("SELECT * FROM orders WHERE order_date LIKE '$current_date%'");
$total=0;
$eatin_parsed=0;
$takeout_parsed=0;

while ($total_orders=mysqli_fetch_assoc($total_orders_query)) {
	$items=json_decode($total_orders['items'],true);
	$takeouts=json_decode($total_orders['takeout_items'],true);
	if ($items=="") {
		$eatin_parsed=0;
	}
	elseif($takeouts==""){
		$takeout_parsed=0;
	}
	elseif($takeouts==""&&$items==""){
		$takeout_parsed=0;
		$eatin_parsed=0;
	}
	else{
		$eatin_parsed=orders_quantity_parser($items);
		$takeout_parsed=orders_quantity_parser($takeouts);
	}
	
	$total+=($eatin_parsed+$takeout_parsed);
	
}


/////////////////////////////////////////////////////////////////////////////
$total_menu_query=$db->query("SELECT * FROM menu");
$total_menu_item=mysqli_num_rows($total_menu_query);
?>
<div class="income-order-visit-user-area" style="padding-top: 75px">
	<div class="container-fluid">
		<div class="col-md-2 text-center">
				<canvas id="canvas2" width="150" height="150" style="box-shadow:0 4px 10px 0 rgba(0, 0, 0, 0.30), 0 2px 10px 0 rgba(0, 0, 0, 0.30); border-radius: 10px;background-color:#500101">
				</canvas>
				<div style="padding-top: 50px">
					<img src="../logo.png" style="width: 250px; height: auto">
				</div>
				
		</div>
		<div class="col-md-10">
	        <div class="col-lg-3 col-md-6 col-sm-12">
	            <div class="income-dashone-total income-monthly shadow-reset nt-mg-b-30" style="box-shadow:0 4px 10px 0 rgba(0, 0, 0, 0.30), 0 2px 10px 0 rgba(0, 0, 0, 0.30); border-radius: 10px;">
	                <div class="income-title">
	                    <div class="main-income-head">
	                        <h2>Sales</h2>
	                        <div class="main-income-phara">
	                            <p>Today</p>
	                        </div>
	                    </div>
	                </div>
	                <div class="income-dashone-pro">
	                    <div class="income-rate-total">
	                        <div class="price-adminpro-rate">
	                            <h3><span>Br. </span><span class="counter"><?=$total_total;?></span></h3>
	                        </div>
	                        <div class="price-graph">
	                            <span id="sparkline1"><canvas width="27" height="16" style="display: inline-block; width: 27px; height: 16px; vertical-align: top;"></canvas></span>
	                        </div>
	                    </div>
	                    <div class="income-range">
	                        <p>Total income</p>
	                        <span class="income-percentange">98% <i class="fa fa-bolt"></i></span>
	                    </div>
	                    <div class="clear"></div>
	                </div>
	            </div>
	        </div>
	        <div class="col-lg-3 col-md-6 col-sm-12">
	            <div class="income-dashone-total income-monthly shadow-reset nt-mg-b-30" style="box-shadow:0 4px 10px 0 rgba(0, 0, 0, 0.30), 0 2px 10px 0 rgba(0, 0, 0, 0.30); border-radius: 10px;">
	                <div class="income-title">
	                    <div class="main-income-head">
	                        <h2>Eat-in orders</h2>
	                        <div class="main-income-phara">
	                            <p>Today</p>
	                        </div>
	                    </div>
	                </div>
	                <div class="income-dashone-pro">
	                    <div class="income-rate-total">
	                        <div class="price-adminpro-rate">
	                            <h3><span class="counter"><?=$total_eatin;?></span></h3>
	                        </div>
	                        <div class="price-graph">
	                            <span id="sparkline1"><canvas width="27" height="16" style="display: inline-block; width: 27px; height: 16px; vertical-align: top;"></canvas></span>
	                        </div>
	                    </div>
	                    <div class="income-range">
	                        <p>New orders</p>
	                        <span class="income-percentange">98% <i class="fa fa-bolt"></i></span>
	                    </div>
	                    <div class="clear"></div>
	                </div>
	            </div>
	        </div>
	        <div class="col-lg-3 col-md-6 col-sm-12">
	            <div class="income-dashone-total orders-monthly shadow-reset nt-mg-b-30" style="box-shadow:0 4px 10px 0 rgba(0, 0, 0, 0.30), 0 2px 10px 0 rgba(0, 0, 0, 0.30); border-radius: 10px;">
	                <div class="income-title">
	                    <div class="main-income-head">
	                        <h2>Takeout orders</h2>
	                        <div class="main-income-phara order-cl">
	                            <p>Today</p>
	                        </div>
	                    </div>
	                </div>
	                <div class="income-dashone-pro">
	                    <div class="income-rate-total">
	                        <div class="price-adminpro-rate">
	                            <h3><?=$total_takeout;?></h3>
	                        </div>
	                        <div class="price-graph">
	                            <span id="sparkline6"><canvas width="56" height="16" style="display: inline-block; width: 56px; height: 16px; vertical-align: top;"></canvas></span>
	                        </div>
	                    </div>
	                    <div class="income-range order-cl">
	                        <p>New Orders</p>
	                        <span class="income-percentange">66% <i class="fa fa-level-up"></i></span>
	                    </div>
	                    <div class="clear"></div>
	                </div>
	            </div>
	        </div>
	        <div class="col-lg-3 col-md-6 col-sm-12">
                <div class="income-dashone-total visitor-monthly shadow-reset nt-mg-b-30" style="box-shadow:0 4px 10px 0 rgba(0, 0, 0, 0.30), 0 2px 10px 0 rgba(0, 0, 0, 0.30); border-radius: 10px;">
                    <div class="income-title">
                        <div class="main-income-head">
                            <h2>Total orders</h2>
                            <div class="main-income-phara visitor-cl">
                                <a href="products.php"><p>View</p></a>
                            </div>
                        </div>
                    </div>
                    <div class="income-dashone-pro">
                        <div class="income-rate-total">
                            <div class="price-adminpro-rate">
                                <h3><span class="counter"><?=$total;?></span></h3>
                            </div>
                            <div class="price-graph">
                                <span id="sparkline2"><canvas width="39" height="19" style="display: inline-block; width: 39px; height: 19px; vertical-align: top;"></canvas></span>
                            </div>
                        </div>
                        <div class="income-range visitor-cl">
                            <p></p>
                            <span class="income-percentange">55% <i class="fa fa-level-up"></i></span>
                        </div>
                        <div class="clear"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12">
                <div class="income-dashone-total visitor-monthly shadow-reset nt-mg-b-30" style="box-shadow:0 4px 10px 0 rgba(0, 0, 0, 0.30), 0 2px 10px 0 rgba(0, 0, 0, 0.30); border-radius: 10px;">
                    <div class="income-title">
                        <div class="main-income-head">
                            <h2>Average wait time</h2>
                        </div>
                    </div>
                    <div class="income-dashone-pro">
                        <div class="income-rate-total">
                            <div class="price-adminpro-rate">
                                <h3><span class="counter"><?=average_wait_time();?></span><span> Minutes</span></h3>
                            </div>
                            <div class="price-graph">
                                <span id="sparkline2"><canvas width="39" height="19" style="display: inline-block; width: 39px; height: 19px; vertical-align: top;"></canvas></span>
                            </div>
                        </div>
                        <div class="income-range visitor-cl">
                            <p></p>
                            <span class="income-percentange">55% <i class="fa fa-level-up"></i></span>
                        </div>
                        <div class="clear"></div>
                    </div>
                </div>
            </div>
	        <div class="col-lg-3 col-md-6 col-sm-12">
                <div class="income-dashone-total visitor-monthly shadow-reset nt-mg-b-30" style="box-shadow:0 4px 10px 0 rgba(0, 0, 0, 0.30), 0 2px 10px 0 rgba(0, 0, 0, 0.30); border-radius: 10px;">
                    <div class="income-title">
                        <div class="main-income-head">
                            <h2>Menu items</h2>
                            <div class="main-income-phara visitor-cl">
                                <a href="products.php"><p>View</p></a>
                            </div>
                        </div>
                    </div>
                    <div class="income-dashone-pro">
                        <div class="income-rate-total">
                            <div class="price-adminpro-rate">
                                <h3><span class="counter"><?=$total_menu_item;?></span></h3>
                            </div>
                            <div class="price-graph">
                                <span id="sparkline2"><canvas width="39" height="19" style="display: inline-block; width: 39px; height: 19px; vertical-align: top;"></canvas></span>
                            </div>
                        </div>
                        <div class="income-range visitor-cl">
                            <p></p>
                            <span class="income-percentange">55% <i class="fa fa-level-up"></i></span>
                        </div>
                        <div class="clear"></div>
                    </div>
                </div>
            </div>	   
             <div class="col-lg-3 col-md-6 col-sm-12">
	    	<?php $best_seller=best_seller($current_date);
	    		$best_id=$best_seller[0]['id'];
	    		$best_quantity=$best_seller[0]['quan'];
	    		$best_query=$db->query("SELECT * FROM menu WHERE id='$best_id'");
	    		$best=mysqli_fetch_assoc($best_query);
	    	?>
	            <div class="income-dashone-total income-monthly shadow-reset nt-mg-b-30" style="box-shadow:0 4px 10px 0 rgba(0, 0, 0, 0.30), 0 2px 10px 0 rgba(0, 0, 0, 0.30); border-radius: 10px;">
	                <div class="income-title">
	                    <div class="main-income-head">
	                        <h2>Best seller</h2>
	                        <div class="main-income-phara">
	                            <p>Today</p>
	                        </div>
	                    </div>
	                </div>
	                <div class="income-dashone-pro">
	                    <div class="income-rate-total">
	                    <div class="col-md-6 col-sm-6">
	   						<div  style="border: 3px solid rgba(252,84,4,1);width:70px; height:70px ; border-radius: 50%; overflow: hidden; background-color: white; margin-top: -10px;margin-left: -20px">
								<img src="<?='../'.$best['item_pic'];?>" alt="" style="width: 100px; height: auto; padding-top: 5px">
							</div>
						</div>
						<div class="col-md-6 col-sm-6">
								<h4 class="text-right" style="color: white; margin-right: -10px"><?=$best['item_name'];?></h4>
						</div>
 						
	                    <div class="income-range">
	                       
	                        <span class="income-percentange"><?=$best_quantity;?> Orders <i class="fa fa-bolt"></i></span>
	                    </div>
	                    <div class="clear"></div>
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