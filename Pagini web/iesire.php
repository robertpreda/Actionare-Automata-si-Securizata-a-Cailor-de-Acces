<?php
session_start();
session_destroy();
session_unset();
echo 'Ati iesit din sistem. <br>
	  Pentru a va intoarce la pagina principala, apasati <a href="index.php">aici</a>';

?>
