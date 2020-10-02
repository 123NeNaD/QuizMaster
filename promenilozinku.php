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

		<div id="Container13">
				
					<div style="width:20%; height:200px; background-color:#efceff; float:left;">
						<?php
							$kime = $_SESSION['kime'];
							$upit1 = "SELECT tipkorisnika FROM korisnici WHERE kime='".$kime."'";
							$rezultat1 = mysqli_query($konekcija, $upit1) or die("Greska u upitu:$upit1");
							$niz = mysqli_fetch_array($rezultat1);
							if($niz['tipkorisnika'] == "administrator"){
								echo "<a href='administrator.php'>Nazad</a>";
							}
							if($niz['tipkorisnika'] == "autor"){
								echo "<a href='autor.php'>Nazad</a>";
							}
							if($niz['tipkorisnika'] == "ispitanik"){
								echo '<a href="ispitanik.php">Nazad</a>';
							}
						?>
					</div>
					
					<div style="width:48%; height:200px; background-color:#efceff; float:left; text-align:center;">
						<center><h3 style="position:relative; left:0px;"> <?php echo "<br>Ulogovani ste kao: $x";?> </h3></center>
						<center><a href="logout.php" style="position:relative; left:0px;"><img src="logout.png"></a><center> <hr style="position:relative; left:0px; width:80%">
					</div>
					
					<div style="width:32%; height:200px; background-color:#efceff; float:left; text-align:center;">
						<form name="mojaforma13" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
							<fieldset>
							<br><label>Trenutna lozinka:</label> <input type="text" name="trenutnalozinka" placeholder="Unesite trenutnu lozinku" value="<?php if(isset($_POST['trenutnalozinka'])) echo $_POST['trenutnalozinka'];?>"><br><hr style="width:75%;"> 
							<label style="position:relative; top:0px; left:39px;">Nova loznika:</label><input type="text" style="position:relative; left:43px; top:0px;" name="novalozinka" placeholder="Unesite novu lozinku" value="<?php if(isset($_POST['novalozinka'])) echo $_POST['novalozinka'];?>">
							<label style="position:relative; top:26px; right:162px;">Potvrda:</label><input type="text" style="position:relative; left:59px; top:5px;" name="potvrda" placeholder="Potvrdite novu lozinku" value="<?php if(isset($_POST['potvrda'])) echo $_POST['potvrda'];?>">
							<br><input type="submit" name="potvrdi" style="background-color:#34056d; color:white; cursor:pointer; position:relative; top:15px;" value="PROMENI LOZINKU"><br><br><br>
							
							<?php

								include_once('inc/DB.inc.php');
								
								if(isset($_POST['trenutnalozinka']) AND isset($_POST['novalozinka']) AND isset($_POST['potvrda'])){
									
									if($_POST['trenutnalozinka'] != "" AND $_POST['novalozinka'] != "" AND $_POST['potvrda'] != ""){
									
										$upit1 = "SELECT * FROM korisnici WHERE kime = '".$_SESSION['kime']."' AND lozinka ='".$_POST['trenutnalozinka']."'";
										$rezultat1 = mysqli_query($konekcija, $upit1) or die("Greska: " . mysqli_error($konekcija));
										
										if(mysqli_num_rows($rezultat1) == 0){
											echo "<label style='color:red'><center><b>Greska! Pogresan unos trenutne lozinke.</b></center></label>";
										}
										
										if(mysqli_num_rows($rezultat1) > 1){
											echo "<label style='color:red'><center><b>Greska! postoji vise istih korisnika.</b></center></lable>";
										}
										
										if(mysqli_num_rows($rezultat1) == 1){
											
											if (preg_match("/(^[a-z](?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{7,}$)|(^[A-Z](?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{7,}$)/", $_POST['novalozinka'])) {
											
												if($_POST['novalozinka'] == $_POST['potvrda']){
													
													$upit2 = "UPDATE korisnici SET lozinka='".$_POST['novalozinka']."' WHERE kime='".$_SESSION['kime']."'";
													$rezultat2 = mysqli_query($konekcija, $upit2) or die("Greska: " . mysqli_error($konekcija));
													if($rezultat2) {
														echo "<label style='color:green'><center><b>Lozinka uspesno promenjena.</b></center></label>";
													} else {
													echo "Greska: ".$upit2." tip gr:".mysqli_error($konekcija);
													}
								
												} else {
													echo "<label style='color:red'><center><b>Greska! Nova lozinka i potvrda nove lozinke nisu iste.</b></center></label>";
												}
												
											} else {
												echo "<label style='color:red'><center><b>Greska! Nova lozinka nije u ispravnom formatu.</b></center></label>";
											}
										
										}
										
									} else {
										echo "<label style='color:red'><center><b>Unesite prvo sve podatke.</b></center></label>";
									}
								} 

							?>
							
							</fieldset>
						</form>
					</div>
					
		</div>
		
	</body>
	
</html>



