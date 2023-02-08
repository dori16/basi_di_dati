<html lang="it">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="initial-scale=1.0, width=device-width" />
		<link rel="stylesheet" href="home.css"/>
		<link rel="icon" href="img/favicon.ico" />   <!-- inserire favicon qui -->
		<link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Lexend+Deca&display=swap" rel="stylesheet"> <!-- font google -->


		<title>IKM - LOGIN</title>
	</head>

<body>

<header>  <div class="title"><h1>IKM</h1></div> </header>
	


<form action="action.php" method="post">            
    <div class = "login-box">
        <h1>LOGIN</h1>
        <div class = "textbox">
            <input type = "text" placeholder="E-mail" name = "email" value ="">
        </div>

        <div class = "textbox">
            <input type = "password" placeholder="Password" name = "pass" value ="">
        </div>

        <input class = "button" type = "submit" name = "submit" value = "Login">
    </div>

    <div id="tornaHome">
        <a href = "index.php" class='buttonhome'>Torna alla home</a>
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