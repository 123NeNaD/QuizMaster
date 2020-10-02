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
		
		<div id="Container36">
		
			<div style="width:20%; height:100px; background-color:#efceff; float:left;">
				<a href="autor.php">Nazad</a><br>
			</div>
			
			<div style="width:48%; height:100px; background-color:#efceff; float:left; text-align:center;">
				<center><h3> <?php echo "<br>Ulogovani ste kao: $x";?> </h3></center>
				<center><a href="logout.php"><img src="logout.png"></a><center> <hr style="width:80%">
			</div>
			
			<div style="width:32%; height:170px; background-color:#efceff; float:left; text-align:center;">
					
					<form name="mojaforma37" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
						
						<br>
						<fieldset>
						<br><label style="position:relative; top:8px;">Ime ankete:</label> <input type="text" name="imeankete" placeholder="Unesite ime ankete" style="position:relative; top:8px;" value="<?php if(isset($_POST['imeankete'])) echo $_POST['imeankete'];?>"> &nbsp 
						<input type="submit" name="potvrdi" value="ZAPOCNI ANKETU" style="background-color:#34056d; color:white; cursor:pointer; position:relative; top:10px; left:34px;"> <br><br>
						
						<?php

							include_once('inc/DB.inc.php');
							
							if(isset($_POST['imeankete'])){
								
								$datum = date("Y-m-d");
								$upit3 = "SELECT * FROM ankete WHERE ime_ankete = '".$_POST['imeankete']."'";
								$rezultat3 = mysqli_query($konekcija, $upit3) or die("Greska: " . mysqli_error($konekcija));
								
								if(mysqli_num_rows($rezultat3) == 0){
									echo "<label style='color:red;'><center><b>Ne postoji anketa sa unetim imenom.</b></center></label>";
								}
								
								if(mysqli_num_rows($rezultat3) > 1){
									echo "<label style='color:red;'><center><b>Greska! Postoji vise istih anketa.</b></center></label>";
								}
								
								if(mysqli_num_rows($rezultat3) == 1){
									
									$upit5 = "SELECT * FROM anketapitanja WHERE ime_ankete = '".$_POST['imeankete']."'";
									$rezultat5 = mysqli_query($konekcija, $upit5) or die("Greska: " . mysqli_error($konekcija));
									if(mysqli_num_rows($rezultat5) > 0){
									
										$upit4 = "SELECT * FROM ankete WHERE ime_ankete = '".$_POST['imeankete']."' AND autor_ankete='".$_SESSION['kime']."'";
										$rezultat4 = mysqli_query($konekcija, $upit4) or die("Greska: " . mysqli_error($konekcija));
										if(mysqli_num_rows($rezultat4) == 0){
											
											$niz = mysqli_fetch_array($rezultat3);
											if($niz['datum_pocetka']<$datum AND $niz['datum_zavrsetka']>$datum){
												
												$upit4 = "SELECT * FROM anketa_konacni_odgovori WHERE ime_ankete='".$_POST['imeankete']."' AND kime_ispitanika='".$_SESSION['kime']."'";
												$rezultat4 = mysqli_query($konekcija, $upit4) or die("Greska: " . mysqli_error($konekcija));
												if(mysqli_num_rows($rezultat4) == 0){
													$_SESSION['imeankete'] = $niz['ime_ankete'];
													header("Location: resavanjeankete.php");
												} else {
													echo "<label style='color:red;'><center><b>Vec ste popunili izabranu anketu. Istu anketu ne mozete popuniti vise puta.</b></center></label>";
												}

											} else if($niz['datum_pocetka']>$datum){
												echo "<label style='color:red;'><center><b>Izabrana anketa jos uvek nije dostupana.</b></center></label>";
											} else {
												echo "<label style='color:red;'><center><b>Izabrana anekta vise nije dostupana.</b></center></label>";
											}
										
										} else {
											echo "<label style='color:red;'><center><b>Greska! Izabrali ste vasu anketu. Ne mozete popunjavati sopstvene ankete.</b></center></label>";
										}

									} else {
										echo "<label style='color:red;'><center><b>Ne postoji anketa sa unetim imenom.</b></center></label>";
									}
									
								}
								
							} 
						
						?>
						
						<br>
						</fieldset>
					
					</form>
			</div>
					
		</div>
		
	</body>
	
