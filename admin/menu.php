<?php
require_once "../core/init.php";
include "includes/head.php";
$dbpath='';	
$temploc='';
$uploadloc='';

if (isset($_POST['add'])&&!empty($_POST)) {
	$sub_menu=sanitize($_POST['sub']);
	
	$db->query("INSERT INTO category (cat_name) VALUES ('$sub_menu')");
	header('Location: menu');
}
$cat_query=$db->query("SELECT * FROM category");

if (isset($_GET['cat'])&&!empty($_GET['cat'])) {
	$cat_id=sanitize($_GET['cat']);
	$cat_query=$db->query("SELECT * FROM category WHERE id='$cat_id'");
	$cat_result=mysqli_fetch_assoc($cat_query);
	$menu_query=$db->query("SELECT * FROM menu WHERE cat_id='$cat_id'");
//////////////////////////////////////////////////////////////////////////////
					if (isset($_GET['edit'])) {
						$edit_id=sanitize($_GET['edit']);
						$edit_query=$db->query("SELECT * FROM menu WHERE id='$edit_id'");
						$edit_result=mysqli_fetch_assoc($edit_query);
						$edit_comp=json_decode($edit_result['composition'],true);
						$edit_comp_string='';
						foreach ($edit_comp as $ec) {
							$edit_comp_string=$edit_comp_string.$ec['comp'].':'.$ec['quantity'].',';
						}
					
					}
		
				
				if (isset($_POST['add-sub'])) {

					
				$comps=sanitize($_POST['comps']);
				$comps=rtrim($comps,',');
				$comps=explode(',', $comps);
				$comps_array=array();
				$i=0;
				
				///////////////////////////////////////////
				$comps_json=json_encode($comps_array);
				$price=sanitize($_POST['price']);
				$pname=sanitize($_POST['sub']);
	
				///////////////////////////////////////////
				$errors=array();
				$required=array('sub','comps','price');
				foreach($required as $field){
					if($_POST[$field]==''){
						$errors[]='All feilds with astriks must not be empty';
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
				if(!empty($errors)){
					
					echo display_errors($errors);
				}
				else{
					if (!empty($_FILES)) {
						move_uploaded_file($temploc, $uploadloc);	
					}
					foreach ($comps as $com) {
					$temp=explode(':', $com);
					$comps_array[$i]['comp']=$temp[0];
					$comps_array[$i]['quantity']=$temp[1];
					$i++;					
					}
					$comps_json=json_encode($comps_array);
					
	

					$insertsql="INSERT INTO menu (item_name,item_pic,cat_id,composition,price) VALUES ('$pname','$dbpath','$cat_id','$comps_json','$price')";
					if (isset($_GET['edit'])) {
						$insertsql="UPDATE menu set item_name='$pname', item_pic='$dbpath', cat_id='$cat_id', composition='$comps_json',price='$price' WHERE id='$edit_id'";
					}
					$db->query($insertsql);
					header('Location: menu.php?cat='.$cat_id);

					}

			}
//////////////////////////////////////////////////////////////////////////////////
?>
<div class="container-fluid">
	<div class="row" style="padding-top: 75px; padding-bottom: 30px;">
		<h1 class="text-center" style="font-family: 'Rockwell'; font-size: 3em"><b><?=$cat_result['cat_name'];?></b></h1>
	</div>
	<div class="row" style="margin: 15px">
		<?php if(isset($_GET['edit'])){ ?>
			<div class="col-md-12"><h3>Editing - <span style="color: green"><?=$edit_result['item_name'];?></span></h3></div>
		<?php }else{ ?>
			<div class="col-md-12"><h3>Add a <?=rtrim($cat_result['cat_name'],'s');?></h3></div>
		<?php }?>
		<div class="col-md-12" style="padding-top:20px; padding-bottom: 20px; margin: 5px; background-color: #f9f9f9; border: 1px solid #f0f0f0;box-shadow: 0 1px 4px 0 rgba(0, 0, 0, 0.14);">
			<form class="form-group" action="menu.php?cat=<?=$cat_id;?><?=(isset($_GET['edit']))?'&edit='.$edit_id:'';?>" method="post" enctype="multipart/form-data">
				<div class="col-md-2"><label for="name">Name*</label><input type="text" name="sub" class="form form-control" value="<?=isset($_GET['edit'])? $edit_result['item_name']:'';?>"></div>

				<div class="col-md-2"><label for="photo"><?=(isset($_GET['edit']))?'Add new ':'';?>Image*</label><input type="file" class="form-control"  accept="image/*" capture="camera" name="photo"></div>

				<div class="col-md-2"><label for="name">Composition*</label><button name="comp" class="btn btn-success form-control"  onclick="jQuery('#compModal').modal('toggle'); return false;">Composition</button></div>

				<div class="col-md-2"><label for="name">Composition Preview</label><input type="text" value="<?=(isset($_GET['edit'])? $edit_comp_string : '');?>" id="comps" name="comps" class="form form-control"  readonly></div>

				<div class="col-md-2"><label for="name">Price*</label><input type="number" name="price" value="<?=(isset($_GET['edit'])? $edit_result['price'] : '');?>" class="form-control"></div>

				<div class="col-md-2"><label for="name"><?=(isset($_GET['edit']))?'Edit':'Add to sub-menu';?></label><button name="add-sub" class="btn btn-success form-control" style="background-color: #5cb85c;border-color:#4cae4c; color: white;" ><?=(isset($_GET['edit']))?'Edit':'Add';?></button></div>

			</form>

		</div>
	</div>

	<div class="row text-center" style="padding-top: 5px">
		<div class="col-md-12 col-sm-12 col-xs-12" style="padding-top: 15px;">
			<?php while($menu_item=mysqli_fetch_assoc($menu_query)): ?>
			<a href="menu?cat=<?=$cat_id;?>&edit=<?=$menu_item['id'];?>">
				<div class="col-md-2 col-sm-2 col-xs-2">
					<img src="<?='../'.$menu_item['item_pic'];?>" alt="" style="width: 100px; height: auto; padding-top: 10px">
					<p class="text-center"><b><?=$menu_item['item_name'];?></b></p>
					<p class="text-center" style="color: green"><?=cash($menu_item['price']);?></p>
				</div>
			</a>
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
                        <label for="comp">Ingredient</label>
                        <input type="text" class="form-control" id="comp<?=$i;?>" name="comp<?=$i;?>">
                    </div>
                    <div class="form-group col-md-2">
                        <label for="size">Quantity</label>
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
			<div class="col-md-6" style="padding-top:20px; padding-bottom: 20px; margin: 5px; background-color: #f9f9f9; border: 1px solid #f0f0f0;box-shadow: 0 1px 4px 0 rgba(0, 0, 0, 0.14);">
				<div class="col-md-4"><h3><b>Add sub-menu</b></h3></div>
				<form class="form" action="menu.php" method="post" >
					<div class="col-md-4"><input type="text" name="sub" class="form form-control"></div>
					<div class="col-md-4"><button name="add" class="btn btn-success form-control" style="background-color: #5cb85c;border-color:#4cae4c; color: white;">Add</button></div>
				</form>

			</div>
			<div class="col-md-3"></div>

		</div>
	
		<div class="row" style="margin: 15px">
			<?php while($cat=mysqli_fetch_assoc($cat_query)): ?>
				<a href="menu?cat=<?=$cat['id'];?>">
					<div class="col-md-3" style="width:24%; padding-top:40px; padding-bottom: 40px; margin: 5px; background-color: #f9f9f9; border: 1px solid #f0f0f0;box-shadow: 0 1px 4px 0 rgba(0, 0, 0, 0.14);">
						<h3 class="text-center"><b><span><img src="../images/item_image/hamburger.jpg" style="width:70px"></span> <?=$cat['cat_name'];?></b></h3>
					</div>
				</a>
			<?php endwhile;?>
		</div>

	
	
</div>

<?php
}
include "includes/navigation.php";
include "includes/footer.php";
?>