<?php
	include 'connessione.php';
	include 'salvaSessione.php';
	//Recupero i valori immessi nei campi di registrazione
	$nome = $_POST['fname'];
	$cognome = $_POST['lname'];
	$pass = $_POST['pass'];
	$sesso = $_POST['sesso'];
	$emailIb = $_POST['email'];
	$email = strtolower($emailIb);
	$paese = $_POST['paese'];
	$data = date('Y/m/d');
	$nascita = $_POST['nascita'];
	//Query che controlla se l'email inserita è già utilizzata
	$queryEm = "SELECT Email FROM Utente";
	$exEm = mysqli_query($connessione,$queryEm);
	//Eseguo il controllo
	while($arrEm = mysqli_fetch_array($exEm)){
		if($email == $arrEm[0]){
		echo("<script type = 'text/javascript'>alert('E-mail già utilizzata!')</script>");
        echo ("<script type='text/javascript'>window.location.href ='./registrazione.php'</script>");
    	mysqli_close($connessione);
		}
	}
	//Controllo se ci sono campi vuoti
	 if($nome==""||$cognome==""||$sesso==""||$email==""||$paese==""||$nascita ==""){
        echo("<script type = 'text/javascript'>alert('Inserisci tutti i campi!')</script>");
        echo ("<script type='text/javascript'>window.location.href ='./registrazione.php'</script>");
        mysqli_close($connessione);
    //Controllo se la password ha una lunghezza superiore agli 8 caratteri ed inferiore ai 20
    }else if(strlen($pass)<8||strlen($pass)>20||strlen($pass)==0){
    	echo("<script type = 'text/javascript'>alert('Inserire una password che rispetta gli standard!')</script>");
        echo ("<script type='text/javascript'>window.location.href ='./registrazione.php'</script>");
    	mysqli_close($connessione);
    //Controllo se l'email inserita è valida 
    } else if(!strstr($email,'@')){
    	echo("<script type = 'text/javascript'>alert('Inserire una e-mail corretta!')</script>");
        echo ("<script type='text/javascript'>window.location.href ='./registrazione.php'</script>");
    	mysqli_close($connessione);
    //Controllo sulla data inserita
    } else if($nascita>$data||strlen($nascita)>10){
    	echo("<script type = 'text/javascript'>alert('Inseririsci una data valida!')</script>");
        echo ("<script type='text/javascript'>window.location.href ='./registrazione.php'</script>");
    	mysqli_close($connessione);
    //Se i campi hanno superato tutti i controlli li inserisco all'interno del database
    } else{
    	//Query per inserire le informazioni relative agli utenti
		$query_insert = "INSERT INTO Utente (Password, Nome, Cognome, Sesso, Nascita, Paese, Email) VALUES ('$pass', '$nome', '$cognome', '$sesso', '$nascita', '$paese', '$email')";
		//Eseguo la query
		$risultato_insert = mysqli_query($connessione,$query_insert);
		//Se la query ha esito negativo stampa un errore
		if(!$risultato_insert){
			echo("Error!");
		}
		//Se la query ha esito postivo eseguo le seguenti istruzioni
		else{
			$_SESSION['Email'] = $email;
			$_SESSION['Nome'] = $nome;
			$_SESSION['login'] = "ok";
			$_SESSION['Sesso'] = $sesso;
			$_SESSION['idBlog'] = "";
			//reindirizzo alla pagina di home
			header("location: ./index.php");
		}
		//Chiudo la connessione
		mysqli_close($connessione);
	}
?>
