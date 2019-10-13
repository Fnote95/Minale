<?php 
require_once '..\core\init.php';

include 'includes\head.php';

$email=(isset($_POST['email'])? sanitize($_POST['email']):'');
$email=trim($email);
$password=(isset($_POST['password'])? sanitize($_POST['password']):'');
$password=rtrim($password);
$errors=array();
if (isset($_POST['submit'])) {
	# code...
}

?>

<div class="container-fluid">
	<div class="row" style="margin-top: 100px"></div>
	<div class="row">
		<div class="col-md-4"></div>
		<div class="charts-single-pro shadow-reset col-md-4 col-xs-12">
		<div>
			<?php
				if ($_POST) {
				 	//form validation
				 	if ($email==''||$password=='') {
				 		$errors[]='Both email and password are required';
				 	}
				 	//validate email
				 	if (!filter_var($email,FILTER_VALIDATE_EMAIL)) {
				 		$errors[]='you must enter a valid email';
				 	}
				 	//check to see if the email exists in the database
				 	$emailquery=$db->query("SELECT * FROM users WHERE email='$email'");
				 	$user=mysqli_fetch_assoc($emailquery);
				 	$emailCount=mysqli_num_rows($emailquery);
				 	if($emailCount==0){
				 		$errors[]='The email doesnt match any of our records';
				 	}
				 	//check to see if the password entered is strong enough
				 	if (strlen($password)<6){
				 		$errors[]='The password must be atleast 6 characters';
				 	}
				 	//validate password
				 	if (!password_verify($password,$user['password'])) {
				 		$errors[]='your password doesnt match the email you entered, please try again!';
				 	}

				 	if(!empty($errors)){
				 		echo display_errors($errors);
				 	}
				 	else{
				 		$user_id=$user['id'];
				 		login($user_id);
				 	}
				 
				 } 


			?>
		</div>
		<div class="col-md-12">
			<img src="../logo.png" class="image-thumb img-responsive" style="width:200px; height:auto ; margin: 0% auto;"><hr>
		</div>
		<h2 class="text-center">Login</h2><hr>
		<div class="col-md-12">
			<form class="form-group" action="login.php" method="post">
				<div class="form-group">
					<label for="email">Email:</label>
					<input type="text" name="email" id="email" class="form-control" value="<?=$email;?>">
				</div>
				<div class="form-group">
					<label for="password">Password:</label>
					<input type="password" name="password" id="password" class="form-control" value="<?=$password;?>">
				</div>
				<input type="submit" name="submit" value="Login" class="btn pull-right">
			</form>
		</div>

		<p class="text-right"><a href="../index.php" style="color: white;">Visit site</a></p>
	</div>
	<div class="col-md-4"></div>
</div>
</div>

<?php include 'includes\footer.php';?>