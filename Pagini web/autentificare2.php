<script src="jquery.min.js"></script>
<script>
var start = 0;
var start1 = 0;
var cnt = 0;
var cnt2 = 0;
var vect = [];
var i;
var obj = {};
var deTrimis;
var vectDeTrimis = [];
var ourObj = {};

function processKeyDown(e) {
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

function processKeyUp(e) {
    if(e.keyCode == 13){
    dacadauclick();}
    else
    if(e.keyCode != 8 && e.keyCode !=9)
    {
    var delta = (new Date()).getTime() - start;
    vect[cnt2+1] = delta;
    vect[cnt2] = start - start1;
    cnt2+=2;
    start1 = start;
    //start = 0;
    cnt = 0;
   }
}
function dacadauclick(){
var user = document.getElementById("user").value;
var parola = document.getElementById("parola").value;
ourObj.user = user;
ourObj.parola = parola;
ourObj.data = vect;
ourObj.lungime = vect.length;
$.ajax({
   url: 'datejs1.php',
   type: 'post',
   data: { "points" : JSON.stringify(ourObj) },
   success: function(data) {
		alert("Data: " + data + "\nStatus: " + status);
		if(data == "Parola ok"){
		document.getElementById("myform").submit();
		}
   }
});
//document.forms["myform"].submit();

}
    
</script>



<?php
print '<a href="iesire2.php">Sterge tot</a>';
print '<link rel="stylesheet" type="text/css" href="style.css">';
print '
<html>
<head></head>
<body>
<center>
<form id="myform" method="POST" action="main2.php">
  Username: <input type="text" name="username" size="15" id="user" /><br>
  <br>
  <br>
  Password: <input type="password" name="password" size="15" input id="parola" onkeydown="processKeyDown(event)" onkeyup="processKeyUp(event)" /><br>
  <input type="checkbox" onchange="document.getElementById(\'parola\').type = this.checked ? \'text\' : \'password\'"> Afisare parola
  <div align="center">
  
    <p><input type="button" value="Login" onClick="dacadauclick()"/></p>
  </div>
</form>

</center>
</body>
</html>
';
?>
