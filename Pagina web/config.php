<?php
session_start();
set_time_limit(0);
error_reporting(E_ALL);

// Informatii baza de date

 $AdresaBazaDate = "localhost";
 $UtilizatorBazaDate = "root";
 $ParolaBazaDate = "admin1234";
 $NumeBazaDate = "poarta";

 $conexiune = mysql_connect($AdresaBazaDate,$UtilizatorBazaDate,$ParolaBazaDate) or die("Nu ma pot conecta la MySQL!");
 mysql_select_db($NumeBazaDate, $conexiune) or die("Nu gasesc baza de date");

function addentities($data){
   if(trim($data) != ''){
   $data = htmlentities($data, ENT_QUOTES);
   return str_replace('\\', '&#92;', $data);
   } else return $data;
} 

function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
// End addentities() --------------

/*print '<script language="JavaScript" type="text/JavaScript">

function MM_openBrWindow(theURL,winName,features) {
window.open(theURL,winName,features);


}
</script>';
*/


?>
