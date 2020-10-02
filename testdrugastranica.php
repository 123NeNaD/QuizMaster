<?php

	session_start();
	
	if(isset($_SESSION['korisnik']) AND isset($_SESSION['kime']) AND isset($_SESSION['imetesta'])){
		$x = $_SESSION['korisnik'];
		include_once('inc/DB.inc.php');
	} else {
		header("Location: index.php");
	}
	
?>


<html>

	<body>
		
		<div id="Container18">
		
			<div style="width:20%; height:100px; background-color:#efceff; float:left;">
				
				<?php
				
				if($_SESSION['tajmer'] != 0){
					echo "<a href='resavanjetesta.php'>Nazad</a><br>";
				} 
				
				?>

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

		<form name="mojaforma18" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
		
			<?php
				
				if(isset($_SESSION['imetesta'])){
					
					include_once('inc/DB.inc.php');
					echo "<br><br><br><br><br><br><br><h1 style='position:relative; right:69px; color:#34056d; text-decoration:underline;'><center>Resavate test: ".$_SESSION['imetesta']."</center></h1>";
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
			
			<?php
				
				if($_SESSION['tajmer'] == 0){
					echo "<label style='position:relative; right:69px;'><center>Test je zavrsen. Kliknite na POTVRDI ODGOVORE da bi ste videli rezultate testa.</center></label><br>";
				} else {
					echo "<label style='position:relative; right:69px;'><center>Mozete se vratiti nazad i promeniti odgovore ili potvrditi vec unete odgovore. U slucaju potvrde vasi odgovori se smatraju konacnim.</center></label><br>";
				}
				
			?>

			<center><input type="submit" name="potvrdiodgovore" value="POTVRDI ODGOVORE" style="background-color:#34056d; position:relative; right:69px; color:white; cursor:pointer; align:right;"></center>
			
		</form>
	
	</body>
	
</html>


<?php
	
	include_once('inc/DB.inc.php');
	
	if(isset($_POST['potvrdiodgovore'])){
		
		$brojpitanja = $_SESSION['brojpitanja'];
		$brojac = 1;
		
		while($brojpitanja>0){
			
			$upit1 = "INSERT INTO testodgovori (kime, ime_testa, tekst_pitanja, odgovor, broj_poena) VALUES ('".$_SESSION['kime']."','".$_SESSION['imetesta']."','".$_SESSION["pitanje$brojac"]."','".$_SESSION["odgovor$brojac"]."','".$_SESSION["poeni$brojac"]."')";
			$rezultat1 = mysqli_query($konekcija, $upit1) or die("Greska u upitu:$upit1");
			$brojac++;
			$brojpitanja--;
		}
		
		header("Location: rezultatitesta.php");
	
	}
	
?>				

