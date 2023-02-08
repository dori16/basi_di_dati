<!DOCTYPE html>
<html>
	<head>
		<meta charset = "utf-8">
		<link rel = "stylesheet" href = "home.css">
		<link rel="icon" href="img/favicon.ico" />
		<title>IKM - Registrazione</title>
	</head>

	<body background="img/mesh-gradient.png">
	

		<form action = "info.php" method="post">
			<div class = "reg-box">
				<h1>Iscriviti</h1>
				<div class = "regText">
					<input type = "text" placeholder="Nome" name = "fname" maxlength="20" value ="">
		

					<input type = "text" placeholder="Cognome" name = "lname" maxlength="20" value ="">
			

				
					<p>Sesso:</p>
					<label class="container"><p>M &nbsp; &nbsp; &nbsp; &nbsp;</p>  
						<input type = "radio" name = "sesso" value = "M">
						<span class="checkmark"></span>
					</label>
					<label class="container"><p>F &nbsp; &nbsp; &nbsp; &nbsp;</p> 
						<input type = "radio" name = "sesso" value = "F">
						<span class="checkmark"></span>
					</label>
				

				
					<input type = "text" placeholder="E-mail" name = "email" maxlength="40" value ="">
			

				
					<input type = "text" placeholder="Paese di residenza" name = "paese" maxlength="40" value ="">
			

				
					<input type = "text" onfocus="(this.type='date')" placeholder="Data di nascita" name = "nascita" value ="">
			

				
					<input type = "password" placeholder="Password (8-20 character)" maxlength="20" name = "pass" value ="">
</div>
				<div id="tornaHome">
				<input class = "bton"  type = "submit" name = "Sign up" value = "Sign up">
			</div>

			<div id="tornaHome">
				<a href  = "index.php" class='buttonhome'>Torna alla home</a>
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