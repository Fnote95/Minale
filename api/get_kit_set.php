<?php
require_once "../core/init.php";

$num_kitchens=(int)$_POST['num_kitchens'];
$kitchen_query=$db->query("SELECT * FROM kitchens");


ob_start();?>
<?php 
$i=1;
while($check_num=mysqli_fetch_assoc($kitchen_query)):
	$admin_query=$db->query("SELECT * FROM users WHERE permission='Chef,Admin' OR permission='Chef' OR permission='Owner,Admin'");
	?>
<div class="col-md-6 col-sm-6">
	<label for="k_name<?=$i;?>">Kitchen <?=$i;?> name</label>
	<input type="text" name="Kitchen<?=$i;?>" id="k_name<?=$i;?>" value="<?=$check_num['kit_name'];?>" class="form-control">
</div>
<div class="col-md-6 col-sm-6">
	<label for="admin<?=$i;?>">Kitchen <?=$i;?> admin</label>
	<select class="form-control" name="admin<?=$i;?>" id="admin<?=$i;?>">
		<option value=""></option>
		<?php while($admin=mysqli_fetch_assoc($admin_query)):?>
			<option value="<?=$admin['id'];?>" <?=(($check_num['admin']==$admin['id'])?'selected':'');?>><?=$admin['full_name'];?></option>
		<?php endwhile;?>
	</select>
</div>
<?php 
$i++;
endwhile;?>
<?php echo ob_get_clean();?>