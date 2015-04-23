<?php
require_once('config.php');
include("connect.php");
//print $_SESSION['user'];
//print $_GET['mod'];
if(!isset($_GET['com'])) $_GET['com'] = '';
if(!isset($_GET['ID'])) $_GET['ID'] = '';
if(!isset($_GET['data'])) $_GET['data'] = '';
if(!isset($_GET['ora'])) $_GET['ora'] = '';
if(!isset($_GET['actiune'])) $_GET['actiune'] = '';
if(!isset($_GET['nr'])) $_GET['nr'] = '';

if(!isset($_SESSION['logat'])) $_SESSION['logat'] = 'NU';
if($_SESSION['logat'] != 'Da')
{
echo 'Pentru a accesa aceasta pagina, trebuie sa va autentificati. <br>
      Pentru a va autentifica, apasati <a href="index.php">aici</a><br>
	  Pentru a va inregistra, apasati <a href="inregistrare.php">aici</a>';
}
else
{
if($_SESSION['user']=="root"){
$cerere="select ID from users where nume='".$_SESSION['user']."'";
$cerere2="select Numar from pontaje";
$resursa =mysql_query($cerere);
$row=mysql_fetch_array($resursa);
$id=$row['ID'];
switch($_GET['com'])
{
case '':
print 'gol';
break;


case 'stergere_inreg':
$cerere = "DELETE FROM `poarta`.`pontaje` where ID='".$_GET['ID']."' and Data='".$_GET['data']."' and Ora='".$_GET['ora']."' and Actiune='".$_GET['actiune']."'";
mysql_query($cerere);
//$output = shell_exec('gpio mode 0 out');
//$output1 = shell_exec('gpio write 0 1');
print 'S-a sters inregistrarea';
break;


case 'confirm_inreg_cauta':
print '<form action="gestionarebaza.php?com=stergere_inreg_cauta" method="POST">
<INPUT type="hidden" name="sters" value="sters_ok">
Sunteti sigur ca doriti stergerea inregistrarilor din lista?<br>
<INPUT type="submit" name="da" value="Da">
<INPUT type="button" name="nu" value="Nu" onclick="window.close()">
</form>';
break;


case 'stergere_inreg_cauta':
if(isset($_POST['sters']) && $_POST['sters'] == 'sters_ok')
{
$cerere = "DELETE FROM `poarta`.`pontaje` where sters='da'";
mysql_query($cerere);
print 'S-au sters inregistrarire';
}else print 'Nu s-a sters nimic';
break;


case '4':
$cerere = "INSERT INTO `poarta`.`pontaje` (`ID`, `Data`, `Ora`,`Actiune`) VALUES ('".$id."', CURDATE(), CURTIME(),'Pauza');";
mysql_query($cerere);
print 'Poarta este oprita';
break;


}
}
}
?>
