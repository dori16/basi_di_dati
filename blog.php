<?php
    include 'connessione.php';
    include 'salvaSessione.php';
    //Recupero i dati immessi nel form
    $nomeIb = $_POST['NameBlog'];
    //Utilizzo la funzione addslashes per l'immissione nei campi dei caratteri speciali
    $nome = addslashes($nomeIb);
    $tema = $_POST['TemaBlog'];     //recupera il tema scelto dall'utente nell'index
    $email = $_SESSION['Email'];
    //Se non ho inserito nè il nome, nè il tema allora compare un alert e si chiude la connessione
    if($nome==""||$tema==""){
        echo("<script type = 'text/javascript'>alert('Nome o tema non inserito!')</script>");
        echo ("<script type='text/javascript'>window.location.href ='./index.php'</script>");
        mysqli_close($connessione);
    }
    //Se ho inseririto correttamente i dati nel form allora li inserisco nel database
    else{
        //Controllo se esiste un blog con lo stesso nome e stesso tema
        $qControllo = "SELECT Nome_Blog,Tema FROM Blog";
        $exContr = mysqli_query($connessione,$qControllo);
        //Controllo per vedere se esiste già un tema con lo stesso nome e tema
        while($arrContr = mysqli_fetch_array($exContr)){
            //Se esiste già un blog con lo stesso nome e tema allora blocco l'utente con un alert
            if($nome == $arrContr[0]&&$tema==$arrContr[1]){
                echo("<script type = 'text/javascript'>alert('Nome e tema già in uso, scegline un altro')</script>");
                echo ("<script type='text/javascript'>window.location.href ='./index.php'</script>");
                mysqli_close($connessione);
            }
        };  
            //Query per inserire i dati nel database
            $blog_insert =  "INSERT INTO Blog (Nome_Blog,Tema) VALUES ('$nome','$tema')";
            $risultato_blog_insert = mysqli_query($connessione,$blog_insert);

           
            //Query che mi restituisce l'idBlog
            $queryId = "SELECT ID_Blog FROM Blog WHERE Nome_Blog ='$nome' AND Tema = '$tema'";
            $exId = mysqli_query($connessione,$queryId);
            $arrID = mysqli_fetch_array($exId);
            //Memorizzo l'id del blog
            $idBlog = $arrID[0];
            //Query per inserire le informazioni dentro la tabella creatore
            $creatore_insert = "INSERT INTO Creatore (Utente, Blog) VALUES ('$email','$idBlog')";
            //LE la query
            $risultato_creatore_insert = mysqli_query($connessione,$creatore_insert);
            //Se la query ha esisto negativo segnala l'errore
            if(!$risultato_creatore_insert){
                echo("Error");
            } else{ //La query ha esito positivo
                //Memorizzo in sessione l'id del blog
                $_SESSION['ID_Blog'] = $idBlog;
                
                //le prossime tre righe servono per inserire il valore "Default" alla grafica ogni volta che viene creato un nuovo blog
                $Default='Default';
                $blog_insertgr =  "INSERT INTO Grafica (Blog, Grafica) VALUES ('$idBlog','$Default')";
                $risultato_blog_insertgr = mysqli_query($connessione,$blog_insertgr);
        $queryNome = "SELECT Tema FROM Blog WHERE ID_Blog = '$idBlog'";
		$exNomee = mysqli_query($connessione,$queryNome);
		$arrNome = mysqli_fetch_array($exNomee);
		$tema = $arrNome[0];
		//memorizzo in sessione il tema del blog
		$_SESSION['Tema'] = $tema;
                //Chiudo la connessione e reindirizzo a creaBlog
                mysqli_close($connessione);
                header("location: ./creaBlog.php");
            }
    }
?>
