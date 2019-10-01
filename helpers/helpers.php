<?php 
function display_errors($errors){
	$display= '<div class="container-fluid"><div class="row text-center"><ul class="bg-danger">';
	foreach ($errors as $error) {
		$display.='<li class="text-danger" style="padding:15px"><h4>'.$error.'</h4></li>';
	}
	$display.="</ul></div></div>";
	return $display;
}
function display_errors_two($errors){
	$display= '<div class="container-fluid" style="margin-top:50px;"><div class="row text-center"><ul class="bg-danger">';
	foreach ($errors as $error) {
		$display.='<li class="text-danger" style="padding:15px"><h4>'.$error.'</h4></li>';
	}
	$display.="</ul></div></div>";
	return $display;
}
function sanitize($dirty){
	return htmlentities($dirty);
}
function cash($number){

	return $number.' Br.';

}
function login($user_id){
	$_SESSION['SBuser']=$user_id;
	global $db;
	$date= date("Y-m-d H:i:s");
	$db->query("UPDATE users SET last_logged='$date' WHERE id='$user_id'");
	$_SESSION['success']='You have been logged in successfully!';
	header('Location: index.php');
}
function is_logged_in(){
	if(isset($_SESSION['SBuser'])&& $_SESSION['SBuser']>0){
		return true;
	}
	return false;
}
function has_permission($permission='admin'){
	global $user_data;
	$permissions=explode(',', $user_data['permission'] );
	if(in_array($permission, $permissions)){
		return true;
	}
	return false;
}
function session_error_redirect($url='login.php'){
	header('Location: index');
}
function login_error_redirect($url='login.php'){

	$_SESSION['error']='you need to be logged to access this page';
	header('Location:'.$url);
	echo 'you are not logging in!';

}
function permission_error_redirect($url='login.php'){
	echo 'no way bro';
	$_SESSION['error']='you dont have permission to access that page';
	header('Location:'.$url);
}
function pretty_date($date){
	return date("l M d, Y h:i A",strtotime($date));
}
function validate_post($post){
	return ((isset($_POST[$post]) && $_POST[$post]!='')?sanitize($_POST[$post]):'');
}

function validate_get($get){
	return (isset($_GET[$get])&& !empty($_GET[$get])?sanitize($_GET[$get]):'');
}

