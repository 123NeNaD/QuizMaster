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
		
		<div id="Container12">
		
			<div style="width:20%; height:150px; background-color:#efceff; float:left;">
				<a href="autor.php">Nazad</a><br>
			</div>
			
			<div style="width:48%; height:150px; background-color:#efceff; float:left; text-align:center;">
				<center><h3> <?php echo "<br>Ulogovani ste kao: $x";?> </h3></center>
				<center><a href="logout.php"><img src="logout.png"></a><center> <hr style="width:80%">
			</div>
			
			<div style="width:32%; height:150px; background-color:#efceff; float:left;">
			</div>
			
			<div style="width:100%; height:150px; background-color:#efceff; float:left;">
					
				<form name="mojaforma12" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
				<fieldset>
					<label style="position:relative; bottom:55px;">Tekst pitanja:</label><textarea name="tekstpitanja" style="position:relative; top:30px; left:2px;" cols="30" rows="5" placeholder="Unesite tekst pitanja"><?php if(isset($_POST['tekstpitanja'])) echo $_POST['tekstpitanja'];?></textarea>
					<label style="position:relative; left:410px; bottom:81px;">Ponudjeni odgovori:</label><textarea name="ponudjeniodgovori" style="position:relative; left:412px; top:1px;" cols="30" rows="5" placeholder="Unesite sve ponudjene odgovore tako da budu u formatu: PONUDJENI ODGOVOR 1; PONUDJENI ODGOVOR 2; PONUDJENI ODGOVOR 3; itd."><?php if(isset($_POST['ponudjeniodgovori'])) echo $_POST['ponudjeniodgovori'];?></textarea>
					<label style="position:relative; right:741px; bottom:80px;">Ime ankete:</label><input type="text" name="imeankete" style="position:relative; right:739px; bottom:80px;" placeholder="Unesite ime ankete" value="<?php if(isset($_POST['imeankete'])) echo $_POST['imeankete'];?>">
					<label style="position:relative; bottom:80; right:575px;">Vrsta odgovora:</label><select name="vrstaodgovora" style="position:relative; bottom:102px; left:504px;" value="<?php if(isset($_POST['vrstaodgovora'])) echo $_POST['vrstaodgovora'];?>">
						<option value='1'>Unos broja</option>
						<option value='2'>Unos teksta</option>
						<option value='3'>Izbor jednog od dva ponudjena</option>
						<option value='4'>Izbor jednog od vise ponudjenjih</option>
						<option value='5'>Izbor vise od vise ponudjenih</option>
						<option value='6'>Komentar</option>
					</select>
					<label style="position:relative; bottom:75; left:299px;">Tip odgovora:</label><select name="tipodgovora" style="position:relative; bottom:75; left:302px;">
						<option value="Obavezan">Obavezan</option>
						<option value="Opcioni">Nije obavezan</option>
					</select>
					<label style="position:relative; bottom:47px; left:69px;">Broj ponudjenih odgovora:</label><input type="text" name="brojponudjenih" style="position:relative; bottom:47px; left:72px;" size="5" value="<?php if(isset($_POST['brojponudjenih'])) echo $_POST['brojponudjenih'];?>">
					<input type="submit" name="dodajpitanje" value="DODAJ PITANJE U ANKETU" style="background-color:#34056d; color:white; cursor:pointer; position:relative; top:3px; left:294px;">
				</fieldset>
				</form>
					
			<div>
			
		</div>
		
	</body>

</html>



