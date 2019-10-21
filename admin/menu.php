<?php
require_once "../core/init.php";
include "includes/head.php";
$dbpath='';	
$temploc='';
$uploadloc='';
if (isset($_GET['deletecat'])&&!empty($_GET['deletecat'])) {
	$del_id=sanitize($_GET['deletecat']);
	$delete_query=$db->query("DELETE FROM category WHERE id='$del_id'");
			header('Location: menu');
}
if (isset($_POST['add'])&&!empty($_POST)) {
	$sub_menu=sanitize($_POST['sub']);
	$errors=array();

	if ($_POST['sub']=="") {
		$errors[]="You must add a sub menu first!";
	}
	if (!empty($errors)) {
		echo display_errors_two($errors);
	}
	else{
	
	$db->query("INSERT INTO category (cat_name) VALUES ('$sub_menu')");
	header('Location: menu');
}
}
$cat_query=$db->query("SELECT * FROM category");

if (isset($_GET['cat'])&&!empty($_GET['cat'])) {
	$cat_id=sanitize($_GET['cat']);
	$cat_query=$db->query("SELECT * FROM category WHERE id='$cat_id'");
	$cat_result=mysqli_fetch_assoc($cat_query);
	$menu_query=$db->query("SELECT * FROM menu WHERE cat_id='$cat_id'");
//////////////////////////////////////////////////////////////////////////////
		if (isset($_GET['delete'])&&!empty($_GET['delete'])) {
			$delete_id=sanitize($_GET['delete']);
			$delete_query=$db->query("DELETE FROM menu WHERE id='$delete_id'");
			header('Location: menu?cat='.$cat_id);
		}

////////////////////////////////////////////////////////////////////////////
					if (isset($_GET['edit'])) {
						$edit_id=sanitize($_GET['edit']);
						$edit_query=$db->query("SELECT * FROM menu WHERE id='$edit_id'");
						$edit_result=mysqli_fetch_assoc($edit_query);
						$edit_ing_type=$edit_result['ing_type'];
						if ($edit_ing_type==3) {
							$edit_comp_string="None";
						}
						else{
							$edit_comp=json_decode($edit_result['composition'],true);
							$edit_comp_string='';
							foreach ($edit_comp as $ec) {
								$edit_comp_string=$edit_comp_string.$ec['comp'].':'.$ec['quantity'].',';
							}
						}
						
					
					}
		
				
			if (isset($_POST['add-sub'])) {
				
					
				$comps=sanitize($_POST['comps']);
				$comps=rtrim($comps,',');
				$ing_type=sanitize($_POST['ing_type']);
				$comps=explode(',', $comps);
				$comps_array=array();
				$i=0;
				
				///////////////////////////////////////////
				$comps_json=json_encode($comps_array);
				$price=sanitize($_POST['price']);
				$pname=sanitize($_POST['sub']);
	
				///////////////////////////////////////////
				$errors=array();
				$required=array('sub','comps','price','ing_type');
				foreach($required as $field){
					if($_POST[$field]==''){
						$errors[]='All feilds with astriks must not be empty!';
						break;
					}
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
						$uploadloc='C:\wamp64\www\res_automation\images\item_image\\'.$uploadname;
						$dbpath='images/item_image/'.$uploadname;
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
						$errors[]="You must enter an image for the menu item!";
					}



				}
				if(!empty($errors)){
					
					echo display_errors_two($errors);
				}
				else{
					if (!empty($_FILES)) {
						move_uploaded_file($temploc, $uploadloc);	
					}
					if ($ing_type==3) {
						$comps_json="None";
					}
					else{
						foreach ($comps as $com) {
						$temp=explode(':', $com);
						$comps_array[$i]['comp']=$temp[0];
						$comps_array[$i]['quantity']=$temp[1];
						$i++;					
						}
						$comps_json=json_encode($comps_array);
					}
					
					
	

					$insertsql="INSERT INTO menu (item_name,item_pic,cat_id,ing_type,composition,price) VALUES ('$pname','$dbpath','$cat_id','$ing_type','$comps_json','$price')";
					if (isset($_GET['edit'])) {
					$insertsql="UPDATE menu set item_name='$pname', item_pic='$dbpath', cat_id='$cat_id', ing_type='$ing_type',composition='$comps_json',price='$price' WHERE id='$edit_id'";
					}

					$db->query($insertsql);
					header('Location: menu.php?cat='.$cat_id);

					}

			}
