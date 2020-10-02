<?php

	session_start();
    session_unset();
    session_destroy();

?>


<html>

	<head>
		<link rel="stylesheet" type="text/css" href="Projekat_CSS.css">
		<script language="JavaScript" src="Projekat_JS.js"></script>
		<script src="https://www.google.com/recaptcha/api.js" async defer></script>


	</head>
	
	<body>
	
		<form name="mojaforma1" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
		<table align="left">
			
			<tr >
				<td width="54%"> <td>
				<td align="center" colspan="2"> <h1> Registracija korisnika: </h1> </td>
			</tr>
			
			<tr>
			    <td width="54%"> <td>
				<td colspan="2"> <hr> </td>
			</tr>
		
			<tr>
				<td width="54%"> <td>
				<td>Ime:</td>
				<td> <input type="text" name="ime" id="IME" placeholder="Unesite vase ime" size="25" maxlength="20" value="<?php if(isset($_POST['ime'])) echo $_POST['ime'];?>"></td>
			</tr>
			
			<tr>
				<td width="54%"> <td>
				<td>Prezime:</td>
				<td> <input type="text" name="prezime" id="PREZIME" placeholder="Unesite vase prezime" size="25" maxlength="30" value="<?php if(isset($_POST['prezime'])) echo $_POST['prezime'];?>"></td>
			</tr>
			
			<tr>
				<td width="54%"> <td>
				<td>Korisnicko ime:</td>
				<td> <input type="text" name="kime" id="KIME" placeholder="Unesite korisnicko ime" size="25" maxlength="25" value="<?php if(isset($_POST['kime'])) echo $_POST['kime'];?>"></td>
			</tr>
			
			<tr>
				<td width="54%"> <td>
				<td>Lozinka:</td>
				<td> <input type="password" name="lozinka" id="LOZINKA" placeholder="Unesite lozinku" size="25" maxlength="25" value="<?php if(isset($_POST['lozinka'])) echo $_POST['lozinka'];?>"></td>
			</tr>
			
			<tr>
				<td width="54%"> <td>
				<td>Potvrda lozinke:</td>
				<td> <input type="password" name="plozinke" id="PLOZINKE" placeholder="Potvrdite lozinku" size="25" maxlength="25" value="<?php if(isset($_POST['plozinke'])) echo $_POST['plozinke'];?>"></td>
			</tr>
			
			<tr>
				<td width="54%"> <td>
				<td>Datum rodjenja:</td>
				<td> <input type="date" name="datumrodj" id="DATUMRODJ" value="<?php if(isset($_POST['datumrodj'])) echo $_POST['datumrodj'];?>"></td>
			</tr>
			
			<tr>
				<td width="54%"> <td>
				<td>Mesto rodjenja:</td>
				<td> <input type="text" name="mestorodj" id="MESTORODJ" placeholder="Unesite mesto rodjenja" size="25" maxlength="30" value="<?php if(isset($_POST['mestorodj'])) echo $_POST['mestorodj'];?>"></td>
			</tr>
			
			<tr>
				<td width="54%"> <td>
				<td>JMBG:</td>
				<td> <input type="JMBG" name="jmbg" id="JMBG" placeholder="Unesite svoj JMBG" size="25" maxlength="13" value="<?php if(isset($_POST['jmbg'])) echo $_POST['jmbg'];?>"></td>
			</tr>

			<tr>
				<td width="54%"> <td>
				<td>Kontakt telefon:</td>
				<td> <input type="text" name="telefon" id="TELEFON" placeholder="Unesite kontakt telefon" size="25" maxlength="20" value="<?php if(isset($_POST['telefon'])) echo $_POST['telefon'];?>"></td>
			</tr>
			
			<tr>
				<td width="54%"> <td>
				<td>E-mail:</td>
				<td> <input type="text" name="email" id="EMAIL" placeholder="Unesite svoju e-mail adresu" size="25" maxlength="30" value="<?php if(isset($_POST['email'])) echo $_POST['email'];?>"></td>
			</tr>
			
			<tr>
				<td width="54%"> <td>
				<td colspan="2"> <hr class="linija"> </td>
			</tr>
			
			<tr>
				<td width="54%"> <td>
				<td colspan="2" align="center"> <input type="button" name="registracija" style="background-color:#34056d; color:white; cursor:pointer;" value="Registracija" onClick="Proveri_Registracija()"> </td>
			</tr>
			
			<tr>
				<td width="54%"> <div class="g-recaptcha" data-sitekey="6LfoKswUAAAAAIRhuWZOnfLEcFPB2l_lIDsakR5R"></div> <td>
				<td colspan="2">
				
					<?php
					
						if(isset($_POST['jmbg'])){
							
							$captcha;

							if(isset($_POST['g-recaptcha-response'])){
							  $captcha=$_POST['g-recaptcha-response'];
							}
							if(!$captcha){
							  echo "<label style='color:red;'><center><b>Please check the captcha form first.</b></center></label>";
							  exit;
							}else {
								$secretKey = "6LfoKswUAAAAAG0QQ0uLfRX01yValZ-Xa8Jf1Rya";
								$ip = $_SERVER['REMOTE_ADDR'];
								// post request to server
								$url = 'https://www.google.com/recaptcha/api/siteverify?secret=' . urlencode($secretKey) .  '&response=' . urlencode($captcha);
								$response = file_get_contents($url);
								$responseKeys = json_decode($response,true);
								// should return JSON with success as true
								if($responseKeys["success"]) {
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
									
									$upit1 = "SELECT kime FROM nacekanju WHERE kime='".$kime."'";
									$rezultat1 = mysqli_query($konekcija, $upit1) or die("Greska u upitu:$upit1");
									$upit4 = "SELECT kime FROM korisnici WHERE kime='".$kime."'";
									$rezultat4 = mysqli_query($konekcija, $upit4) or die("Greska u upitu:$upit4");
									if((mysqli_num_rows($rezultat1) + mysqli_num_rows($rezultat4))>0){
										echo "<label style='color:red;'><center><b>Korisnicko ime je vec zauzeto.</b></center></label>";
									} else {
											$upit2 = "SELECT email FROM nacekanju WHERE email='".$email."'";
											$rezultat2 = mysqli_query($konekcija, $upit2) or die("Greska u upitu:$upit2");
											$upit5 = "SELECT email FROM korisnici WHERE email='".$email."'";
											$rezultat5 = mysqli_query($konekcija, $upit5) or die("Greska u upitu:$upit5");
											if((mysqli_num_rows($rezultat2) + mysqli_num_rows($rezultat5))>1){
												echo "<label style='color:red;'><center><b>E-mail adresa je vec zauzeta.</b></center></label>";
											} else {
												$upit3 = "INSERT INTO nacekanju(ime, prezime, kime, lozinka, datumrodj, mestorodj, jmbg, telefon, email) VALUES('".$ime."','".$prezime."','".$kime."','".$lozinka."','".$datumrodj."','".$mestorodj."','".$jmbg."','".$telefon."','".$email."')";
												$rezultat3 = mysqli_query($konekcija, $upit3); // or die(mysqli_errno($konekcija));
												if($rezultat3) {
													echo "<label style='color:green;'><center><b>Your registration request has been sent.<br>Thank you!</b></center></label>";
												} else {
														echo "Greska: ".$upit3." tip gr:".mysqli_error($konekcija);
													}
											}
										}
								} else {
										echo "<label style='color:red;'><center><b>You are spammer!</b></center></label>";
									}
							}		
						}
					?>
				
				</td>
			</tr>

		</table>
		</form>
	
	</body>

</html>
