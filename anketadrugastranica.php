<?php

	session_start();
	
	if(isset($_SESSION['korisnik']) AND isset($_SESSION['kime']) AND isset($_SESSION['imeankete'])){
		$x = $_SESSION['korisnik'];
		include_once('inc/DB.inc.php');
	} else {
		header("Location: index.php");
	}
	
?>


<html>

	<body>
		
		<div id="Container24">
		
			<div style="width:20%; height:100px; background-color:#efceff; float:left;">
				<a href="resavanjeankete.php">Nazad</a><br>
			</div>
			
			<div style="width:48%; height:100px; background-color:#efceff; float:left; text-align:center;">
				<center><h3> <?php echo "<br>Ulogovani ste kao: $x";?> </h3></center>
				<center><a href="logout.php"><img src="logout.png"></a><center> <hr style="width:80%">
			</div>
			
			<div style="width:32%; height:100px; background-color:#efceff; float:left;">
			</div>

		</div>

	</body>
	
</html>



<html>

	<body>

		<form name="mojaforma24" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
		
			<?php
				
				if(isset($_SESSION['imeankete'])){
					
					include_once('inc/DB.inc.php');
					echo "<br><br><br><br><br><br><br><h1 style='position:relative; right:69px; color:#34056d; text-decoration:underline;'><center>Popunjavate anketu: ".$_SESSION['imeankete']."</center></h1>";
					echo "<br>";
			
					$brojpitanja = $_SESSION['brojpitanja'];
					$brojac = 1; 
					$brojneodgovorenih = 0;
					
					while($brojpitanja>0){
						
						if($_SESSION["odgovor$brojac"] == "Not answered"){
							$brojneodgovorenih++;
						}
						$brojac++;
						$brojpitanja--;
					}
					
					$brojodgovorenih = $_SESSION['brojpitanja'] - $brojneodgovorenih;	
					echo "<h2 style='position:relative; right:69px; color:black;'><center>Odgovorili ste na ".$brojodgovorenih."/".$_SESSION['brojpitanja']." pitanja</center></h2>";
				}
				
			?>	
			

			<label style="position:relative; right:69px;"><center>Mozete se vratiti nazad i promeniti odgovore ili potvrditi vec unete odgovore. U slucaju potvrde vasi odgovori se smatraju konacnim.</center></label>
			<br>
			<center><input type="submit" name="potvrdiodgovore" value="POTVRDI ODGOVORE" style="background-color:#34056d; position:relative; right:69px; color:white; cursor:pointer; align:right;"></center>
			
		</form>
		
		<form name="mojaforma25" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
		
			<label style="position:relative; right:69px;"><center>Mozete i prekinuti sa radom pa nastaviti ponovo kasnije. U slucaju prekida rada vasi trenutni odgovori ce biti sacuvani.</center></label>
			<br>
			<center><input type="submit" name="prekidrada" value="PREKID RADA" style="background-color:#34056d; position:relative; right:69px; color:white; cursor:pointer; align:right;"></center>
			
		</form>
		
	</body>
	
</html>


<?php
	
	include_once('inc/DB.inc.php');
	
	if(isset($_POST['potvrdiodgovore'])){
		
		$brojpitanja = $_SESSION['brojpitanja'];
		$brojac = 1;
		
		while($brojpitanja>0){
			
			$upit1 = "INSERT INTO anketa_konacni_odgovori (kime_ispitanika, ime_ankete, tekst_pitanja, odgovor) VALUES ('".$_SESSION['kime']."','".$_SESSION['imeankete']."','".$_SESSION["pitanje$brojac"]."','".$_SESSION["odgovor$brojac"]."')";
			$rezultat1 = mysqli_query($konekcija, $upit1) or die("Greska u upitu:$upit1");
			$brojac++;
			$brojpitanja--;
		}
		
		$upit2 = "DELETE FROM anketa_odgovori WHERE kime_ispitanika='".$_SESSION['kime']."' AND ime_ankete='".$_SESSION['imeankete']."'";
		$rezultat2 = mysqli_query($konekcija, $upit2) or die("Greska u upitu2:$upit2");
		
		header("Location: rezultatiankete.php");
	
	}
	
?>


<?php
	
	include_once('inc/DB.inc.php');
	
	if(isset($_POST['prekidrada'])){
		
		$upit2 = "SELECT * FROM anketa_odgovori WHERE kime_ispitanika='".$_SESSION['kime']."' AND ime_ankete='".$_SESSION['imeankete']."'";
		$rezultat2 = mysqli_query($konekcija, $upit2) or die("Greska u upitu2: ".mysqli_errno($konekcija));
		
		if(mysqli_num_rows($rezultat2) == 0){
		
			$brojpitanja = $_SESSION['brojpitanja'];
			$brojac = 1;
			
			while($brojpitanja>0){
				
				$upit4 = "INSERT INTO anketa_odgovori (kime_ispitanika, ime_ankete, tekst_pitanja, odgovor) VALUES ('".$_SESSION['kime']."','".$_SESSION['imeankete']."','".$_SESSION["pitanje$brojac"]."','".$_SESSION["odgovor$brojac"]."')";
				$rezultat4 = mysqli_query($konekcija, $upit4) or die("Greska u upitu4: ".mysqli_errno($konekcija));
				$brojac++;
				$brojpitanja--;
			}

		} else {
			
			$brojpitanja = $_SESSION['brojpitanja'];
			$brojac = 1;
			
			while($brojpitanja>0){
				
				$upit5 = "UPDATE anketa_odgovori SET odgovor='".$_SESSION["odgovor$brojac"]."' WHERE kime_ispitanika='".$_SESSION['kime']."' AND ime_ankete='".$_SESSION["imeankete"]."' AND tekst_pitanja='".$_SESSION["pitanje$brojac"]."'";         
				$rezultat5 = mysqli_query($konekcija, $upit5) or die("Greska u upitu4: ".mysqli_errno($konekcija));
				$brojac++;
				$brojpitanja--;
			}

		}
		
		$brojpitanja = $_SESSION['brojpitanja'];
		$brojac = 1; 
	
		while($brojpitanja>0){
			
			unset($_SESSION["pitanje$brojac"]);
			unset($_SESSION["odgovor$brojac"]);
			unset($_SESSION["imeankete"]);
			unset($_SESSION["brojpitanja"]);
			unset($_SESSION["vrstaodgovora$brojac"]);
			
			$brojpitanja--;
			$brojac++;
		
		}
		
		header("Location: pregledanketa.php");
	
	}
	
?>			