function total_sales(){
	global $db;
	$current_date=date("Y-m-d");
	$sale=0;
	$orders_query=$db->query("SELECT * FROM order_detail WHERE order_date LIKE '$current_date%'");

	while($order_results=mysqli_fetch_assoc($orders_query)){
		$quantity=$order_results['quantity'];
		$unit_price=$order_results['paid'];
		$sale=$sale+$unit_price;
	}
	return $sale;

}
function total_net_sales(){
	global $db;
	$current_date=date("Y-m-d");
	$sale=0;
	$orders_query=$db->query("SELECT * FROM order_detail WHERE order_date LIKE '$current_date%'");

	while($order_results=mysqli_fetch_assoc($orders_query)){
		$quantity=$order_results['quantity'];
		$unit_sale=$order_results['net_sale'];
		$sale=$sale+$unit_sale;
	}
	return $sale;	
}
function total_orders(){
	global $db;
	$current_date=date("Y-m-d");
	$orders_query=$db->query("SELECT * FROM order_detail WHERE order_date LIKE '$current_date%'");
	$orders=mysqli_num_rows($orders_query);

	return $orders;
}
function total_stock(){
	global $db;
	$stock_query=$db->query("SELECT * FROM products WHERE archived=0");
	$sum_total=0;
	while($stock_results=mysqli_fetch_assoc($stock_query)){
		$sizes_string=$stock_results['sizes'];
		$sizes_array=explode(',', $sizes_string);
		$size_len=sizeof($sizes_array);
		$sizes=array();
		$quantity=array();
		$sub_total=0;
		for ($i=0; $i <$size_len ; $i++) { 
			$temp=explode(':', $sizes_array[$i]);
			$sizes[$i]=$temp[0];
			$quantity[$i]=$temp[1];
		}
		for ($j=0; $j < $size_len ; $j++) { 
			$sub_total=$sub_total+$quantity[$j];
		}
		$sum_total=$sum_total+$sub_total;
	}
	return $sum_total;

}
function notif_num(){
	global $db;
	$notify_query=$db->query("SELECT * FROM notifications WHERE seen=0");
	$notif_num=mysqli_num_rows($notify_query);
	return $notif_num;
}
function notify_all($p_id){
	global $db;
	$unpaid_import_query=$db->query("SELECT * FROM products WHERE id='$p_id' AND import_unpaid_amount!=0");
	$unpaid_sell_query=$db->query("SELECT * FROM order_detail WHERE product_id='$p_id' AND due!=0");

	if (mysqli_num_rows($unpaid_import_query)!=0) {
		notify_unpaid_import($unpaid_import_query);
		
	}
	if (mysqli_num_rows($unpaid_sell_query)!=0) {
		notify_unrecieved_payment($unpaid_sell_query,$p_id);
		
	}

}
function notify_unpaid_import($unpaid_import_query){
		global $db;
		$import_unpaid=mysqli_fetch_assoc($unpaid_import_query);
	
		$p_name=$import_unpaid['title'];
		$p_id=$import_unpaid['id'];
		
		$notification='The import amount to be paid for the item '.$p_name.' is not complete';
		$db->query("INSERT INTO notifications (prod_id, message) VALUES ('$p_id','$notification')");
	
}
function notify_unrecieved_payment($unpaid_sell_query,$p_id){
		global $db;
		$p_unpaid=mysqli_fetch_assoc($unpaid_sell_query);
		$p_id=$p_unpaid['product_id'];
		$p_query=$db->query("SELECT * FROM products WHERE id='$p_id'");
		$p_result=mysqli_fetch_assoc($p_query);
		$p_name=$p_result['title'];
		$notification='You have payment due for the item '.$p_name;
		$db->query("INSERT INTO notifications (prod_id, message) VALUES ('$p_id','$notification')");
}
function noftify_out_stock(){
	get_notification_queries();
	$out_of_stock=get_quantities();
	$num_out_stock=sizeof($out_of_stock);
	for ($i=0; $i < $num_out_stock; $i++) { 
		$p_id=$out_of_stock[$i]['id'];
		$p_query=$db->query("SELECT * FROM products WHERE id='$p_id'");
		$prod=mysqli_fetch_assoc($p_query);
		$notification='The item: '.$prod['title'].' size: '.$out_of_stock[$i]['size'].' is out of stock';
		$db->query("INSERT INTO notifications (prod_id, message) VALUES ('$p_id','$notification')");
	}
}

