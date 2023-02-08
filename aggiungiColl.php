
<?php


//Includo la pagina che mi connette al  database e la pagina che mi salva la sessione
include 'connessione.php';
include 'salvaSessione.php';

//Recupero dalla sessione l'id del blog e l'utente attualmente loggato
$utente = $_POST['ut'];
$blog = $_SESSION['ID_Blog'];
$utenteLog = $_SESSION['Email'];

//Recupero l'utente che ho inserito nel form html


$coll = "INSERT INTO Collaboratore VALUES ('$utente','$blog')";
$nocoll = mysqli_query($connessione, $coll);

error_reporting(E_ALL);
ini_set('display_errors', 1);
//Chiudo la connessione
mysqli_close($connessione);


?>

