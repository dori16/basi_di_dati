<?php
	//connessione al database
	include 'connessione.php';
	include 'salvaSessione.php';
	if(isset($_POST)){
		$idPost = $_POST['idP'];
        //Memorizzo in sessione l'id del post
        $_SESSION['Post'] = $idPost;
	}
	//Chiudo la connessione
	mysqli_close($connessione);
?>