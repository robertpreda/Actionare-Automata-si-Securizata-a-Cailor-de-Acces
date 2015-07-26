<?php
require_once 'config.php';
include("connect.php");
print '<html>
<title>LogIn</title>
<body>
<center>
    <section class="loginform cf">  
    <form name="login" action="index_submit" method="get" accept-charset="utf-8">  
        <ul>  
            <li><label for="nume">Nume</label>  
            <input type="text" name="nume" placeholder=" " required></li>  
            <li><label for="parola">parola</label>  
            <input type="text" name="parola" placeholder=" " required></li>  
            <li>  
            <input type="submit" value="Login"></li>  
        </ul>  
    </form>  
    </section>  
</center>';

if(!isset$_SESSION['logat'])) $_SESSION['logat'] = 'NU';
if($_SESSION['logat'] != 'Da')
{
echo 'Nu aveti acces la aceasta pagina. <br>
      Pentru a reveni la prima pagina, apasati <a href="index.php">aici</a><br>';

}
elseif($_SESSION['user']!="admin")
echo 'Nu aveti acces la aceasta pagina. <br>
      Pentru a reveni la prima pagina, apasati <a href="index.php">aici</a><br>';
else
{ print'<td width=100% valign="top">';
print '</body>
</html>';
?>
