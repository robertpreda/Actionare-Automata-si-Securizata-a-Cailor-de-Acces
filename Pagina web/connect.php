<?php
$db_host="localhost";
$db_username="root";
$db_password="admin1234";
$db_select="poarta";
mysql_connect($db_host,$db_username,$db_password);
mysql_select_db($db_select);

/*fisierul se conecteaza la baza de date dinainte creata, numita "dictionar", care
cuprinde cateva tabele : cuvinte, domenii, useri, etc.*/
?>