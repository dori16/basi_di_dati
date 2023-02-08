<?php
	//mi collego al database
	include 'salvaSessione.php';
	include 'connessione.php';
	//inizializzo un array vuoto dove metterò i risultati della select
	$result_array = array();
	if (isset($_POST['search'])) {
		//recupero la parola immessa in input
		$word = $_POST['search'];
		//Query per cercare tramite il nome dato
		$sqlNome = "SELECT * FROM Utente WHERE Email = '$word' OR Nome = '$word' OR Cognome = '$word'";
		//eseguo la query
		$resultN = $connessione->query($sqlNome);
		echo "<h3>Risultati della ricerca:</h3></br></br>";
		if ($resultN = $connessione->query($sqlNome)) {
			//Nel caso in cui la ricerca non produca risultati stampo la seguente stringa
			if ($resultN->num_rows == 0) {
				echo '<p>Nessun risultato corrispondente</p>';
			} else {
				$end_result = '';
 				//Immagazzino i risultati all'interno di un array associativo
 				while($rowN=mysqli_fetch_assoc($resultN)){
 					//Stampo i risultati
 					$nome = $rowN['Nome']." ".$rowN['Cognome'];
 					$bold = $word;	
 					echo("<li>" . str_ireplace($word, $bold,$nome) . "</li>"."<p class = 'emailRes'>".$rowN['Email']."</p>"." "."<input type = 'button' class = 'aggiungi' value = 'Aggiungi'>");
				};	
			}
		}
	}
	//Chiudo la connessione
	$connessione->close();
?>