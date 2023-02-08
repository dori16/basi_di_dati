<?php
	//Connesione al database
    include 'connessione.php';
    include 'salvaSessione.php';
    //Recupero dati immessi nel form
    $commentIbrido = $_POST['commento'];
    $comment = addslashes($commentIbrido);
    //Se il commento non è stato inserito 
    if(strlen($comment)<1){
        echo("<script type = 'text/javascript'>alert('Commento non inserito!')</script>");
         echo ("<script type='text/javascript'>window.location.href ='./vediPost.php'</script>");
    }else{
        //Recupero i dati da inserire all'interno del database
        $utente = $_SESSION['Email'];
        $post = $_SESSION['Post'];
        $data = date('Y/m/d H:i:s');
        //Query per inserire i dati all'interno della tabella apposita
        $inserisci = "INSERT INTO commento (Post,Utente,Testo,Data_Ora) VALUES('$post','$utente','$comment','$data')";
        $fine = mysqli_query($connessione,$inserisci);
        //Reindirizzamento alla pagina stessa
        header("location: ./vediPost.php");
    }
?>

<?php
    //Chiusura della connessione al database
	mysqli_close($connessione);
?>