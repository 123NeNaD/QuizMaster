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

		<div id="Container28">
				
					<div style="width:20%; height:170px; background-color:#efceff; float:left;">
						<a href="autor.php">Nazad</a>
					</div>
					
					<div style="width:48%; height:170px; background-color:#efceff; float:left; text-align:center;">
						<center><h3 style="position:relative; left:8px;"> <?php echo "<br>Ulogovani ste kao: $x";?> </h3></center>
						<center><a href="logout.php" style="position:relative; left:8px;"><img src="logout.png"></a><center> <hr style="position:relative; left:8px; width:81%">
					</div>
					
					<div style="width:32%; height:170px; background-color:#efceff; float:left; text-align:center;">
						<form name="mojaforma29" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
							<br>
							<fieldset>
							<br><label style="position:relative; top:8px;">Ime ankete:</label> <input type="text" name="imeankete" placeholder="Unesite ime ankete" style="position:relative; top:8px;" value="<?php if(isset($_POST['imeankete'])) echo $_POST['imeankete'];?>"> &nbsp 
							<input type="submit" name="potvrdi" value="OBRISI" style="background-color:#34056d; color:white; cursor:pointer; position:relative; top:8px; right:7px;"> <br><br>
							
							<?php

								include_once('inc/DB.inc.php');
								
								if(isset($_POST['imeankete'])){
									
									$upit1 = "SELECT * FROM ankete WHERE ime_ankete = '".$_POST['imeankete']."'";
									$rezultat1 = mysqli_query($konekcija, $upit1) or die("Greska: " . mysqli_error($konekcija));
									
									if(mysqli_num_rows($rezultat1) == 0){
										echo "<label style='color:red;'><center><b>Ne postoji anketa koju zelite da obrisete.</b></center></label>";
									}
									
									if(mysqli_num_rows($rezultat1) > 1){
										echo "<label style='color:red;'><center><b>Greska! Postoji vise istih anketa.</b></center></label>";
									}
									
									if(mysqli_num_rows($rezultat1) == 1){

										$upit3 = "SELECT * FROM ankete WHERE ime_ankete= '".$_POST['imeankete']."' AND autor_ankete='".$_SESSION['kime']."'";
										$rezultat3 = mysqli_query($konekcija, $upit3) or die("Greska: " . mysqli_error($konekcija));
										if(mysqli_num_rows($rezultat3) == 1){
										
											$upit4 = "DELETE FROM anketapitanja WHERE ime_ankete='".$_POST['imeankete']."'";
											$rezultat4 = mysqli_query($konekcija, $upit4) or die("Greska: " . mysqli_error($konekcija));
										
											$upit5 = "DELETE FROM ankete WHERE ime_ankete='".$_POST['imeankete']."'";
											$rezultat5 = mysqli_query($konekcija, $upit5) or die("Greska: " . mysqli_error($konekcija));
											echo "<label style='color:green;'><center><b>Anketa uspesno obrisana.</b></center></label>"; 
										
										} else {
											echo "<label style='color:red;'><center><b>Izabrana anketa nije vasa! Mozete brisati samo vase ankete.</b></center></label>";
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

	$upit2 = "SELECT * FROM ankete WHERE autor_ankete = '".$_SESSION['kime']."'";
		
	$rezultat2 = mysqli_query($konekcija, $upit2)
		or die("Greska u upitu1: ".mysqli_errno($konekcija));

	echo "<br><table style='position:relative; top:25px; right:72px; background-color:white; color:black;' border='10px' cellpadding='5px' align='center'> <tr> <th>R.br.</th> <th>Autor ankete</th> <th>Ime ankete</th> <th>Datum pocetka</th> <th>Datum zavrsetka</th> <th>Tip ankete</th></tr>";
	$brojac = 1;
	while($niz = mysqli_fetch_array($rezultat2)){
		echo "<tr> <td align='center'>".$brojac++."</td>";
		echo "<td align='center'>".$niz['autor_ankete']."</td>";
		echo "<td align='center'>".$niz['ime_ankete']."</td>";
		echo "<td align='center'>".$niz['datum_pocetka']."</td>";
		echo "<td align='center'>".$niz['datum_zavrsetka']."</td>";
		echo "<td align='center'>".$niz['tip_ankete']."</td></tr>";
	}
	echo "</table>";
?>
