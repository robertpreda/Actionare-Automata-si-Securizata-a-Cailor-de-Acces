<?php
require_once('config.php');
include("connect.php");
//print $_SESSION['user'];
//print $_GET['mod'];
if(!isset($_GET['com'])) $_GET['com'] = '';

if(!isset($_SESSION['logat'])) $_SESSION['logat'] = 'NU';
if($_SESSION['logat'] != 'Da')
{
echo 'Pentru a accesa aceasta pagina, trebuie sa va autentificati. <br>
      Pentru a va autentifica, apasati <a href="index.php">aici</a><br>
	  Pentru a va inregistra, apasati <a href="inregistrare.php">aici</a>';
}
else
{
if($_SESSION['user']=="root" || $_SESSION['user'] == "admin" || $_SESSION['user'] == "portar"){
$cerere="select ID from users where nume='".$_SESSION['user']."'";
$resursa =mysql_query($cerere);
$row=mysql_fetch_array($resursa);
$id=$row['ID'];
switch($_GET['com'])
{
case '':
print 'gol';
break;


case '1':
$cerere = "INSERT INTO `poarta`.`pontaje` (`ID`, `Data`, `Ora`,`Actiune`) VALUES ('".$id."', CURDATE(), CURTIME(),'Deschidere');";
mysql_query($cerere);
print 'Se trimite comanda de deschidere<br>';
$output = shell_exec('gpio mode 0 out');
$output1 = shell_exec('gpio write 0 0');
sleep(2);
$output2 = shell_exec('gpio write 0 1');
print 'Se deschide porta';
break;


case '2':
$cerere = "INSERT INTO `poarta`.`pontaje` (`ID`, `Data`, `Ora`,`Actiune`) VALUES ('".$id."', CURDATE(), CURTIME(),'Inchidere');";
mysql_query($cerere);
print 'Se trimite comanda de inchidere<br>';
$output = shell_exec('gpio mode 1 out');
$output1 = shell_exec('gpio write 1 0');
sleep(2);
$output2 = shell_exec('gpio write 1 1');
print 'Se inchide poarta';
break;


case '3':
$cerere = "INSERT INTO `poarta`.`pontaje` (`ID`, `Data`, `Ora`,`Actiune`) VALUES ('".$id."', CURDATE(), CURTIME(),'Automat');";
mysql_query($cerere);
print 'Se trimite comanda de deschidere<br>';
	$output = shell_exec('gpio mode 0 out');
	$output1 = shell_exec('gpio write 0 0');
	sleep(2);
	$output2 = shell_exec('gpio write 0 1');
print 'Poarta s-a deschis, iar peste 10 secunde se va inchide<br>';
sleep(15);
print 'Se trimite comanda de inchidere<br>';
	$output = shell_exec('gpio mode 1 out');
	$output1 = shell_exec('gpio write 1 0');
	sleep(2);
	$output2 = shell_exec('gpio write 1 1');
print 'Poarta se inchide';
break;


case '4':
$cerere = "INSERT INTO `poarta`.`pontaje` (`ID`, `Data`, `Ora`,`Actiune`) VALUES ('".$id."', CURDATE(), CURTIME(),'Pauza');";
mysql_query($cerere);
print 'Se trimite comanda de pauza<br>';
$output = shell_exec('gpio mode 2 out');
$output1 = shell_exec('gpio write 2 0');
sleep(2);
$output2 = shell_exec('gpio write 2 1');
print 'Poarta este oprita';
break;


}
}
}
?>
