<?php
print '<link rel="stylesheet" type="text/css" href="style.css">';
require_once('config.php');
include("connect.php");
if(!isset($_GET['user'])) $_GET['user']='';
if(!isset($_GET['nume'])) $_GET['nume']='';
if(!isset($_GET['prenume'])) $_GET['prenume']='';
if(!isset($_GET['data1'])) $_GET['data1']='';
if(!isset($_GET['data2'])) $_GET['data2']='';

$output = shell_exec('gpio mode 0 out');
$output1 = shell_exec('gpio write 0 1');

$output = shell_exec('gpio mode 1 out');
$output1 = shell_exec('gpio write 1 1');

$output = shell_exec('gpio mode 2 out');
$output1 = shell_exec('gpio write 2 1');


if(!isset($_SESSION['logat'])) $_SESSION['logat'] = 'NU';
if($_SESSION['logat'] != 'Da')
{
echo 'Pentru a accesa aceasta pagina, trebuie sa va autentificati. <br>
      Pentru a va autentifica, apasati <a href="index.php">aici</a><br>
	  Pentru a va inregistra, vorbiti cu root';
}
else
{
print '<a href="iesire.php">Delogare</a>';
print '<script language="JavaScript" type="text/JavaScript">

function MM_openBrWindow(theURL,winName,features) {
window.open(theURL,winName,features);
  

}
</script>';

print '
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Pagina principala</title>



</head>
<body>
<center>



<table width="1000" height="419" border="0">';

if($_SESSION['user']=="admin" || $_SESSION['user']=="portar" || $_SESSION['user']=="root")
 {
 print' <tr>

    <td width="393" height="173">
    Butoane pentru actionarea portii: 
      <form id="form1" name="form1" method="post" action="">
        <input type="submit" name="Deschidere" id="1" value="Deschidere" onClick="MM_openBrWindow(\'actionare.php?com=1\',\'\',\'width=500,height=100,valign=center \')">
  <input type="submit" name="Inchidere" id="2" value="Inchidere" onClick="MM_openBrWindow(\'actionare.php?com=2\',\'\',\'width=500,height=100,valign=center \')">
  <input type="submit" name="Automat" id="3" value="Automat" onClick="MM_openBrWindow(\'actionare.php?com=3\',\'\',\'width=500,height=100,valign=center \')">
        <input type="submit" name="Pauza" id="4" value = "Pauza" onClick="MM_openBrWindow(\'actionare.php?com=4\',\'\',\'width=500,height=100,valign=center \')">
  </form></td>
';
}
if($_SESSION['user']=="admin" || $_SESSION['user'] == "root"){
$cerere2 = "select * from users, pontaje where users.id = pontaje.id order by Data DESC, Ora DESC";
$resursa2 =mysql_query($cerere2);
$row=mysql_fetch_array($resursa2);
$cerere3="SELECT COUNT(Numar) as num from pontaje where data=curdate()";
$resursa3 = mysql_query($cerere3);
$total=mysql_result($resursa3,0);
print '
    <td width="381"><p>Detalii de ultima ora: </p>
<p>Ultimul intrat: <font color="red">'.$row['Nume'].'</font> </p>
<p>Data ultimei intrari: <font color="red">'.$row['Data'].'</font> Ora: <font color="red">'.$row['Ora'].'</font></p>
<p>Nr. de actionari asupra portii/zi: <font color="red">'.$total.'</font></p>
</td>
  </tr>
  <tr>
    <td height="123"><form id="form2" name="form2" method="post" action="">
      Cautare avansata: 
      <table border="0">
      <tr>
      <form action="#" method="post">
      <td>
      UserID: 
      </td>
       <td>
        <input type="text" name="user" id="user" />
        </td>
      <td> Nume:</td>
      
      <td><input type="text" name="nume"/></td>
      <td> Prenume:</td>
      <td><input type="text" name="prenume"/></td>
      </tr>
      <tr>
      <td>
      Data 1
      </td>
      <td>
        <input type="date" name="data1" id="data1" value="'.date('Y-m-d').'"/>
        </td>
      <td>
      Data 2
      </td>
      <td>
      <input type="date" name="data2" id="data2" value="'.date('Y-m-d').'"/>
      </td>
      </tr>
      <tr>
      <td>Ora 1</td>
      <td>
      <input type="time" name="ora1" id="ora1" value="00:00:01"/>
      </td>
      <td>Ora 2</td>
      <td>
      <!--<input type="text" pattern="([01]?[0-9]|2[0-3]):[0-5][0-9]" name="timefrom">-->
	<input type="time" name="ora2" id="ora2" value="'.date('H:i:s').'"/>
      </td>
	<td></td>

     <td><input name="cauta" type="submit" value="cauta" /></td>
	<td><input name="reset" type="reset" value="reset" /></td>
      </tr>
      </table>
    </form></td>
    <td> <!--&nbsp;--><center><a href=gestionare.php?mod=adaugare>Adaugare utilizator nou</a></center><br>
	<center><a href=gestionare.php?mod=modificare>Modificare utilizator</a></center><br>
	<center><a href=gestionare.php?mod=stergere>Stergere utilizator</a></center><br></td>
  </tr>
  <tr >
    <td height="113">
    <table border="1">
    <tr>
    <td>User: </td>
    <td>Data intrarii: </td>
    <td>Actiune: </td>
    <td>Adresa: </td>';

	if($_SESSION['user'] == "root"){
    print '<td><input type="button" name="sterge_tot" value="sterge tot" onClick="MM_openBrWindow(\'gestionarebaza.php?com=confirm_inreg_cauta\',\'\',\'width=500,height=100,valign=center \')" ></td>';
	}
print'
    </form>
    </tr>
    ';
//$cerere="select * from users, pontaje where users.id = pontaje.id and ID =".$_POST['user']." LIKE '%".$_POST['nume']."%' and Prenume LIKE '%".$_POST['prenume']."%' order by Data DESC, Ora DESC ";
/*if($_POST['user']=='' && $_POST['nume']=='' && $_POST['prenume']=='' && $_POST['data1']=='' && $_POST['data2']==''){
$cerere="select * from users, pontaje where users.id = pontaje.id order by Data DESC, Ora DESC ";
}
elseif($_POST['user']!=''){
$cerere="select * from users, pontaje where users.id = pontaje.id and users.id =".$_POST['user']." and data >= '".$_POST['data1']."' and data <= '".$_POST['data2']."' order by Data DESC, Ora DESC ";
print $cerere;
}elseif($_POST['nume']!='' || $_POST['prenume']!=''){
$cerere="select * from users, pontaje where users.id = pontaje.id and (nume LIKE '%".$_POST['nume']."%' and prenume LIKE '%".$_POST['prenume']."%') order by Data DESC, Ora DESC ";
}*/
$cerere="UPDATE pontaje SET sters='nu'";
$resursa =mysql_query($cerere);

$cerere="select * from users, pontaje where users.id = pontaje.id";
if($_POST['user']!=''){$cerere=$cerere." and users.id =".$_POST['user'];}
if($_POST['nume']!=''){$cerere=$cerere." and nume LIKE '%".$_POST['nume']."%'";}
if($_POST['prenume']!=''){$cerere=$cerere." and prenume LIKE '%".$_POST['prenume']."%'";}
if($_POST['data1']!=''){$cerere=$cerere." and data >= '".$_POST['data1']."'";}
if($_POST['data2']!=''){$cerere=$cerere." and data <= '".$_POST['data2']."'";}
if($_POST['ora1']!=''){$cerere=$cerere." and ora >= '".$_POST['ora1']."'";}
if($_POST['ora2']!=''){$cerere=$cerere." and ora <= '".$_POST['ora2']."'";}
$cerere=$cerere." order by Data DESC, Ora DESC";
$resursa =mysql_query($cerere);
$culoare="white";

while($row=mysql_fetch_array($resursa))

{
    if($culoare == "white"){
	$culoare="orange";
}	
else{$culoare="white";}

    print '<tr bgcolor="'.$culoare.'">
    <td>'.$row['Nume'].' '.$row['Prenume'].'
    </td>
    <td>'.$row['Data'].' '.$row['Ora'].'</td>
    <td>'.$row['Actiune'].'</td>
    <td>'.$row['Adresa'].'</td>';
    if($_SESSION['user'] == "root"){
$cerere1="UPDATE pontaje SET sters='da' where numar='".$row['Numar']."'";
mysql_query($cerere1);

    print '<td><input type="button" name="sterge" value="sterge inregistrare" ondblClick="MM_openBrWindow(\'gestionarebaza.php?com=stergere_inreg&ID='.$row['ID'].'&data='.$row['Data'].'&ora='.$row['Ora'].'&actiune='.$row['Actiune'].'\',\'\',\'width=500,height=100,valign=center \')" ></td>';
	}
print '
    </tr>';
}
    print '
    <tr>
    <td>
    
    </table>
    </td>
    <td>&nbsp;</td>
  </tr>

';
}
print '
</table>
</center>
</body>
</html>
';
}
?>
