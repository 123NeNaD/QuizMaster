<?php

	session_start();
	
	if(isset($_SESSION['korisnik']) AND isset($_SESSION['kime']) AND isset($_SESSION['imetesta'])){
		$x = $_SESSION['korisnik'];
		include_once('inc/DB.inc.php');
	} else {
		header("Location: index.php");
	}
	
	if(!isset($_SESSION['tajmer'])){
		
		$upit3 = "SELECT trajanje_min FROM testovi WHERE ime_testa='".$_SESSION['imetesta']."'";
		$rezultat3 = mysqli_query($konekcija, $upit3);
		
		if(mysqli_num_rows($rezultat3) == 0){
			echo "Greska! Izabrani test ne postoji.";
		}
		
		if(mysqli_num_rows($rezultat3) > 1){
			echo "Greska! Postoji vise istih testova.";
		}
		
		if(mysqli_num_rows($rezultat3) == 1){
			$niz = mysqli_fetch_array($rezultat3);
			$vreme_trajanja = $niz["trajanje_min"]*60;
		}
		
	} else {
		$vreme_trajanja = $_SESSION['tajmer'];
	}
	
?>


<html>
	
	<head> 
		<link rel="stylesheet" type="text/css" href="Projekat_CSS.css">
		<script language="JavaScript" src="Tajmer.js"></script>
	</head>
	
	<body>
		
		<div id="Container17">
		
			<div style="width:20%; height:100px; background-color:#efceff; float:left;">
			</div>
			
			<div style="width:48%; height:100px; background-color:#efceff; float:left; text-align:center;">
				<center><h3> <?php echo "<br>Ulogovani ste kao: $x";?> </h3></center>
				<center><a href="logout.php"><img src="logout.png"></a><center> <hr style="width:80%">
			</div>
			
			<div style="width:32%; height:100px; background-color:#efceff; float:left;">
				<label>Preostalo vremena:</label><time id="countdown"></time>
			</div>

		</div>

	</body>
	
</html>

<script>
var seconds = <?php echo $vreme_trajanja?>;
</script>

