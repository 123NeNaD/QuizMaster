<?php

	session_start();
	
	if(isset($_SESSION['korisnik']) AND isset($_SESSION['kime']) AND isset($_SESSION['imetesta'])){
		$x = $_SESSION['korisnik'];
		include_once('inc/DB.inc.php');
	} else {
		header("Location: index.php");
	}

	//Prebrojavanje rezultata testova po opsezima
	$brojac = 1;
	$brojac1 = 0;
	$brojac2 = 0;
	$brojac3 = 0;
	$brojac4 = 0;
	$brojac5 = 0;
	$brojac6 = 0;
	$brojac7 = 0;
	$brojac8 = 0;
	$brojac9 = 0;
	$brojac10 = 0;
	$upit1 = "SELECT * FROM test_poeni WHERE ime_testa='".$_SESSION['imetesta']."'";
	$rezultat1 = $rezultat1 = mysqli_query($konekcija, $upit1) or die("Greska u upitu:$upit1");
	while($niz = mysqli_fetch_array($rezultat1)){
		
		$broj_osvojenih_poena = $niz['broj_osvojenih_poena'];
		$ukupno_poena = $niz['max_poena'];
		
		if($ukupno_poena != 0){
			
			$procenat = $broj_osvojenih_poena/$ukupno_poena*100;
		
		} else {
			$procenat = 100;
		}
	
		if($procenat >= 0 AND $procenat < 10){
			$brojac1++;
		}

		if($procenat >= 10 AND $procenat < 20){
			$brojac2++;
		}
		
		if($procenat >= 20 AND $procenat < 30){
			$brojac3++;
		}
		
		if($procenat >= 30 AND $procenat < 40){
			$brojac4++;
		}
		
		if($procenat >= 40 AND $procenat < 50){
			$brojac5++;
		}
		
		if($procenat >= 50 AND $procenat < 60){
			$brojac6++;
		}
		
		if($procenat >= 60 AND $procenat < 70){
			$brojac7++;
		}
		
		if($procenat >= 70 AND $procenat < 80){
			$brojac8++;
		}
		
		if($procenat >= 80 AND $procenat < 90){
			$brojac9++;
		}
		
		if($procenat >= 90 AND $procenat <= 100){
			$brojac10++;
		}
	
	}
	
	
	//Pravljenje CSV fajla za vizuelizaciju podataka
	$headers = array("opseg", "brojispitanika");
	
	$data = array(
		array(
			"opseg" => "0-10%",
			"brojispitanika" => "$brojac1",
		),
		array(
			"opseg" => "10-20%",
			"brojispitanika" => "$brojac2",
		),
		array(
			"opseg" => "20-30%",
			"brojispitanika" => "$brojac3",
		),
		array(
			"opseg" => "30-40%",
			"brojispitanika" => "$brojac4",
		),
		array(
			"opseg" => "40-50%",
			"brojispitanika" => "$brojac5",
		),
		array(
			"opseg" => "50-60%",
			"brojispitanika" => "$brojac6",
		),
		array(
			"opseg" => "60-70%",
			"brojispitanika" => "$brojac7",
		),
		array(
			"opseg" => "70-80%",
			"brojispitanika" => "$brojac8",
		),
		array(
			"opseg" => "80-90%",
			"brojispitanika" => "$brojac9",
		),
		array(
			"opseg" => "90-100%",
			"brojispitanika" => "$brojac10",
		),
		
	);
	
	$fh = fopen("grafiktesta.csv", "w");
	
	fputcsv($fh, $headers);
	
	foreach($data as $fields){
		fputcsv($fh, $fields);
	}
	
	fclose($fh);
	
?>


