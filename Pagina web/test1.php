<?php

$link = mysql_connect('localhost', 'root', 'admin1234');
if (!$link) {
    die('Not connected : ' . mysql_error());
}

// make foo the current db
$db_selected = mysql_select_db('test', $link);
if (!$db_selected) {
    die ('Can\'t use foo : ' . mysql_error());
}
echo "merge";
//$cerere="select nume, data_conectarii from users, detalii2 where users.id = detalii2.id order by nume ASC, data_conectarii DESC ";
$cerere="SELECT COUNT(id) as num from detalii2 where id=1";

$resursa =mysql_query($cerere);
$total=mysql_result($resursa,0);
print $total;

/*while($row=mysql_fetch_array($resursa))

{
print "Numele utiluzatorului este:".$row['nume']." end \n";
print "data este".$row['data_conectarii']."end <br>";
}
*/
?>