//////////////////////////////////////////////////////////////////////////////////
?>
<div class="container-fluid">
	<div class="row" style="padding-top: 75px; padding-bottom: 10px;">
		<h1 class="text-center" style="font-family: 'Rockwell'; font-size: 3em"><b><?=$cat_result['cat_name'];?></b></h1>
	</div>
	<div class="row" style="margin: 15px">
		<?php if(isset($_GET['edit'])){ ?>
			<div class="col-md-12"><h3>Editing - <span style="color: green"><?=$edit_result['item_name'];?></span></h3></div>
		<?php }else{ ?>
			<div class="col-md-12"><h3>Add a <?=rtrim($cat_result['cat_name'],'s');?></h3></div>
		<?php }?>
		<div class="col-md-12 review2" style=" border-radius: 10px;box-shadow:0 2px 5px 0 rgba(0, 0, 0, 0.16), 0 2px 10px 0 rgba(0, 0, 0, 0.12); padding-top: 15px;padding-bottom: 15px; ">
			<form class="form-group" action="menu.php?cat=<?=$cat_id;?><?=(isset($_GET['edit']))?'&edit='.$edit_id:'';?>" method="post" enctype="multipart/form-data">
				<div class="col-md-2"><label for="name">Name*</label><input type="text" name="sub" class="form form-control" value="<?=isset($_GET['edit'])? $edit_result['item_name']:'';?>" style="color: black"></div>

				<div class="col-md-2"><label for="photo"><?=(isset($_GET['edit']))?'Add new ':'';?>Image*</label><input type="file" class="form-control"  accept="image/*" capture="camera" name="photo" style="color: black"></div>
				<div class="col-md-2"><label for="ing_type"><?=(isset($_GET['edit']))?'Add new ':'';?>Ingredient Type</label>
					<select class="form-control" id="ing_type" name="ing_type" style="color:black">
						<option value=""></option>
						<option value="1">Quantitative</option>
						<option value="2">Not quantitative</option>
						<option value="3">No Ingredient</option>
					</select>

				</div>

				<div class="col-md-2"><label for="name">Ingredients*</label><button name="comp" id="comp" class="btn btn-primary form-control"  onclick="jQuery('#compModal').modal('toggle'); return false;" style="background-color: #5cb85c;border-color:#4cae4c; color: white;" disabled="ture">Composition</button></div>

				<div class="col-md-2"><label for="name">Ingredients Preview</label><input type="text" value="<?=(isset($_GET['edit'])? $edit_comp_string : '');?>" id="comps" name="comps" class="form form-control" style="color: black"  readonly></div>

				<div class="col-md-1"><label for="name">Price*</label><input type="number" name="price" value="<?=(isset($_GET['edit'])? $edit_result['price'] : '');?>" class="form-control" style="color: black"></div>

				<div class="col-md-1"><button name="add-sub" class="btn btn-primary form-control" style="background-color: #5cb85c;border-color:#4cae4c; color: white;margin-top: 25px" ><?=(isset($_GET['edit']))?'Edit':'Add';?></button></div>

			</form>

		</div>
	</div>

	<div class="row text-center" style="padding-top: 5px">
		<div class="col-md-12 col-sm-12 col-xs-12" style="padding-top: 15px;">
			<?php while($menu_item=mysqli_fetch_assoc($menu_query)): ?>
			
				<div class="col-md-2 col-sm-12 col-xs-12" style="padding-top: 20px">
				
					<div class="review2" style=" border-radius: 10px;box-shadow:0 2px 5px 0 rgba(0, 0, 0, 0.16), 0 2px 10px 0 rgba(0, 0, 0, 0.12); padding-top: 15px;padding-bottom: 15px; ">
						<div style="padding-bottom: 5px;padding-right: 10px;margin-top: -5px" class="text-right">
							<a href="menu?cat=<?=$cat_id;?>&delete=<?=$menu_item['id'];?>" onClick="return confirm('Are you sure you want to remove this item from you Burgers?')" class="btn btn-default btn-xs " ><span class="glyphicon glyphicon-remove"  style="color:red"></span></a>
						</div>
						
						<div style="border: 3px solid rgba(252,84,4,1);width:120px; height:120px ; margin: 0% auto; border-radius: 50%; overflow: hidden; background-color: white;">
							<img src="<?='../'.$menu_item['item_pic'];?>" alt="" style="width: 150px; height: auto; padding-top: 5px">
						</div>
						<h5 class="text-center" style="color: white; padding-top:10px"><b><?=$menu_item['item_name'];?></b></h5>
						<h4 class="text-center" style="color: white"><b><?=cash($menu_item['price']);?></b></h4>
						<a href="menu?cat=<?=$cat_id;?>&edit=<?=$menu_item['id'];?>" class="btn btn-default" style="color:red"><b>Edit</b></a>
						
					</div>
				</div>
			
			<?php endwhile;?>
		</div>
	</div>


