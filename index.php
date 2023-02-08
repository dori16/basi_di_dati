<?php
	//Includo salvaSessione che consente di gestire le sessioni all'interno delle pagine
	include 'salvaSessione.php';
?>


<html lang="it">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="initial-scale=1.0, width=device-width" />
		<link rel="stylesheet" href="home.css"/>
		<link rel="icon" href="img/favicon.ico" />   <!-- inserire favicon qui -->
		<link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Lexend+Deca&display=swap" rel="stylesheet"> <!-- font google -->
		
     
		 	
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
		<script type="text/javascript">$(document).ready(function(){
			//Nascondo i vari id del blog
			$('p.iB').hide();
			//Se clicco log-out si avvia la funzione anonima
			$('.buttonlog').click(function(){
				$.ajax({
					//Mi collego alla pagina destroy.php che distrugge la sessione
					url: 'destroy.php',
					type: 'POST',
					
				});
			});

			//Quando clicco su un blog mi porta alla pagina di gestione blog
			$('#risultatiBlog li').click(function(){
				//recupero l'id di un blog
				var $car = $(this).next();
				var $id = $car.text();
				//Eseguo una chiamata ajax che mi registra l'id del blog in sessione
				$.ajax({
					url: "recBlog.php",
					method: "POST",	
					data: "id="+$id,
					dataType: "html",
					success: function(){
						$(window.location).attr('href','./creaBlog.php');
					}
				});
				//Caso di insuccesso
				return false;
			});
			
				
		

			//Ricerca per nome di un blog
			$('#searchButton').click(function(){
				//Recupero il nome e il tema di un blog
				var searchString = $('#search').val();
				var temaString = $('#tema').val();
				if(searchString){
					//Chiamata di ajax
					$.ajax({
						type: 'POST',
						url: 'searchBlog.php',
						data: 'search='+searchString,
						data: 'tema='+temaString,
						//Prima di effettuare la chiamata mi stampa una stringa vuota
						beforeSend: function(html){
							$('#risultatiRic').html('');
							$('#searchResults').show();
							$(".word").html(searchString);
						},
						//Se la chiamata ha successo allora mi appende i risultati all'interno dell'hmtl come elementi di una lista
						success: function(html){
							$('#risultatiRic').show();
							$('#risultatiRic').append(html);
							$('#risultatiRic li').click(function(){
								//Passo le variabili relative al blog
								var $car = $(this).next();
								var $res = $car.text();
								$.ajax({
									url: "recBlog.php",
									method: "POST",	
									data: "id="+$res,
									dataType: "html",
									success: function(){
										$(window.location).attr('href','./creaBlog.php');
									}
								});
							});
						}
					});
				}
				//Caso di insuccesso
				return false;
			});

		});
	
	
		</script>



		<title>IKM - HOME</title>
		
		<div class="benvenuto">
			<?php
				//Includo la pagina connessione.php che connette la pagina al db
				include 'connessione.php';
				
				//Se l'utente è loggato allora gli appare la scritta Benvenuto utente
				if (isset($_SESSION['login'])){
					$Sesso = $_SESSION['Sesso'];
					if($Sesso == 'M'){
						echo ("<h1>Benvenuto " .$_SESSION['Nome'] ."!</h1>");
					} else {
						echo ("<h1>Benvenuta " .$_SESSION['Nome'] ."!</h1>");
					}
					echo("<a href = 'index.php' class='buttonlog'>Logout</a>");
					//Chiudo la connessione
					mysqli_close($connessione);
				//Se non è loggato compare benvenuto ospite e il pulsante accedi o iscriviti
				}else{
					$_SESSION['Nome'] = "Ospite";
					//$_SESSION['email'] = "";
					echo("<h1>Benvenuto ospite :)</h1>");
					echo("<a href = 'registrazione.php' class='buttonlog'>Iscriviti</a>");
					echo("<p>oppure</p>");
					echo("<a href = 'login.php' class='buttonlog'>Accedi</a>");
				}
			?>
		</div>
	</head>

<body>
<header>  <div class="title"><h1>IKM</h1> </div> </header>