<html>

	<body>

		<form name="mojaforma17" method="POST">
			<input type="hidden" name="skriveno" id="skriveno" value="<?php if(isset($_SESSION['tajmer'])){ echo $_SESSION['tajmer']; } else { echo $vreme_trajanja; } ?>">
		<?php

			include_once('inc/DB.inc.php');
			echo "<br><br><br><br><br><br><br><h1 style='position:relative; right:69px; color:#34056d; text-decoration:underline;'><center>Resavate test: ".$_SESSION['imetesta']."</center></h1>";
			echo "<br>";
			$upit1 = "SELECT * FROM testpitanja WHERE ime_testa = '".$_SESSION['imetesta']."'";
			$rezultat1 = mysqli_query($konekcija, $upit1)
				or die("Greska u upitu2: ".mysqli_errno($konekcija));
			
			echo "<br><table style='position:relative; right:0px; width='100%'; background-color:#efceff;; color:black;' border='0px' cellpadding='5px' align='center'>";
			$brojac = 1;
			$broj_pitanja = 1;
			while($niz = mysqli_fetch_array($rezultat1)){
				$_SESSION["pitanje$broj_pitanja"] = $niz['tekst_pitanja'];
				$_SESSION["poeni$broj_pitanja"] = $niz['broj_poena'];
				$_SESSION["brojtacnih$broj_pitanja"] = $niz['broj_tac_odg'];
				$_SESSION["tacanodgovor$broj_pitanja"] = $niz['tacan_odgovor'];
				$_SESSION["vrstaodgovora$broj_pitanja"] = $niz['vrsta_odgovora'];
				echo "<tr> <td align='left' width='7%' height='50px'>".$broj_pitanja.". [".$niz['broj_poena']."]</td>";
				echo "<td align='left' width='64%' height='50px'>".$niz['tekst_pitanja']."</td>";
				echo "<td width='30%' height='50px'>Vas odgovor:";
				if($niz['vrsta_odgovora'] == 1){
					if(isset($_SESSION["odgovor$broj_pitanja"])){
						if($_SESSION["odgovor$broj_pitanja"] != "Not answered"){
							$p = $_SESSION["odgovor$broj_pitanja"];
						} else {
							$p = "";
						}
					} else {
						$p = "";
					}
					echo "<input type='number' name='odgovor".$brojac."' value='".$p."'>";
					$brojac++;
					$broj_pitanja++;
				}
				
				if($niz['vrsta_odgovora'] == 2){
					if(isset($_SESSION["odgovor$broj_pitanja"])){
						if($_SESSION["odgovor$broj_pitanja"] != "Not answered"){
							$p = $_SESSION["odgovor$broj_pitanja"];
						} else {
							$p = "";
						}
					} else {
						$p = "";
					}
					echo "<input type='text' name='odgovor".$brojac."' value='".$p."'>";
					$brojac++;
					$broj_pitanja++;
				}
				
				if($niz['vrsta_odgovora'] == 3){
					$ponudjeni = explode(";", $niz['ponudjeni_odgovori']);
					if(isset($_SESSION["odgovor$broj_pitanja"])){
						if($_SESSION["odgovor$broj_pitanja"] == $ponudjeni[0]){
							$p1 = "checked";
							$p2 = "unchecked";
						}
						if($_SESSION["odgovor$broj_pitanja"] == $ponudjeni[1]){
							$p1 = "unchecked";
							$p2 = "checked";
						}
					} else {
						$p1 = "checked";
						$p2 = "unchecked";
					}
					echo "<input type='radio' name='odgovor".$brojac."' value='".$ponudjeni[0]."'".$p1.">".$ponudjeni[0];
					echo "<input type='radio' name='odgovor".$brojac."' value='".$ponudjeni[1]."'".$p2.">".$ponudjeni[1];
					$brojac++;
					$broj_pitanja++;
				}
				
				if($niz['vrsta_odgovora'] == 4){
					$brojponudjenih = $niz['broj_pon_odg'];
					$ponudjeni = explode(";", $niz['ponudjeni_odgovori']);	
					echo "<select name='odgovor".$brojac."'>";
					$brojac2 = 0;
					while($brojponudjenih){
						if(isset($_SESSION["odgovor$broj_pitanja"])){
							if($_SESSION["odgovor$broj_pitanja"] == $ponudjeni[$brojac2]){
								$p = "selected";
							} else {
								$p = "";
							}
						}
						echo "<option ".$p.">".$ponudjeni[$brojac2++]."</option>";
						$brojponudjenih--;
					}
					echo "</select>";
					$brojac++;
					$broj_pitanja++;
				}
				
				if($niz['vrsta_odgovora'] == 5){
					echo "<br>";
					$brojponudjenih = $niz['broj_pon_odg'];
					$pom = $niz['ponudjeni_odgovori'];
					$pom = trim($pom);
					$ponudjeni = explode(";", $pom);
					$brojac2 = 0;
					while($brojponudjenih){
						if(isset($_SESSION["odgovor$broj_pitanja"])){
							$odgovori = explode(",", $_SESSION["odgovor$broj_pitanja"]);
							if(in_array($ponudjeni[$brojac2], $odgovori)){
								$p = "checked";
							} else {
								$p = "";
							}
						} else {
							$p = "";
						}
						echo "<input type='checkbox' name='odgovor".$brojac."' value='' ".$p.">".$ponudjeni[$brojac2++]."<br>";
						$brojponudjenih--;
						$brojac++;
					}
					$broj_pitanja++;
				}
				
				echo "</td></tr>";
				echo "<tr><td colspan='3'><hr style='color:#34056d;'></td></tr>";
			}
			echo "</table><br>";
			
		?>
		
		<center><input type="submit" name="potvrdi" value="ZAVRSI TEST" style="background-color:#34056d; position:relative; right:75px; color:white; cursor:pointer; align:right;"></center>
		<br>

		</form>
	
	</body>
	
</html>


<?php

	if(isset($_POST['skriveno'])){	
		
		$upit2 = "SELECT * FROM testpitanja WHERE ime_testa = '".$_SESSION['imetesta']."'";
		$rezultat2 = mysqli_query($konekcija, $upit2)
			or die("Greska u upitu2: ".mysqli_errno($konekcija));
		$brojpitanja = mysqli_num_rows($rezultat2);
		$_SESSION['brojpitanja'] = $brojpitanja;
		$brojac = 1;
		$brojac2 = 1;
		
		while($niz = mysqli_fetch_array($rezultat2)){
			
			if($niz['vrsta_odgovora'] == 1 OR $niz['vrsta_odgovora'] == 2 OR $niz['vrsta_odgovora'] == 3 OR $niz['vrsta_odgovora'] == 4){
				if($_POST["odgovor$brojac"] != ""){
					$_SESSION["odgovor$brojac2"] = $_POST["odgovor$brojac"];
				} else {
					$_SESSION["odgovor$brojac2"] = "Not answered";
				}
				$brojac++;
				$brojac2++;
			}

			if($niz['vrsta_odgovora'] == 5){
				$brojponudjenih = $niz['broj_pon_odg'];
				$ponudjeni = explode(";", $niz['ponudjeni_odgovori']);
				$odgovor = "";
				$brojac3 = 0;
				while($brojponudjenih>0){
					if(isset($_POST["odgovor$brojac"])){
						$odgovor = $odgovor.$ponudjeni[$brojac3].",";
					}
					$brojponudjenih--;
					$brojac++;
					$brojac3++;
				}
				$odgovor = substr($odgovor, 0, -1);
				$odgovor = trim($odgovor);
				$_SESSION["odgovor$brojac2"] = $odgovor;
				$brojac2++;
			}
	
		}
		
		$_SESSION['tajmer'] = $_POST['skriveno'];
		
		header("Location: testdrugastranica.php");
	
	}

?>
