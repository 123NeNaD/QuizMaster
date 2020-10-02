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

		<div id="Container10">
				
					<div style="width:20%; height:200px; background-color:#efceff; float:left;">
						<a href="autor.php">Nazad</a>
					</div>
					
					<div style="width:48%; height:200px; background-color:#efceff; float:left; text-align:center;">
						<center><h3 style="position:relative; left:0px;"> <?php echo "<br>Ulogovani ste kao: $x";?> </h3></center>
						<center><a href="logout.php" style="position:relative; left:0px;"><img src="logout.png"></a><center> <hr style="position:relative; left:0px; width:80%">
					</div>
					
					<div style="width:32%; height:200px; background-color:#efceff; float:left; text-align:center;">
						<form name="mojaforma10" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
							<fieldset>
							<br><label>Ime testa:</label> <input type="text" name="imetesta" id="IMETESTA" placeholder="Unesite ime testa" value="<?php if(isset($_POST['imetesta'])) echo $_POST['imetesta'];?>"><br><hr style="width:75%;"> 
							<label style="position:relative; left:4px;">Datum pocetka:</label><input type="date" name="datumpocetka" style="position:relative; left:10px;" value="<?php if(isset($_POST['datumpocetka'])) echo $_POST['datumpocetka'];?>">
							<br><label style="position:relative; top:4px; right:0px;">Datum zavrsetka:</label><input type="date" style="position:relative; left:5px; top:4px;" name="datumzavrsetka" value="<?php if(isset($_POST['datumzavrsetka'])) echo $_POST['datumzavrsetka'];?>">
							<br><label style="position:relative; top:8px; left:0px;">Vreme trajanja:</label><input type="text" style="position:relative; left:5px; top:8px;" name="vremetrajanja" placeholder="Unesite vreme trajanja" value="<?php if(isset($_POST['vremetrajanja'])) echo $_POST['vremetrajanja'];?>">
							<br><input type="submit" name="potvrdi"style="background-color:#34056d; color:white; cursor:pointer; position:relative; top:15px;" value="NAPRAVI"><br><br>
							
							<?php

								include_once('inc/DB.inc.php');
								
								if(isset($_POST['imetesta']) AND isset($_POST['datumpocetka']) AND isset($_POST['datumzavrsetka']) AND isset($_POST['vremetrajanja'])){
									
									if($_POST['imetesta'] != "" AND $_POST['vremetrajanja'] != ""){
										
										$upit1 = "SELECT * FROM testovi WHERE ime_testa = '".$_POST['imetesta']."'";
										$rezultat1 = mysqli_query($konekcija, $upit1) or die("Greska: " . mysqli_error($konekcija));
										
										if(mysqli_num_rows($rezultat1) > 0){
											echo "<label style='color:red;'><center><b>Test sa unetim imenom vec postoji. Izaberite novo ime.</b></center></label>";
										}
										
										if(mysqli_num_rows($rezultat1) == 0){
											if ((preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $_POST['datumpocetka'])) AND (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $_POST['datumzavrsetka']))){
												$imetesta = $_POST['imetesta'];
												$datumpocetka = $_POST['datumpocetka'];
												$datumzavrsetka = $_POST['datumzavrsetka'];
												$vremetrajanja = $_POST['vremetrajanja'];
												$autor = $_SESSION['kime'];
												
												$upit2 = "INSERT INTO testovi(autor_testa, ime_testa, datum_pocetka, datum_zavrsetka, trajanje_min) VALUES('".$autor."','".$imetesta."','".$datumpocetka."','".$datumzavrsetka."','".$vremetrajanja."')";
												$rezultat2 = mysqli_query($konekcija, $upit2) or die(mysqli_errno($konekcija));
												if($rezultat2) {
													echo "<label style='position:relative; right:0px; color:green'><center><b>Test uspesno unet u bazu testova.</b></center></label>";
												} else {
													echo "Greska: ".$upit2." tip gr:".mysqli_error($konekcija);
												}
											} else {
												echo "<label style='color:red;'><center><b>Neispravan unos datuma! Datum mora biti u formatu GGGG-MM-DD.</b></center></label>";
											}
										}
									} else {
										echo "<label style='color:red;'><center><b>Unesite prvo sve podatke.</b></center></label>";
									}
								} 

							?>
							
							</fieldset>
						</form>
					</div>
					
		</div>
		
	</body>
	
</html>

	
	
<?php	

	include_once('inc/DB.inc.php');

	$upit3 = "SELECT * FROM testovi WHERE autor_testa = '".$_SESSION['kime']."'";
		
	$rezultat3 = mysqli_query($konekcija, $upit3)
		or die("Greska u upitu1: ".mysqli_errno($konekcija));

	echo "<br><table style='position:relative; top:25px; right:72px; background-color:white; color:black;' border='10px' cellpadding='5px' align='center'> <tr> <th>R.br.</th> <th>Autor testa</th> <th>Ime testa</th> <th>Datum pocetka</th> <th>Datum zavrsetka</th> <th>Trajanje [min]</th></tr>";
	$brojac = 1;
	while($niz = mysqli_fetch_array($rezultat3)){
		echo "<tr> <td align='center'>".$brojac++."</td>";
		echo "<td align='center'>".$niz['autor_testa']."</td>";
		echo "<td align='center'>".$niz['ime_testa']."</td>";
		echo "<td align='center'>".$niz['datum_pocetka']."</td>";
		echo "<td align='center'>".$niz['datum_zavrsetka']."</td>";
		echo "<td align='center'>".$niz['trajanje_min']."</td></tr>";
	}
	echo "</table>";
?>



