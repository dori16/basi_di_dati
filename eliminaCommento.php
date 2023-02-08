<?php
	//Connessione al database e recupero valori di sessione
	include 'connessione.php';
	include 'salvaSessione.php';
	//Recupero l'id del commento 
	$idCom = $_POST["commento"];
	//Eseguo una query che cancella il commento all'interno del database
	$query = "DELETE FROM commento WHERE ID_Commento = '$idCom'";
	$exDel = mysqli_query($connessione,$query);
	//Chiudo la connessione
    mysqli_close($connessione);
?>