<?php
					
	if(isset($_POST['imeankete']) AND isset($_POST['tekstpitanja']) AND isset($_POST['vrstaodgovora']) AND isset($_POST['tipodgovora']) AND isset($_POST['brojponudjenih'])){
		if($_POST['imeankete'] != "" AND $_POST['tekstpitanja'] != "" AND $_POST['vrstaodgovora'] != "" AND $_POST['tipodgovora'] != "" AND $_POST['brojponudjenih'] != ""){				
			
			include_once('inc/DB.inc.php');
			$imeankete = $_POST['imeankete'];
			$tekstpitanja = $_POST['tekstpitanja'];
			$vrstaodgovora = $_POST['vrstaodgovora'];
			$tipodgovora = $_POST['tipodgovora'];
			$brojponudjenih = $_POST['brojponudjenih'];
			$ponudjeniodgovori = $_POST['ponudjeniodgovori'];
										
			$upit1 = "SELECT ime_ankete FROM ankete WHERE ime_ankete='".$imeankete."'";
			$rezultat1 = mysqli_query($konekcija, $upit1) or die("Greska u upitu:$upit1");
			
			if((mysqli_num_rows($rezultat1))==0){
				echo "<label style='position:relative; right:67px; color:red;'><center><b>Izabrana anketa ne postoji. Morate je prvo napraviti.</b></center></label>";
			}
			
			if((mysqli_num_rows($rezultat1))>1){
				echo "<label style='position:relative; right:67px; color:red;'><center><b>Greska! Postoji vise istih anketa.</b></center></label>";
			}	
			
			if((mysqli_num_rows($rezultat1))==1){
				
				$upit2 = "SELECT ime_ankete FROM ankete WHERE ime_ankete='".$imeankete."' AND autor_ankete='".$_SESSION['kime']."'";
				$rezultat2 = mysqli_query($konekcija, $upit2) or die("Greska u upitu:$upit2");
				
				if((mysqli_num_rows($rezultat2))==1){
					
					$upit5 = "SELECT a.ime_ankete FROM ankete a, anketapitanja p WHERE a.ime_ankete='".$imeankete."' AND a.autor_ankete='".$_SESSION['kime']."' AND a.ime_ankete = p.ime_ankete AND p.tekst_pitanja = '".$tekstpitanja."'";
					$rezultat5 = mysqli_query($konekcija, $upit5) or die(mysqli_errno($konekcija));
					
					if((mysqli_num_rows($rezultat5))>0){
						echo "<label style='position:relative; right:67px; color:red;'><center><b>Uneto pitanje vec postoji u izabranom testu.</b></center></label>";
					} else {
						$upit4 = "INSERT INTO anketapitanja(ime_ankete, tekst_pitanja, broj_pon_odg, vrsta_odgovora, ponudjeni_odgovori) VALUES('".$imeankete."','".$tekstpitanja."','".$brojponudjenih."','".$vrstaodgovora."','".$ponudjeniodgovori."')";
						$rezultat4 = mysqli_query($konekcija, $upit4) or die(mysqli_errno($konekcija));
						
						if($rezultat4) {
							echo "<label style='position:relative; right:67px; color:green;'><center><b>Pitanje uspesno uneto u anketu: ".$imeankete."</b></center></label>";
						} else {
						echo "Greska: ".$upit4." tip gr:".mysqli_error($konekcija);
						}
					}
			
				} else {
					echo "<label style='position:relative; right:67px; color:red;'><center><b>Izabrana anketa nije vasa. Mozete dodavati pitanja samo u vase ankete.</b></center></label>";
				}
			}	
			
		} else {
			echo "<label style='position:relative; right:67px; color:red;'><center><b>Unesite prvo sve podatke.</b></center></label>";
		}
	}
?>



<?php	

	include_once('inc/DB.inc.php');

	$upit2 = "SELECT a.autor_ankete, a.ime_ankete, p.tekst_pitanja, p.id_pitanja FROM ankete a, anketapitanja p WHERE a.autor_ankete= '".$_SESSION['kime']."' AND a.ime_ankete=p.ime_ankete";
		
	$rezultat2 = mysqli_query($konekcija, $upit2)
		or die("Greska u upitu2: ".mysqli_errno($konekcija));

	echo "<br><table style='position:relative; right:0px; background-color:white; color:black;' border='10px' cellpadding='5px' align='center'> <tr> <th>R.br.</th> <th>Autor ankete</th> <th>Ime ankete</th> <th>Tekst pitanja</th> <th>Id. pitanja</th><tr>";
	$brojac = 1;
	while($niz = mysqli_fetch_array($rezultat2)){
		echo "<tr> <td align='center'>".$brojac++."</td>";
		echo "<td align='center'>".$niz['autor_ankete']."</td>";
		echo "<td align='center'>".$niz['ime_ankete']."</td>";
		echo "<td align='center'>".$niz['tekst_pitanja']."</td>";
		echo "<td align='center'>".$niz['id_pitanja']."</td></tr>";
	}
	echo "</table><br><br>";
?>
