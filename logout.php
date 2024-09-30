<?php
session_start();
session_destroy();
setcookie('creation',base64_encode($num['id']),time()+0);
header('location:signin.php');
?>