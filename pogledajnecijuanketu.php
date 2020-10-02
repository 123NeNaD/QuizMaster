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
		
		<div id="Container34">
		
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
		echo "<br><br><br><br><br><br><br><h1 style='position:relative; right:69px; color:#34056d; text-decoration:underline;'><center>Odgovori korisnika ".$_SESSION['kime_ispitanika']." na anketu: ".$_SESSION['imeankete']."</center></h1>";

		echo "<br>";
		
		//Ispis odgovora na pitanja
		$upit2 = "SELECT * FROM anketa_konacni_odgovori WHERE kime_ispitanika='".$_SESSION['kime_ispitanika']."' AND ime_ankete='".$_SESSION['imeankete']."'";
		$rezultat2 = mysqli_query($konekcija, $upit2)
			or die("Greska u upitu2: ".mysqli_errno($konekcija));
		if(mysqli_num_rows($rezultat2) == 0){
			echo "Greska! Korisnik nije popunio ovu anketu.";
		} else {
			
			echo "<br><table style='position:relative; right:0px; width='100%'; background-color:#efceff;; color:black;' border='0px' cellpadding='5px' align='center'>";
			$brojac = 1;
			while($niz2 = mysqli_fetch_array($rezultat2)){
				echo "<tr> <td align='left' width='7%' height='50px'>".$brojac.".</td>";
				echo "<td align='left' width='64%' height='50px'>".$niz2["tekst_pitanja"]."</td>";
				echo "<td width='30%' height='50px'>Odgovor: ".$niz2["odgovor"]."</td></tr>";
				echo "<tr><td colspan='3'><hr style='color:#34056d;'></td></tr>";
				$brojac++;
			}
			echo "</table>";

		}
		
	}
	
?>


<html>
	
	<form name="mojaforma35" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">

		<input type="submit" name="uradjeneankete" value="POVRATAK NA REZULTATE ANKETE" style="background-color:#34056d; position:relative; left:400px; color:white; cursor:pointer; align:center;">
		<br><br>
		
	</form>
	
</html>


<?php

	if(isset($_POST['uradjeneankete'])){

		unset($_SESSION["kime_ispitanika"]);
		header("Location: rezultatianketiranjadrugastranica.php");
		
	}

?>
