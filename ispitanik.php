<?php

	session_start();
	
	if(isset($_SESSION['korisnik'])){
		$x = $_SESSION['korisnik'];
		include_once('inc/DB.inc.php');
	} else {
		header("Location: index.php");
	}
	
?>


<html>

	<body>
		
		<div id="Container15">
		
			<div style="width:20%; height:100px; background-color:#efceff; float:left;">
				<a href="pregledtestova.php">Pregled svih testova</a><br> <a href="uradjenitestovi.php">Pregled uradjenih testova</a><br> <a href="pregledanketa.php">Pregled svih anketa</a><br> 
				<a href="uradjeneankete.php">Pregled uradjenih anketa</a><br> <a href="promenilozinku.php">Promeni lozinku</a><br>
			</div>
			
			<div style="width:48%; height:100px; background-color:#efceff; float:left; text-align:center;">
				<center><h3> <?php echo "<br>Ulogovani ste kao: $x";?> </h3></center>
				<center><a href="logout.php"><img src="logout.png"></a><center> <hr style="width:80%">
			</div>
			
			<div style="width:32%; height:100px; background-color:#efceff; float:left;">
			</div>
			
		</div>
		
	</body>

</html>
