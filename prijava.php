<html>

	<head>
		<link rel="stylesheet" type="text/css" href="Projekat_CSS.css">
		<script language="JavaScript" src="Projekat_JS.js"></script>
	</head>
	
	<body>
	
		<form name="mojaforma2" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
		<table align="left">
			
			<tr >
				<td width="57%"> <td>
				<td align="center" colspan="2"> <h1> Prijava korisnika: </h1> </td>
			</tr>
			
			<tr>
				<td width="54%"> <td>
				<td colspan="2"> <hr> </td>
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
				<td colspan="2"> <hr class="linija"> </td>
			</tr>
			
			<tr>
				<td width="54%"> <td>
				<td colspan="2" align="center"> <input type="submit" name="login" style="background-color:#34056d; color:white; cursor:pointer;" value="PRIJAVI SE"> </td>
			</tr>
			
			<tr></tr>
			<tr></tr>
			<tr></tr>
			<tr></tr>
			
			<tr>
				<td width="54%"> <td>
				<td colspan="2" align="center">
				
					<?php
						
						if(isset($_POST['kime']) and isset($_POST['lozinka'])){
							
							include_once('inc/DB.inc.php');
							
							$kime = $_POST['kime'];
							$lozinka = $_POST['lozinka'];

							$upit1 = "SELECT * FROM korisnici WHERE kime='".$kime."' AND lozinka='".$lozinka."'";
							$rezultat1 = mysqli_query($konekcija, $upit1)
								or die("Greska u upitu: ".mysqli_errno($konekcija));
								
							if(mysqli_num_rows($rezultat1)>1){
								echo ("<label style='color:red;'><center><b>Greska! Postoji vise istih korisnika.</b></center></label>");
							}
							
							if(mysqli_num_rows($rezultat1)==1){
								
								$niz = mysqli_fetch_array($rezultat1);
								
								session_start();
								$_SESSION['korisnik'] = $niz['ime']." ".$niz['prezime'] ;
								$_SESSION['kime'] = $niz['kime'];
								
								if($niz['tipkorisnika'] == "administrator"){
									header("Location: administrator.php");
								}
								if($niz['tipkorisnika'] == "ispitanik"){
									header("Location: ispitanik.php");
								}
								if($niz['tipkorisnika'] == "autor"){
									header("Location: autor.php");
								}
							} 
							
							if(mysqli_num_rows($rezultat1)==0){
								echo "<label style='color:red;'><center><b>Kredencijali nisu ispravni.</b></center></label>";
							}
						}

					?>
					
				</td>
			</tr>
			
		
		</table>
		</form>
	
	</body>

</html>