function get_quantities(){
	global $db;
	$stock_query=$db->query("SELECT * FROM products WHERE archived=0");
	
	$empty_sizes=array();
	$c=0;
	while($stock_results=mysqli_fetch_assoc($stock_query)){
		$sizes_string=$stock_results['sizes'];
		$sizes_array=explode(',', $sizes_string);
		$size_len=sizeof($sizes_array);
		$sizes=array();
		$quantity=array();

		for ($i=0; $i <$size_len ; $i++) { 
			$temp=explode(':', $sizes_array[$i]);
			$sizes[$i]=$temp[0];
			$quantity[$i]=$temp[1];
		}
		for ($j=0; $j < $size_len ; $j++) { 
			if ($quantity[$j]==0) {
				$empty_sizes[$c]['id']=$stock_results['id'];
				$empty_sizes[$c]['size']=$sizes[$j];
					$c++;
			}
		}
	
	}
	return $empty_sizes;
}
function parse_date($dated){
	if($dated!=''){
	$temp=explode('/', $dated);
	$real_date=$temp[2].'-'.$temp[0].'-'.$temp[1];
	return $real_date;
	}
	else{
		return '';
	}
}
function categories_parser(){
	global $db;

	$parent_array=$arrayName = array();
$p_query=$db->query("SELECT * FROM catagories WHERE parent=0");
$j=0;
while ($parent=mysqli_fetch_assoc($p_query)) {
	$parent_array[$j]['parent']=$parent['catagory'];
	$parent_array[$j]['id']=$parent['id'];
	$j++;
}
$len=sizeof($parent_array);

$data=$arrayName = array();
$sum=0;


for ($i=0; $i < $len ; $i++) { 
	$par=$parent_array[$i]['id'];
	$quan_query=$db->query("SELECT * FROM `catagories` JOIN `products` WHERE catagories=catagories.id AND archived=0 AND parent='$par'");
	$sum_total=0;
	$check=mysqli_num_rows($quan_query);


	if($check > 0){
		while($stock_results=mysqli_fetch_assoc($quan_query)){
		
			$sizes_string=$stock_results['sizes'];
			$sizes_array=explode(',', $sizes_string);
			$size_len=sizeof($sizes_array);
			$sizes=array();
			$quantity=array();
			$sub_total=0;
			for ($k=0; $k <$size_len ; $k++) { 
				$temp=explode(':', $sizes_array[$k]);
				$sizes[$k]=$temp[0];
				$quantity[$k]=$temp[1];
			}
			for ($j=0; $j < $size_len ; $j++) { 
				$sub_total=$sub_total+$quantity[$j];
			}
			$sum_total=$sum_total+$sub_total;
		}	
	}
	$data[$i]['parent']=$parent_array[$i]['parent'];
	$data[$i]['quantity']=$sum_total;
}
return $data;
}
function validate_text(){
	 
}
function validate_number(){

}
function validate_image(){

}
function validate_video(){

}

/////////////////////////////////////////////////////////////////////////////
function end_session($session_id_to_destroy){
	
// 1. commit session if it's started.
if (session_id()) {
    session_commit();
}

// 2. store current session id
session_start();
$current_session_id = session_id();
session_commit();

// 3. hijack then destroy session specified.
session_id($session_id_to_destroy);
session_start();
session_destroy();
session_commit();

// 4. restore current session id. If don't restore it, your current session will refer     to the session you just destroyed!
session_id($current_session_id);
session_start();
session_commit();
}

function orders_parser($orders_array){
	global $db;
	
	$items_array=array();
	$index=0;
	foreach($orders_array as $orders){
		$item_id=$orders['item_id'];
		$menu_item=mysqli_fetch_assoc($db->query("SELECT * FROM menu WHERE id='$item_id'"));

		$items_array[$index]['name']=$menu_item['item_name'];
		$items_array[$index]['quantity']=$orders['quantity'];
		$index++;
	}
	?>
	<ul>
		<?php foreach($items_array as $items): ?>
			<li><?='~ '.$items['name'].' * '.$items['quantity'];?></li>
		<?php endforeach;?>
	</ul>
<?php
}
function orders_quantity_parser($orders_array){
	$total_quantity=0;
	foreach($orders_array as $orders){
		$item_quantity=$orders['quantity'];
		$total_quantity+=$item_quantity;
	}
	return $total_quantity;
}
function orders_price_parser($orders_array){
	global $db;
	$price_array=array();

	$vat=0;
	$actual_base_price=0;
	$ser_charge=0;
	foreach($orders_array as $orders){
		$item_id=$orders['item_id'];
		$menu_item=mysqli_fetch_assoc($db->query("SELECT * FROM menu WHERE id='$item_id'"));
		$price=$menu_item['price'];
		$quantity=$orders['quantity'];
		$base_price=(int)($price/1.15)*$quantity;
		$vat=$vat+(0.15*$base_price);
		$pre_actual_base=($base_price/1.02);
		$actual_base_price=$actual_base_price+$pre_actual_base;
		$ser_charge=$ser_charge+($base_price-$pre_actual_base);

	
	}
		$price_array['sub_total']=$actual_base_price;
		$price_array['vat']=$vat;
		$price_array['service']=$ser_charge;
		$price_array['total']=$actual_base_price+$vat+$ser_charge;

	return $price_array;

}
?>