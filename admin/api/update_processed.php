<?php
require_once "../../core/init.php";

$order_processed_query=$db->query("SELECT * FROM orders WHERE order_status=1");
//$queued_js_index=8;
$process_js_index=8;


ob_start();?>
	<h2 class="text-center"><b>Orders Being Processed</b></h2>
	<?php while($order_processed=mysqli_fetch_assoc($order_processed_query)): 
		$cust_array=json_decode($order_processed['items'],true);
		if ($cust_array=="") {
			continue;
		}
		$cust_check=0;
		foreach ($cust_array as $cust) {
			if ($cust['custom_id']!='none') {
				$cust_check++;
			}
		}?>
		<script>
			
			 
			 setInterval(function(){
	         var v1="<?=$order_processed['order_date'];?>";
	         var diff = Math.abs(new Date() - new Date(v1.replace(/-/g,'/')));
	         var link="eatin?done=<?=$order_processed['id'];?>&time="+diff;
	     	 jQuery('#done<?=$order_processed['id'];?>').attr("href", link);
	         var result=msToTime(diff);
	         jQuery('#<?=$order_processed['id'];?>').html('<b>'+result+'</b>');
	        ;}, 1);
		
		</script>
		<div class="col-md-12 col-sm-12 col-xs-12" style="padding:15px; margin-top: 15px; background-color: #fff; border: 1px solid #f0f0f0;box-shadow:0 4px 10px 0 rgba(0, 0, 0, 0.12), 0 2px 10px 0 rgba(0, 0, 0, 0.12); border-radius: 10px;">
			<div class="row" style="border-bottom: 1px solid #d8d8d8">
				<div class="col-md-2 col-sm-2"><h4 style="color: red"><b>#<?=$order_processed['id'];?></b></h4></div>
					<div class="col-md-3 col-sm-3"><h5><b>Table No. <?=$order_processed['table_no'];?></b></h5></div>
				<div class="col-md-4 col-sm-4"><h5 style="color: green"><b><?=($cust_check>0)? $cust_check.' Customized orders':'All Regular';?></b></h5></div>
				<div class="col-md-3 col-sm-4">
					<h4 style="color: red" id="<?=$order_processed['id'];?>"><b></b></h4>
				</div>
			</div>
		<div class="row" style="padding: 5px">
			<?php
				$items_array=json_decode($order_processed['items'],true);
				$num=0;
				$done_btn_check=0;
				foreach($items_array as $items):
					
					$items_id=$items['item_id'];
					$items_query=$db->query("SELECT * FROM menu WHERE id='$items_id'");
					$perm_query=$db->query("SELECT * FROM menu JOIN category JOIN kitchens WHERE cat_id=category.id AND kit_id=kitchens.id AND admin='$user_id' AND menu.id='$items_id'");
					$perm_result=mysqli_fetch_assoc($perm_query);
					//var_dump($perm_result);
					//var_dump($user_id);

					
					$menu_item=mysqli_fetch_assoc($items_query);
	    					$c_id=$menu_item['cat_id'];
	    					$cat_query=$db->query("SELECT * FROM category WHERE id='$c_id'");
	    					$cat_result=mysqli_fetch_assoc($cat_query);
					$ing_type=$menu_item['ing_type'];
					$custom_id=$items['custom_id'];
					$custom_query=$db->query("SELECT * FROM customize WHERE id='$custom_id'");
					$custom=mysqli_fetch_assoc($custom_query);
					$custom_items=json_decode($custom['composition'],true);
					
					
			?>	
				<div class="col-md-4 col-sm-4 text-center">
					<div style="border: 3px solid red;width:86px; height:auto ; margin: 0% auto; border-radius: 50%; overflow: hidden; background-color: white; box-shadow:0 4px 10px 0 rgba(0, 0, 0, 0.30), 0 2px 10px 0 rgba(0, 0, 0, 0.30);">
						<img src="<?='../'.$menu_item['item_pic'];?>" class="image" style="width:80px; height: 80px; padding-top: 5px">
					</div>

					<div style="padding-top: 5px">
						<h5><b><?=$menu_item['item_name'];?></b> <span style="color: red"><b>X <?=$items['quantity'];?></b></span></h5>
						<p style="color: purple"><b><?=$cat_result['cat_name'];?></b></p>
						<p style="color: blue"><b><?=($items['custom_id']=='none')?'Regular':'Customized';?></b></p>
						
						<?php 
	        				if ($items['custom_id']=='none') {
	        				}
	        				else{
	        					if ($custom_items==null) {?>
	        					<h5 style="color:green;"><?=$custom['composition'];?></h5>
	        				<?php }
	        				else{
	        				?>
	        				<table class="table table-striped">
	        					<thead>
	        				
	        					</thead>
	        					<tbody>
	        						<?php foreach($custom_items as $cus_items): ?>
	        						<tr>
	        							
	        								<td><?=$cus_items['comp'];?></td>
	        								<td><?=($ing_type==1)?$cus_items['quantity']:(($cus_items['needed']=="true")?"<span class='glyphicon glyphicon-ok'></span>":"<span class='glyphicon glyphicon-remove'></span>");?></td>
	        							
	        						</tr>
	        						<?php endforeach; ?>
	        					</tbody>
	        				</table>
        				<?php }}?>
        				<?php if(has_permission('Admin')||has_permission('Chef')):?>
        					<p style="color: green"><b><?=($items['mini_status']==0)?'Processing...':'Ready!';?></b></p>
        				<?php endif;?>
        				<?php if((has_permission('Chef'))&&($items['mini_status']==0)&&($perm_result!=null||has_permission('Admin'))):?>
        					<a href="eatin?finish=<?=$order_processed['id'];?>&item=<?=$num;?>" class="btn btn-primary btn-xs shadow"><span class="glyphicon glyphicon-ok"></span></a>
        				<?php endif;?>
					</div><hr>
					
				</div>
			<?php 
			$num++;
			if ($items['mini_status']==1) {
				$done_btn_check++;
			}
			endforeach;?>
			<div class="col-md-12 col-sm-12 col-xs-12 text-center">
				<?php if(has_permission('Admin')&&($num==$done_btn_check)):?>
				<a href="" id="done<?=$order_processed['id'];?>"  onClick="return confirm('Are you sure you are done?')"  class="btn btn-primary" style="box-shadow:0 4px 10px 0 rgba(0, 0, 0, 0.30), 0 2px 10px 0 rgba(0, 0, 0, 0.30);">Done</a>
				<?php endif;?>
			</div>
		</div>
	</div>

	<?php endwhile;?>
<?php echo ob_get_clean();?>