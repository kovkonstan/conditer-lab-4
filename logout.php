<?php
header('Content-type:text/html;charset=utf-8');
include_once 'classes.php';
$Link=new Link('localhost','root','','sklad');
include_once 'header.php'; ?>


<?php
	session_start();
	unset($_SESSION['user']);
	session_destroy();
	header("Location: sklad.php");
	exit;
?>
