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
		
		<div id="Container17">
		
			<div style="width:20%; height:100px; background-color:#efceff; float:left;">
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


<?php
	
	if(isset($_SESSION['imeankete'])){
	
		include_once('inc/DB.inc.php');
		echo "<br><br><br><br><br><br><br><h1 style='position:relative; right:69px; color:#34056d; text-decoration:underline;'><center>Anekta: ".$_SESSION['imeankete']."</center></h1>";

		//Ispis odgovora na pitanja
		echo "<br><table style='position:relative; right:69px; width='100%'; background-color:#efceff;; color:black;' border='0px' cellpadding='5px' align='center'>";
		$brojpitanja = $_SESSION['brojpitanja'];
		$brojac = 1; 
	
		while($brojpitanja>0){
						
			echo "<tr> <td align='left' width='7%' height='50px'>".$brojac.".</td>";
			echo "<td align='left' width='64%' height='50px'>".$_SESSION["pitanje$brojac"]."</td>";
			echo "<td width='30%' height='50px'>Vas odgovor: ".$_SESSION["odgovor$brojac"]."</td></tr>";
			echo "<tr><td colspan='3'><hr style='color:#34056d;'></td></tr>";
			$brojac++;
			$brojpitanja--;
		
		}
		
		echo "</table>";
	
	}
	
?>		


<html>
	
	<form name="mojaforma17" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">

		<input type="submit" name="pocetna" value="POVRATAK NA POCETNU STRANU" style="background-color:#34056d; position:relative; left:400px; color:white; cursor:pointer; align:center;">
		<br><br>
		
	</form>
	
</html>


<?php

	if(isset($_POST['pocetna'])){
		
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
	
		header("Location: ispitanik.php");
		
	}

?>





