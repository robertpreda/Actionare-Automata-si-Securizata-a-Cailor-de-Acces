<?php
//print 'kjakajdakjdh';
require_once('config.php');
include("connect.php");
if(!isset($_SESSION['datejs1'])) $_SESSION['datejs1'] = 'nu';
if(!isset($_POST['id'])) $_POST['id'] = '';
if(!isset($_POST['pass1'])) $_POST['pass1'] = '';
//print 'logat:'.$_SESSION['datejs1'];
if (isset($_POST["points"])) 
{
    // Decode our JSON into PHP objects we can use
    $points = json_decode($_POST["points"]);
    // Access our object's data and array values.
    //echo "Data is: " . $points->data . "<br>";
    //echo "Point 1: " . $points->data[1] . ", " . $points->arPoints[0]->y;
    $lungime = $points->lungime;
    $date = $lungime.';'; 
    for($j=1;$j<$lungime;$j++){
    	//print $points->data[$j].'  ';
        $date =$date.$points->data[$j].';';
    }    
   
//print 'mama lena da-mi mancare';
//print $date;
//print 'id= '.$points->id;
//print 'parola= '.$points->pass;
//print " lungime = ".$lungime;

$update = "UPDATE users SET Parola_3='".$points->pass."', timpi='".$date."' where ID='".$points->id."'";
//print $update;
mysql_query($update);
print 'Cerere inserare trimisa';

}


?>
