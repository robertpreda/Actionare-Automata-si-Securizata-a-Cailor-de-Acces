<?php 

$date=time();
$nume =$_GET['user'].'_'.$date; 
$becuri='avconv -f video4linux2 -s vga -i /dev/video0 -vframes 1 /var/www/test/img/'.$nume.'.jpg';
echo $becuri;
$comanda=shell_exec('sh /var/www/test/grabpicture.sh');
//$comanda=shell_exec('sh /usr/local/bin/grabpicture');
echo $comanda;



?>
