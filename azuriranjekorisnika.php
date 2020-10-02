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

		<div id="Container4">
				
					<div style="width:20%; height:200px; background-color:#efceff; float:left;">
						<a href="administrator.php">Nazad</a>
					</div>
					
					<div style="width:48%; height:200px; background-color:#efceff; float:left; text-align:center;">
						<center><h3 style="position:relative; left:0px;"> <?php echo "<br>Ulogovani ste kao: $x";?> </h3></center>
						<center><a href="logout.php" style="position:relative; left:0px;"><img src="logout.png"></a><center> <hr style="position:relative; left:0px; width:80%">
					</div>
					
					<div style="width:32%; height:200px; background-color:#efceff; float:left; text-align:center;">
						<form name="mojaforma4" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
							<fieldset>
							<br><label>Korisnicko ime:</label> <input type="text" name="korisnickoime" id="KORISNICKOIME" placeholder="Unesite korisnicko ime" value="<?php if(isset($_POST['korisnickoime'])) echo $_POST['korisnickoime'];?>"><br><hr style="width:75%;"> 
							<label style="position:relative; right:36px;">Promeni:</label> 
							<select name="opcije1" id="OPCIJE1" style="position:relative; left:9px;">
								<option value='1'>Ime</option>
								<option value='2'>Prezime</option>
								<option value='3'>Korisnicko ime</option>
								<option value='4'>Lozinka</option>
								<option value='5'>Datum rodjenja</option>
								<option value='6'>Mesto rodjenja</option>
								<option value='7'>JMBG</option>
								<option value='8'>Kontakt telefon</option>
								<option value='9'>E-mail</option>
								<option value='10'>Tip korisnika</option>
							</select>
							<br><label style="position:relative; top:5px; right:5px;">Nova vrednost:</label><input type="text" style="position:relative; left:5px; top:5px;" name="novavrednost" id="NOVAVREDNOST" placeholder="Unesite novu vrednost">
							<br><input type="submit" name="potvrdi"style="background-color:#34056d; color:white; cursor:pointer; position:relative; top:15px;" value="UPDATE"><br><br>
							
							<?php

								include_once('inc/DB.inc.php');
								
								if(isset($_POST['korisnickoime'])){
									
									$upit1 = "SELECT * FROM korisnici WHERE kime = '".$_POST['korisnickoime']."'";
									$rezultat1 = mysqli_query($konekcija, $upit1) or die("Greska: " . mysqli_error($konekcija));
									
									if(mysqli_num_rows($rezultat1) == 0){
										echo "<label style='color:red;'><center><b>Ne postoji korisnik sa unetim korisnickim imenom.</b></center></label>";
									}
									
									if(mysqli_num_rows($rezultat1) > 1){
										echo "<label style='color:red;'><center><b>Greska! postoji vise istih korisnika.</b></center></label>";
									}
									
									if(mysqli_num_rows($rezultat1) == 1){
										
										if(isset($_POST['opcije1'])){
											
											if($_POST['opcije1'] == 1){
												$upit2 = "UPDATE korisnici SET ime='".$_POST['novavrednost']."' WHERE kime='".$_POST['korisnickoime']."'";
												$rezultat2 = mysqli_query($konekcija, $upit2) or die("Greska: " . mysqli_error($konekcija));
												echo "<label style='color:green;'><center><b>Ime uspesno promenjeno korisniku ".$_POST['korisnickoime'].".</b></center></label>"; 
											}
											
											if($_POST['opcije1'] == 2){
												$upit3 = "UPDATE korisnici SET prezime='".$_POST['novavrednost']."' WHERE kime='".$_POST['korisnickoime']."'";
												$rezultat3 = mysqli_query($konekcija, $upit3) or die("Greska: " . mysqli_error($konekcija));
												echo "<label style='color:green;'><center><b>Prezime uspesno promenjeno korisniku ".$_POST['korisnickoime'].".</b></center></label>"; 
											}
											
											if($_POST['opcije1'] == 3){
												$upit4 = "UPDATE korisnici SET kime='".$_POST['novavrednost']."' WHERE kime='".$_POST['korisnickoime']."'";
												$rezultat4 = mysqli_query($konekcija, $upit4) or die("Greska: " . mysqli_error($konekcija));
												echo "<label style='color:green;'><center><b>Korisnicko ime uspesno promenjeno korisniku ".$_POST['korisnickoime'].".</b></center></label>"; 
											}
											
											if($_POST['opcije1'] == 4){
												$upit5 = "UPDATE korisnici SET lozinka='".$_POST['novavrednost']."' WHERE kime='".$_POST['korisnickoime']."'";
												$rezultat5 = mysqli_query($konekcija, $upit5) or die("Greska: " . mysqli_error($konekcija));
												echo "<label style='color:green;'><center><b>Lozinka uspesno promenjena korisniku ".$_POST['korisnickoime'].".</b></center></label>"; 
											}
											
											if($_POST['opcije1'] == 5){
												
												if (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $_POST['novavrednost'])) {
													$upit6 = "UPDATE korisnici SET datumrodj='".$_POST['novavrednost']."' WHERE kime='".$_POST['korisnickoime']."'";
													$rezultat6 = mysqli_query($konekcija, $upit6) or die("Greska: " . mysqli_error($konekcija));
													echo "<label style='color:green;'><center><b>Datum rodjenja uspesno promenjen korisniku ".$_POST['korisnickoime'].".</b></center></label>"; 
												} else {
													echo "<label style='color:red;'><center><b>Neispravan unos! Datum mora biti u formatu GGGG-MM-DD.</b></center></label>";
												} 
													
											}
											
											if($_POST['opcije1'] == 6){
												$upit7 = "UPDATE korisnici SET mestorodj='".$_POST['novavrednost']."' WHERE kime='".$_POST['korisnickoime']."'";
												$rezultat7 = mysqli_query($konekcija, $upit7) or die("Greska: " . mysqli_error($konekcija));
												echo "<label style='color:green;'><center><b>Mesto rodjenja uspesno promenjeno korisniku ".$_POST['korisnickoime'].".</b></center></label>"; 
											}
											
											if($_POST['opcije1'] == 7){
												$upit8 = "UPDATE korisnici SET jmbg='".$_POST['novavrednost']."' WHERE kime='".$_POST['korisnickoime']."'";
												$rezultat8 = mysqli_query($konekcija, $upit8) or die("Greska: " . mysqli_error($konekcija));
												echo "<label style='color:green;'><center><b>JMBG uspesno promenjen korisniku ".$_POST['korisnickoime'].".</b></center></label>"; 
											}
											
											if($_POST['opcije1'] == 8){
												$upit9 = "UPDATE korisnici SET telefon='".$_POST['novavrednost']."' WHERE kime='".$_POST['korisnickoime']."'";
												$rezultat9 = mysqli_query($konekcija, $upit9) or die("Greska: " . mysqli_error($konekcija));
												echo "<label style='color:green;'><center><b>Kontakt telefon uspesno promenjen korisniku ".$_POST['korisnickoime'].".</b></center></label>"; 
											}
											
											if($_POST['opcije1'] == 9){
												$upit10 = "UPDATE korisnici SET email='".$_POST['novavrednost']."' WHERE kime='".$_POST['korisnickoime']."'";
												$rezultat10 = mysqli_query($konekcija, $upit10) or die("Greska: " . mysqli_error($konekcija));
												echo "<label style='color:green;'><center><b>E-mail uspesno promenjen korisniku ".$_POST['korisnickoime'].".</b></center></label>"; 
											}
											
											if($_POST['opcije1'] == 10){
												if($_POST['novavrednost']=='administrator' OR $_POST['novavrednost']=='ispitanik' OR $_POST['novavrednost']=='autor'){
													$upit11 = "UPDATE korisnici SET tipkorisnika='".$_POST['novavrednost']."' WHERE kime='".$_POST['korisnickoime']."'";
													$rezultat11 = mysqli_query($konekcija, $upit11) or die("Greska: " . mysqli_error($konekcija));
													echo "<label style='color:green;'><center><b>Tip korisnika uspesno promenjen korisniku ".$_POST['korisnickoime'].".</b></center></label>";
												} else {
													echo "<label style='color:red;'><center><b>Neispravan unos! Tip korisnika moze biti samo administrator, ispitanik ili autor.</b></center></label>";
												}
											}
											

										} else {
											echo "<label style='color:red;'><center><b>Izaberite prvo opciju iz padajuceg menija.</b></center></label>";
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

	$upit12 = "SELECT * FROM korisnici";
		
	$rezultat12 = mysqli_query($konekcija, $upit12)
		or die("Greska u upitu1: ".mysqli_errno($konekcija));

	echo "<br><table style='position:relative; right:15px; background-color:white; color:black;' border='10px' cellpadding='5px' align='center'> <tr> <th>R.br.</th> <th>Ime</th> <th>Prezime</th> <th>Korisnicko ime</th> <th>Lozinka</th> <th>Datum rodjenja</th> <th>Mesto rodjenja</th> <th>JMBG</th> <th>Kontakt telefon</th> <th>E-mail</th> <th>Tip korisnika</th></tr>";
	$brojac = 1;
	while($niz = mysqli_fetch_array($rezultat12)){
		echo "<tr> <td align='center'>".$brojac++."</td>";
		echo "<td align='center'>".$niz['ime']."</td>";
		echo "<td align='center'>".$niz['prezime']."</td>";
		echo "<td align='center'>".$niz['kime']."</td>";
		echo "<td align='center'>".$niz['lozinka']."</td>";
		echo "<td align='center'>".$niz['datumrodj']."</td>";
		echo "<td align='center'>".$niz['mestorodj']."</td>";
		echo "<td align='center'>".$niz['jmbg']."</td>";
		echo "<td align='center'>".$niz['telefon']."</td>";
		echo "<td align='center'>".$niz['email']."</td>";
		echo "<td align='center'>".$niz['tipkorisnika']."</td></tr>";
	}
	echo "</table>";
?>



