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

		<div id="Container14">
				
					<div style="width:20%; height:170px; background-color:#efceff; float:left;">
						<a href="autor.php">Nazad</a>
					</div>
					
					<div style="width:48%; height:170px; background-color:#efceff; float:left; text-align:center;">
						<center><h3 style="position:relative; left:8px;"> <?php echo "<br>Ulogovani ste kao: $x";?> </h3></center>
						<center><a href="logout.php" style="position:relative; left:8px;"><img src="logout.png"></a><center> <hr style="position:relative; left:8px; width:81%">
					</div>
					
					<div style="width:32%; height:170px; background-color:#efceff; float:left; text-align:center;">
						<form name="mojaforma13" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
							<br>
							<fieldset>
							<br><label style="position:relative; top:8px;">Id. pitanja:</label> <input type="text" name="idpitanja" placeholder="Unesite Id. pitanja" style="position:relative; top:8px;" value="<?php if(isset($_POST['idpitanja'])) echo $_POST['idpitanja'];?>"> &nbsp <input type="submit" name="potvrdi" value="OBRISI" style="background-color:#34056d; color:white; cursor:pointer; position:relative; top:8px; right:7px;"> <br><br>
							
							<?php

								include_once('inc/DB.inc.php');
								
								if(isset($_POST['idpitanja'])){
									
									$upit1 = "SELECT * FROM anketapitanja WHERE id_pitanja = '".$_POST['idpitanja']."'";
									$rezultat1 = mysqli_query($konekcija, $upit1) or die("Greska: " . mysqli_error($konekcija));
									
									if(mysqli_num_rows($rezultat1) == 0){
										echo "<label style='color:red;'><center><b>Ne postoji pitanje koje zelite da obrisete.</b></center></label>";
									}
									
									if(mysqli_num_rows($rezultat1) > 1){
										echo "<label style='color:red;'><center><b>Greska! Postoji vise istih pitanja.</b></center></label>";
									}
									
									if(mysqli_num_rows($rezultat1) == 1){
										
										$upit3 = "SELECT * FROM ankete a, anketapitanja p WHERE a.autor_ankete= '".$_SESSION['kime']."' AND a.ime_ankete=p.ime_ankete AND p.id_pitanja = '".$_POST['idpitanja']."'";
										$rezultat3 = mysqli_query($konekcija, $upit3) or die("Greska: " . mysqli_error($konekcija));
										if(mysqli_num_rows($rezultat3) == 1){
											
											$upitBrisanje = "DELETE FROM anketapitanja WHERE id_pitanja='".$_POST['idpitanja']."'";
											$rezBrisanja = mysqli_query($konekcija, $upitBrisanje) or die("Greska: " . mysqli_error($konekcija));
											echo "<label style='color:green;'><center><b>Pitanje uspesno obrisano.</b></center></label>"; 
										
										} else {
											echo "<label style='color:red;'><center><b>Izabrano pitanje ne pripada vasoj anketi! Mozete brisati pitanja samo iz vasih anketa.</b></center></label>";
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

	$upit2 = "SELECT a.autor_ankete, a.ime_ankete, p.tekst_pitanja, p.id_pitanja FROM ankete a, anketapitanja p WHERE a.autor_ankete= '".$_SESSION['kime']."' AND a.ime_ankete=p.ime_ankete";
		
	$rezultat2 = mysqli_query($konekcija, $upit2)
		or die("Greska u upitu1: ".mysqli_errno($konekcija));

	echo "<br><table style='position:relative; right:0px; background-color:white; color:black;' border='10px' cellpadding='5px' align='center'> <tr> <th>R.br.</th> <th>Autor ankete</th> <th>Ime ankete</th> <th>Tekst pitanja</th> <th>Id. pitanja</th><tr>";
	$brojac = 1;
	while($niz = mysqli_fetch_array($rezultat2)){
		echo "<tr> <td align='center'>".$brojac++."</td>";
		echo "<td align='center'>".$niz['autor_ankete']."</td>";
		echo "<td align='center'>".$niz['ime_ankete']."</td>";
		echo "<td align='center'>".$niz['tekst_pitanja']."</td>";
		echo "<td align='center'>".$niz['id_pitanja']."</td></tr>";
	}
	echo "</table>";
?>



