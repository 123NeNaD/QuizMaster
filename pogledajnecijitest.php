<?php

	session_start();
	
	if(isset($_SESSION['korisnik']) AND isset($_SESSION['kime']) AND isset($_SESSION['imetesta'])){
		$x = $_SESSION['korisnik'];
		include_once('inc/DB.inc.php');
	} else {
		header("Location: index.php");
	}
	
?>


<html>

	<body>
		
		<div id="Container31">
		
			<div style="width:20%; height:100px; background-color:#efceff; float:left;">
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


<?php
	
	if(isset($_SESSION['imetesta'])){
	
		include_once('inc/DB.inc.php');
		echo "<br><br><br><br><br><br><br><h1 style='position:relative; right:69px; color:#34056d; text-decoration:underline;'><center>Rezultati testa: ".$_SESSION['imetesta']." za korisnika: ".$_SESSION['kime_ispitanika']."</center></h1>";
		
		$upit1 = "SELECT * FROM test_poeni WHERE ime_testa='".$_SESSION['imetesta']."' AND kime_ispitanika='".$_SESSION['kime_ispitanika']."'";
		$rezultat1 = mysqli_query($konekcija, $upit1)
			or die("Greska u upitu2: ".mysqli_errno($konekcija));
		if(mysqli_num_rows($rezultat1) == 0){
			echo "Greska! Izabrani korisnik nije radio ovaj test.";
		}
		if(mysqli_num_rows($rezultat1) > 1){
			echo "Greska! Izabrani korisnik je ovaj test radio vise puta.";
		}
		if(mysqli_num_rows($rezultat1) == 1){
			$niz1 = mysqli_fetch_array($rezultat1);
			$osvojenopoena = $niz1['broj_osvojenih_poena'];
			$ukupnopoena = $niz1['max_poena'];
		}
		
		echo "<h1 style='position:relative; right:69px; color:black; text-decoration:none;'><center>Osvojeno $osvojenopoena/$ukupnopoena poena</center></h1>";
		echo "<br>";
		
		//Ispis odgovora na pitanja
		$upit2 = "SELECT * FROM testodgovori WHERE kime='".$_SESSION['kime_ispitanika']."' AND ime_testa='".$_SESSION['imetesta']."'";
		$rezultat2 = mysqli_query($konekcija, $upit2)
			or die("Greska u upitu2: ".mysqli_errno($konekcija));
		if(mysqli_num_rows($rezultat2) == 0){
			echo "Greska! Korisnik nije radio ovaj test.";
		} else {
			
			echo "<br><table style='position:relative; right:0px; width='100%'; background-color:#efceff;; color:black;' border='0px' cellpadding='5px' align='center'>";
			$brojac = 1;
			while($niz2 = mysqli_fetch_array($rezultat2)){
				echo "<tr> <td align='left' width='7%' height='50px'>".$brojac.". [".$niz2["broj_poena"]."]</td>";
				echo "<td align='left' width='64%' height='50px'>".$niz2["tekst_pitanja"]."</td>";
				echo "<td width='30%' height='50px'>Odgovor: ".$niz2["odgovor"]."</td></tr>";
				echo "<tr><td colspan='3'><hr style='color:#34056d;'></td></tr>";
				$brojac++;
			}
			echo "</table>";

		}
		
	}
	
?>


<html>
	
	<form name="mojaforma32" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">

		<input type="submit" name="uradjenitestovi" value="POVRATAK NA REZULTATE TESTA" style="background-color:#34056d; position:relative; left:400px; color:white; cursor:pointer; align:center;">
		<br><br>
		
	</form>
	
</html>


<?php

	if(isset($_POST['uradjenitestovi'])){

		unset($_SESSION["kime_ispitanika"]);
		header("Location: rezultatitestiranjadrugastranica.php");
		
	}

?>
