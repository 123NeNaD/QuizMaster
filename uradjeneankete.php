<?php

	session_start();
	
	unset($_SESSION["imeankete"]);
	if(isset($_SESSION['korisnik'])){
		$x = $_SESSION['korisnik'];
		include_once('inc/DB.inc.php');
	} else {
		header("Location: index.php");
	}

?>


<html>

	<body>
		
		<div id="Container25">
		
			<div style="width:20%; height:100px; background-color:#efceff; float:left;">
				<a href="ispitanik.php">Nazad</a><br>
			</div>
			
			<div style="width:48%; height:100px; background-color:#efceff; float:left; text-align:center;">
				<center><h3> <?php echo "<br>Ulogovani ste kao: $x";?> </h3></center>
				<center><a href="logout.php"><img src="logout.png"></a><center> <hr style="width:80%">
			</div>
			
			<div style="width:32%; height:170px; background-color:#efceff; float:left; text-align:center;">
					
					<form name="mojaforma26" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
						
						<br>
						<fieldset>
						<br><label style="position:relative; top:8px;">Ime ankete:</label> <input type="text" name="imeankete" placeholder="Unesite ime ankete" style="position:relative; top:8px;" value="<?php if(isset($_POST['imeankete'])) echo $_POST['imeankete'];?>"> &nbsp 
						<input type="submit" name="potvrdi" value="POGLEDAJ ANKETU" style="background-color:#34056d; color:white; cursor:pointer; position:relative; top:10px; left:32px;"> <br><br>
						
						<?php

							include_once('inc/DB.inc.php');
							
							if(isset($_POST['imeankete'])){
								
								$upit4 = "SELECT * FROM ankete WHERE ime_ankete = '".$_POST['imeankete']."'";
								$rezultat4 = mysqli_query($konekcija, $upit4) or die("Greska: " . mysqli_error($konekcija));
								if(mysqli_num_rows($rezultat4) == 0){
									echo "<label style='color:red'><center><b>Izabrana anketa ne postoji.</b></center></label>";
								}
								
								if(mysqli_num_rows($rezultat4) > 1){
									echo "<label style='color:red'><center><b>Greska! Postoji vise istih anketa.</b></center></label>";
								}
								
								if(mysqli_num_rows($rezultat4) == 1){
								
									$upit3 = "SELECT * FROM anketa_konacni_odgovori WHERE ime_ankete = '".$_POST['imeankete']."' AND kime_ispitanika = '".$_SESSION['kime']."'";
									$rezultat3 = mysqli_query($konekcija, $upit3) or die("Greska: " . mysqli_error($konekcija));
									
									if(mysqli_num_rows($rezultat3) == 0){
										echo "<label style='color:red'><center><b>Izabranu anketu jos uvek niste popunili.</b></center></label>";
									} else {
										$_SESSION['imeankete'] = $_POST['imeankete'];
										header("Location: prikazrezultataankete.php");
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


<?php	

	include_once('inc/DB.inc.php');

	$upit2 = "SELECT DISTINCT a.ime_ankete, a.datum_pocetka, a.datum_zavrsetka, a.tip_ankete FROM ankete a, anketa_konacni_odgovori o WHERE a.ime_ankete = o.ime_ankete AND o.kime_ispitanika ='".$_SESSION['kime']."' ORDER BY datum_pocetka DESC, datum_zavrsetka DESC";
	$rezultat2 = mysqli_query($konekcija, $upit2)
		or die("Greska u upitu2: ".mysqli_errno($konekcija));

	echo "<br><table style='position:relative; right:69px; background-color:white; color:black;' border='10px' cellpadding='5px' align='center'> <tr> <th>R.br.</th> <th>Ime ankete</th> <th>Datum pocetka</th> <th>Datum zavrsetka</th> <th>Tip ankete</th><tr>";
	$brojac = 1;
	while($niz = mysqli_fetch_array($rezultat2)){
		echo "<tr> <td align='center'>".$brojac++."</td>";
		echo "<td align='center'>".$niz['ime_ankete']."</td>";
		echo "<td align='center'>".$niz['datum_pocetka']."</td>";
		echo "<td align='center'>".$niz['datum_zavrsetka']."</td>";
		echo "<td align='center'>".$niz['tip_ankete']."</td></tr>";
	}
	echo "</table><br><br>";
?>