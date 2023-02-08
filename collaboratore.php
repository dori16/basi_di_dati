<?php
//Recupero sessione e connessione al database
include 'connessione.php';
include 'salvasessione.php';
//Recupero l'utente e il blog dalla sessione
$collaboratore = $_SESSION['Email'];
$blog = $_SESSION['Blog'];
//Recupero idBlog per inserirlo nella tabella collaboratore
$queryId = "SELECT ID_Blog FROM Blog WHERE Nome_Blog ='$blog'";
$exId = mysqli_query($connessione,$queryId);
//Memorizzo i risultati all'interno dell'array
$arrID = mysqli_fetch_array($exId);
//Recupero l'id del blog per inserirlo nella tabella apposita
$idBlog = $arrID[0];
$queryColl = "INSERT INTO Collaboratore (Utente, Blog) VALUES ('$collaboratore','$idBlog')";
$exColl = mysqli_query($connessione,$queryColl);
//Chiusura della connessione
mysql_close($connessione);
?>


