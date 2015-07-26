<script language="JavaScript" type="text/JavaScript">

function MM_openBrWindow(theURL,winName,features) {
window.open(theURL,winName,features);
  

}
</script>

<?php
print '<link rel="stylesheet" type="text/css" href="style.css">';
require_once('config.php');
include("connect.php");
if(!isset($_SESSION['datejs'])) $_SESSION['datejs']='nu';
if($_SESSION['datejs'] != 'parola_ok')
	{echo 'Pentru a accesa aceasta pagina, trebuie sa va autentificati. <br>
      Pentru a va autentifica, apasati <a href="autentificare2.php">aici</a><br>';
	}
	else
{ 
print '
<a href="iesire2.php">Delogare</a>
<center>
<br><br><br>
<table>
<tr>

    <td width="393" height="173">
    Butoane pentru actionarea portii: 
      <form id="form1" name="form1" method="post" action="">
        <input type="submit" name="Deschidere" id="1" value="Deschidere" onClick="MM_openBrWindow(\'actionare2.php?com=1\',\'\',\'width=500,height=100,valign=center \')">
  <input type="submit" name="Inchidere" id="2" value="Inchidere" onClick="MM_openBrWindow(\'actionare2.php?com=2\',\'\',\'width=500,height=100,valign=center \')">
  <input type="submit" name="Automat" id="3" value="Automat" onClick="MM_openBrWindow(\'actionare2.php?com=3\',\'\',\'width=500,height=100,valign=center \')">
        <input type="submit" name="Pauza" id="4" value = "Pauza" onClick="MM_openBrWindow(\'actionare2.php?com=4\',\'\',\'width=500,height=100,valign=center \')">
  </form></td>
</table>
</center>

';
}
?>