<!----------composition modal--->
<div class="modal fade" id="compModal" tabindex="-1" role="dialog" aria-labelledby="compModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="compModal">Ingredients & Quantity</h4>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <?php for($i=1;$i<11;$i++):;?>
                    <div class="form-group col-md-4">
                        <label for="comp">Ingredient <?=$i;?></label>
                        <input type="text" class="form-control" id="comp<?=$i;?>" name="comp<?=$i;?>">
                    </div>
                    <div class="form-group col-md-2">
                        <label for="size" id="label<?=$i;?>">Quantity <?=$i;?></label>
                        <input type="number" class="form-control" id="quantity<?=$i;?>" name="quanitty<?=$i;?>">
                    </div>
                    <?php endfor;?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="updateComp();jQuery('#compModal').modal('toggle');return false;">Save changes</button>
            </div>
        </div>
    </div>
</div>
</div>
<!---------------------------------------------->




<?php
}
else{
?>
<div class="container-fluid">
	<div class="row" style="padding-top: 75px; padding-bottom: 30px;">
		<h1 class="text-center" style="font-family: 'Rockwell'; font-size: 3em"><b>Menu</b></h1>
	</div>
		<div class="row" style="margin: 15px">
			<div class="col-md-3"></div>
			<div class="col-md-6 review2" style="padding-top:20px; padding-bottom: 20px; margin: 5px; border-radius: 10px;box-shadow:0 2px 5px 0 rgba(0, 0, 0, 0.16), 0 2px 10px 0 rgba(0, 0, 0, 0.12); padding-top: 15px;padding-bottom: 15px;">
				<div class="col-md-4"><h3><b>Add sub-menu</b></h3></div>
				<form class="form" action="menu.php" method="post" >
					<div class="col-md-4"><input type="text" name="sub" class="form form-control"></div>
					<div class="col-md-4"><button name="add" class="btn btn-success form-control" style="background-color: #5cb85c;border-color:#4cae4c; color: white;">Add</button></div>
				</form>

			</div>
			<div class="col-md-3"></div>

		</div>
	
		<div class="row" style="margin: 15px" >
			<?php while($cat=mysqli_fetch_assoc($cat_query)): ?>
				
					<div class="col-md-3 col-sm-6" style="margin-bottom: 10px;">
						<div class="review2" style=" border-radius: 10px;box-shadow:0 2px 5px 0 rgba(0, 0, 0, 0.16), 0 2px 10px 0 rgba(0, 0, 0, 0.12); padding-top: 25px;padding-bottom: 25px;">
							<div class="text-right" style="margin-right: 5px;margin-top: -15px">
									<a href="menu?deletecat=<?=$cat['id'];?>" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-remove" onClick="return confirm('Are you sure you want to remove this item from you Burgers?')" style="color:red"></span></a>
									<a href="menu?cat=<?=$cat['id'];?>"></a>
							</div>
							<div class="row" style="padding-left: 10px">
								
						
								<div class="col-md-4 col-sm-4">
									<div style="border: 3px solid rgba(252,84,4,1);width:90px; height:90px ; margin: 0% auto; border-radius: 50%; overflow: hidden; background-color: white;">
										<img src="../images/item_image/hamburger.jpg" style="width:100px">
									</div>
								</div>

								<div class="col-md-8 col-sm-4" style="padding-top: 25px">
									<h3 style="margin-left: 10px"><?=$cat['cat_name'];?></h3>
								</div>
								
							</div>
							<div class="text-right" style="margin-right: 5px;margin-top: -15px">
									<a href="menu?cat=<?=$cat['id'];?>" class="btn btn-default btn-xs" style="color: red"><b>Edit</b></a>
									
							</div>
						</div>
						
					</div>
			
			<?php endwhile;?>
		</div>

	
	
</div>

<?php
}
include "includes/navigation.php";
include "includes/footer.php";
?>
