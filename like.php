<?php
	//Connessione al database
	include 'connessione.php';
	include 'salvaSessione.php';
	//Recupero dell'email dell'utente loggato e l'id del post
	$utente = $_SESSION['Email'];
	$post = $_SESSION['Post'];
	//Inserimento dei dati all'interno del database
	$queryLike = "INSERT INTO MiPiace(Post,Utente,Stato)VALUES('$post','$utente','Si')";
	$exLike = mysqli_query($connessione,$queryLike);
	//Chiusura della connessione
	mysqli_close($connessione);
?>