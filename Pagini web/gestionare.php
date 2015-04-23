<script>
function genrandom(n)
{
    var text = "";
    var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

    for( var i=0; i < n; i++ )
        text += possible.charAt(Math.floor(Math.random() * possible.length));

    return text;
}
</script>
<?php
require_once('config.php');
include("connect.php");
//print $_SESSION['user'];
//print $_GET['mod'];
/*function generateRandomString($length) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
*/
if(!isset($_GET['mod'])) $_GET['mod'] = '';
if(!isset($_SESSION['nume'])) $_SESSION['nume'] = '';
if(!isset($_SESSION['prenume'])) $_SESSION['prenume'] = '';
if(!isset($_SESSION['parola1'])) $_SESSION['parola1'] = '';
if(!isset($_SESSION['parola2'])) $_SESSION['parola2'] = '';
if(!isset($_SESSION['adresa'])) $_SESSION['adresa'] = '';
if(!isset($_SESSION['id'])) $_SESSION['id'] = '';
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
if($_SESSION['user']=="root"){
print '<script language="JavaScript" type="text/JavaScript">

function MM_openBrWindow(theURL,winName,features) {
window.open(theURL,winName,features);
  

}
</script>';
switch($_GET['mod'])
{
case '':
print 'gol';
break;
case 'adaugare':
print '<center><table width="500" length="400" border="0"><form action="gestionare.php?mod=validare" method="post">
<tr><td><font color="darkgray">Nume:</td><td><input type="text" name="nume" value="'.$_SESSION['nume'].'"></font></td><br></tr>
<tr><td><font color="darkgray">Prenume: </td><td><input type="text" name="prenume" value="'.$_SESSION['prenume'].'"></font></td><br></tr>
<tr><td><font color="darkgray">Adresa: </td><td><input type="text" name="adresa" value="'.$_SESSION['adresa'].'"></font></td><br></tr>
<tr><td><font color="darkgray">Parola1: </td><td><input type="text" id="parola1" name="parola1" value="'.generateRandomString(18).'"><input type="button" value="random" onClick="document.getElementById(\'parola1\').value = genrandom(18)"><br></td></tr>
<tr><td><font color="darkgray">Parola2: </td><td><input type="text" id="parola2" name="parola2" value="'.generateRandomString(8).'"><input type="button" value="random" onClick="document.getElementById(\'parola2\').value = genrandom(8)"></font><br</td></tr>
<tr><td><input type="submit" value="Adauga"></td></tr>
<tr><td><input name="reseteaza" type="reset" value="Reset"></td></tr>
<tr><td></td></tr>
</form>
</table>
</center>';

break;
case 'validare':
$_SESSION['nume'] = $_POST['nume'];
$_SESSION['prenume'] = $_POST['prenume'];
$_SESSION['adresa'] = $_POST['adresa'];
$_SESSION['parola1'] = $_POST['parola1'];
$_SESSION['parola2'] = $_POST['parola2'];
$select ="select * from `users` where Nume = \"".$_SESSION['nume']."\" and Prenume = \"".$_SESSION['prenume']."\"";
$resursa =mysql_query($select);
 while($row = mysql_fetch_array($resursa)) {
    if($_SESSION['nume'] == $row['Nume'] && $_SESSION['prenume']==$row['Prenume']){
    print '<br><center>Utilizator deja existent. Alegeti alt nume sau prenume.<br></center>
    <center><table width="500" length="400" border="1">
<tr><td><font color="black">Nume:</td><td>'.$row['Nume'].'</font></td><br></tr>
<tr><td><font color="black">Prenume: </td><td>'.$row['Prenume'].'</font></td><br></tr>
<tr><td><font color="black"Adresa: </td>Adresa: <td>'.$row['Adresa'].'</font></td><br></tr>
<tr><td><font color="black">Parola1: </td><td>'.$row['Parola_1'].'</font><br></td></tr>
<tr><td><font color="black">Parola2: </td><td>'.$row['Parola_2'].'</font><br</td></tr>
</table>
</center>
      Apasa <a href="gestionare.php?mod=adaugare">aici</a> pentru a te intoarce la pagina anterioara.</center>';
      return ;
    }
}
$cereresql="INSERT INTO `users` (`Nume`,`Prenume`,`Adresa`,`Parola_1`,`Parola_2`) VALUES ('".addentities($_SESSION['nume'])."', '".($_SESSION['prenume'])."', '".addentities($_SESSION['adresa'])."', '".addentities($_SESSION['parola1'])."', '".addentities($_SESSION['parola2'])."');";
if($_SESSION['nume']==''||$_SESSION['prenume']==''||$_SESSION['adresa']==''||$_SESSION['parola1']==''||$_SESSION['parola2']==''){
    print '<center><h2>Ati uitat sa completati un camp!
    Click <a href="gestionare.php?mod=adaugare">aici</a> pentru a reveni</h2></center>';
}else{
mysql_query($cereresql);
print '<center><h4>S-a inserat cu succes utilizatorul (teoretic)</h4></center>
<br> Apasa <a href="main.php">aici</a> pentru a te intoarce la pagina anterioara.';
$_SESSION['nume'] = '';
$_SESSION['prenume'] = '';
$_SESSION['adresa'] = '';
$_SESSION['parola1'] = '';
$_SESSION['parola2'] = '';
}
break;
case 'stergere':
$cerere2 = "select * from users, pontaje where users.id = pontaje.id order by Data DESC, Ora DESC";
$resursa2 =mysql_query($cerere2);
$row=mysql_fetch_array($resursa2);
$cerere3="SELECT COUNT(Numar) as num from pontaje where data=curdate()";
$resursa3 = mysql_query($cerere3);
$total=mysql_result($resursa3,0);
print '
    
  <tr>
    <td height="123"><form id="form2" name="form2" method="post" action="">
      Cautare: 
      <table border="0">
      <tr>
      <form action="#" method="post">
      <td>
      Adresa: 
      </td>
       <td>
        <input type="text" name="adresa" id="adresa" />
        </td>
      <td> Nume:</td>
      <td><input type="text" name="nume"/></td>
      <td> Prenume:</td>
      <td><input type="text" name="prenume"/></td>
      </tr>
      <tr>
      </tr>
	<td></td>

     <td><input name="cauta" type="submit" value="cauta" /></td>
	<td><input name="reset" type="reset" value="reset" /></td>
      </tr>
      </table>
    </form></td>
    <td>&nbsp;</td>
  </tr>
  <tr >
    <td height="113">
    <table border="1">
    <tr>
    <td>Nume: </td>
    <td>Prenume: </td>
    <td>Adresa: </td>';

	//if($_SESSION['user'] == "root"){
    //print '<td><input type="button" name="sterge_tot" value="sterge tot" onClick="MM_openBrWindow(\'gestionarebaza.php?com=confirm_inreg_cauta\',\'\',\'width=500,height=100,valign=center \')" ></td>';
	//}
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
$cerere="UPDATE users SET sters='nu'";
$resursa =mysql_query($cerere);

$cerere="select * from users where 1";
//if($_POST['user']!=''){$cerere=$cerere." and users.id =".$_POST['user'];}
if($_POST['nume']!=''){$cerere=$cerere." and Nume LIKE '%".$_POST['nume']."%'";}
if($_POST['prenume']!=''){$cerere=$cerere." and Prenume LIKE '%".$_POST['prenume']."%'";}
if($_POST['adresa']!=''){$cerere=$cerere." and Adresa LIKE '%".$_POST['adresa']."%'";}
//if($_POST['data1']!=''){$cerere=$cerere." and data >= '".$_POST['data1']."'";}
//if($_POST['data2']!=''){$cerere=$cerere." and data <= '".$_POST['data2']."'";}
//if($_POST['ora1']!=''){$cerere=$cerere." and ora >= '".$_POST['ora1']."'";}
//if($_POST['ora2']!=''){$cerere=$cerere." and ora <= '".$_POST['ora2']."'";}
$resursa =mysql_query($cerere);
$culoare="white";

while($row=mysql_fetch_array($resursa))

{
    if($culoare == "white"){
	$culoare="orange";
}	
else{$culoare="white";}
if($row['ID']>3){
    print '<tr bgcolor="'.$culoare.'">
    <td>'.$row['Nume'].'</td>
    <td>'.$row['Prenume'].'</td>
    <td>'.$row['Adresa'].'</td>';
    }
    if($_SESSION['user'] == "root"){
$cerere1="UPDATE users SET sters='da' where ID='".$row['ID']."'";
mysql_query($cerere1);
if($row['ID']>3){
    print '<td><input type="button" name="sterge" value="sterge utilizator" ondblClick="MM_openBrWindow(\'gestionare.php?mod=validare_stergere&ID='.$row['ID'].'\',\'\',\'width=500,height=100,valign=center \')" ></td>';
    }
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
break;
case 'validare_stergere':
if(isset($_GET['ID'])){
$cerere = "DELETE FROM `poarta`.`users` where ID='".$_GET['ID']."'";
mysql_query($cerere);
print 'S-a sters inregistrarea (sper)';
}
break;

case 'modificare':
$cerere2 = "select * from users, pontaje where users.id = pontaje.id order by Data DESC, Ora DESC";
$resursa2 =mysql_query($cerere2);
$row=mysql_fetch_array($resursa2);
$cerere3="SELECT COUNT(Numar) as num from pontaje where data=curdate()";
$resursa3 = mysql_query($cerere3);
$total=mysql_result($resursa3,0);
print '
    
  <tr>
    <td height="123"><form id="form2" name="form2" method="post" action="">
      Cautare: 
      <table border="0">
      <tr>
      <form action="#" method="post">
      <td>
      Adresa: 
      </td>
       <td>
        <input type="text" name="adresa" id="adresa" />
        </td>
      <td> Nume:</td>
      <td><input type="text" name="nume"/></td>
      <td> Prenume:</td>
      <td><input type="text" name="prenume"/></td>
      </tr>
      <tr>
      </tr>
	<td></td>

     <td><input name="cauta" type="submit" value="cauta" /></td>
	<td><input name="reset" type="reset" value="reset" /></td>
      </tr>
      </table>
    </form></td>
    <td>&nbsp;</td>
  </tr>
  <tr >
    <td height="113">
    <table border="1">
    <tr>
    <td>Nume: </td>
    <td>Prenume: </td>
    <td>Adresa: </td>';

	//if($_SESSION['user'] == "root"){
    //print '<td><input type="button" name="sterge_tot" value="sterge tot" onClick="MM_openBrWindow(\'gestionarebaza.php?com=confirm_inreg_cauta\',\'\',\'width=500,height=100,valign=center \')" ></td>';
	//}
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
$cerere="UPDATE users SET sters='nu'";
$resursa =mysql_query($cerere);

$cerere="select * from users where 1";
//if($_POST['user']!=''){$cerere=$cerere." and users.id =".$_POST['user'];}
if($_POST['nume']!=''){$cerere=$cerere." and Nume LIKE '%".$_POST['nume']."%'";}
if($_POST['prenume']!=''){$cerere=$cerere." and Prenume LIKE '%".$_POST['prenume']."%'";}
if($_POST['adresa']!=''){$cerere=$cerere." and Adresa LIKE '%".$_POST['adresa']."%'";}
//if($_POST['data1']!=''){$cerere=$cerere." and data >= '".$_POST['data1']."'";}
//if($_POST['data2']!=''){$cerere=$cerere." and data <= '".$_POST['data2']."'";}
//if($_POST['ora1']!=''){$cerere=$cerere." and ora >= '".$_POST['ora1']."'";}
//if($_POST['ora2']!=''){$cerere=$cerere." and ora <= '".$_POST['ora2']."'";}
$resursa =mysql_query($cerere);
$culoare="white";

while($row=mysql_fetch_array($resursa))

{
    if($culoare == "white"){
	$culoare="orange";
}	
else{$culoare="white";}
if($row['ID']>3){
    print '<tr bgcolor="'.$culoare.'">
    <td>'.$row['Nume'].'</td>
    <td>'.$row['Prenume'].'</td>
    <td>'.$row['Adresa'].'</td>';
    }
    if($_SESSION['user'] == "root"){
$cerere1="UPDATE users SET sters='da' where ID='".$row['ID']."'";
mysql_query($cerere1);
if($row['ID']>3){
    print '<td><input type="button" name="modifica" value="modifica utilizator" onClick="MM_openBrWindow(\'gestionare.php?mod=validare_modificare&ID='.$row['ID'].'\',\'\',\'width=500,height=500,valign=center \')" ></td>
    <td><input type="button" name="timp" value="modifica timpi" onClick="MM_openBrWindow(\'parolacutimp.php?id='.$row['ID'].'\',\'\',\'width=500,height=500,valign=center \')" ></td>';
    }
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
break;
case 'validare_modificare':
if(isset($_GET['ID'])){
$select ="select * from `users` where ID = ".$_GET['ID'];
$resursa =mysql_query($select);
 //while($row = mysql_fetch_array($resursa)) 
 $row = mysql_fetch_array($resursa);
 {
 $_SESSION['nume']=$row['Nume'];
 $_SESSION['prenume']=$row['Prenume'];
 $_SESSION['adresa']=$row['Adresa'];
 $_SESSION['parola1']=$row['Parola_1'];
 $_SESSION['parola2']=$row['Parola_2'];
 $_SESSION['id']=$row['ID'];
 
 }
print '<center><table width="500" length="400" border="0"><form action="gestionare.php?mod=validare2" method="post">
<tr><td><font color="darkgray">Nume:</td><td><input type="text" name="nume" value="'.$_SESSION['nume'].'"></font></td><br></tr>
<tr><td><font color="darkgray">Prenume: </td><td><input type="text" name="prenume" value="'.$_SESSION['prenume'].'"></font></td><br></tr>
<tr><td><font color="darkgray">Adresa: </td><td><input type="text" name="adresa" value="'.$_SESSION['adresa'].'"></font></td><br></tr>
<tr><td><font color="darkgray">Parola1: </td><td><input type="text" id="parola1" name="parola1" value="'.$_SESSION['parola1'].'"><input type="button" value="random" onClick="document.getElementById(\'parola1\').value = genrandom(18)"><br></td></tr>
<tr><td><font color="darkgray">Parola2: </td><td><input type="text" id="parola2" name="parola2" value="'.$_SESSION['parola2'].'"><input type="button" value="random" onClick="document.getElementById(\'parola2\').value = genrandom(8)"></font><br</td></tr>
<tr><td><input type="hidden" name="id" value="'.$_SESSION['id'].'"></td></tr>
<tr><td><input type="submit" value="Modifica"></td></tr>
<tr><td><input name="reseteaza" type="reset" value="Reset"></td></tr>
<tr><td></td></tr>
</form>
</table>
</center>';



}
break;
case 'validare2':
$_SESSION['nume'] = $_POST['nume'];
$_SESSION['prenume'] = $_POST['prenume'];
$_SESSION['adresa'] = $_POST['adresa'];
$_SESSION['parola1'] = $_POST['parola1'];
$_SESSION['parola2'] = $_POST['parola2'];
$_SESSION['id']=$_POST['id'];
//print "id=".$_POST['id'];
$select ="select * from `users` where Nume = \"".$_SESSION['nume']."\" and Prenume = \"".$_SESSION['prenume']."\"";
$resursa =mysql_query($select);
 while($row = mysql_fetch_array($resursa)) {
    if($_SESSION['nume'] == $row['Nume'] && $_SESSION['prenume']==$row['Prenume'] && $_SESSION['id']!=$row['ID']){
    print '<br><center>Utilizator deja existent. Alegeti alt nume sau prenume.<br></center>
    <center><table width="500" length="400" border="1">
<tr><td><font color="black">Nume:</td><td>'.$row['Nume'].'</font></td><br></tr>
<tr><td><font color="black">Prenume: </td><td>'.$row['Prenume'].'</font></td><br></tr>
<tr><td><font color="black"Adresa: </td>Adresa: <td>'.$row['Adresa'].'</font></td><br></tr>
<tr><td><font color="black">Parola1: </td><td>'.$row['Parola_1'].'</font><br></td></tr>
<tr><td><font color="black">Parola2: </td><td>'.$row['Parola_2'].'</font><br</td></tr>
</table>
</center>
      Apasa <a href="gestionare.php?mod=validare_modificare&ID='.$_SESSION['id'].'">aici</a> pentru a te intoarce la pagina anterioara.</center>';
      return ;
    }
}
$cerere="UPDATE users SET Nume='".$_SESSION['nume']."', Prenume='".$_SESSION['prenume']."', Adresa='".$_SESSION['adresa']."', Parola_1='".$_SESSION['parola1']."', Parola_2='".$_SESSION['parola2']."' where ID='".$_SESSION['id']."'";
$resursa =mysql_query($cerere);
//print $cerere;
print 'S-au modificat valorile';
break;

}
}
}


?>
