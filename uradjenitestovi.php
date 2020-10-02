<?php

	session_start();
	
	unset($_SESSION["imetesta"]);
	if(isset($_SESSION['korisnik'])){
		$x = $_SESSION['korisnik'];
		include_once('inc/DB.inc.php');
	} else {
		header("Location: index.php");
	}

?>


<html>

	<body>
		
		<div id="Container20">
		
			<div style="width:20%; height:100px; background-color:#efceff; float:left;">
				<a href="ispitanik.php">Nazad</a><br>
			</div>
			
			<div style="width:48%; height:100px; background-color:#efceff; float:left; text-align:center;">
				<center><h3> <?php echo "<br>Ulogovani ste kao: $x";?> </h3></center>
				<center><a href="logout.php"><img src="logout.png"></a><center> <hr style="width:80%">
			</div>
			
			<div style="width:32%; height:170px; background-color:#efceff; float:left; text-align:center;">
					
					<form name="mojaforma20" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
						
						<br>
						<fieldset>
						<br><label style="position:relative; top:8px;">Ime testa:</label> <input type="text" name="imetesta" placeholder="Unesite ime testa" style="position:relative; top:8px;" value="<?php if(isset($_POST['imetesta'])) echo $_POST['imetesta'];?>"> &nbsp 
						<input type="submit" name="potvrdi" value="POGLEDAJ TEST" style="background-color:#34056d; color:white; cursor:pointer; position:relative; top:8px; right:7px;"> <br><br>
						
						<?php

							include_once('inc/DB.inc.php');
							
							if(isset($_POST['imetesta'])){
								
								$upit4 = "SELECT * FROM testovi WHERE ime_testa = '".$_POST['imetesta']."'";
								$rezultat4 = mysqli_query($konekcija, $upit4) or die("Greska: " . mysqli_error($konekcija));
								if(mysqli_num_rows($rezultat4) == 0){
									echo "<center><b>Izabrani test ne postoji.</b></center>";
								}
								
								if(mysqli_num_rows($rezultat4) > 1){
									echo "<center><b>Greska! Postoji vise istih testova.</b></center>";
								}
								
								if(mysqli_num_rows($rezultat4) == 1){
								
									$upit3 = "SELECT * FROM test_poeni WHERE ime_testa = '".$_POST['imetesta']."' AND kime_ispitanika = '".$_SESSION['kime']."'";
									$rezultat3 = mysqli_query($konekcija, $upit3) or die("Greska: " . mysqli_error($konekcija));
									
									if(mysqli_num_rows($rezultat3) == 0){
										echo "<center><b>Izabrani test jos uvek niste radili.</b></center>";
									}
									
									if(mysqli_num_rows($rezultat3) > 1){
										echo "<center><b>Greska! Izabrani test ste radili vise puta.</b></center>";
									}
									
									if(mysqli_num_rows($rezultat3) == 1){
										$_SESSION['imetesta'] = $_POST['imetesta'];
										header("Location: prikazrezultatatesta.php");
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

	$upit2 = "SELECT t.ime_testa, t.datum_pocetka, t.datum_zavrsetka, p.broj_osvojenih_poena, p.max_poena FROM testovi t, test_poeni p WHERE t.ime_testa = p.ime_testa AND p.kime_ispitanika ='".$_SESSION['kime']."' ORDER BY datum_pocetka DESC, datum_zavrsetka DESC";
	$rezultat2 = mysqli_query($konekcija, $upit2)
		or die("Greska u upitu2: ".mysqli_errno($konekcija));

	echo "<br><table style='position:relative; right:69px; background-color:white; color:black;' border='10px' cellpadding='5px' align='center'> <tr> <th>R.br.</th> <th>Ime testa</th> <th>Datum pocetka</th> <th>Datum zavrsetka</th> <th>Osvojeno poena</th><tr>";
	$brojac = 1;
	while($niz = mysqli_fetch_array($rezultat2)){
		echo "<tr> <td align='center'>".$brojac++."</td>";
		echo "<td align='center'>".$niz['ime_testa']."</td>";
		echo "<td align='center'>".$niz['datum_pocetka']."</td>";
		echo "<td align='center'>".$niz['datum_zavrsetka']."</td>";
		echo "<td align='center'>".$niz['broj_osvojenih_poena']."/".$niz['max_poena']."</td></tr>";
	}
	echo "</table><br><br>";
?>