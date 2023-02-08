<?php
//Credenziali che utilizzo per l'accesso al database
$nomehost = 'localhost';
$admin = 'root';
$password = '';
$database = 'ikm';

//Connessione al database server attraverso mysqli_connect
$connessione = mysqli_connect($nomehost, $admin, $password, $database);

//Caso di connessione non riuscita/fallita
if(!$connessione) {
die("Connessione fallita: ".mysqli_connect_error());
}

//Selezione del database
mysqli_select_db($connessione, $database)
or die ("Impossibile connettersi al database $database");
?>