<?php
require_once('config.php');
include("connect.php");
//print $_SESSION['user'];
//print $_GET['mod'];
$cerere2="select * from random where 1";
$resursa2=mysql_query($cerere2);
$row=mysql_fetch_array($resursa2);
print $row['rand']; 
?>