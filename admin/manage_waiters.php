<?php

require_once "../core/init.php";
include "includes/head.php";
/////////////////////////////////////////////////////////////////////////////

$waiters_query=$db->query("SELECT * FROM waiters");
?>

<?php 
if (isset($_GET['edit'])&&!empty($_GET['edit'])) {
	$edit_id=sanitize($_GET['edit']);
	$resp_query=$db->query("SELECT * FROM users WHERE id='$edit_id'");
	$resp=mysqli_fetch_assoc($resp_query);
	$unassigned=array();
	$waiters_table_query=$db->query("SELECT * FROM waiters");
	$settings_query=$db->query("SELECT * FROM settings");
	$settings=mysqli_fetch_assoc($settings_query);
	$no_tables=$settings['no_of_tables'];
	$tables_array=array();
	for ($i=1; $i <= $no_tables ; $i++) { 
		$tables_array[]=$i;
	}
	$full_array=array();
	while($check=mysqli_fetch_assoc($waiters_table_query)){
		if ($check['resp_table']=="none") {
			$full_array[]=0;
		}
		else{
			$assigned_array=explode('-', $check['resp_table']);
		
			for ($i=(int)($assigned_array[0]); $i <= (int)($assigned_array[1]); $i++) { 
				$full_array[]=$i;
			}
		}


	}
	foreach($tables_array as $tables){
		if (!in_array($tables, $full_array)) {
			
				$unassigned[]=$tables;
			}
		}
	if (isset($_POST['finish'])&&!empty($_POST['finish'])) {
	
		$from=(int)sanitize($_POST['from']);
		$upto=(int)sanitize($_POST['to']);
		$errors=array();

		if ($from==""||$upto==""){
			$errors[]="All fields must not be empty";
		}
		else{
			if ($from>=$upto) {
				$errors[]='"Starting from" can not be greater than "upto" please insert a valid range';
			}
			$post_array=array();
			for ($i=$from; $i <= $upto ; $i++) { 
				$post_array[]=$i;
				}		
			$assigned_tables="";
			foreach($post_array as $pos){
				if(!in_array($pos, $unassigned)){
					$assigned_tables=$assigned_tables.$pos.",";
				}
			}
			if ($assigned_tables!="") {
				$errors[]="The tables ".$assigned_tables." are already assigned to other waiters, Please choose a range from the unsigned table sections on the right side";
			}
		}


		if (!empty($errors)) {
			echo display_errors($errors);
		}
		else{
			$resp_table=$from."-".$upto;
			$db->query("UPDATE waiters SET resp_table='$resp_table' WHERE user_id='$edit_id'");
			header('Location: manage_waiters');
		}

	}
	?>
	
<div class="container-fluid">
	<div class="row" style="padding-top: 75px">
		<div class="col-md-6 col-sm-6 col-xs-6" style="margin-top: 10px">
			<h3 class="text-left">Waiter detail </h3><hr>
			<div class="col-md-12 col-sm-12 col-xs-12" style="margin-top:10px;background-color: #fff; border: 1px solid #f0f0f0;box-shadow:0 4px 10px 0 rgba(0, 0, 0, 0.12), 0 2px 10px 0 rgba(0, 0, 0, 0.12); border-radius: 10px;">
				<div class="col-md-3 col-sm-3 col-xs-3" style="padding:15px;">
					<div style="border: 3px solid red;width:86px; height:auto ; margin: 0% auto; border-radius: 50%; overflow: hidden; background-color: white; box-shadow:0 4px 10px 0 rgba(0, 0, 0, 0.30), 0 2px 10px 0 rgba(0, 0, 0, 0.30);">
						<img src="<?='../'.$resp['img'];?>" class="image" style="width:80px; height: 80px; padding-top: 5px">
					</div>
				</div>
					<div class="col-md-9 col-sm-9 col-xs-9" style="padding:15px;border-left: 2px solid #f0f0f0;">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<h4><?=$resp['full_name'];?></h4>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12">
							<h4>Tables responsible for: </h4>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12">
							<form action="" method="post" enctype="multipart/form-data">
								<div class="form-group col-md-4 col-sm-4 col-xs-4">
									<label for="from">Starting From</label>
									<input type="number" id="from" name="from" class="form-control">
								</div>
								<div class="form-group col-md-4 col-sm-4 col-xs-4">
									<label for="to">Up To</label>
									<input type="number" id="to" name="to" class="form-control">
								</div>
								<div class="form-group col-md-4 col-sm-4 col-xs-4">
									<input type="submit" name="finish" class="btn btn-primary btn-sm form-control" value="Add" style="margin-top: 25px;background-color: #337ab7;color: white;box-shadow:0 4px 10px 0 rgba(0, 0, 0, 0.30), 0 2px 10px 0 rgba(0, 0, 0, 0.30);border-radius: 5px;border-color: 1px solid #337ab7">
								</div>
							</form>	
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-6 col-sm-6 col-xs-6" style="margin-top: 10px">
				<h3 class="text-left">Unasigned Tables</h3><hr>
				
				<?php foreach($unassigned as $un):?>
					<div class="col-md-1 col-sm-1 col-xs-1 text-center" style="margin:5px;padding: 5px; background-color:red;color: white;border-radius: 3px;box-shadow:0 4px 10px 0 rgba(0, 0, 0, 0.30), 0 2px 10px 0 rgba(0, 0, 0, 0.30);"><?=$un;?></div>
				<?php endforeach;?>
			</div>
		</div>
	</div>




<?php
}else{

?>
<div class="container-fluid">
	<div class="row" style="padding: 15px">
		<div class="row" style="padding-top: 75px">
			<h2 class="text-center"><b>Waiters</b></h2>
		</div>
		<?php while($waiter=mysqli_fetch_assoc($waiters_query)):
			$waiter_id=$waiter['user_id'];
			$resp_query=$db->query("SELECT * FROM users WHERE id='$waiter_id'");
			$resp=mysqli_fetch_assoc($resp_query);?>
			<div class="col-md-6 col-sm-6 col-xs-6">
				<div class="col-md-12 col-sm-12 col-xs-12" style="margin-top:10px;background-color: #fff; border: 1px solid #f0f0f0;box-shadow:0 4px 10px 0 rgba(0, 0, 0, 0.12), 0 2px 10px 0 rgba(0, 0, 0, 0.12); border-radius: 10px;">
					<div class="col-md-3 col-sm-3 col-xs-3" style="padding:15px;border-right: 2px solid #f0f0f0;">
							<div style="border: 3px solid red;width:86px; height:auto ; margin: 0% auto; border-radius: 50%; overflow: hidden; background-color: white; box-shadow:0 4px 10px 0 rgba(0, 0, 0, 0.30), 0 2px 10px 0 rgba(0, 0, 0, 0.30);">
								<img src="<?='../'.$resp['img'];?>" class="image" style="width:80px; height: 80px; padding-top: 5px">
							</div>
					</div>
					<div class="col-md-9 col-sm-9 col-xs-9" style="padding:15px">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<h4><?=$resp['full_name'];?></h4>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12">
							<h4>Tables responsible for: <span><?=$waiter['resp_table'];?></span></h4>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12 text-right">
							<a href="manage_waiters?edit=<?=$waiter['user_id'];?>" id="edit<?=$waiter['id'];?>" class="btn btn-primary" style="box-shadow:0 4px 10px 0 rgba(0, 0, 0, 0.30), 0 2px 10px 0 rgba(0, 0, 0, 0.30);">Edit</a>
						</div>
					</div>
				</div>
			</div>

					
		<?php endwhile;?>
	</div>
</div>

<?php }
include "includes/navigation.php";
include "includes/footer.php";
?>