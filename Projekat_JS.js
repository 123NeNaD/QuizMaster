function Proveri_Registracija(){
	
	ime = document.getElementById("IME").value;	
	prezime = document.getElementById("PREZIME").value;	
	kime = document.getElementById("KIME").value;	
	lozinka = document.getElementById("LOZINKA").value;
	plozinke = document.getElementById("PLOZINKE").value;		
	datumrodj = document.getElementById("DATUMRODJ").value;	
	mestorodj = document.getElementById("MESTORODJ").value;	
	JMBG = document.getElementById("JMBG").value;
	telefon = document.getElementById("TELEFON").value;
	email = document.getElementById("EMAIL").value;
	error = "";
	
	if(ime=="" || prezime=="" || kime=="" || lozinka=="" || plozinke=="" || datumrodj=="" || mestorodj=="" || JMBG=="" || telefon=="" || email=="") {
		alert("Molimo unesite sve podatke.")
    } else {
			//Provera lozinke
			test_lozinka = /(^[a-z](?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{7,}$)|(^[A-Z](?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{7,}$)/;
			if(!lozinka.match(test_lozinka)) {
				error = error + "Neispravna lozinka \n";
			} else {
				if (!(lozinka == plozinke)){
					error = error + "Neispravna potvrda lozinke \n";
				}
			}		
			
			//Provera JMBG-a
			x = datumrodj.split(/-/);
			dan = x[2];
			mesec = x[1];
			godina = x[0];
			flag = true;
			S = 7*JMBG[0] + 6*JMBG[1] + 5*JMBG[2] + 4*JMBG[3] + 3*JMBG[4] + 2*JMBG[5] + 7*JMBG[6] + 6*JMBG[7] + 5*JMBG[8] + 4*JMBG[9] + 3*JMBG[10] + 2*JMBG[11];
			m = S % 11;
			
			if (m == 0 && JMBG[12] != 0) {
				flag = false;
			}
			
			if (m == 1) {
				flag = false;
			}
			
			if (m>1 && JMBG[12]!=(11-m)) {
				flag = false;
			}
			
			if (!(JMBG[0] == dan[0] && JMBG[1] == dan[1] && JMBG[2] == mesec[0] && JMBG[3] == mesec[1] && JMBG[4] == godina[1] && JMBG[5] == godina[2] && JMBG[6] == godina[3] && flag)) {
				error = error + "Neispravan JMBG \n";
			}
			
			//Ako nema greske onda sumbmit
			if(error != ""){
				alert(error);
			} else { 
				document.forms['mojaforma1'].submit();
			}
	}
}

