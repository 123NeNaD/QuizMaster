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
		
		<div id="Container7">
		
			<div style="width:20%; height:100px; background-color:#efceff; float:left;">
				<a href="novitest.php">Napravi novi test</a><br> <a href="novaanketa.php">Napravi novu anketu</a><br> <a href="dodajpitanjatest.php">Dodaj pitanja u test</a><br> <a href="dodajpitanjaanketa.php">Dodaj pitanja u anketu</a><br>
				<a href="obrisipitanjatest.php">Obrisi pitanja iz testa</a><br> <a href="obrisipitanjaanketa.php">Obrisi pitanja iz ankete</a><br> <a href="rezultatitestiranja.php">Rezultati testova</a><br>
				<a href="rezultatianketiranja.php">Rezultati anketa</a><br> <a href="obrisitest.php">Obrisi test</a><br> <a href="obrisianketu.php">Obrisi anketu</a><br> <a href="pregledtestovazaautora.php">Pregled svih testova</a><br> 
				<a href="pregledanketazaautora.php">Pregled svih anketa</a><br> <a href="promenilozinku.php">Promeni lozinku</a><br>
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

