<?php
header('Content-type:text/html;charset=utf-8');
include_once 'classes.php';
$Link=new Link('localhost','root','','sklad');
include_once 'header.php'; ?>


<?php
$login = "Не известно";
$password = "Не известно";
if(isset($_POST['login'])) $login = $_POST['login'];
if (isset($_POST['password'])) $password = $_POST['password'];

$result=$Link->Login($login, $password);
if($result == "OK")
{
	session_start();
	$_SESSION['user'] = $login;
	header("Location: sklad.php");
	exit;
}
else if($result == "INVALID_PASS")
{
	echo '<p>Пароль не верный!</p>';	
}
else if($result == "NOT_USER")
{
	echo '<p>Пользователя не существует!</p>';
}
echo '<a href="form.php">Вход</a>'
?>
