<?php
	//effettuo la connessione al database
	include 'salvaSessione.php';
	include 'connessione.php';
	//Recupero l'utente loggato
	$seguace = $_SESSION['Email'];
	//Recupero l'id del blog che vuole seguire
	$blog = $_SESSION['Blog'];
	$tema = $_POST['temaS'];
	//Recupero idBlog per inserirlo nella tabella seguace
	$queryId = "SELECT ID_Blog FROM Blog WHERE Nome_Blog ='$blog' AND Tema = '$tema'";
	//Eseguo la query
	$exId = mysqli_query($connessione,$queryId);
	$arrID = mysqli_fetch_array($exId);
	//Memorizzo l'id blog per inserirlo nella tabella seguace
	$idBlog = $arrID[0];
	$querySeg = "INSERT INTO Seguace (Utente,Blog) VALUES ('$seguace','$idBlog')";
	$exColl = mysqli_query($connessione,$querySeg);
	//Chiudo la connessione
	mysqli_close($connessione);
?>