<?php
require_once "../core/init.php";

$num_kitchens=(int)$_POST['num_kitchens'];
$admin_query=$db->query("SELECT * FROM users WHERE permission='Admin'");
ob_start();?>
<?php for($i=1; $i<=$num_kitchens;$i++):
	$admin_query=$db->query("SELECT * FROM users WHERE permission='Admin'");
	?>
<div class="col-md-6 col-sm-6">
	<label for="k_name<?=$i;?>">Kitchen <?=$i;?> name</label>
	<input type="text" name="Kitchen<?=$i;?>" id="k_name<?=$i;?>" class="form-control">
</div>
<div class="col-md-6 col-sm-6">
	<label for="admin<?=$i;?>">Kitchen <?=$i;?> admin</label>
	<select class="form-control" name="admin<?=$i;?>" id="admin<?=$i;?>">
		<option value=""></option>
		<?php while($admin=mysqli_fetch_assoc($admin_query)):?>
			<option value="<?=$admin['id'];?>"><?=$admin['full_name'];?></option>
		<?php endwhile;?>
	</select>
</div>
<?php endfor;?>
<?php echo ob_get_clean();?>