<div id="container">

	<div class="div">

		<div class="colonna1">
		<form action = "recBlog.php" method = "GET" >

			<?php
						include 'connessione.php';
						
						//Se l'utente non è loggato gli offro la possibilità di visitare dei blog casuali $queryBlog = "SELECT Nome_Blog, ID_Blog FROM Blog LIMIT 5";
					//Se l'utente è loggato allora gli mostro i suoi blog
					if(!isset($_SESSION['Email'])){ 
						//Sezione dove vede i blog da lui creati
						echo("<h2>Naviga all'interno di questi blog oppure registrati e creane uno</h2>");
						//Query che seleziona tutti i blog creati dall'utente loggato
				
						$query = $query = "SELECT Nome_Blog, ID_Blog FROM Blog LIMIT 5";
						//Lancio la queryID_
						$result = mysqli_query($connessione,$query);
						$contaCrBg = mysqli_num_rows($result);
						//Creo una lista in html
						echo("<ul id = risultatiBlog>");
						//Se l'utente ha creato Blog memorizzo i risultati della query in un array
						if($contaCrBg>0){
							while ($array = mysqli_fetch_array($result)) {
								//Assegno ad una variabile il primo elemento dell'aray risultante dalla query
								echo("<li>".$array[0]."</p></li>");
								echo("<p class = 'iB'>".$array[1]."</p>");
							};
								//Se non esistono blog creati lo invito ad iscriversi
								} else{
									echo("<p>Crea per primo un blog, per farlo basta iscriversi</p>");
									echo("<a href = 'registrazione.php'>Iscriviti</a>");
								}
							}
						
						
						//Se l'utente è loggato allora gli mostro i suoi blog
						if(isset($_SESSION['Email'])){ 
							//Sezione dove vede i blog da lui creati
							echo("<h1> I miei blog </h1>");
							$utente = $_SESSION['Email'];
							//Query che seleziona tutti i blog creati dall'utente loggato
	
							$query = "SELECT Nome_Blog, ID_Blog FROM Creatore, Blog WHERE Creatore.Utente = '$utente' AND Creatore.Blog = Blog.ID_Blog" ;
							//Lancio la queryID_
							$result = mysqli_query($connessione,$query);
							$contaCrBg = mysqli_num_rows($result);
							//Creo una lista in html
							echo("<ul id = risultatiBlog>");
							//Se l'utente ha creato Blog memorizzo i risultati della query in un array
							if($contaCrBg>0){
								while ($array = mysqli_fetch_array($result)) {
									//Assegno ad una variabile il primo elemento dell'aray risultante dalla query
									echo("<li>".$array[0]."</p></li>");
									echo("<p class = 'iB'>".$array[1]."</p>");
								};
							} else { //Se l'utente non ha creato alcun blog
								echo("<p>Non hai creato ancora un blog</p>");
							}
							//Query per recuperare i blog cui l'utente è collaboratore
							echo("<h2>I blog a cui collabori</h2></br></br>");
							$queryId = "SELECT Nome_Blog, ID_Blog FROM Collaboratore, Blog WHERE Collaboratore.Utente = '$utente' AND Blog.ID_Blog = Collaboratore.Blog" ;
							$exId = mysqli_query($connessione,$queryId);
							//Conto i blog a cui l'utente collabora
							$contaClBg = mysqli_num_rows($exId);
							//Se la query ha esito negativo
							if (!$exId) {
		                   		printf("Error: %s\n", mysqli_error($connessione));
		                   		exit();
							}else{
								//Se collabora ad almeno un blog gli stampo i vari blog
								if($contaClBg>0){
									while($coll = mysqli_fetch_array($exId)){
										
										echo("<li>".$coll[0]."<p class = 'temaR'></p></li>");
										echo("<p class = 'iB'>".$coll[1]."</p>");
									};
								} else { //Se non collabora ad alcun blog gli stampo la seguente stringa
									echo("<p>Non collabori a nessun blog</p>");
								}
							}
						};
						

									if(isset($_SESSION['Email'])){ 
										$utente = $_SESSION['Email'];
										echo("</br><h2>I blog che segui</h2></br></br>");	
										$piuseg= "SELECT  Nome_Blog, ID_Blog FROM Blog, Seguace WHERE Blog.ID_Blog = Seguace.Blog AND Seguace.Utente = '$utente'";
										$expiuseg=mysqli_query($connessione, $piuseg);
										$contaClseg = mysqli_num_rows($expiuseg);
										if (!$expiuseg) {
											printf("Error: %s\n", mysqli_error($connessione));
											exit();
									 
										}
									   
										else{
										   
										 
										 if($contaClseg>0){
											 while($colo = mysqli_fetch_array($expiuseg)){
												 
												 echo("<li>".$colo[0]."<p class = 'piuseg'></p></li>");
												 echo("<p class = 'iB'>".$colo[1]."</p>");
												 
											 }
											}	}
										   };
						
				?>			
		
			</form>
		</div>

		
		
		<div class="colonna3">
			<h1>Cerca un blog</h1>
		
			<div class = 'textbox'>
					<input type = "text" placeholder="Cerca per nome" maxlength = 40 id = "search" value ="">
					</div>
					<div class = 'login-box' style='width:200px;'>
	
					<p>Inserisci il tema per una ricerca più precisa</p>
					
					
					<div class = 'box'>
					<?php
					echo("<select name='TemaBlog' id='tema' value=''>");
										echo("<option value=''>Scegli un tema");
										$query="SELECT Altro FROM Temi";
										$result2=mysqli_query($connessione, $query);
										
										while ($array = mysqli_fetch_array($result2)) {
											//Assegno ad una variabile il primo elemento dell'aray risultante dalla query
											echo("<option>".$array[0]."</p></option>");
											echo("<p class = 'iB'>".$array[1]."</p>");
										};
										echo("</option>");
										echo("</select>");
							?>			
					</div>
					
					
					<input type= "button" id = 'searchButton' type = "submit" value = "Cerca">
					</div>
					<div id = "risultatiRic">
						<div id = "searchResults">
							<p class = "word"></p>
						</div>
					</div>
			
		</div>


