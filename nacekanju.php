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

		<div id="Container3">
				
					<div style="width:20%; height:170px; background-color:#efceff; float:left;">
						<a href="administrator.php">Nazad</a>
					</div>
					
					<div style="width:48%; height:170px; background-color:#efceff; float:left; text-align:center;">
						<center><h3 style="position:relative; left:8px;"> <?php echo "<br>Ulogovani ste kao: $x";?> </h3></center>
						<center><a href="logout.php" style="position:relative; left:8px;"><img src="logout.png"></a><center> <hr style="position:relative; left:8px; width:81%">
					</div>
					
					<div style="width:32%; height:170px; background-color:#efceff; float:left; text-align:center;">
						<form name="mojaforma3" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
							<br>
							<fieldset>
							<br><label style="position:relative; top:8px;">Korisnicko ime:</label> <input type="text" name="korisnickoime" id="KORISNICKOIME" placeholder="Unesite korisnicko ime" style="position:relative; top:8px;" value="<?php if(isset($_POST['korisnickoime'])) echo $_POST['korisnickoime'];?>"> &nbsp <input type="submit" name="potvrdi" value="POTVRDI" style="background-color:#34056d; color:white; cursor:pointer; position:relative; top:8px; right:7px;" value="PRIJAVI SE"> <br>
							<input type="radio" name="opcije" value="prihvati" style="position:relative; left:8px; top:10px"><label style="position:relative; left:8px; top:10px;">Prihvati</label>
							<input type="radio" name="opcije" value="obrisi" style="position:relative; left:8px; top:10px;"><label style="position:relative; left:8px; top:10px;">Obrisi</label> <br><br>
							
							<?php

								include_once('inc/DB.inc.php');
								
								if(isset($_POST['korisnickoime'])){
									
									$upit1 = "SELECT * FROM nacekanju WHERE kime = '".$_POST['korisnickoime']."'";
									$rezultat1 = mysqli_query($konekcija, $upit1) or die("Greska: " . mysqli_error($konekcija));
									
									if(mysqli_num_rows($rezultat1) == 0){
										echo "<label style='color:red;'><center><b>Ne postoji korisnik sa unetim korisnickim imenom.</b></center></label>";
									}
									
									if(mysqli_num_rows($rezultat1) > 1){
										echo "<label style='color:red;'><center><b>Greska! postoji vise istih korisnika.</b></center></label>";
									}
									
									if(mysqli_num_rows($rezultat1) == 1){
										
										if(isset($_POST['opcije'])){
											
											if($_POST['opcije'] == "obrisi"){
												$upitBrisanje = "DELETE FROM nacekanju WHERE kime='".$_POST['korisnickoime']."'";
												$rezBrisanja = mysqli_query($konekcija, $upitBrisanje) or die("Greska: " . mysqli_error($konekcija));
												echo "<label style='color:green;'><center><b>Korisnik uspesno obrisan.</b></center></label>"; 
											}
											
											if($_POST['opcije'] == "prihvati"){
												
												$niz = mysqli_fetch_array($rezultat1);
												
												$upitDodavanje = "INSERT INTO korisnici(ime, prezime, kime, lozinka, datumrodj, mestorodj, jmbg, telefon, email, tipkorisnika) VALUES('".$niz['ime']."','".$niz['prezime']."','".$niz['kime']."','".$niz['lozinka']."','".$niz['datumrodj']."','".$niz['mestorodj']."','".$niz['jmbg']."','".$niz['telefon']."','".$niz['email']."','ispitanik')";
												$rezDodavanja = mysqli_query($konekcija, $upitDodavanje) or die(mysqli_errno($konekcija));

												$upitBrisanje = "DELETE FROM nacekanju WHERE kime='".$_POST['korisnickoime']."'";
												$rezBrisanja = mysqli_query($konekcija, $upitBrisanje) or die("Greska: " . mysqli_error($konekcija));
												
												if($rezBrisanja){
													echo "<label style='color:green;'><center><b>Korisnik uspesno prebacen u bazu korisnika.</b></center></label>";
												} else {
													echo "Greska: ".$upitDodavanje." tip gr:".mysqli_error($konekcija);
												}
											}

										} else {
											echo "<label style='color:red;'><center><b>Izaberite prvo opciju PRIHVATI/OBRISI</b></center></label>";
										}
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

	$upit2 = "SELECT * FROM nacekanju";
		
	$rezultat2 = mysqli_query($konekcija, $upit2)
		or die("Greska u upitu1: ".mysqli_errno($konekcija));

	echo "<br><table style='position:relative; right:45px; background-color:white; color:black;' border='10px' cellpadding='5px' align='center'> <tr> <th>R.br.</th> <th>Ime</th> <th>Prezime</th> <th>Korisnicko ime</th> <th>Lozinka</th> <th>Datum rodjenja</th> <th>Mesto rodjenja</th> <th>JMBG</th> <th>Kontakt telefon</th> <th>E-mail</th> </tr>";
	$brojac = 1;
	while($niz = mysqli_fetch_array($rezultat2)){
		echo "<tr> <td align='center'>".$brojac++."</td>";
		echo "<td align='center'>".$niz['ime']."</td>";
		echo "<td align='center'>".$niz['prezime']."</td>";
		echo "<td align='center'>".$niz['kime']."</td>";
		echo "<td align='center'>".$niz['lozinka']."</td>";
		echo "<td align='center'>".$niz['datumrodj']."</td>";
		echo "<td align='center'>".$niz['mestorodj']."</td>";
		echo "<td align='center'>".$niz['jmbg']."</td>";
		echo "<td align='center'>".$niz['telefon']."</td>";
		echo "<td align='center'>".$niz['email']."</td></tr>";
	}
	echo "</table>";
?>