<html>

	<head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="grafiktesta.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/d3/3.5.5/d3.min.js" charset="utf-8"></script>
	</head>

	<body>
		
		<div id="Container30">
		
			<div style="width:20%; height:100px; background-color:#efceff; float:left;">
				<a href="rezultatitestiranja.php">Nazad</a>
			</div>
			
			<div style="width:48%; height:100px; background-color:#efceff; float:left; text-align:center;">
				<center><h3> <?php echo "<br>Ulogovani ste kao: $x";?> </h3></center>
				<center><a href="logout.php"><img src="logout.png"></a><center> <hr style="width:80%">
			</div>
			
			<div style="width:32%; height:170px; background-color:#efceff; float:left; text-align:center;">
				<form name="mojaforma31" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
					<br>
					<fieldset>
					<br><label style="position:relative; top:8px;">Korisnicko ime osobe:</label> <input type="text" name="kime" placeholder="Unesite korisnicko ime osobe" size="25" style="position:relative; top:8px;" value="<?php if(isset($_POST['kime'])) echo $_POST['kime'];?>"> &nbsp 
					<input type="submit" name="rezultati" value="POGLEDAJ TEST" style="background-color:#34056d; color:white; cursor:pointer; position:relative; top:10px; left:70px;"> <br><br>
					
					<?php

						include_once('inc/DB.inc.php');
								
						if(isset($_POST['kime'])){
							
							$upit1 = "SELECT * FROM testovi WHERE ime_testa = '".$_SESSION['imetesta']."'";
							$rezultat1 = mysqli_query($konekcija, $upit1) or die("Greska: " . mysqli_error($konekcija));
							
							if(mysqli_num_rows($rezultat1) == 0){
								echo "<label style='color:red;'><center><b>Izabrani test ne postoji.</b></center></label>";
							}
							
							if(mysqli_num_rows($rezultat1) > 1){
								echo "<label style='color:red;'><center><b>Greska! Postoji vise istih testova.</b></center></label>";
							}
							
							if(mysqli_num_rows($rezultat1) == 1){

								$upit3 = "SELECT * FROM test_poeni WHERE ime_testa= '".$_SESSION['imetesta']."' AND kime_ispitanika='".$_POST['kime']."'";
								$rezultat3 = mysqli_query($konekcija, $upit3) or die("Greska: " . mysqli_error($konekcija));
								if(mysqli_num_rows($rezultat3) == 1){
								
									$_SESSION['kime_ispitanika'] = $_POST['kime'];
									header("Location: pogledajnecijitest.php");
								
								} 
								
								if(mysqli_num_rows($rezultat3) == 0){
									echo "<label style='color:red;'><center><b>Izabrana osoba nije radila ovaj test.</b></center></label>";
								}

								if(mysqli_num_rows($rezultat3) > 1){
									echo "<label style='color:red;'><center><b>Greska! Izabrana osoba je ovaj test radila vise puta.</b></center></label>";
								}								
							
							} 

						}
						
					?>
					<br>
					</fieldset>
				</form>
			</div>

		</div>
		
		<br><br><br><br><br><br><br><br>
		<!-- Title -->
		<h1 style="text-align:center; color:#34056d; position:relative; right:70px;">Grafik rezultata testa: <?php echo $_SESSION['imetesta'];?></h1>
		<!-- Your D3 code for bar graph -->
		<script type="text/javascript" src="grafiktesta.js"></script>
		
	</body>
	
</html>



<?php	

	if(isset($_SESSION['imetesta'])){
		
		include_once('inc/DB.inc.php');

		$upit2 = "SELECT k.ime, k.prezime, k.datumrodj, t.broj_osvojenih_poena, t.max_poena, t.kime_ispitanika FROM test_poeni t, korisnici k WHERE k.kime = t.kime_ispitanika AND ime_testa='".$_SESSION['imetesta']."'";
			
		$rezultat2 = mysqli_query($konekcija, $upit2)
			or die("Greska u upitu1: ".mysqli_errno($konekcija));

		echo "<table style='position:relative; top:0px; right:72px; background-color:white; color:black;' border='10px' cellpadding='5px' align='center'> <tr> <th>R.br.</th> <th>Ime testa</th> <th>Osoba</th> <th>Datum rodjenja</th> <th>Korisnicko ime</th> <th>Broj poena</th></tr>";
		$brojac = 1;
		while($niz = mysqli_fetch_array($rezultat2)){
			echo "<tr> <td align='center'>".$brojac++."</td>";
			echo "<td align='center'>".$_SESSION['imetesta']."</td>";
			echo "<td align='center'>".$niz['ime']." ".$niz['prezime']."</td>";
			echo "<td align='center'>".$niz['datumrodj']."</td>";
			echo "<td align='center'>".$niz['kime_ispitanika']."</td>";
			echo "<td align='center'>".$niz['broj_osvojenih_poena']."/".$niz['max_poena']."</td></tr>";
		}
		echo "</table><br>";
	}
?>
