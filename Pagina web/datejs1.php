<?php

require_once('config.php');
include("connect.php");
$e=40;//epsilon timp apasare tasta
$e1=125;//epsilon timp intre taste
$e2=2;//nr de greseli permise
$e3=27; 
if(!isset($_SESSION['datejs'])) $_SESSION['datejs'] = 'nu';
//print 'logat:'.$_SESSION['datejs'];
if (isset($_POST["points"])) 
{
    // Decode our JSON into PHP objects we can use
    $points = json_decode($_POST["points"]);
    // Access our object's data and array values.
    //echo "Data is: " . $points->data . "<br>";
    //echo "Point 1: " . $points->data[1] . ", " . $points->arPoints[0]->y;
    $lungime = $points->lungime;
    
    //for($j=1;$j<$lungime;$j++){
    	//print $points->data[$j].';';
    //}
    
//print 'user= '.$points->user;
//print 'parola= '.$points->parola;
$cerereSQL = "SELECT * FROM `users` WHERE ID='".$points->user."' AND Parola_3='".$points->parola."'";
$rezultat = mysql_query($cerereSQL);
if(mysql_num_rows($rezultat) == 1)
{
  while($rand = mysql_fetch_array($rezultat))
  {
    $timpi = explode(';', $rand['timpi']);
    $k=0;
    //$points->data=$timpi;
    $lungime=$timpi[0];
    for($i=1;$i<$lungime;$i+=2){
    	//print 'up'.($timpi[$i]-$points->data[$i]).' ';
    	//print "sp".($timpi[$i+1]-$points->data[$i+1])." ";
    	if(abs($timpi[$i] - $points->data[$i])<$e){
    		$k++;
    	}
    	
    	if(abs($timpi[$i+1] - $points->data[$i+1])<$e1+$timpi[$i+1] * $e3/100){
    		$k++;
    	}
    }
    if(($lungime-$k)<=$e2){
    		$_SESSION['datejs'] = "parola_ok";
    		$_SESSION['id_datejs'] = $points->user;
    		print "Parola ok";
    	}
    	else{
    print "  lungime= ".$lungime;
    print "  k= ".$k;
    }
    //print $rand['timpi'];
    //$_SESSION['datejs'] = 'parola_ok';
    //echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=main2.php">';
    
  }

}
else
{
echo 'Date incorecte. <Br>
      Apasati <a href="autentificare2.php">aici</a> pentru a va intoarce la pagina precedenta.';
}
    
}


?>