</html>


<form name="mojaforma42" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>"> 
	<label style="position:relative; left:350px;">Sortiraj po: </label><select name="opcije" style="position:relative; left:350px;">
		<option value="1" selected>Nazivu rastuce</option>
		<option value="2">Nazivu opadajuce</option>
		<option value="3">Datumu pocetka rastuce</option>
		<option value="4">Datumu pocetka opadajuce</option>
		<option value="5">Datumu zavrsetka rastuce</option>
		<option value="6">Datumu zavrsetka opadajuce</option>
	</select>
	<input type="submit" name="sortiraj" value="SORTIRAJ" style="background-color:#34056d; color:white; cursor:pointer; position:relative; left:350px;">
</form>


<?php	

	include_once('inc/DB.inc.php');

	if(!isset($_POST['opcije'])){
	
		$upit2 = "SELECT DISTINCT a.ime_ankete, a.datum_pocetka, a.datum_zavrsetka, a.tip_ankete FROM ankete a, anketapitanja p WHERE a.ime_ankete = p.ime_ankete ORDER BY a.ime_ankete ASC";
			
		$rezultat2 = mysqli_query($konekcija, $upit2)
			or die("Greska u upitu2: ".mysqli_errno($konekcija));

		echo "<br><table style='position:relative; right:69px; background-color:white; color:black;' border='10px' cellpadding='5px' align='center'> <tr> <th>R.br.</th> <th>Ime ankete</th> <th>Datum pocetka</th> <th>Datum zavrsetka</th> <th>Tip ankete</th> <th>Status</th><tr>";
		$brojac = 1;
		$datum = date("Y-m-d");
		while($niz = mysqli_fetch_array($rezultat2)){
			echo "<tr> <td align='center'>".$brojac++."</td>";
			echo "<td align='center'>".$niz['ime_ankete']."</td>";
			echo "<td align='center'>".$niz['datum_pocetka']."</td>";
			echo "<td align='center'>".$niz['datum_zavrsetka']."</td>";
			echo "<td align='center'>".$niz['tip_ankete']."</td>";
			if($niz['datum_pocetka']<$datum AND $niz['datum_zavrsetka']>$datum){
				echo "<td align='center'><label style='color:green'>DOSTUPANA</label></td></tr>";
			} else {
				echo "<td align='center'><label style='color:red'>NEDOSTUPANA</label></td></tr>";
			}
		}
		echo "</table><br><br>";
		
	}

?>


