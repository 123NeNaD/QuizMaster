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
		
		<div id="Container2">
		
			<div style="width:20%; height:100px; background-color:#efceff; float:left;">
				<a href="nacekanju.php">Pregled korisnika na cekanju</a><br> <a href="azuriranjekorisnika.php">Izmena postojecih korisnika</a><br> 
				<a href="brisanjekorisnika.php">Brisanje postojecih korisnika</a><br> <a href="dodajkorisnika.php">Dodaj novog korisnika</a><br> 
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
