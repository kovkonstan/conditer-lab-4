<?php

  include_once('classes.php');
 if (isset($_POST) && isset ($_POST['type_name']))
        
 {
    $link=new Link('localhost','root','','sklad');
       $link->AddType($_POST['type_name']);
       header('location:sklad.php');
 }

?>



