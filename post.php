<?php
	//Connesione al database
    include 'connessione.php';
    include 'salvaSessione.php';
    //Recupero dati immessi nel form
    $data = date('Y/m/d H:i:s');
    $titlePostIb = $_POST['TitlePost'];
    $titlePost = addslashes($titlePostIb);
    $testoIbrido = $_POST['TextPost'];
    $textPost = addslashes($testoIbrido);
    //Controllo per vedere se ho inserito testo e titolo di un post
    if($titlePost==""||$testoIbrido==""){
        echo("<script type = 'text/javascript'>alert('Inserisci sia testo sia titolo!')</script>");
        echo ("<script type='text/javascript'>window.location.href ='./creaBlog.php'</script>");
        mysqli_close($connessione);
    //Se il testo è troppo lungo genero un alert che mi avvisa di ciò e mi impedisce di creare il post
    }else if (strlen($textPost)>500){
        echo("<script type = 'text/javascript'>alert('Testo troppo lungo!')</script>");
        echo ("<script type='text/javascript'>window.location.href ='./creaBlog.php'</script>");
        mysqli_close($connessione);
    //Se titolo e testo rispettano gli standard allora immetto i dati nel database
    } else{
        //Recupero dalla sessione l'id del blog e l'email dell'utente loggato
        $idBlog = $_SESSION['ID_Blog'];
        $utente = $_SESSION['Email'];
        //Query per inserire i dati nel database
        $queryImm = "INSERT INTO Post (Blog, Titolo, Testo, Utente, Data_Ora) VALUES ('$idBlog','$titlePost','$textPost','$utente','$data')";
        //Immissione dati nel database
        $result = mysqli_query($connessione,$queryImm);
        //Recupero l'id del post
        $recuperoId = "SELECT ID_Post FROM Post WHERE Blog = '$idBlog' AND Titolo = '$titlePost' AND Testo = '$textPost'";
        $queryId = mysqli_query($connessione,$recuperoId);
        //Memorizzo l'id del post corrispondente
        while($arrPost = mysqli_fetch_array($queryId)){
            $idPost = $arrPost[0];
        };
        //Recupero informazioni relative alle immagini
        $filetmp = $_FILES['file_img']['tmp_name'];
        $filename = $_FILES['file_img']['name'];
        $filesize = $_FILES['file_img']['size'];
        //Verifico se è stata caricata l'immagine
        if (is_uploaded_file($filetmp) == True){
            //grandezza massima del file
            $sizeMax = 1000000;
            //Memorizzo la grandezza dell'immagine
            $is_img = getimagesize($filetmp);
            if (!$is_img||$filesize>$sizeMax) { //Se non lo è annullo l'invio dell'immagine e riconduco alla stessa pagina
                echo("<script type = 'text/javascript'>alert('Impossibile caricare il file!')</script>");
                echo ("<script type='text/javascript'>window.location.href ='./creaBlog.php'</script>");
                mysqli_close($connessione);
            } else{   
                //Inserisco l'immagine nella cartella foto
                $filepath = 'photo/'.$filename;
                //Inserimento immagine nella cartella
                move_uploaded_file($filetmp, $filepath);
                //Query per inserimento immagini nel database
                $queryUp = "INSERT INTO Immagine (Nome, Contenuto, Post) VALUES('$filename','$filepath','$idPost')";
                $esegui = mysqli_query($connessione,$queryUp);
                $_SESSION['Post'] = $idPost;
                header("location: ./creaBlog.php");
                mysqli_close($connessione);
            }
            //Se l'immagine non è stata caricata eseguo un controllo
        } else if (is_uploaded_file($filetmp) == False){
            //Se l'immagine caricata è superiore ai 2MB php non la riconosce dunque ottimizzo i controlli con il codice seguente
            if($filename!=""){
                echo("<script type = 'text/javascript'>alert('Impossibile caricare il file!')</script>");
                echo ("<script type='text/javascript'>window.location.href ='./creaBlog.php'</script>");
            }else{
                header("location: ./creaBlog.php");
            }
            //Memorizzo in sessione l'id del post e reindirizzo alla pagina creaBlog
            $_SESSION['Post'] = $idPost;
            mysqli_close($connessione);
        }
    }
?>