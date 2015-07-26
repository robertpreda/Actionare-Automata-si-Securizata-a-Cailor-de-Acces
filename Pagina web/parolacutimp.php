<script src="jquery.min.js"></script>
<script>
var start = 0;
var start1 = 0;
var cnt = 0;
var cnt2 = 0;
var vect = [];
var matrice = [];
var i;
var j;
var medie = [];
var obj = {};
var deTrimis;
var vectDeTrimis = [];
var ourObj = {};

function processKeyDown(e, k) {
     if(e.keyCode == 8)
    	{
            vect.length -= 2;		    	
    	    cnt2 = cnt2 - 2;
    	    
    	    
    	}
    	if(cnt2<=0)
    	    {
    	    	cnt2 = 0;
    	    
    	    }

    	//if (!start) 
    	{
        	start = (new Date()).getTime();
    }
    
    ++cnt;
  
}

function processKeyUp(e, k) {
    //alert("mama lena");
   if(e.keyCode != 8 && e.keyCode !=9){
    var delta = (new Date()).getTime() - start;
    vect[cnt2+1] = delta;
    vect[cnt2] = start - start1;
    cnt2+=2;
    //alert(k);
    start1 = start;
    //start = 0;
    //alert(matrice[k]);
   }
}


function prelucrare(){
var username = document.getElementById("username").value;
var pass1 = document.getElementById("pass1").value;
var pass2 = document.getElementById("pass2").value;
var pass3 = document.getElementById("pass3").value;
var pass4 = document.getElementById("pass4").value;
var pass5 = document.getElementById("pass5").value;
//alert("pass1= " + pass1 + "pass2= " + pass2 + "pass3= " + pass3 + "pass4= " + pass4 + "pass5= " + pass5);
if(pass1 == pass2 &&  pass1 == pass3 && pass1 == pass4 && pass1 == pass5){
//alert("merge? merge");
	//alert(vect);
var k=0;
var n = 5;
var m = (vect.length)/5;
//alert(m + " " + vect.length);
for(i=0;i<n;i++){
	matrice[i] = [];
	for(j=0;j<m;j++)
	{
	
	    matrice[i][j]=vect[k];
	    k++;
	
	}
}

for(i=0;i<m;i++){
   medie[i] = (matrice[0][i]+matrice[1][i]+matrice[2][i]+matrice[3][i]+matrice[4][i])/5; 
}
ourObj.id = username;
ourObj.pass = pass1;
ourObj.data = medie;
ourObj.lungime = m;
$.ajax({
   url: 'datejs.php',
   type: 'post',
   data: { "points" : JSON.stringify(ourObj) },
   success: function(data) {
		alert("Data: " + data + "\nStatus: " + status);
		
   }
});
alert("Date inserate cu succes");
}
else
	alert("Ai introdus parola necorespunzatoare intr-unul dintre textbox-uri");
}

    
</script>


<?php
require_once('config.php');
include("connect.php");
if(!isset($_SESSION['logat'])) $_SESSION['logat'] = 'NU';

if($_SESSION['logat'] == 'Da')
{
if($_SESSION['user'] == "root"){
if(isset($_GET['id'])){
print'
<html>
<head></head>
<body>
<center>
<form method="post" action="datejs.php">
<table>
<tr><td>ID: </td><td><input type="text" name="id" value="'.$_GET['id'].'" id="username" disabled="disabled" /></td></tr><br>
<tr><td>Parola1: </td><td><input type="password" name="pass1" onkeydown="processKeyDown(event, 0)" onkeyup="processKeyUp(event, 0)" id="pass1"/></td><br></tr>
<tr><td>Parola2: </td><td><input type="password" name="pass2" onkeydown="processKeyDown(event, 1)" onkeyup="processKeyUp(event, 1)" id="pass2"/></td><br></tr>
<tr><td>Parola3: </td><td><input type="password" name="pass3" onkeydown="processKeyDown(event, 2)" onkeyup="processKeyUp(event, 2)" id="pass3"/></d><br></tr>
<tr><td>Parola4: </td><td><input type="password" name="pass4" onkeydown="processKeyDown(event, 3)" onkeyup="processKeyUp(event, 3)" id="pass4"/></td><br></tr>
<tr><td>Parola5: </td><td><input type="password" name="pass5" onkeydown="processKeyDown(event, 4)" onkeyup="processKeyUp(event, 4)" id="pass5"/></td><br></tr>
<center><tr><td><input type="button" name="proceseaza" value="Terminat" onClick="prelucrare()"></td></tr></center>';
//$cerere="UPDATE users SET Parola_3 = ".$_POST['']." "


print'
</table>
<div id="bec"> </div>
</form>
</center>
</body>
</html>
';
}
}
else
{echo 'Pentru a accesa aceasta pagina, trebuie sa va autentificati cu root. <br>';
}
}
else
{echo 'Pentru a accesa aceasta pagina, trebuie sa va autentificati. <br>';
}
?>
