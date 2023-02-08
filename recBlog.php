<?php
	include 'connessione.php';
	include 'salvaSessione.php';
	if(isset($_POST)){
		//recupero l'id del blog
		$idBlog = $_POST['id'];
		$_SESSION['ID_Blog'] = $idBlog; //assegnazione 
		//Query per recuperare il nome del blog
		$queryNom = "SELECT Nome_Blog FROM Blog WHERE ID_Blog = '$idBlog'";
		$exNome = mysqli_query($connessione,$queryNom);
		$arrNom = mysqli_fetch_array($exNome);
		$blog = $arrNom[0];
		//memorizzo in sessione il nome del blog
		$_SESSION['Blog'] = $blog;
		$queryNome = "SELECT Tema FROM Blog WHERE ID_Blog = '$idBlog'";
		$exNomee = mysqli_query($connessione,$queryNome);
		$arrNome = mysqli_fetch_array($exNomee);
		$tema = $arrNome[0];
		//memorizzo in sessione il nome del blog
		$_SESSION['Tema'] = $tema;
	}
	//Chiudo la connessione
	mysqli_close($connessione);
?>