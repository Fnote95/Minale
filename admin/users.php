<?php

require_once "../core/init.php";
include "includes/head.php";

$dbpath='';	
$temploc='';
$uploadloc='';
//process delete
if (isset($_GET['delete'])&&!empty($_GET['delete'])) {
	$delete_id=sanitize($_GET['delete']);
	$db->query("DELETE FROM users WHERE id='$delete_id'");
	$_SESSION['success']='The user has been deleted';
	header('Locataion: users.php');
}
if(isset($_GET['add'])){
$full_name=(isset($_POST['full_name']))?sanitize($_POST['full_name']):'';
$email=(isset($_POST['email']))?sanitize($_POST['email']):'';
$password=(isset($_POST['password']))?sanitize($_POST['password']):'';
$confirm_password=(isset($_POST['confirm_password']))?sanitize($_POST['confirm_password']):'';
$permission=(isset($_POST['permission']))?sanitize($_POST['permission']):'';
$dbpath=((isset($_POST['photo']) && $_POST['photo']!='')?sanitize($_POST['photo']):'');
$errors=array();

if ($_POST) {
	# code...

//form validation
if(empty($_POST['full_name'])||empty($_POST['email'])||empty($_POST['password'])||empty($_POST['confirm_password'])||empty($_POST['permission'])){
					$errors[]='you must fill out all forms';
				}
			 	//form validation
			 
			 	//check to see if the password entered is strong enough
			 	if (strlen($password)<6){
			 		$errors[]='The password must be atleast 6 characters';
			 	}
			 	//check to see if the password confirms
			 	if(!($password==$confirm_password)){
			 		$errors[]='please reenter the conformation password, it doesnt match';
			 	}
			 	//validate email
			    if (!filter_var($email,FILTER_VALIDATE_EMAIL)) {
			 		$errors[]='you must enter a valid email';
			 	}
				if(!empty($_FILES)){
					
					if ($_FILES['photo']['error']==0) {
						$photo=$_FILES['photo'];
						$name=$photo['name'];
						$photoarray=explode('.', $name);
						$imageName=$photoarray[0];
						$imageExtention=$photoarray[1];
						$mime=explode('/', $photo['type']);
						$mimetype=$mime[0];
						$mimeext=$mime[1];
						$temploc=$photo['tmp_name'];
						$filesize=$photo['size'];
						$allowedtypes=array('png','jpg','jpeg','gif');
						$uploadname=md5(microtime()).'.'.$imageExtention;
						$uploadloc='C:\wamp64\www\res_automation\images\profile_pic\\'.$uploadname;
						$dbpath='images/profile_pic/'.$uploadname;
						if ($mimetype!='image') {
							$errors[]='The file must be an image';
						}
						if(!in_array($imageExtention, $allowedtypes)){
							$errors[]='The image doesnt have a supported type, the allowed image extentions are: png, jpg, jpeg and gif';
						}
						if($filesize>15000000){
							$errors[]='The file cannot be more than 15MB';
						}
						if($imageExtention!=$mimeext &&($imageExtention=='jpeg' && $mimeext!='jpg')){
							$errors[]='File extention does not match the file';
						}# code...
					}



				}
			 	//validate password
			 	if(!empty($errors)){
			 		echo display_errors($errors);
			 	}
			 	else{

					move_uploaded_file($temploc, $uploadloc);	
			 		$hashed=password_hash($password,PASSWORD_DEFAULT);
			
			 		//insert the user into the database
			 	$db->query("INSERT INTO `users` (`full_name`, `email`, `password`, `permission`, `img`) VALUES ('$full_name','$email','$hashed','$permission','$dbpath')");
			 		$_SESSION['success']='User added successfully';
			 		header('Location: users.php');

			 	}
			 }
?>

<div class="container-fluid">
	<div class="row" style="padding-top: 75px; padding-bottom: 50px;">
		<div class="col-md-12 col-lg-12">
			<div class="sparkline8-list shadow-reset">
		        <div class="sparkline8-hd">
		            <div class="main-sparkline8-hd">
		                <h2 class="text-center">Add Users</h2>	
		            </div>
		        </div>
		        <div class="sparkline8-graph">
		            <div class="static-table-list">
		              <form action="users.php?add=1" class="form-group" method="post" enctype="multipart/form-data">
						<div class="container-fluid">
							<div class="col-md-6" id="right-border">
								<div class="form-group col-md-6">
									<label for="full_name">Full name*</label>
									<input type="text" class="form-control" name="full_name" id="full_name" value="<?=$full_name;?>">
								</div>
								<div class="form-group col-md-6">
									<label for="email">email*</label>
									<input type="email" class="form-control" name="email" id="email" value="<?=$email;?>">
								</div>
								<div class="form-group col-md-6">
									<label for="full_name">password*</label>
									<input type="password" class="form-control" name="password" id="password" value="<?=$password;?>">
								</div>
								<div class="form-group col-md-6">
									<label for="full_name">Confirm  password*</label>
									<input type="password" class="form-control" name="confirm_password" id="confirm_password" value="<?=$password;?>">
								</div>
								<div class="form-group col-md-6">
									<label for="permission">permission*</label>
									<select class="form-control" id="permission" name="permission">
										<option value=""<?=(($permission=='')? 'selected':'');?>></option>
										<option value="editor"<?=(($permission=='editor')? 'selected':'');?>>Admin</option>
										<option value="admin,editor"<?=(($permission=='Cashier')? 'selected':'');?>>Cashier</option>
										<option value="admin,editor"<?=(($permission=='Admin, Cashier')? 'selected':'');?>>Admin,Cashier</option>
										<option value="admin,editor"<?=(($permission=='Waiter')? 'selected':'');?>>Waiter</option>
									</select>
								</div>
								<div class="form-group col-md-6">
									<label for="permission">Profile pic*</label>
				    				<input type="file" id="input_file" accept="image/*" capture="camera" name="photo">
								</div>
								<div class="form-group col-md-12">
									<a href="users.php" class="btn btn-default">Cancel</a>
									<input type="submit" value="Add user" class="btn btn-success">
								</div>
							</div>
						</div>
						</form>
		            </div>
		        </div>
		    </div>
		</div>
	</div>
</div>
<hr>

<?php
}
else{
	$usersql=$db->query("SELECT * FROM users");
?>

<div class="container-fluid">
	<div class="row" style="padding-top: 75px; padding-bottom: 50px;">
		
		<div class="col-md-12">
			<div class="sparkline8-list shadow-reset">
		        <div class="sparkline8-hd">
		            <div class="main-sparkline8-hd">
	                	<div class="row">
	                		<div class="col-md-12">
	                			<h2 class="text-center">Users</h2>	
	                		</div>
		                	<div class="col-md-12" id="pcShow_add">
		                		<a href="users.php?add=1" class="btn btn-success pull-right"  style="margin-top:-35px">Add Users</a>
		                	</div>
		                 
		                    <div class="col-md-12" id="mobileShow_add" >
		                    	 <a href="users.php?add=1" class="pull-right btn btn-xs" style="margin-top:-35px"><span class="glyphicon glyphicon-plus-sign"></span></a>
		                    </div>
	                	</div>
		            </div>
		        </div>
		        <div class="sparkline8-graph">
		            <div class="static-table-list scrolling_wrapper">
		              <table class="table table-bordered table-condensed table-striped table-responsive">
						<thead>
							<th></th><th>Full Name</th><th>Email</th><th>Permission</th><th>Joined date</th><th>Last login</th>
						</thead>
						<tbody>
							<?php while($users=mysqli_fetch_assoc($usersql)):?>
							<tr>
								<td>
									<?php if($users['id']!=$user_data['id']):?>
									<a href="users.php?delete=<?=$users['id'];?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-remove-sign"></span></a>
									<?php endif;?>		
								</td>
								<td><?=$users['full_name'];?></td>
								<td><?=$users['email'];?></td>
								<td><?=$users['permission'];?></td>
								<td><?=pretty_date($users['joined_date']);?></td>
								<td><?=(($users['last_login']=='0001-01-01 00:00:00')?'Never':pretty_date($users['last_logged']));?></td>
							</tr>
						    <?php endwhile;?>
						</tbody>
					</table>
		            </div>
		        </div>
		    </div>
		</div>
	</div>
</div>
<hr>



<?php 
}
include 'includes\footer.php';
?>
<?php include 'includes\navigation.php';?>
