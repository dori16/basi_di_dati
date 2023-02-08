<?php
    include 'salvaSessione.php';
?>
<!DOCTYPE html>
<html>
    <head>
    <meta charset = "utf-8">
        <link rel="stylesheet" href="home.css"/>
        <link rel="icon" href="img/favicon.ico" />
         
    	<title>IKM - Post</title>
    	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    	<script>$(document).ready(function(){
        	//Se clicco torna alla home si avvia la chiamata ajax V
        	$('#tab').click(function(){
                $.ajax({
                	//Mi collego alla pagina rimuoviBlog.php che toglie dalla sessione il blog in cui ero
                	url: 'rimuoviBlog.php',
                	type: 'POST',
                	//Se la funzione ha successo vado nella pagina di creaBlog
                	success: function() {
                    	$(window.location).attr('href','./creaBlog.php');
                	}
                });
            });
            //Se clicco su like V
            $('#like').click(function(){
                $.ajax({
                    //Mi collego alla pagina php che mi memorizza il like
                    url: 'like.php',
                    success: function() {
                        $(window.location).attr('href','./vediPost.php');
                    }
                })
            });

            //Se clicco su dislike V
             $('#dislike').click(function(){
                $.ajax({
                    //Mi collego alla pagina php che mi memorizza il like
                    url: 'dislike.php',
                    success: function() {
                        $(window.location).attr('href','./vediPost.php');
                    }
                })
            });
            //Se clicco sul pulsante elimina post si avvia la chiamata ajax che cancella i record nel database
            $('input#delPost').click(function(){
                $.ajax({
                    url: "eliminaPost.php",
                    success: function(){
                         $(window.location).attr('href','./creaBlog.php');
                    }
                });
            });
            //Se clicco su elimina commento si avvia la chiamata ajax che mi cancella i record relativi a quel commento
            $('input.delComm').click(function(){
                var individua = $(this).next();
                var idCom = individua.text();
                $.ajax({
                    url: "eliminaCommento.php",
                    method: "POST",
                    data: "commento="+idCom,
                    dataType: "html",
                    success: function(){
                        $(window.location).attr('href','./vediPost.php');
                    }
                });
            });
            //Nel momento del caricamento della pagina mostro i primi 5 commenti
            $('div.spazioCommenti').hide();
            $('div.spazioCommenti').slice(0,4).show();
            //Se clicco su mostra tutti si avvia una funzione che mostra tutti i commenti relativi al post
            $('#event').click(function(){
                var conta = $('p.cm').length;
                for (var i=4;i<conta;i++){
                    $('div.spazioCommenti').slice(i,i+4).show();
                    $('#event').hide();
                }
            });
        });
    	</script>
    </head>

    <body background="img/mesh-gradient.png">

    <div class = "post-box">
        <div id="post">
        	<input type = "button" id = "tab" value = "Torna al blog">
        	<form action = "commento.php" method = "post"> 
                <div id="corpoPost">
                    <?php
                        //Effettuo la connessione al database
                        include 'connessione.php';
                        //Recupero l'id del post per stampare il post per intero
                        $idPost = $_SESSION['Post'];
                        //Recupero il testo e il titolo del post dall'idPost
                        $queryTitText = "SELECT Titolo, Testo, Utente, Data_Ora FROM Post WHERE ID_Post='$idPost'";
                        //Eseguo la query
                        $exTitText = mysqli_query($connessione,$queryTitText);
                        //Stampo titolo e testo
                        while($titText = mysqli_fetch_array($exTitText)){
                            echo("<div id = 'testo'><h1 id ='title'>Titolo ".$titText[0] ."</h1>"."<p class ='data'> pubblicato il ".$titText[3]."</p>");
                            echo("<p id = 'post'>Post ".$titText[1]."</p></div><div id = 'row-reverse'>");
                            $creatore = $titText[2];
                            //Controllo se l'utente loggato è quello che scritto il post
                            if(isset($_SESSION['login'])){
                                $utenteLog = $_SESSION['Email'];
                                //Se l'utente loggato è il creatore può eliminare il post
                                if($utenteLog==$creatore){
                                    echo("<input type = 'button' id ='delPost' class = 'btn' value = 'Elimina post'>");
                                }
                            } else{
                                echo("");
                            } 
                            //query che recupera l'immagine eventualmente associata
                            $qimmagine = "SELECT Contenuto FROM Immagine WHERE Post = '$idPost'";
                            //Esecuzione della query
                            $exImg = mysqli_query($connessione,$qimmagine);
                            if(!$exImg){
                                echo("");
                            }else{
                                //Conto i risultati della query
                                $conta = mysqli_num_rows($exImg);
                                //Se è associata un'immagine al post la stampo
                                if($conta ==1){
                                    $contenuto = mysqli_fetch_array($exImg);
                                    $immagine = $contenuto[0];
                                    //Stampo l'immagine 
                                    echo("<div id = 'immagine'><img src=".$immagine." alt='Mia Immagine' id = 'immagine' width = 400px height = 400px></div>");
                                }
                                
                            };
                            echo("</div>");
                        };  
                    ?>
                </div>
                <?php
                include 'connessione.php';
                    //Se l'utente non è loggato lo invito ad iscriversi per commentare o mettere mi piace
                    if(!isset($_SESSION['login'])){
                        echo("<p>Per mettere mi piace e commentare</p>"."<a href = 'registrazione.php'>Iscriviti</a><br />");
                    }else{
                        //Recupero l'utente loggato
                        $utente = $_SESSION['Email'];
                        //query per vedere se l'utente ha messo mi piace
                        $queryLike = "SELECT * FROM MiPiace WHERE Post = '$idPost' AND Utente = '$utente' ";
                        $exLike = mysqli_query($connessione,$queryLike);
                        $conta = mysqli_num_rows($exLike);
                        $miPiace = mysqli_fetch_array($exLike);
                        //Se non ha messo mai mi piace gli do la possibilità di mettere mi piace
                        if($conta == 0){
                            echo("<img src='img/like.png' id = 'like'alt='Like' width = 20px height = 20px>Like<br/>");
                        }
                        //Se ha messo mi piace può toglierlo cliccando su l'icona apposita
                        else if($conta!=0){
                            if($miPiace['Stato']=='Si'){
                                echo("<img src='img/dislike.png' id = 'dislike'alt='Dislike' width = 20px height = 20px>Non mi piace più<br/>");
                            } else {
                                echo("<img src='img/like.png' id = 'like'alt='Like' width = 20px height = 20px>Like<br/>");
                            }
                        };
                    }  

                    //query per contare i mi piace relativi ad un post
                    $queryContaMiPiace = "SELECT * FROM MiPiace WHERE Post ='$idPost'";
                    //eseguo la query
                    $exMP = mysqli_query($connessione,$queryContaMiPiace);
                    $contaMP = mysqli_num_rows($exMP);
                    //Conto quanti mi piace ha il post
                    if($contaMP==0 AND isset($_SESSION['login'])){
                        //Se nessuno ha messo mi piace stampo la seguente stringa di testo
                        echo("</br> Metti mi piace per primo</br></br>");
                    }else{
                        //Se ha almeno un mi piace conto i mi piace e stampo la stringa
                        echo("<p id = 'contaMP'>".$contaMP." mi piace</p>");
                    } 
                ?>
                   
                
                <div id="commenti">
            		<?php
                		//Recupero l'id del post per stampare i commenti relativi al post
                		$idPost = $_SESSION['Post'];
                	    echo("<h2>Commenti</h2>"); 
                	    //query per contare i mi piace relativi ad un post
                        $queryContaCommenti = "SELECT * FROM commento WHERE Post ='$idPost'";
                        //eseguo la query
                        $exCM = mysqli_query($connessione,$queryContaCommenti);
                        $contaCM = mysqli_num_rows($exCM);
                        //Se sono presenti più di 4 commenti allora do la possibilià di visualizzarli tutti tramite il pulsante apposito
                        if($contaCM>4){
                            echo("<input type='button' class = 'btn' id='event' value = 'Vedi tutti i commenti'>");
                        }
                        else if($contaCM==0){
                        	echo("<p>Nessun commento</p>");
                        }
                        //Seleziono il testo, l'utente e l'id del commento in ordine decrescente
                        $commento = "SELECT Testo, Utente, ID_Commento, Data_Ora FROM commento  WHERE Post = '$idPost' ORDER BY ID_Commento DESC";
                        //Eseguo la query
                        $eseguoCom = mysqli_query($connessione,$commento); 
                        while($com = mysqli_fetch_array($eseguoCom)){
                            $em = $com[1];
                            $idComm = $com[2];
                            $data = $com[3];
                            //Stampo i commenti con l'autore relativo
                            echo("</br><div class = 'spazioCommenti'><h4 class='intestazione'>".$em."</h4>"." "."<p class = 'cm'>".$com[0]."</p>"."<p class = 'data'>".$data."</p>");
                            if(isset($_SESSION['login'])){
                                //Se l'utente loggato è il creatore del commento oppure il creatore del blog può eliminare il commento
                                if($creatore == $utenteLog||$utenteLog ==$em){
                                    echo("<input type = 'button' class= 'delComm' value ='Elimina commento'>");
                                    echo("<p id='idCom' style = 'display: none;'>".$idComm."</p><br/>");
                                    echo("</div>");
                                }
                            }
                        };    
                        //Se l'utente è loggato
                        if (isset($_SESSION['login'])){
                            //Se non sono presenti commenti stampo la stringa di testo seguente
                            if($contaCM==0){
                                echo("<br/>Commenta per primo: <br/>");
                            }
                            //Stampo l'area di testo per l'inserimento dei commenti 
                            echo("</br><textarea rows ='5' cols = '60' maxlength='250' name = 'commento' id = 'TextPost' value = '' placeholder='Scrivi...'></textarea><br/><br/>");
                            echo(" ");   
                            //Stampo il pulsante per commentare
                            echo("<input class = 'btn' type = 'submit' name = 'Commenta' value = 'Commenta'>");
                        }
            		?>
                
                </div>
        	</form>
        </div>
        </div>
    </body>
</html>