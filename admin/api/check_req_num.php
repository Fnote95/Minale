<?php
require_once "../../core/init.php";

$req_query=$db->query("SELECT * FROM requests");
$req_num=mysqli_num_rows($req_query);

ob_start();?>
<?=$req_num;?>
<?php echo ob_get_clean();?>
