<?php 
$cookie_name='cookie_monster';
$cookie_value='yam yam';
$cart_expire=date("Y-m-d H:i:s",strtotime("+30 days"));
setcookie($cookie_name,$cookie_value,time() + (86400 * 30),'/');

if(isset($_COOKIE['cookie_monster'])){
	echo 'the cookie name is: '.$cookie_name.' and the cookie value is: '.$_COOKIE['cookie_monster'];
}
else{
	echo "something is not working";
}

?>