<?php
require_once('config.php');
include("connect.php");
//print $_SESSION['user'];
//print $_GET['mod'];
if(!isset($_GET['com'])) $_GET['com'] = '';
if(!isset($_GET['user'])) $_GET['user'] = '';
if(!isset($_GET['token'])) $_GET['token'] = '';
$cerere2="select * from users, random where ID='".$_GET['user']."'";
$date=time();
$nume =$_GET['user'].'_'.$date; 
$resursa2=mysql_query($cerere2);
$row=mysql_fetch_array($resursa2);
//print $row['Parola_2'].' '.$row['rand']; 
//print $cerere
//var_dump($row);
//print md5($_GET['user'].$row['Parola_2'].$row['rand'].'1';
if($_GET['token'] == md5($_GET['user'].$row['Parola_2'].$row['rand'].'1')){
$becuri='avconv -f video4linux2 -s vga -i /dev/video0 -vframes 1 /var/www/test/img/'.$nume.'.jpg';
echo $becuri;
$comanda=shell_exec($becuri);
echo $comanda;
$cerere = "INSERT INTO `poarta`.`pontaje` (`ID`, `Data`, `Ora`,`Actiune`,`poza`) VALUES ('".$_GET['user']."', CURDATE(), CURTIME(),'Deschidere','".$nume.".jpg')";
echo $cerere;
mysql_query($cerere);
$output = shell_exec('gpio mode 0 out');
$output1 = shell_exec('gpio write 0 0');
sleep(2);
$output2 = shell_exec('gpio write 0 1');
print 'S-a deschis poarta';
print 'comanda este 1';
$randNou=$row['rand']+1;
$cerere="UPDATE `poarta`.`random` SET  `rand` =  '".$randNou."' WHERE  `random`.`rand` ='".$row['rand']."'";
mysql_query($cerere);
}
else if($_GET['token'] == md5($_GET['user'].$row['Parola_2'].$row['rand'].'2')){
$comanda = shell_exec('avconv -f video4linux2 -s vga -i /dev/video0 -vframes 1 /var/www/test/img/'.$nume.'.jpg');
$cerere = "INSERT INTO `poarta`.`pontaje` (`ID`, `Data`, `Ora`,`Actiune`,`poza`) VALUES ('".$_GET['user']."', CURDATE(), CURTIME(),'Inchidere','".$nume.".jpg')";
mysql_query($cerere);
print 'S-a inchis poarta';
$output = shell_exec('gpio mode 1 out');
$output1 = shell_exec('gpio write 1 0');
sleep(2);
$output2 = shell_exec('gpio write 1 1');
print 'comanda este 2';
$randNou=$row['rand']+1;
$cerere="UPDATE `poarta`.`random` SET  `rand` =  '".$randNou."' WHERE  `random`.`rand` ='".$row['rand']."'";
mysql_query($cerere);

}
else if($_GET['token'] == md5($_GET['user'].$row['Parola_2'].$row['rand'].'3')){
$randNou=$row['rand']+1;
$cerere="UPDATE `poarta`.`random` SET  `rand` =  '".$randNou."' WHERE  `random`.`rand` ='".$row['rand']."'";
mysql_query($cerere);
$comanda=shell_exec('avconv -f video4linux2 -s vga -i /dev/video0 -vframes 1 /var/www/test/img/'.$nume.'.jpg');
$cerere = "INSERT INTO `poarta`.`pontaje` (`ID`, `Data`, `Ora`,`Actiune`,`poza`) VALUES ('".$_GET['user']."', CURDATE(), CURTIME(),'Automat','".$nume.".jpg')";
mysql_query($cerere);
$output = shell_exec('gpio mode 0 out');
	$output1 = shell_exec('gpio write 0 0');
	sleep(2);
	$output2 = shell_exec('gpio write 0 1');
//print 'Poarta s-a deschis, iar peste 10 secunde se va inchide<br>';
sleep(15);
//print 'Se trimite comanda de inchidere<br>';
	$output = shell_exec('gpio mode 1 out');
	$output1 = shell_exec('gpio write 1 0');
	sleep(2);
	$output2 = shell_exec('gpio write 1 1');
print 'Poarta automat';
//$output = shell_exec();

print 'comanda este 3';


}
else if($_GET['token'] == md5($_GET['user'].$row['Parola_2'].$row['rand'].'4')){

$cerere = "INSERT INTO `poarta`.`pontaje` (`ID`, `Data`, `Ora`,`Actiune`) VALUES ('".$_GET['user']."', CURDATE(), CURTIME(),'Pauza')";
mysql_query($cerere);
$output = shell_exec('gpio mode 2 out');
$output1 = shell_exec('gpio write 2 0');
sleep(2);
$output2 = shell_exec('gpio write 2 1');
//print 'Poarta este oprita';

print 'comanda este 4';
$randNou=$row['rand']+1;
$cerere="UPDATE `poarta`.`random` SET  `rand` =  '".$randNou."' WHERE  `random`.`rand` ='".$row['rand']."'";
mysql_query($cerere);

}
/*switch($_GET['com'])
{
case '':
print 'gol';
break;


case '1':
$cerere = "INSERT INTO `poarta`.`pontaje` (`ID`, `Data`, `Ora`,`Actiune`) VALUES ('".$id."', CURDATE(), CURTIME(),'Deschidere');";
mysql_query($cerere);
$output = shell_exec('gpio mode 0 out');
$output1 = shell_exec('gpio write 0 1');
print 'S-a deschis poarta';
break;


case '2':
$cerere = "INSERT INTO `poarta`.`pontaje` (`ID`, `Data`, `Ora`,`Actiune`) VALUES ('".$id."', CURDATE(), CURTIME(),'Inchidere');";
mysql_query($cerere);
print 'S-a inchis poarta';
$output = shell_exec('gpio mode 0 out');
$output1 = shell_exec('gpio write 0 0');
break;


case '3':
$cerere = "INSERT INTO `poarta`.`pontaje` (`ID`, `Data`, `Ora`,`Actiune`) VALUES ('".$id."', CURDATE(), CURTIME(),'Automat');";
mysql_query($cerere);
print 'Poarta s-a deschis, iar peste 10 secunde se va inchide';
$output = shell_exec();
break;


case '4':
$cerere = "INSERT INTO `poarta`.`pontaje` (`ID`, `Data`, `Ora`,`Actiune`) VALUES ('".$id."', CURDATE(), CURTIME(),'Pauza');";
mysql_query($cerere);
print 'Poarta este oprita';
break;


}
}
}
*/
?>
