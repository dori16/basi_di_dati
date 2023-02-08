<?php
	//Connesione al database
    include 'connessione.php';
    include 'salvaSessione.php';
    //Recupero dati immessi nel form
    $nome =$_POST['aspetto'];
    //Recupero id blog
    $blog = $_SESSION['ID_Blog'];
    //Cancella le impostazione predefinite
    $queryDel = "DELETE FROM Grafica WHERE Blog = '$blog'";
    $eseguiDel = mysqli_query($connessione,$queryDel);
    //Combino i vari valori a seconda del tema scelto dall'utente

   
    //Query per inserire i dati nel database
    $queryGrafica = "INSERT INTO Grafica (Blog, Grafica) VALUES('$blog','$nome')";
    $exGraf = mysqli_query($connessione,$queryGrafica);
    //Chiudo la connessione e reindirizzo alla pagina creaBlog	
    mysqli_close($connessione);
    header("location: ./creaBlog.php");
?>