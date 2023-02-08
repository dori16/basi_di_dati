<?php
	//Connessione al database e recupero di valori di sessione
	include 'connessione.php';
	include 'salvaSessione.php';
	//Recupero l'utente loggato e il post a cui vuole levare il mi piace
	$utente = $_SESSION['Email'];
	$post = $_SESSION['Post'];
	//Elimino il mi piace e i campi relativi ad esso nel database
	$queryDisLike = "DELETE FROM MiPiace WHERE Post = '$post' AND Utente = '$utente'";
	$exLike = mysqli_query($connessione,$queryDisLike);
	//Chiudo la connessione
	mysqli_close($connessione);
?>