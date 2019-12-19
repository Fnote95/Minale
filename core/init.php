<?php 
$db= mysqli_connect("127.0.0.1","root","","res_automation");
if(mysqli_connect_errno()){
echo "There was a problem connecting to the database".mysqli_connect_error();
die();
}
session_start();
require_once $_SERVER['DOCUMENT_ROOT'].'/menu/config.php';
require_once BASEURL.'\menu\helpers\helpers.php';


$cart_id='';
if(isset($_COOKIE[CART_COOKIE])){ 
	$cart_id=sanitize($_COOKIE[CART_COOKIE]);
}

if(isset($_SESSION['SBuser'])){
	$user_id=$_SESSION['SBuser'];
	$squery=$db->query("SELECT * FROM users WHERE id='$user_id'");  
	$user_data=mysqli_fetch_assoc($squery);
	$fn=explode(' ', $user_data['full_name']);
	$user_data['first']=$fn[0];
	if(sizeof($fn)==2){
		$user_data['last']=$fn[1];
	}
	//$permission=$user_data['permission'];
	
	
}

if (isset($_SESSION['success'])) {
	
	//unset($_SESSION['success']);
}
if (isset($_SESSION['error'])) {
	echo '<script>alert('.$_SESSION['error'].');</script>';
	//echo '<div class="container-fluid"><div class="row"><div class="bg-danger"><p class="text-center text-danger">'.$_SESSION['error'].'</p></div></div></div>';
	unset($_SESSION['error']);
}
