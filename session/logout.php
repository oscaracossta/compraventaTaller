<?php
session_start();
session_destroy(); 
header("Location: ../compraventa.php"); 
exit();
?>