<form action = "blog.php" method = "POST" >
<div id="container">
	<div class="colonna2">
		<?php
					include 'connessione.php';
					//Se l'utente è loggato ha la possibilità di creare un blog con un nome che vuole e un tema a scelta dal menu, se non è loggato allora non vede manco il div
						if(isset($_SESSION['Email'])){		
							
									echo("<h1>Crea un blog</h1>");
										echo("<div class = 'textbox'>"); 
										echo("<input type = 'text' placeholder='Scegli un nome' name = 'NameBlog' maxlength = 40 value =''>"."<br/>");
										echo("</div>");
										echo("<div class='box'>");
										
										echo("<select name='TemaBlog' ='tema' value=''>");
										echo("<option value=''>Scegli un tema");
										$query="SELECT Altro FROM Temi";
										$result2=mysqli_query($connessione, $query);
										
										while ($array = mysqli_fetch_array($result2)) {
											//Assegno ad una variabile il primo elemento dell'aray risultante dalla query
											echo("<option>".$array[0]."</p></option>");
											echo("<p class = 'iB'>".$array[1]."</p>");
										};
										echo("</option>");
										echo("</select>");
										
										echo("<div class = 'login-box' style='width:200px;'>"); 
										echo("<input class='button' type = 'submit' name = 'submit' value = 'Crea'>");
										echo("</div>");
									
									
								}echo("<ul id = risultatiBlog>");
								if(!isset($_SESSION['Email'])){ 
									echo("</br><h2>I blog seguiti dagli utenti</h2></br></br>");	
									$piuseg= "SELECT DISTINCT Nome_Blog, ID_Blog FROM Blog, Seguace WHERE Blog.ID_Blog = Seguace.Blog ";
									$expiuseg=mysqli_query($connessione, $piuseg);
									$contaClseg = mysqli_num_rows($expiuseg);
									if (!$expiuseg) {
										printf("Error: %s\n", mysqli_error($connessione));
										exit();
								 
									}
								   
									else{
									   
									 //Se collabora ad almeno un blog gli stampo i vari blog
									 if($contaClseg>0){
										 while($colo = mysqli_fetch_array($expiuseg)){
											 
											 echo("<li>".$colo[0]."<p class = 'piuseg'></p></li>");
											 echo("<p class = 'iB'>".$colo[1]."</p>");
											 
										 }
										}	}
									   };

									   echo("</div>");
									   echo("</div>");
						//Chiudo la connessione
								mysqli_close($connessione);
							?>

		
						

	</div>

</div>
							
</form>














<footer>
            <p>Progetto realizzato per il corso di basi di dati A.A. 2021-2022 da: <br/>
            <br/> Isidoro Allegretti: <a href="mailto:i.allegretti@studenti.unipi.it">i.allegretti@studenti.unipi.it</a>
            <br/> Katerina Bigicchi: <a href="mailto:k.bigicchi@studenti.unipi.it">k.bigicchi@studenti.unipi.it</a>
             <br/>Matteo Solini:  <a href="mailto:i.allegretti@studenti.unipi.it">m.solini@studenti.unipi.it</a>
            </p>
</footer>


				
	
</body>
</html>