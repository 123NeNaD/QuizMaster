<?php

	include_once('inc/DB.inc.php');
	
	$kime = $_POST['kime'];
	$lozinka = $_POST['lozinka'];

	$upit1 = "SELECT * FROM korisnici WHERE kime='".$kime."' AND lozinka='".$lozinka."'";
	$rezultat1 = mysqli_query($konekcija, $upit1)
		or die("Greska u upitu: ".mysqli_errno($konekcija));
	
	if($niz = mysqli_fetch_array($rezultat1)){
		echo "Ime:".$niz['ime']."<br/>";
		echo "Prezime:".$niz['prezime']."<br/>";
		
		if($niz['tipkorisnika'] == "administrator"){
			if(mysqli_num_rows($rezultat1)==1){
				header("Location: administrator.php");
			}	
		} 
		
		if($niz['tipkorisnika'] == "ispitanik"){
			if(mysqli_num_rows($rezultat1)==1){
				header("Location: ispitanik.php");
			}	
		} 
		
		if($niz['tipkorisnika'] == "autor"){
			if(mysqli_num_rows($rezultat1)==1){
				header("Location: autor.php");
			}	
		} 
		
	} else {
		echo "Kredencijali (username/password) nisu u redu!";
	}
	
?>