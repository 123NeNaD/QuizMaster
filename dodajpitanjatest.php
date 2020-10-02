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
		
		<div id="Container8">
		
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
					
				<form name="mojaforma8" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
				<fieldset>
					<label style="position:relative; bottom:55px;">Tekst pitanja:</label><textarea name="tekstpitanja" style="position:relative; top:30px; left:2px;" cols="30" rows="5" placeholder="Unesite tekst pitanja"><?php if(isset($_POST['tekstpitanja'])) echo $_POST['tekstpitanja'];?></textarea>
					<label style="position:relative; left:410px; bottom:81px;">Ponudjeni odgovori:</label><textarea name="ponudjeniodgovori" style="position:relative; left:412px; top:1px;" cols="30" rows="5" placeholder="Unesite sve ponudjene odgovore tako da budu u formatu: PONUDJENI ODGOVOR 1; PONUDJENI ODGOVOR 2; PONUDJENI ODGOVOR 3; itd."><?php if(isset($_POST['ponudjeniodgovori'])) echo $_POST['ponudjeniodgovori'];?></textarea>
					<label style="position:relative; right:729px; bottom:80px;">Ime testa:</label><input type="text" name="imetesta" style="position:relative; right:727px; bottom:80px;" placeholder="Unesite ime testa" value="<?php if(isset($_POST['imetesta'])) echo $_POST['imetesta'];?>">
					<label style="position:relative; bottom:80; right:562px;">Vrsta odgovora:</label><select name="vrstaodgovora" style="position:relative; bottom:102px; left:504px;" value="<?php if(isset($_POST['vrstaodgovora'])) echo $_POST['vrstaodgovora'];?>">
						<option value='1'>Unos broja</option>
						<option value='2'>Unos teksta</option>
						<option value='3'>Izbor jednog od dva ponudjena</option>
						<option value='4'>Izbor jednog od vise ponudjenjih</option>
						<option value='5'>Izbor vise od vise ponudjenih</option>
					</select>
					<label style="position:relative; bottom:73px; left:185px;">Tacan odgovor:</label><input type="text" name="tacanodgovor" style="position:relative; bottom:73px; left:187px;" placeholder="Unesite tacan odgovor" value="<?php if(isset($_POST['tacanodgovor'])) echo $_POST['tacanodgovor'];?>"> 
					<label style="position:relative; bottom:44px; right:37px;">Broj poena:</label><input type="text" name="brojpoena" style="position:relative; bottom:44px; right:35px;" size="5" value="<?php if(isset($_POST['brojpoena'])) echo $_POST['brojpoena'];?>"> 
					<label style="position:relative; bottom:52px; left:87px;">Broj tacnih odgovora:</label><input type="text" name="brojtacnih" style="position:relative; bottom:52px; left:89px;" size="5" value="<?php if(isset($_POST['brojtacnih'])) echo $_POST['brojtacnih'];?>">
					<label style="position:relative; bottom:25px; right:144px;">Broj ponudjenih odgovora:</label><input type="text" name="brojponudjenih" style="position:relative; bottom:25px; right:142px;" size="5" value="<?php if(isset($_POST['brojponudjenih'])) echo $_POST['brojponudjenih'];?>">
					<input type="submit" name="dodajpitanje" value="DODAJ PITANJE U TEST" style="background-color:#34056d; color:white; cursor:pointer; position:relative; bottom:7px; left:950px;">
				</fieldset>
				</form>
					
			<div>
			
		</div>
		
	</body>

</html>



