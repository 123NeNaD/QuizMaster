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

	<head>
		<script language="JavaScript" src="Projekat_JS.js"></script>
	</head>
	
	<body>

		<div id="Container5">
				
					<div style="width:20%; height:150px; background-color:#efceff; float:left;">
						<a href="administrator.php">Nazad</a>
					</div>
					
					<div style="width:48%; height:150px; background-color:#efceff; float:left; text-align:center;">
						<center><h3 style="position:relative; left:0px;"> <?php echo "<br>Ulogovani ste kao: $x";?> </h3></center>
						<center><a href="logout.php" style="position:relative; left:0px;"><img src="logout.png"></a><center> <hr style="position:relative; left:0px; width:80%">
					</div>
					
					<div style="width:32%; height:150px; background-color:#efceff; float:left; text-align:center;"> </div>
					
					<div style="width:100%; height:50px; background-color:#efceff; float:left; text-align:center;">
					
						<form name="mojaforma5" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
							<fieldset>
								<label style="position:relative; right:109px;">Ime:</label><input type="text" name="ime" id="IME" style="position:relative; right:80px;" placeholder="Unesite ime" size="20" maxlength="20" value="<?php if(isset($_POST['ime'])) echo $_POST['ime'];?>"> 
								<label style="position:relative; right:35px;">Prezime:</label><input type="text" name="prezime" id="PREZIME" style="position:relative; left:14px;" placeholder="Unesite prezime" size="20" maxlength="30" value="<?php if(isset($_POST['prezime'])) echo $_POST['prezime'];?>"> 
								<label style="position:relative; left:50px;">Korisnicko ime:</label><input type="text" name="kime" id="KIME" style="position:relative; left:52px;" placeholder="Unesite korisnicko ime" size="20" maxlength="25" value="<?php if(isset($_POST['kime'])) echo $_POST['kime'];?>"> 
								<label style="position:relative; left:96px;">Tip korisnika:</label><input type="text" name="tipkorisnika" id="TIPKORISNIKA" style="position:relative; left:98px;" placeholder="Unesite tip korisnika" size="20" maxlength="13" value="<?php if(isset($_POST['tipkorisnika'])) echo $_POST['tipkorisnika'];?>"> 
								<br><label style="position:relative; right:203px; top:3px;">Lozinka:</label><input type="text" name="lozinka" id="LOZINKA" style="position:relative; right:201px; top:3px;" placeholder="Unesite lozinku" size="20" maxlength="25" value="<?php if(isset($_POST['lozinka'])) echo $_POST['lozinka'];?>"> 
								<label style="position:relative; right:157px; top:3px;">Datum rodjenja:</label><input type="date" name="datumrodj" id="DATUMRODJ" style="position:relative; right:154px; top:3px;" value="<?php if(isset($_POST['datumrodj'])) echo $_POST['datumrodj'];?>"> 
								<label style="position:relative; right:96px; top:3px;">Mesto rodjenja:</label><input type="text" name="mestorodj" id="MESTORODJ" style="position:relative; right:91px; top:3px;" placeholder="Unesite mesto rodjenja" size="20" maxlength="30" value="<?php if(isset($_POST['mestorodj'])) echo $_POST['mestorodj'];?>"> 
								<br><label style="position:relative; right:159px; top:6px;">JMBG:</label><input type="text" name="jmbg" id="JMBG" style="position:relative; right:146px; top:6px;" placeholder="Unesite JMBG" size="20" maxlength="13" value="<?php if(isset($_POST['jmbg'])) echo $_POST['jmbg'];?>"> 
								<label style="position:relative; right:102px; top:6px;">Kontakt telefon:</label><input type="telefon" id="TELEFON" name="telefon" style="position:relative; right:100px; top:6px;" placeholder="Unesite kontakt telefon" size="20" maxlength="20" value="<?php if(isset($_POST['telefon'])) echo $_POST['telefon'];?>"> 
								<label style="position:relative; right:63px; top:6px;">E-mail:</label><input type="text" name="email" id="EMAIL" style="position:relative; right:7px; top:6px;" placeholder="Unesite e-mail" size="20" maxlength="30" value="<?php if(isset($_POST['email'])) echo $_POST['email'];?>"> 
								<input type="submit" name="unesi" value="DODAJ KORISNIKA" style="background-color:#34056d; color:white; cursor:pointer; position:relative; left:138px; bottom:17px;">
							</fieldset>
						</form>
					
					<div>

		</div>
		
	</body>
	
</html>



