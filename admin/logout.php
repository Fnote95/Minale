<?php 
require_once '../core/init.php';
unset($_SESSION['SBuser']);
header('Location: login.php');
?>