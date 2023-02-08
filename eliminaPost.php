<?php
	//Mi collego al database e recupero i valori di sessione
	include 'connessione.php';
	include 'salvaSessione.php';
	//Recupero l'id del post
	$idPost = $_SESSION['Post'];
	//Eseguo una query per cancella il post e i valori associati ad esso all'interno del database
	$query = "DELETE FROM Post WHERE ID_Post = '$idPost'";
	$exDel = mysqli_query($connessione,$query);
	//Chiudo la connessione
    mysqli_close($connessione);
?>