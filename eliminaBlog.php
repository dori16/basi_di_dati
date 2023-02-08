 <?php
	include 'connessione.php';
	include 'salvaSessione.php';
	//Recuper l'id del Blog
	$idBlog = $_SESSION['ID_Blog'];
	//Cancello il blog dalla tabella blog
	$query = "DELETE FROM Blog WHERE ID_Blog = '$idBlog'";
	$exDel = mysqli_query($connessione,$query);
	//Chiudo la connessione
    mysqli_close($connessione);
?>