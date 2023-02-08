<?php
	//Mi collego al database e recupero i dati dalla sessione
	include 'connessione.php';
	include 'salvaSessione.php';
	//Se ho compilato il form
	if(isset($_POST)){
		//Recupero i valori inerenti il campo registrazione
		$email = $_POST['email'];
		$password = $_POST['pass'];
		//Controllo per vedere se sono stati inseriti i campi relativi a email e password
		if($email==""||$password==""){
			//Generazione di un alert reltivo ai campi inseriti
	        echo("<script type = 'text/javascript'>alert('Nome o password non inseriti!')</script>");
	        echo ("<script type='text/javascript'>window.location.href ='./login.php'</script>");
	        mysqli_close($connessione);
    	}else{
    		//Query per recuperare l'utente registrato che ha email e password uguali a quelle inserite
			$query = "SELECT * FROM Utente WHERE Email = '$email' AND Password = '$password' ";
			$result = mysqli_query($connessione,$query);
			$array = mysqli_fetch_array($result);
			$rowcount = mysqli_num_rows($result);

			

			//Se esiste un utente con l'email e la password inserita allora eseguo il login e memorizzo in sessione il nome e l'email
			if ($rowcount == 1) {
				echo("<script type = 'text/javascript'>alert('Login riuscito!')</script>");
				$_SESSION['Email'] = $array['Email'];
				$_SESSION['Nome'] = $array['Nome'];
				$_SESSION['Sesso'] = $array['Sesso'];
				$_SESSION['login'] = "ok";
				$_SESSION['idBlog'] = "";
				//Reindirizzo alla pagina home e chiudo la connessione
				
				header("location: ./index.php"); 
				mysqli_close($connessione);
			} else { //Se email o password non corrispondono nel database genero un alert
				echo("<script type = 'text/javascript'>alert('Utente non registrato o credenziali non valide!')</script>");
				echo ("<script type='text/javascript'>window.location.href ='./login.php'</script>");
				//Chiudo la connessione
				mysqli_close($connessione);
			}
	    }
	}
?>
