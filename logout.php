<?php
session_start();
$_SESSION['login']=0;
unset($_SESSION['login']);
session_destroy();
header('Location: /index.php');
?>