<?php	

	if(isset($_POST['opcije'])){

		include_once('inc/DB.inc.php');
		
		if($_POST['opcije'] == 1){

			$upit2 = "SELECT DISTINCT a.ime_ankete, a.datum_pocetka, a.datum_zavrsetka, a.tip_ankete FROM ankete a, anketapitanja p WHERE a.ime_ankete = p.ime_ankete ORDER BY a.ime_ankete ASC";
				
			$rezultat2 = mysqli_query($konekcija, $upit2)
				or die("Greska u upitu2: ".mysqli_errno($konekcija));

			echo "<br><table style='position:relative; right:69px; background-color:white; color:black;' border='10px' cellpadding='5px' align='center'> <tr> <th>R.br.</th> <th>Ime ankete</th> <th>Datum pocetka</th> <th>Datum zavrsetka</th> <th>Tip ankete</th> <th>Status</th><tr>";
			$brojac = 1;
			$datum = date("Y-m-d");
			while($niz = mysqli_fetch_array($rezultat2)){
				echo "<tr> <td align='center'>".$brojac++."</td>";
				echo "<td align='center'>".$niz['ime_ankete']."</td>";
				echo "<td align='center'>".$niz['datum_pocetka']."</td>";
				echo "<td align='center'>".$niz['datum_zavrsetka']."</td>";
				echo "<td align='center'>".$niz['tip_ankete']."</td>";
				if($niz['datum_pocetka']<$datum AND $niz['datum_zavrsetka']>$datum){
					echo "<td align='center'><label style='color:green'>DOSTUPANA</label></td></tr>";
				} else {
					echo "<td align='center'><label style='color:red'>NEDOSTUPANA</label></td></tr>";
				}
			}
			echo "</table><br><br>";
			
		}
		
		if($_POST['opcije'] == 2){

			$upit2 = "SELECT DISTINCT a.ime_ankete, a.datum_pocetka, a.datum_zavrsetka, a.tip_ankete FROM ankete a, anketapitanja p WHERE a.ime_ankete = p.ime_ankete ORDER BY a.ime_ankete DESC";
				
			$rezultat2 = mysqli_query($konekcija, $upit2)
				or die("Greska u upitu2: ".mysqli_errno($konekcija));

			echo "<br><table style='position:relative; right:69px; background-color:white; color:black;' border='10px' cellpadding='5px' align='center'> <tr> <th>R.br.</th> <th>Ime ankete</th> <th>Datum pocetka</th> <th>Datum zavrsetka</th> <th>Tip ankete</th> <th>Status</th><tr>";
			$brojac = 1;
			$datum = date("Y-m-d");
			while($niz = mysqli_fetch_array($rezultat2)){
				echo "<tr> <td align='center'>".$brojac++."</td>";
				echo "<td align='center'>".$niz['ime_ankete']."</td>";
				echo "<td align='center'>".$niz['datum_pocetka']."</td>";
				echo "<td align='center'>".$niz['datum_zavrsetka']."</td>";
				echo "<td align='center'>".$niz['tip_ankete']."</td>";
				if($niz['datum_pocetka']<$datum AND $niz['datum_zavrsetka']>$datum){
					echo "<td align='center'><label style='color:green'>DOSTUPANA</label></td></tr>";
				} else {
					echo "<td align='center'><label style='color:red'>NEDOSTUPANA</label></td></tr>";
				}
			}
			echo "</table><br><br>";
			
		}
		
		if($_POST['opcije'] == 3){

			$upit2 = "SELECT DISTINCT a.ime_ankete, a.datum_pocetka, a.datum_zavrsetka, a.tip_ankete FROM ankete a, anketapitanja p WHERE a.ime_ankete = p.ime_ankete ORDER BY a.datum_pocetka ASC";
				
			$rezultat2 = mysqli_query($konekcija, $upit2)
				or die("Greska u upitu2: ".mysqli_errno($konekcija));

			echo "<br><table style='position:relative; right:69px; background-color:white; color:black;' border='10px' cellpadding='5px' align='center'> <tr> <th>R.br.</th> <th>Ime ankete</th> <th>Datum pocetka</th> <th>Datum zavrsetka</th> <th>Tip ankete</th> <th>Status</th><tr>";
			$brojac = 1;
			$datum = date("Y-m-d");
			while($niz = mysqli_fetch_array($rezultat2)){
				echo "<tr> <td align='center'>".$brojac++."</td>";
				echo "<td align='center'>".$niz['ime_ankete']."</td>";
				echo "<td align='center'>".$niz['datum_pocetka']."</td>";
				echo "<td align='center'>".$niz['datum_zavrsetka']."</td>";
				echo "<td align='center'>".$niz['tip_ankete']."</td>";
				if($niz['datum_pocetka']<$datum AND $niz['datum_zavrsetka']>$datum){
					echo "<td align='center'><label style='color:green'>DOSTUPANA</label></td></tr>";
				} else {
					echo "<td align='center'><label style='color:red'>NEDOSTUPANA</label></td></tr>";
				}
			}
			echo "</table><br><br>";
			
		}
		
		if($_POST['opcije'] == 4){

			$upit2 = "SELECT DISTINCT a.ime_ankete, a.datum_pocetka, a.datum_zavrsetka, a.tip_ankete FROM ankete a, anketapitanja p WHERE a.ime_ankete = p.ime_ankete ORDER BY a.datum_pocetka DESC";
				
			$rezultat2 = mysqli_query($konekcija, $upit2)
				or die("Greska u upitu2: ".mysqli_errno($konekcija));

			echo "<br><table style='position:relative; right:69px; background-color:white; color:black;' border='10px' cellpadding='5px' align='center'> <tr> <th>R.br.</th> <th>Ime ankete</th> <th>Datum pocetka</th> <th>Datum zavrsetka</th> <th>Tip ankete</th> <th>Status</th><tr>";
			$brojac = 1;
			$datum = date("Y-m-d");
			while($niz = mysqli_fetch_array($rezultat2)){
				echo "<tr> <td align='center'>".$brojac++."</td>";
				echo "<td align='center'>".$niz['ime_ankete']."</td>";
				echo "<td align='center'>".$niz['datum_pocetka']."</td>";
				echo "<td align='center'>".$niz['datum_zavrsetka']."</td>";
				echo "<td align='center'>".$niz['tip_ankete']."</td>";
				if($niz['datum_pocetka']<$datum AND $niz['datum_zavrsetka']>$datum){
					echo "<td align='center'><label style='color:green'>DOSTUPANA</label></td></tr>";
				} else {
					echo "<td align='center'><label style='color:red'>NEDOSTUPANA</label></td></tr>";
				}
			}
			echo "</table><br><br>";
			
		}
		
		if($_POST['opcije'] == 5){

			$upit2 = "SELECT DISTINCT a.ime_ankete, a.datum_pocetka, a.datum_zavrsetka, a.tip_ankete FROM ankete a, anketapitanja p WHERE a.ime_ankete = p.ime_ankete ORDER BY a.datum_zavrsetka ASC";
				
			$rezultat2 = mysqli_query($konekcija, $upit2)
				or die("Greska u upitu2: ".mysqli_errno($konekcija));

			echo "<br><table style='position:relative; right:69px; background-color:white; color:black;' border='10px' cellpadding='5px' align='center'> <tr> <th>R.br.</th> <th>Ime ankete</th> <th>Datum pocetka</th> <th>Datum zavrsetka</th> <th>Tip ankete</th> <th>Status</th><tr>";
			$brojac = 1;
			$datum = date("Y-m-d");
			while($niz = mysqli_fetch_array($rezultat2)){
				echo "<tr> <td align='center'>".$brojac++."</td>";
				echo "<td align='center'>".$niz['ime_ankete']."</td>";
				echo "<td align='center'>".$niz['datum_pocetka']."</td>";
				echo "<td align='center'>".$niz['datum_zavrsetka']."</td>";
				echo "<td align='center'>".$niz['tip_ankete']."</td>";
				if($niz['datum_pocetka']<$datum AND $niz['datum_zavrsetka']>$datum){
					echo "<td align='center'><label style='color:green'>DOSTUPANA</label></td></tr>";
				} else {
					echo "<td align='center'><label style='color:red'>NEDOSTUPANA</label></td></tr>";
				}
			}
			echo "</table><br><br>";
			
		}
		
		if($_POST['opcije'] == 6){

			$upit2 = "SELECT DISTINCT a.ime_ankete, a.datum_pocetka, a.datum_zavrsetka, a.tip_ankete FROM ankete a, anketapitanja p WHERE a.ime_ankete = p.ime_ankete ORDER BY a.datum_zavrsetka DESC";
				
			$rezultat2 = mysqli_query($konekcija, $upit2)
				or die("Greska u upitu2: ".mysqli_errno($konekcija));

			echo "<br><table style='position:relative; right:69px; background-color:white; color:black;' border='10px' cellpadding='5px' align='center'> <tr> <th>R.br.</th> <th>Ime ankete</th> <th>Datum pocetka</th> <th>Datum zavrsetka</th> <th>Tip ankete</th> <th>Status</th><tr>";
			$brojac = 1;
			$datum = date("Y-m-d");
			while($niz = mysqli_fetch_array($rezultat2)){
				echo "<tr> <td align='center'>".$brojac++."</td>";
				echo "<td align='center'>".$niz['ime_ankete']."</td>";
				echo "<td align='center'>".$niz['datum_pocetka']."</td>";
				echo "<td align='center'>".$niz['datum_zavrsetka']."</td>";
				echo "<td align='center'>".$niz['tip_ankete']."</td>";
				if($niz['datum_pocetka']<$datum AND $niz['datum_zavrsetka']>$datum){
					echo "<td align='center'><label style='color:green'>DOSTUPANA</label></td></tr>";
				} else {
					echo "<td align='center'><label style='color:red'>NEDOSTUPANA</label></td></tr>";
				}
			}
			echo "</table><br><br>";
			
		}
		
	}
	
?>


 
 
 

 
 
 