<?php
					
	if(isset($_POST['imetesta']) AND isset($_POST['tekstpitanja']) AND isset($_POST['vrstaodgovora']) AND isset($_POST['tacanodgovor']) AND isset($_POST['brojpoena']) AND isset($_POST['brojtacnih']) AND isset($_POST['brojponudjenih'])){
		if($_POST['imetesta'] != "" AND $_POST['tekstpitanja'] != "" AND $_POST['vrstaodgovora'] != "" AND $_POST['tacanodgovor'] != "" AND $_POST['brojpoena'] != "" AND $_POST['brojtacnih'] != "" AND $_POST['brojponudjenih'] != ""){				
			include_once('inc/DB.inc.php');
			$imetesta = $_POST['imetesta'];
			$tekstpitanja = $_POST['tekstpitanja'];
			$vrstaodgovora = $_POST['vrstaodgovora'];
			$tacanodgovor = $_POST['tacanodgovor'];
			$brojpoena = $_POST['brojpoena'];
			$brojtacnih = $_POST['brojtacnih'];
			$brojponudjenih = $_POST['brojponudjenih'];
			$ponudjeniodgovori = $_POST['ponudjeniodgovori'];
										
			$upit1 = "SELECT ime_testa FROM testovi WHERE ime_testa='".$imetesta."'";
			$rezultat1 = mysqli_query($konekcija, $upit1) or die("Greska u upitu:$upit1");
			
			if((mysqli_num_rows($rezultat1))==0){
				echo "<label style='position:relative; right:67px; color:red;'><center><b>Izabrani test ne postoji. Morate ga prvo napraviti.</b></center></label>";
			}
			
			if((mysqli_num_rows($rezultat1))>1){
				echo "<label style='position:relative; right:67px; color:red;'><center><b>Greska! Postoji vise istih testova.</b></center></label>";
			}	
			
			if((mysqli_num_rows($rezultat1))==1){
				
				$upit2 = "SELECT ime_testa FROM testovi WHERE ime_testa='".$imetesta."' AND autor_testa='".$_SESSION['kime']."'";
				$rezultat2 = mysqli_query($konekcija, $upit2) or die("Greska u upitu:$upit2");
				
				if((mysqli_num_rows($rezultat2))==1){
					
					$upit5 = "SELECT t.ime_testa FROM testovi t, testpitanja p WHERE t.ime_testa='".$imetesta."' AND t.autor_testa='".$_SESSION['kime']."' AND t.ime_testa = p.ime_testa AND p.tekst_pitanja = '".$tekstpitanja."'";
					$rezultat5 = mysqli_query($konekcija, $upit5) or die(mysqli_errno($konekcija));
					
					if((mysqli_num_rows($rezultat5))>0){
						echo "<label style='position:relative; right:67px; color:red;'><center><b>Uneto pitanje vec postoji u izabranom testu.</b></center></label>";
					} else {
						$upit4 = "INSERT INTO testpitanja(ime_testa, tekst_pitanja, broj_poena, broj_pon_odg, broj_tac_odg, tacan_odgovor, vrsta_odgovora, ponudjeni_odgovori) VALUES('".$imetesta."','".$tekstpitanja."','".$brojpoena."','".$brojponudjenih."','".$brojtacnih."','".$tacanodgovor."','".$vrstaodgovora."','".$ponudjeniodgovori."')";
						$rezultat4 = mysqli_query($konekcija, $upit4) or die(mysqli_errno($konekcija));
					
						if($rezultat4) {
							echo "<label style='position:relative; right:67px; color:green;'><center><b>Pitanje uspesno uneto u test: ".$imetesta."</b></center></label>";
						} else {
						echo "Greska: ".$upit4." tip gr:".mysqli_error($konekcija);
						}
					}
					
				} else {
					echo "<label style='position:relative; right:67px; color:red;'><center><b>Izabrani test nije vas. Mozete dodavati pitanja samo u vase testove.</b></center></label>";
				}
			}	
			
		} else {
			echo "<label style='position:relative; right:67px; color:red;'><center><b>Unesite prvo sve podatke.</b></center></label>";
		}
	}
?>



<?php	

	include_once('inc/DB.inc.php');

	$upit2 = "SELECT t.autor_testa, t.ime_testa, p.tekst_pitanja, p.id_pitanja FROM testovi t, testpitanja p WHERE t.autor_testa= '".$_SESSION['kime']."' AND t.ime_testa=p.ime_testa";
		
	$rezultat2 = mysqli_query($konekcija, $upit2)
		or die("Greska u upitu2: ".mysqli_errno($konekcija));

	echo "<br><table style='position:relative; right:0px; background-color:white; color:black;' border='10px' cellpadding='5px' align='center'> <tr> <th>R.br.</th> <th>Autor testa</th> <th>Ime testa</th> <th>Tekst pitanja</th> <th>Id. pitanja</th><tr>";
	$brojac = 1;
	while($niz = mysqli_fetch_array($rezultat2)){
		echo "<tr> <td align='center'>".$brojac++."</td>";
		echo "<td align='center'>".$niz['autor_testa']."</td>";
		echo "<td align='center'>".$niz['ime_testa']."</td>";
		echo "<td align='center'>".$niz['tekst_pitanja']."</td>";
		echo "<td align='center'>".$niz['id_pitanja']."</td></tr>";
	}
	echo "</table><br><br>";
?>
