<?php
require_once('config.php');
include("connect.php");
print $_SESSION['user'];

if(!isset($_SESSION['logat'])) $_SESSION['logat'] = 'NU';
if($_SESSION['logat'] != 'Da')
{
echo 'Pentru a accesa aceasta pagina, trebuie sa va autentificati. <br>
      Pentru a va autentifica, apasati <a href="index.php">aici</a><br>
	  Pentru a va inregistra, apasati <a href="inregistrare.php">aici</a>';
}
else
{
print '<a href="iesire.php">Delogare</a>';

print '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<center>
';
if($_SESSION['user']=="admin" || $_SESSION['user']=="portar" || $_SESSION['user']=="root")
 {
print'
<table width="790" height="419" border="0">


  <tr>

    <td width="393" height="173">
    Butoane pentru actionarea portii: 
      <form id="form1" name="form1" method="post" action="">
        <input type="submit" name="Deschidere" id="1" value="Deschidere" />
  <input type="submit" name="Inchidere" id="2" value="Inchidere" />
  <input type="submit" name="Automat" id="3" value="Automat" />
        <input type="submit" name="Pauza" id="4" value = "Pauza" />
  </form></td>';
}
if($_SESSION['user']=="admin" || $_SESSION['user'] == "root"){
print '
    <td width="381"><p>Detalii de ultima ora: </p>
<p>Ultimul intrat: Gheorghe Ion</p>
<p>Nr. de useri/zi: 2</p>
<p>Data ultimei intrari: 13.02.2015 Ora: 19:00</p></td>
  </tr>
  <tr>
    <td height="123"><form id="form2" name="form2" method="post" action="">
      Cautare avansata: 
      <table>
      <tr>
      <td>
      user: 
      </td>
       <td>
        <input type="text" name="user" id="user" />
        </td>
      </tr>
      <tr>
      <td>
      data1
      </td>
      <td>
        <input type="text" name="data1" id="data1" />
        </td>
      <td>
      <label for="2">data2</label>
      </td>
      <td>
      <input type="text" name="2" id="2" />
      </td>
      </tr>
      <tr>
      <td></td>
      <td></td>
      <td></td>
      <td><input name="cauta" type="button" value="cauta" /></td>
      </tr>
      </table>
    </form></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="113">
    <table border="1">
    <tr>
    <td>
   User: 
    </td>
    <td>Data intrarii: </td>
    <td>Adresa</td>
    <td>Observatii</td>
    </tr>
    
    <tr>
    <td>
 	Ionescu Ion
    </td>
    <td>13.02.2015</td>
    <td>Str. Stan Stanescu nr.9</td>
    <td>Sub influenta alcoolului</td>
    </tr>
    
    <tr>
    <td>
 	Gheorghe Ion
    </td>
    <td>13.02.2015</td>
    <td>Str. Stan Stanescu nr.11</td>
    <td>In intarziere</td>
    </tr>
    
    </table>
    </td>
    <td>&nbsp;</td>
  </tr>
</table>
';
if($_SESIION['user']=="root"){
print '<a href=gestionare.php>Gestionare baza de date</a>';}
print '
</center>
</body>
</html>
';
}
?>
