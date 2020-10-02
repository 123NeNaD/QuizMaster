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

		<div id="Container29">
				
					<div style="width:20%; height:170px; background-color:#efceff; float:left;">
						<a href="autor.php">Nazad</a>
					</div>
					
					<div style="width:48%; height:170px; background-color:#efceff; float:left; text-align:center;">
						<center><h3 style="position:relative; left:8px;"> <?php echo "<br>Ulogovani ste kao: $x";?> </h3></center>
						<center><a href="logout.php" style="position:relative; left:8px;"><img src="logout.png"></a><center> <hr style="position:relative; left:8px; width:81%">
					</div>
					
					<div style="width:32%; height:170px; background-color:#efceff; float:left; text-align:center;">
						<form name="mojaforma30" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
							<br>
							<fieldset>
							<br><label style="position:relative; top:8px;">Ime testa:</label> <input type="text" name="imetesta" placeholder="Unesite ime testa" style="position:relative; top:8px;" value="<?php if(isset($_POST['imetesta'])) echo $_POST['imetesta'];?>"> &nbsp 
							<input type="submit" name="rezultati" value="POGLEDAJ REZULTATE" style="background-color:#34056d; color:white; cursor:pointer; position:relative; top:10px; left:28px;"> <br><br>
							
							<?php

								include_once('inc/DB.inc.php');
								
								if(isset($_POST['rezultati'])){
									
									$upit1 = "SELECT * FROM testovi WHERE ime_testa = '".$_POST['imetesta']."'";
									$rezultat1 = mysqli_query($konekcija, $upit1) or die("Greska: " . mysqli_error($konekcija));
									
									if(mysqli_num_rows($rezultat1) == 0){
										echo "<label style='color:red;'><center><b>Izabrani test ne postoji.</b></center></label>";
									}
									
									if(mysqli_num_rows($rezultat1) > 1){
										echo "<label style='color:red;'><center><b>Greska! Postoji vise istih testova.</b></center></label>";
									}
									
									if(mysqli_num_rows($rezultat1) == 1){

										$upit3 = "SELECT * FROM testovi WHERE ime_testa= '".$_POST['imetesta']."' AND autor_testa='".$_SESSION['kime']."'";
										$rezultat3 = mysqli_query($konekcija, $upit3) or die("Greska: " . mysqli_error($konekcija));
										if(mysqli_num_rows($rezultat3) == 1){
										
											$_SESSION['imetesta'] = $_POST['imetesta'];
											header("Location: rezultatitestiranjadrugastranica.php");
										
										} else {
											echo "<label style='color:red;'><center><b>Izabrani test nije vas! Mozete pogledati rezultate samo vasih testove.</b></center></label>";
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

	$upit2 = "SELECT * FROM testovi WHERE autor_testa = '".$_SESSION['kime']."'";
		
	$rezultat2 = mysqli_query($konekcija, $upit2)
		or die("Greska u upitu1: ".mysqli_errno($konekcija));

	echo "<br><table style='position:relative; top:25px; right:72px; background-color:white; color:black;' border='10px' cellpadding='5px' align='center'> <tr> <th>R.br.</th> <th>Autor testa</th> <th>Ime testa</th> <th>Datum pocetka</th> <th>Datum zavrsetka</th> <th>Trajanje [min]</th></tr>";
	$brojac = 1;
	while($niz = mysqli_fetch_array($rezultat2)){
		echo "<tr> <td align='center'>".$brojac++."</td>";
		echo "<td align='center'>".$niz['autor_testa']."</td>";
		echo "<td align='center'>".$niz['ime_testa']."</td>";
		echo "<td align='center'>".$niz['datum_pocetka']."</td>";
		echo "<td align='center'>".$niz['datum_zavrsetka']."</td>";
		echo "<td align='center'>".$niz['trajanje_min']."</td></tr>";
	}
	echo "</table>";
?>
