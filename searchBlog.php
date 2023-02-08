<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
		<script type="text/javascript">$(document).ready(function(){
			//Nascondo i vari id dei blog
			$('p.id').hide();
		});
		</script>
<?php
	//Effettuo la connessione al database
	include 'salvaSessione.php';
	include 'connessione.php';
	//inizializzo un array vuoto all'interno del quale andranno i risultati della select
	$result_array = array();
	if (isset($_POST['search'])) {
		//Recupero la stringa immessa in input
		$word = $_POST['search'];
		//Query per cercare tramite il nome dato
		$sqlNome = "SELECT * FROM Blog WHERE Nome_Blog LIKE '%" . $word . "%'";
		$resultN = $connessione->query($sqlNome);
		echo "<h2>Risultati della ricerca:</h2>";
		if ($resultN = $connessione->query($sqlNome)) {
			//Se la ricerca non ha prodotto risultati stampo la stringa seguente
			if ($resultN->num_rows == 0) {
				echo '<p>Nessun risultato corrispondente</p>';
			} else {
				$end_result = '';
				//Se la ricerca ha dato risultati, li immagazzino in un array associativo
 				while($rowN=mysqli_fetch_assoc($resultN)){
 					//Stampo i risultati
 					$result = $rowN['Nome_Blog'];
 					$idBlog = $rowN['ID_Blog'];
 					$temaBlog = $rowN['Tema'];
 					$bold = $word;
 					$end_result .= '<li>' . str_ireplace($word, $bold,$result) . '</li>'.$temaBlog."<p class = 'id'>".$idBlog."</p>";		
 				};
 				echo($end_result);
			}	
		}
	}
	//Se effettuo la ricerca per tema
	else if (isset($_POST['tema'])) {
		//Recupero la stringa immessa in input
		$tema = $_POST['tema'];
		//Query per cercare tramite il nome dato
		$sqlTema = "SELECT * FROM Blog WHERE Tema LIKE '%" . $tema . "%'";
		$result = $connessione->query($sqlTema);
		echo "<h2>Risultati della ricerca:</h2></br></br>";
		if ($result = $connessione->query($sqlTema)) {
			if ($result->num_rows == 0) {
				//Se la ricerca non ha prodotto risultati
				echo '<p>Nessun risultato corrispondente</p>';
			} else {
				$end_result = '';
				//immagazzino i risulati all'interno di un array associativo
 				while ($row=mysqli_fetch_assoc($result)) {
 					//Stampo i risulati
 					$resultN = $row['Nome_Blog'];
 					$idBlog = $row['ID_Blog'];
 					$bold = $tema;
 					$end_result .= '<li>' . str_ireplace($tema, $bold,$resultN) . '</li>'."<p class = 'id'>".$idBlog."</p></br>";
 				}
 				echo($end_result);
 			}
		}
	}
	//Chiudo la connessione
	mysqli_close($connessione);
?>