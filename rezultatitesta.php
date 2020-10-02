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
		
		<div id="Container19">
		
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
		echo "<br><br><br><br><br><br><br><h1 style='position:relative; right:69px; color:#34056d; text-decoration:underline;'><center>Rezultati testa: ".$_SESSION['imetesta']."</center></h1>";
		
		//Ispis broja osvojenih poena
		$brojpitanja = $_SESSION['brojpitanja'];
		$brojac = 1; 
		$ukupnopoena = 0;
		$osvojenopoena = 0;
	
		while($brojpitanja>0){
			
			$poeni_pitanje = $_SESSION["poeni$brojac"];
			$odgovor_pitanje = $_SESSION["odgovor$brojac"];
			$tacan_odgovor = $_SESSION["tacanodgovor$brojac"];
			$broj_tacnih_odgovora = $_SESSION["brojtacnih$brojac"];
			$vrsta_odgovora = $_SESSION["vrstaodgovora$brojac"];
			$ukupnopoena = $ukupnopoena + $poeni_pitanje;
			
			if($vrsta_odgovora == 1 OR  $vrsta_odgovora == 2 OR $vrsta_odgovora == 3 OR $vrsta_odgovora == 4){
				$odgovor_pitanje = trim($odgovor_pitanje);
				$tacan_odgovor = trim($tacan_odgovor);
				if(strcasecmp($odgovor_pitanje, $tacan_odgovor) == 0){
					$osvojenopoena = $osvojenopoena + $poeni_pitanje;
				}
			}
			
			if($vrsta_odgovora == 5){
				$brojac_tacni_odgovori = 0;
				$brojac_tacno_odgovoreni = 0;
				$odgovor_pitanje = trim($odgovor_pitanje);
				$tacan_odgovor = trim($tacan_odgovor);
				
				if($tacan_odgovor != ""){
					$tacan_odgovor = explode(";", $tacan_odgovor);
					foreach($tacan_odgovor as $t){
						$brojac_tacni_odgovori++;
						if(stristr($odgovor_pitanje, $t)){
							$brojac_tacno_odgovoreni++;
						}
					}
				}
				
				if($brojac_tacni_odgovori == 0){
					$osvojenopoena = $osvojenopoena + $poeni_pitanje;
				} else {
					$pom = $brojac_tacno_odgovoreni/$brojac_tacni_odgovori*$poeni_pitanje;
					$osvojenopoena = $osvojenopoena + $pom;
				}
			
			}
			
			$brojpitanja--;
			$brojac++;
		
		}
		
		echo "<h1 style='position:relative; right:69px; color:black; text-decoration:none;'><center>Osvojili ste $osvojenopoena/$ukupnopoena poena</center></h1>";
		echo "<br>";
		
		//Ispis odgovora na pitanja
		echo "<br><table style='position:relative; right:0px; width='100%'; background-color:#efceff;; color:black;' border='0px' cellpadding='5px' align='center'>";
		$brojpitanja = $_SESSION['brojpitanja'];
		$brojac = 1; 
		$brojneodgovorenih = 0;
	
		while($brojpitanja>0){
						
			echo "<tr> <td align='left' width='7%' height='50px'>".$brojac.". [".$_SESSION["poeni$brojac"]."]</td>";
			echo "<td align='left' width='64%' height='50px'>".$_SESSION["pitanje$brojac"]."</td>";
			echo "<td width='30%' height='50px'>Vas odgovor: ".$_SESSION["odgovor$brojac"]."</td></tr>";
			echo "<tr><td colspan='3'><hr style='color:#34056d;'></td></tr>";
			$brojac++;
			$brojpitanja--;
		
		}
		
		echo "</table>";
	
	
		$upit1 = "SELECT * FROM test_poeni WHERE ime_testa = '".$_SESSION['imetesta']."' AND kime_ispitanika = '".$_SESSION['kime']."'";
		$rezultat1 = mysqli_query($konekcija, $upit1)
			or die("Greska u upitu2: ".mysqli_errno($konekcija));
		if(mysqli_num_rows($rezultat1) > 0){
			echo "Greska! Vec ste radili ovaj test.";
		} else {
			$upit2 = "INSERT INTO test_poeni(ime_testa, kime_ispitanika, broj_osvojenih_poena, max_poena) VALUES('".$_SESSION['imetesta']."','".$_SESSION['kime']."','".$osvojenopoena."','".$ukupnopoena."')";
			$rezultat2 = mysqli_query($konekcija, $upit2) or die(mysqli_errno($konekcija));
		}
	
	}
	
?>		


<html>
	
	<form name="mojaforma19" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">

		<input type="submit" name="pocetna" value="POVRATAK NA POCETNU STRANU" style="background-color:#34056d; position:relative; left:400px; color:white; cursor:pointer; align:center;">
		<br><br>
		
	</form>
	
</html>


<?php

	if(isset($_POST['pocetna'])){
		
		$brojpitanja = $_SESSION['brojpitanja'];
		$brojac = 1; 
	
		while($brojpitanja>0){
			
			unset($_SESSION["tajmer"]);
			unset($_SESSION["pitanje$brojac"]);
			unset($_SESSION["odgovor$brojac"]);
			unset($_SESSION["poeni$brojac"]);
			unset($_SESSION["imetesta"]);
			unset($_SESSION["brojpitanja"]);
			unset($_SESSION["brojtacnih$brojac"]);
			unset($_SESSION["tacanodgovor$brojac"]);
			unset($_SESSION["vrstaodgovora$brojac"]);
			
			$brojpitanja--;
			$brojac++;
		
		}
	
		header("Location: ispitanik.php");
		
	}

?>

