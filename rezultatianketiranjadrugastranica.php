<?php

	session_start();
	
	if(isset($_SESSION['korisnik']) AND isset($_SESSION['kime']) AND isset($_SESSION['imeankete']) AND isset($_SESSION['tipankete'])){
		$x = $_SESSION['korisnik'];
		include_once('inc/DB.inc.php');
	} else {
		header("Location: index.php");
	}

?>


<html>

	<head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="grafiktesta.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/d3/3.5.5/d3.min.js" charset="utf-8"></script>
	</head>

	<body>
		
		<div id="Container33">
		
			<div style="width:20%; height:100px; background-color:#efceff; float:left;">
				<a href="rezultatianketiranja.php">Nazad</a>
			</div>
			
			<div style="width:48%; height:100px; background-color:#efceff; float:left; text-align:center;">
				<center><h3> <?php echo "<br>Ulogovani ste kao: $x";?> </h3></center>
				<center><a href="logout.php"><img src="logout.png"></a><center> <hr style="width:80%">
			</div>
			
			<div style="width:32%; height:170px; background-color:#efceff; float:left; text-align:center;">
				<form name="mojaforma34" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
					<br>
					<fieldset>
					<br><label style="position:relative; top:8px;">Korisnicko ime osobe:</label> <input type="text" name="kime" placeholder="Unesite korisnicko ime osobe" size="25" style="position:relative; top:8px;" value="<?php if(isset($_POST['kime'])) echo $_POST['kime'];?>"> &nbsp 
					<input type="submit" name="rezultati" value="POGLEDAJ ANKETU" style="background-color:#34056d; color:white; cursor:pointer; position:relative; top:10px; left:70px;"> <br><br>
					
					<?php

						include_once('inc/DB.inc.php');
								
						if(isset($_POST['kime'])){
							
							$upit1 = "SELECT * FROM ankete WHERE ime_ankete = '".$_SESSION['imeankete']."'";
							$rezultat1 = mysqli_query($konekcija, $upit1) or die("Greska: " . mysqli_error($konekcija));
							
							if(mysqli_num_rows($rezultat1) == 0){
								echo "<label style='color:red;'><center><b>Izabrana anketa ne postoji.</b></center></label>";
							}
							
							if(mysqli_num_rows($rezultat1) > 1){
								echo "<label style='color:red;'><center><b>Greska! Postoji vise istih anketa.</b></center></label>";
							}
							
							if(mysqli_num_rows($rezultat1) == 1){

								$upit3 = "SELECT * FROM anketa_konacni_odgovori WHERE ime_ankete= '".$_SESSION['imeankete']."' AND kime_ispitanika='".$_POST['kime']."'";
								$rezultat3 = mysqli_query($konekcija, $upit3) or die("Greska: " . mysqli_error($konekcija));
								if(mysqli_num_rows($rezultat3) > 0){
								
									$_SESSION['kime_ispitanika'] = $_POST['kime'];
									header("Location: pogledajnecijuanketu.php");
								
								} 
								
								if(mysqli_num_rows($rezultat3) == 0){
									echo "<label style='color:red;'><center><b>Izabrana osoba nije popunila ovu anketu.</b></center></label>";
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

	if(isset($_SESSION['imeankete']) AND isset($_SESSION['tipankete'])){
		
		include_once('inc/DB.inc.php');
		
		if($_SESSION['tipankete'] == "Personalizovana"){

			$upit2 = "SELECT DISTINCT a.kime_ispitanika, k.ime, k.prezime, k.datumrodj FROM anketa_konacni_odgovori a, korisnici k WHERE k.kime = a.kime_ispitanika AND ime_ankete='".$_SESSION['imeankete']."'";
				
			$rezultat2 = mysqli_query($konekcija, $upit2)
				or die("Greska u upitu1: ".mysqli_errno($konekcija));

			echo "<table style='position:relative; top:0px; right:72px; background-color:white; color:black;' border='10px' cellpadding='5px' align='center'> <tr> <th>R.br.</th> <th>Ime ankete</th> <th>Osoba</th> <th>Datum rodjenja</th> <th>Korisnicko ime</th></tr>";
			$brojac = 1;
			while($niz = mysqli_fetch_array($rezultat2)){
				echo "<tr> <td align='center'>".$brojac++."</td>";
				echo "<td align='center'>".$_SESSION['imeankete']."</td>";
				echo "<td align='center'>".$niz['ime']." ".$niz['prezime']."</td>";
				echo "<td align='center'>".$niz['datumrodj']."</td>";
				echo "<td align='center'>".$niz['kime_ispitanika']."</td></tr>";
			}
			echo "</table><br>";
			
		}	
		
		
		if($_SESSION['tipankete'] == "Anonimna"){

			$upit2 = "SELECT DISTINCT kime_ispitanika FROM anketa_konacni_odgovori WHERE ime_ankete='".$_SESSION['imeankete']."'";
				
			$rezultat2 = mysqli_query($konekcija, $upit2)
				or die("Greska u upitu2: ".mysqli_errno($konekcija));

			echo "<table style='position:relative; top:0px; right:72px; background-color:white; color:black;' border='10px' cellpadding='5px' align='center'> <tr> <th>R.br.</th> <th>Ime ankete</th> <th>Korisnicko ime</th></tr>";
			$brojac = 1;
			while($niz = mysqli_fetch_array($rezultat2)){
				echo "<tr> <td align='center'>".$brojac++."</td>";
				echo "<td align='center'>".$_SESSION['imeankete']."</td>";
				echo "<td align='center'>".$niz['kime_ispitanika']."</td></tr>";
			}
			echo "</table><br>";
			
		}
			
			
			
			
	}
?>
