<?php 
require_once '..\core\init.php';
if(!is_logged_in()){
header('Location: login.php');
}
include 'includes\head.php';
$hashed=$user_data['password']; 
$old_password=(isset($_POST['old_password'])? sanitize($_POST['old_password']):'');
$old_password=rtrim($old_password);
$new_password=(isset($_POST['new_password'])? sanitize($_POST['new_password']):'');
$new_password=rtrim($new_password);
$confirm_password=(isset($_POST['confirm_password'])? sanitize($_POST['confirm_password']):'');
$confirm_password=rtrim($confirm_password);
$errors=array();
$user_id=$user_data['id'];
$new_hashed=password_hash($new_password,PASSWORD_DEFAULT);
/*if (isset($_POST['submit'])) {
	# code...
}*/

?>

	
<div class="container-fluid">
	<div class="row" style="padding-top: 70px">
	<div class="col-md-4"></div>
	<div class="login-form col-md-4 charts-single-pro shadow-reset">
	<div>
		<?php
			if ($_POST) {
				if(empty($_POST['old_password'])||empty($_POST['new_password'])||empty($_POST['confirm_password'])){
					$errors[]='you must fill out all forms';
				}
			 	//form validation
			 
			 	//check to see if the password entered is strong enough
			 	if (strlen($new_password)<6){
			 		$errors[]='The password must be atleast 6 characters';
			 	}
			 	if(!($new_password==$confirm_password)){
			 		$errors[]='please reenter the conformation password, it doesnt match';
			 	}
			 	//validate password
			 	if (!password_verify($old_password,$hashed)) {
			 		$errors[]='incorrect password, please try again!';
			 	}

			 	if(!empty($errors)){
			 		echo display_errors($errors);
			 	}
			 	else{
			 		$pass_change=$db->query("UPDATE users SET password='$new_hashed' WHERE id='$user_id'");
			 		$_SESSION['success']='your password has been successfully changed';
			 		header('Location: index.php');
			 	}
			 
			 } 


		?>
	</div>
	<div class="col-md-12">
		<img src="../logo.png" class="image-thumb img-responsive" style="width:200px; height:auto ; margin: 0% auto;"><hr>
	</div>
	<h3 class="text-center">Change Password</h3><hr>
	<form class="form-group" action="changePassword.php" method="post">
		<div class="form-group">
			<label for="old_password">Original Password:</label>
			<input type="password" name="old_password" id="old_password" class="form-control" value="<?=$old_password;?>">
		</div>
		<div class="form-group">
			<label for="new_password">New Password:</label>
			<input type="password" name="new_password" id="new_password" class="form-control" value="<?=$new_password;?>">
		</div>
		<div class="form-group">
			<label for="confirm_password">Confirm Password:</label>
			<input type="password" name="confirm_password" id="confirm_password" class="form-control" value="<?=$confirm_password;?>">
		</div>
		<div class="text-right">
			<input type="submit" name="submit" value="Change password" class="btn btn-success">
		</div>
		
	</form>
	<p class="text-right"><a href="../index.php" style="color: white;">Visit site</a></p>
</div>
	<div class="col-md-4"></div>
</div>
</div>

<?php include 'includes\footer.php';
	  include 'includes\navigation.php';
?>