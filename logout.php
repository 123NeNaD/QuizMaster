<?php

	session_start();
    session_unset();
    session_destroy();
	header("Location: prijava.php");

?>



// <?php
  //  session_start();
   // echo "<h3> PHP List All Session Variables</h3>";
   // foreach ($_SESSION as $key=>$val)
   // echo $key." ".$val."<br/>";
// ?>