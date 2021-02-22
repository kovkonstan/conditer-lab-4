<?php
header('Content-type:text/html;charset=utf-8');
include_once 'classes.php';
$Link=new Link('localhost','root','','sklad');
include_once 'header.php'; ?>
<div id="content">


 


    <div class="table">

        <h3>Вход на сайт</h3>
		<form action="login.php" method="POST">
			Логин: <input type="text" name="login" /><br><br>
			Пароль: <input type="password" name="password" /><br><br>
			<input type="submit" value="Войти">
		</form>
              
    </div>
    
 


</div>



<?php include_once 'footer.php';
?>
