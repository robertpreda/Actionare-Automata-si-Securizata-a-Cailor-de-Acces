<?php
require_once('config.php');
if(!isset($_GET['actiune'])) $_GET['actiune'] = '';

switch($_GET['actiune'])
{
case '':
/*echo '<form action="index.php?actiune=validare" method="post">
      Utilizator: <input type="text" name="user" value=""><br>
      Parola: <input type="password" name="parola" value=""><br>
	  <input type="submit" name="Login" value="Login">
	  </form>';   */

?>
<center>
<br>
<br>
<br>
<br>
<br>
<br>
<div style="width:153px;">
<h5 style="text-align:left; color:#121087;"><b>Login:</b></h5>
<form action="index.php?actiune=validare" method="POST">
<h5 style="font-size:10px">Username:<input type="text" name="user" size="19"></h5>
<h5 style="font-size:10px">Password:<input type="password" name="parola" size="19"></h5>
<h5><input type="submit" value="Login"></h5>
</form>
</div>
</center>
<?php
print '<head>
<style>
body {
    background-color: #66CCFF;
}

h1 {
    color: orange;
    text-align: center;
}

p {
    font-family: "Times New Roman";
    font-size: 20px;
}
</style>

</head>';
break;

case 'validare':

$_SESSION['user'] = $_POST['user'];

if(($_POST['user'] == '') || ($_POST['parola'] == ''))
{
echo 'Completeaza casutele. <Br>
      Apasati <a href="index.php">aici</a> pentru a va intoarce la pagina precedenta.';
}
else
{
//$cerereSQL = "SELECT * FROM `Admin` WHERE User='".htmlentities($_POST['user'])."' AND Parola='".md5($_POST['parola'])."'";
$cerereSQL = "SELECT * FROM `Admin` WHERE User='".htmlentities($_POST['user'])."' AND Parola='".htmlentities($_POST['parola'])."'";
$rezultat = mysql_query($cerereSQL);
if(mysql_num_rows($rezultat) == 1)
{
  while($rand = mysql_fetch_array($rezultat))
  {
    $_SESSION['logat'] = 'Da';
    echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=main.php">';
  }
}
else
{
echo 'Date incorecte. <Br>
      Apasati <a href="index.php">aici</a> pentru a va intoarce la pagina precedenta.';
}

}
break;
}
?>
