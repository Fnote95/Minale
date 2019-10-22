<?php
require_once "../core/init.php";
include "includes/head.php";
$dbpath='';	
$temploc='';
$uploadloc='';

$check_kitchen_query=$db->query("SELECT * FROM kitchens");
$check_kitchen=mysqli_fetch_assoc($check_kitchen_query);
$check_query=$db->query("SELECT * FROM settings");
$check_num=mysqli_num_rows($check_query);
if ($check_num>0) {
	$settings=mysqli_fetch_assoc($check_query);
	$company_name=$settings['company_name'];
	$num_tables=$settings['no_of_tables'];
	if ($settings['customize']==1) {
		$customize="on";
	}
	else{
		$customize="off";
	}
	$logo=$settings['logo'];
	
}

if (isset($_POST['submit'])) {
	//var_dump($_POST);
	$comp_name=sanitize($_POST['comp_name']);
	$comp_tables=sanitize($_POST['comp_tables']);
	$comp_kitchens=(int)sanitize($_POST['comp_kitchens']);



	if (isset($_POST['switch'])) {
		$custom=1;
	}
	else{
		$custom=0;
	}
///////////////////form_validation//////////////////////

	if ($check_kitchen>0) {
		$db->query("DELETE FROM kitchens");
		$db->query("ALTER TABLE kitchens AUTO_INCREMENT = 0");
	}
	$errors=array();
	for ($i=1; $i <=$comp_kitchens ; $i++) { 
		if (($_POST['Kitchen'.$i]=="")||($_POST['admin'.$i]=="")) {
			$errors[]="You must enter kitchen names and their adminstrators";
		}

		if (!empty($errors)) {
				
		}
		else{
			$kitchens=sanitize($_POST['Kitchen'.$i]);
			$admin=sanitize($_POST['admin'.$i]);
			$db->query("INSERT INTO kitchens (kit_name, admin) VALUES('$kitchens', '$admin')");	
		}
		
	}
	if($comp_name==""||$comp_tables==""){
		$errors[]="None of the fields can be empty";
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
						$uploadloc='C:\wamp64\www\res_automation\images\\'.$uploadname;
						$dbpath='images/'.$uploadname;
						if($name==""){
							$errors[]='You must enter an image for the item!';
						}
						if ($mimetype!='image') {
							$errors[]='The file must be an image!';
						}
						if(!in_array($imageExtention, $allowedtypes)){
							$errors[]='The image doesnt have a supported type, the allowed image extentions are: png, jpg, jpeg and gif!';
						}
						if($filesize>15000000){
							$errors[]='The file cannot be more than 15MB!';
						}
						if($imageExtention!=$mimeext &&($imageExtention=='jpeg' && $mimeext!='jpg')){
							$errors[]='File extention does not match the file!';
						}# code...
					}
					else{
						$errors[]="You must enter an image for the company logo";
					}



				}
				if(!empty($errors)){
					
					echo display_errors_two($errors);
				}
				else{



					if (!empty($_FILES)) {
						move_uploaded_file($temploc, $uploadloc);	
					}
					if ($check_num>0) {

						$db->query("UPDATE settings SET company_name='$comp_name', logo='$dbpath', customize='$custom', no_of_tables='$comp_tables'");				

					}
					else{
						$db->query("INSERT INTO settings (company_name, logo, customize, no_of_tables) VALUES ('$comp_name','$dbpath','$custom','$comp_tables')");
					
					}
					header('Location: settings');
				}

}
?>
<div class="container-fluid">
	<div class="row" style="padding-top: 120px">

		<div class="col-md-12">

			<form action="Settings.php" class="form-group" method="post" enctype="multipart/form-data">
				<div class="col-md-4 text-center">
						<div style="padding:50px">
					<?php if ($check_num>0) {?>
						<img class="shadow bradius" src="<?='../'.$logo;?>" style="width: auto;height: 220px">
					<?php } ;?>
						</div>
				</div>
				<div class="col-md-4 charts-single-pro shadow-reset col-md-4 col-xs-12" style="border-radius: 10px;box-shadow:0 2px 5px 0 rgba(0, 0, 0, 0.16), 0 2px 10px 0 rgba(0, 0, 0, 0.12);">
					<div class="col-md-12">
						<h2 class="text-center"><b>Settings</b></h2>
					</div><hr>
					<div class="col-md-6" style="padding: 10px">
						<label for="comp_name">Company name</label>
						<input type="text" value="<?=($check_num>0)?$company_name:'';?>" name="comp_name" id="comp_name" class="form-control">
					</div>
					<div class="col-md-6" style="padding: 10px">
						<label for="comp_tables">Number of tables</label>
						<input type="number" value="<?=($check_num>0)?$num_tables:'';?>" name="comp_tables" id="comp_tables" class="form-control">
					</div>
					<div class="col-md-6" style="padding: 10px">
						<label for="photo">Company logo</label>
						<input type="file" id="photo" name="photo" class="form-control">
					</div>
					<div class="col-md-6" style="padding: 10px">
						<label for="comp_kitchens">Number of kitchens</label>
						<input type="number" name="comp_kitchens" id="comp_kitchens" class="form-control" min="1">
					</div>
					<div class="col-md-12 col-sm-12" id="kit_form">
						
					</div>
					<div class="col-md-6 text-center" style="padding: 10px">
						<!-- Rounded switch -->
						<label>Customization</label>
						<div>
							<label class="switch">
							  <input type="checkbox" value="<?=($check_num>0)?$customize:'';?>" name="switch">
							  <span class="slider round"></span>
							</label>
						</div>
					</div>
					<div class="col-md-12 col-sm-12">
						<div class="col-md-4"></div>
						<div class="col-md-4" style="padding: 10px">
							<input type="submit" name="submit" value="Submit" class="form-control btn btn-primary" style="box-shadow:0 4px 10px 0 rgba(0, 0, 0, 0.30), 0 2px 10px 0 rgba(0, 0, 0, 0.30); background-color: ">
						</div>
						<div class="col-md-4"></div>

					</div>
					
				</div>
				<div class="col-md-4 text-center">
					<div style="padding:50px">
						<img src="../logo.png" style="width: 400px;height: auto">
					</div>
					
				</div>
			</form>
		</div>
	</div>
</div>
<?php
include "includes/footer.php";
include "includes/navigation.php";
?>