<?php
					
	if(isset($_POST['ime']) AND isset($_POST['prezime']) AND isset($_POST['kime']) AND isset($_POST['lozinka']) AND isset($_POST['datumrodj']) AND isset($_POST['mestorodj']) AND isset($_POST['jmbg']) AND isset($_POST['telefon']) AND isset($_POST['email']) AND isset($_POST['tipkorisnika'])){
		if($_POST['ime'] != "" AND $_POST['prezime'] != "" AND $_POST['kime'] != "" AND $_POST['lozinka'] != "" AND $_POST['mestorodj'] != "" AND $_POST['jmbg'] != "" AND $_POST['telefon'] != "" AND $_POST['email'] != "" AND $_POST['tipkorisnika'] != ""){				
			include_once('inc/DB.inc.php');
			$ime = $_POST['ime'];
			$prezime = $_POST['prezime'];
			$kime = $_POST['kime'];
			$lozinka = $_POST['lozinka'];
			$datumrodj = $_POST['datumrodj'];
			$mestorodj = $_POST['mestorodj'];
			$jmbg = $_POST['jmbg'];
			$telefon = $_POST['telefon'];
			$email = $_POST['email'];
			$tipkorisnika = $_POST['tipkorisnika'];
										
			$upit1 = "SELECT kime FROM nacekanju WHERE kime='".$kime."'";
			$rezultat1 = mysqli_query($konekcija, $upit1) or die("Greska u upitu:$upit1");
			$upit4 = "SELECT kime FROM korisnici WHERE kime='".$kime."'";
			$rezultat4 = mysqli_query($konekcija, $upit4) or die("Greska u upitu:$upit4");
			if((mysqli_num_rows($rezultat1) + mysqli_num_rows($rezultat4))>0){
				echo "<label style='position:relative; right:67px; color:red;'><center><b>Korisnicko ime je vec zauzeto.</b></center></label>";
			} else {
				$upit2 = "SELECT email FROM nacekanju WHERE email='".$email."'";
				$rezultat2 = mysqli_query($konekcija, $upit2) or die("Greska u upitu:$upit2");
				$upit5 = "SELECT email FROM korisnici WHERE email='".$email."'";
				$rezultat5 = mysqli_query($konekcija, $upit5) or die("Greska u upitu:$upit5");
				if((mysqli_num_rows($rezultat2) + mysqli_num_rows($rezultat5))>1){
					echo "<label style='position:relative; right:67px; color:red;'><center><b> E-mail adresa je vec zauzeta.</b></center></label>";
				} else {
					if ($tipkorisnika == "administrator" OR $tipkorisnika == "ispitanik" OR $tipkorisnika == "autor"){
						if (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $_POST['datumrodj'])) {
							$upit3 = "INSERT INTO korisnici(ime, prezime, kime, lozinka, datumrodj, mestorodj, jmbg, telefon, email, tipkorisnika) VALUES('".$ime."','".$prezime."','".$kime."','".$lozinka."','".$datumrodj."','".$mestorodj."','".$jmbg."','".$telefon."','".$email."','".$tipkorisnika."')";
							$rezultat3 = mysqli_query($konekcija, $upit3); // or die(mysqli_errno($konekcija));
							if($rezultat3) {
								echo "<label style='position:relative; right:67px; color:green;'><center><b>Korisnik uspesno unet u bazu korisnika.</b></center></label>";
							} else {
								echo "Greska: ".$upit3." tip gr:".mysqli_error($konekcija);
							}
						} else {
								echo "<label style='position:relative; right:67px; color:red;'><center><b>Neispravan unos datuma! Datum mora biti u formatu GGGG-MM-DD.</b></center></label>";
						}
					} else {
						echo "<label style='position:relative; right:67px; color:red;'><center><b>Neispravan unos tipa korisnika! Tip korisnika moze biti samo administrator, ispitanik ili autor.</b></center></label>";
					}
				}
			}
		} else {
			echo "<label style='position:relative; right:67px; color:red;'><center><b>Unesite prvo sve podatke.</b></center></label>";
		}
	} 
?>
	
	
	
<?php	

	include_once('inc/DB.inc.php');

	$upit12 = "SELECT * FROM korisnici";
		
	$rezultat12 = mysqli_query($konekcija, $upit12)
		or die("Greska u upitu1: ".mysqli_errno($konekcija));

	echo "<br><table style='position:relative; right:0px; background-color:white; color:black;' border='10px' cellpadding='5px' align='center'> <tr> <th>R.br.</th> <th>Ime</th> <th>Prezime</th> <th>Korisnicko ime</th> <th>Lozinka</th> <th>Datum rodjenja</th> <th>Mesto rodjenja</th> <th>JMBG</th> <th>Kontakt telefon</th> <th>E-mail</th> <th>Tip korisnika</th></tr>";
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
	echo "</table><br>";
?>



