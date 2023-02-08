<?php
 //Includo la pagina che fa partire la sessione
 include 'salvaSessione.php';
 ?>
<!DOCTYPE html>
<html>

    <head>
        <meta charset = "utf-8">
        <link rel="stylesheet" href="home.css"/>
        <link rel="icon" href="img/favicon.ico" />
        <title>IKM - Blog</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script>$(document).ready(function(){
            
            //Se clicco il pulsante torna alla home si avvia la funzione anonima
            $('#tah').click(function(){
                $.ajax({
                    //Mi collego alla pagina rimuoviBlog.php che toglie dalla sessione il blog in cui ero
                    url: 'rimuoviBlog.php',
                    type: 'POST',
                    //Se la funzione ha successo vado nella pagina della home
                    success: function() {
                        $(window.location).attr('href','./index.php');
                    }
                });
            });


            //Quando clicco sul pulsante 'Segui'
             $('#segui').click(function(){
                //Passo la variabile che mi memorizza il tema
                var tema = $('#temaS').text();
                //Chiamata ajax per aggiungere l'utente ai seguaci del blog
               $.ajax({
                    url: "seguace.php",
                    method: "POST",
                    data: "temaS="+tema,
                    dataType: "html",
                    success: function(){
                       $(window.location).attr('href','./creaBlog.php');
                   }
                });
            });



            //Quando clicco su un post mi porta alla pagina di gestione post
            $('.btnCom').click(function(){
                var $this = $(this).next();
                var id = $this.text();

                //Chiamata ajax per salvare in sessione l'id del post
                $.ajax({
                    url: "recPost.php",
                    method: "POST", 
                    data: "idP="+id,
                    dataType: "html",
                    success: function(){
                        $(window.location).attr('href','./vediPost.php');
                    }
                });
           });



            //Quando clicco su elimina blog mi elimina tutto il blog e i post ad esso associati
            $('#eb').click(function(){
                $.ajax({
                    url: "eliminaBlog.php",
                    success: function(){
                         $(window.location).attr('href','./index.php');
                    }
                });
            });


        //Ricerca per aggiungere utente
        $('#searchButtonEm').click(function(){
                //Registrazione stringa cercata
                var searchString = $('#searchEm').val();
                if(searchString){
                    //Chiamata di ajax
                    $.ajax({
                        type: 'POST',
                        url: 'searchNome.php',
                        data: 'search='+searchString,
                        //Prima di inviare i risultati
                        beforeSend: function(html){
                            $('.risultatiRic').html('');
                            $('.searchResults').show();
                            $(".word").html(searchString);
                        },
                        //Se ha successo la chiamata appendo i risultati al div html
                        success: function(html){
                            $('.risultatiRic').show();
                            $('.risultatiRic').append(html);
                            //Quando clicco su aggiungi l'utente viene automaticamente aggiunto come collaboratore
                            $('.aggiungi').click(function(){
                                var $ibrido = $(this).prev();
                                var $email = $ibrido.text();
                                $.ajax({
                                    url: 'aggiungiColl.php',
                                    type: 'POST',
                                    data: 'ut='+$email, 
                                 
                                    //Se ha successo mi ricarica la pagina 
                                    success: function(){
                                        $(window.location).attr('href','./creaBlog.php');
                                    }
                                });
                            });
                        }
                    });
                }
                //Se la ricerca non ha successo
                return false;
                
            });
            //Revoca la collaborazione ad un utente cliccando sul pulsante revoca
            $('.revoca').click(function(){
                //Memorizzo l'utente nella stringa utente
                var $utente = $(this).prev();
                var $testo = $utente.text();
                $.ajax({
                    type: "POST",
                    url: "revocaColl.php",
                    data: "utente="+$testo,
                    success: function(){
                         $(window.location).attr('href','./creaBlog.php');
                    }
                });
            });
            
            //Un utente smette di collaborare cliccando sul pulsante revoca
            $('.revocaAu').click(function(){
                $.ajax({
                    url: "revocaCollab2.php",
                    type: "POST",
                    success: function(){
                         $(window.location).attr('href','./creaBlog.php');
                    }
                });
            });
            //Al caricamento della pagina mostro i primi 5 post
            $('div.spazioPost').hide();
            $('div.spazioPost').slice(0,5).show();
            //Premendo su mostra tutti i post mi mostra tutti i post in ordine decrescente e nasconde il tasto mostra tutti i post
            $('#event').click(function(){
                var conta = $('div.spazioPost').length;
                for (var i=5;i<conta;i++){
                    $('div.spazioPost').slice(i,i+5).show();
                    $('#event').hide();
                }
            });

        });
        </script>

    </head>


    <div id="tornaHome">
        <a href = "index.php" class='buttonhome'>Torna alla home</a>
    </div>
    
    <?php
            //Recupero la connessione al database
            include 'connessione.php';
            //Recupero l'id del blog
            $idBlog = $_SESSION['ID_Blog'];
            //Faccio una query per recuperare la grafica salvata del blog
            $queryStile = "SELECT * FROM Aspetto as a, Grafica as g WHERE g.Blog = '$idBlog'  AND g.Grafica = a.Nome";
            //Eseguo la query e memorizzo i risultati in un array
            $exStile = mysqli_query($connessione,$queryStile);
            $arrGr = mysqli_fetch_array($exStile);
            //Recupero le varie caratteristiche dello stile
            $font = $arrGr[1];
            $colore_Titoli = $arrGr[2];
            $colore_Testi = $arrGr[3];
            $sfondoPost = $arrGr[4];
            $sfondoPagina = $arrGr[5];
        ?>
        <style>
            body{
                background: <?php echo $sfondoPagina;?>;   
                font-family:<?php echo $font;?>;
            }
            #corpo{
                background-color: <?php echo $sfondoPost;?>;
            }
            input.btn,.aggiungi,.revoca,.revocaAu {
                background-color: <?php echo $colore_Titoli;?>;
                color:  <?php echo $colore_Testi;?>;
                font-family:<?php echo $font;?>;
            }
            input.btn:hover,.aggiungi:hover,.revoca:hover,.revocaAu:hover {
                background-color: <?php echo $sfondoPost;?>;
            }
            #sfondoPost{
                display: block;
                margin: 1%;
                padding: 1%;
            }
            #post{
                color:  <?php echo $colore_Testi;?>;
            }
            h1,h2,h3, #block, #title,h6{
                color:  <?php echo $colore_Titoli;?>;
            }
            div#gestione h2{
                color:  <?php echo $colore_Titoli;?>;
            }
            #corpo p,#corpo input,#corpo li{
                color:  <?php echo $colore_Testi;?>;
            }
            p, h6{
                color:  <?php echo $colore_Testi;?>;
            }
            #risultatiRic li{
                color:  <?php echo $colore_Testi;?>;
            }
            .risultatiRic li{
                color:  <?php echo $colore_Testi;?>;
            }
        </style> 
    <div class="benvenuto">
                <?php
                include 'connessione.php';
                //Query per recuperare il nome del blog
         
                $idBlog= $_SESSION['ID_Blog'];
                
                $tema = $_SESSION['Tema'];
                $queryNom = "SELECT Nome_Blog FROM Blog WHERE ID_Blog = '$idBlog'"  ;
                $exNome = mysqli_query($connessione,$queryNom);
                $arrNom = mysqli_fetch_array($exNome);
                //Creo una variabile per memorizzare il nome del blog e poi stampo il nome
                
                echo ("<h1> Il nome del blog è " .$arrNom[0]. "</h1></br></br>");
            
							
            //Query per rintracciare il tema del blog
            $queryTema = "SELECT Tema FROM Blog WHERE ID_Blog = '$idBlog'";
            $exTema = mysqli_query($connessione,$queryTema);
            $tema = mysqli_fetch_array($exTema);
            //Stampo il tema del blog
            echo("<h3 id = 'temaS'>".$tema[0]."</h3></br></br>");

            //Memorizzo l'email del creatore assegnando alla nuova variabile il risultato ottenuto sopra dalla query
            $queryCreatore = "SELECT Utente FROM Creatore WHERE Blog = '$idBlog'";
            $exCreatore = mysqli_query($connessione,$queryCreatore);
            $creatore = mysqli_fetch_array($exCreatore);
            $emailCreatore = $creatore[0];
            //query per recuperare nome e cognome del creatore dalla email
            $queryNomeCognome = "SELECT Nome, Cognome FROM Utente WHERE Email = '$emailCreatore'";
            $exNomCog = mysqli_query($connessione,$queryNomeCognome);
            //Memorizzo i risultati all'interno di un array e stampo il nome e cognome del creatore
            $arrNomCog = mysqli_fetch_array($exNomCog);
            echo("<h3>Creato da " .$arrNomCog[0]." ".$arrNomCog[1].".</h3></br></br></br>");

                    mysqli_close($connessione);
                    ?>










                
<form action = "post.php" method = "post" enctype="multipart/form-data">           
            <?php
                include 'connessione.php';
                //Query per recuperare il nome del blog
               
                $idBlog= $_SESSION['ID_Blog'];
              
             //Se l'utente è loggato eseguo le seguenti istruzioni
             if (isset($_SESSION['login'])){
                //Query per recuperare il creatore
                $queryCreatore = "SELECT Utente FROM Creatore WHERE Blog = '$idBlog'";
                $exCreatore = mysqli_query($connessione,$queryCreatore);
                $creatore = mysqli_fetch_array($exCreatore);
                
                //Query per rintracciare eventuali collaboratori
                $queryColl = "SELECT Utente FROM Collaboratore WHERE Blog = '$idBlog'";
                $exColl = mysqli_query($connessione,$queryColl);
                //Inizializzo un array vuoto nel caso non ci fossero collaboratori al blog
                $rightArr = array();
                //Memorizzo i risultati all'interno di un array
                while($arrColl = mysqli_fetch_array($exColl)){
                    $risultati = $arrColl[0];
                    $rightArr[] = $risultati;
                };
                //Se non ci sono collaboratori aggiungo una stringa vuota all'array 
                if(empty($rightArr) == true){
                    $rightArr[] = '';
                }
                //Recupero l'utente loggato
                $utente = $_SESSION['Email'];
                //Query per rintracciare i seguaci
                $querySeg = "SELECT Utente FROM Seguace WHERE Blog = '$idBlog'";
                $exSeg = mysqli_query($connessione,$querySeg);
                //Inizializzo un array vuoto
                $leftArr = array();
                //Memorizzo i risultati all'interno dell'array
                while($arrSeg = mysqli_fetch_array($exSeg)){
                    $resSeg = $arrSeg[0];
                    $leftArr[] = $resSeg;
                };
                //Se l'array è vuoto gli aggiungo una stringa vuota
                if(empty($leftArr) == true){
                    $leftArr[] = '';
                }
                //Se l'utente loggato è il creatore o un collaboratore allora eseguo le istruzioni seguenti
                if(($creatore[0]==$_SESSION['Email']) or (in_array($utente, $rightArr))){
                    //Se l'utente loggato è un collaboratore allora eseguo le seguenti istruzioni
                    if(in_array($utente, $rightArr)){
                        //Stampo le seguenti stringhe e il pulsante per smettere di collaborare
                        echo("<h2>Sei un collaboratore</h2>");
                        echo("<input type = 'button' class = 'revocaAu' value = 'Smetti di collaborare'><br/>");
                        echo("<p id = 'collaboratore'style='display:none;''>".$_SESSION['Email']."</p>");}
                










    //Query che restituisce il numero di post che ha un blog
            $qPost = "SELECT ID_Post FROM Post WHERE Blog = '$idBlog' ";
            //Eseguo la query
            $numPost = mysqli_query($connessione,$qPost);
         //Conto i risultati della query
            $rowCount = mysqli_num_rows($numPost);
             //Se non sono presenti post nel blog eseguo questa istruzione altrimenti la seconda
         if($rowCount==0){
            echo("<h1>Scrivi il tuo primo post</h1></br></br>");
        }else {
            echo("<h1>Aggiungi un post</h1></br></br>");
        }

                //Stampo i campi per l'immissione di un post 
                echo("<h2>Titolo:</h2><br/>");
                echo("<textarea rows ='1' cols = '40' placeholder='Inserisci il titolo' name = 'TitlePost' id = 'titlePost'value ='' maxlength='40'></textarea><br/>");
                echo("<h2 id = 'block'>Testo:</h2></br>");
                echo("<textarea rows ='10' cols = '59'  placeholder='Inserisci il testo (Massimo 1000 caratteri)' name = 'TextPost' id = 'TextPost' maxlength='1000' size='40' value =''></textarea><br/>");
                echo("<h2>Inserisci un'immagine</h2>");
                echo("<h5>Dimensione massima: 2MB</h5>");
                echo("<input type='file' name='file_img' id ='searchimg'/></br>");
                echo("</br></br><input class = 'btnpubb' type = 'submit' name = 'Pubblica' value = 'Pubblica'>");
                


//Nel caso l'utente sia un seguace stampo le relative stringhe e il pulsante smetti di seguire
} if(in_array($utente, $leftArr)){
    echo("<h2>Sei un seguace del blog</h2>");
    echo("<input type = 'button' class = 'revocaAu' value = 'Smetti di seguire'><br/>");
    echo("<p id = 'collaboratore' style='display:none;''>".$_SESSION['Email']."</p>");
} else {
    //Creazione del pulsante per seguire il blog
    echo("<input type = 'button' class = 'btn' id = 'segui' value = 'Segui il blog'>");
}
}



                
                //Chiusura della connessione
                mysqli_close($connessione);
            ?>
        
</form>    
</div>
<div id = "gestione">
                <?php
                include 'connessione.php';
    
                $idBlog= $_SESSION['ID_Blog'];
               
                    //Se l'utente è loggato ed è creatore può gestire e modificare il blog
                    if(isset($_SESSION['login'])){
                        if($creatore[0]==$_SESSION['Email']){
                            echo("<h1>Gestione del blog</h1>");
                            echo("<input type ='button' id = 'eb' class = 'btnel' value = 'Elimina blog'></br>");

                            //RICERCA DI UN UTENTE PER CHIEDERE LA COLLABORAZIONE
                            echo("<h2>Aggiungi un utente come collaboratore</h2>");
                            echo("<input type = 'text' placeholder='Email, nome o cognome' id = 'searchEm' value = ''>");
                            echo("<input type='button' id = 'searchButtonEm' class = 'btn' value = 'Cerca'>");
                            echo("</br>");
                            echo("<div class = 'risultatiRic'>");
                            echo("<div class = 'searchResults'>");
                            echo("<p class = 'word'></p>");
                            echo("</div>");
                            echo("</div>");
                            
                         
                            



                            //Query per cercare i collaboratori al blog
                            $queryCollaboratori = "SELECT Utente FROM Collaboratore WHERE Blog = '$idBlog'";
                            $exCI = mysqli_query($connessione,$queryCollaboratori);
                            //Conto quanti sono i collaboratori ad un blog
                            $contaColl = mysqli_num_rows($exCI);
                            echo("<h3>I collaboratori:</h3>");
                            if($contaColl ==0){
                                echo("<p>Nessun utente sta collaborando a questo blog</p></br></br></br>");
                            }else{
                                //Stampo i nomi dei vari collaboratori al blog con la possibilità di revocarli la collaborazione
                                while($arrCI = mysqli_fetch_array($exCI)){
                                    echo("<p class = 'collaboratore'>".$arrCI[0]."</p>");
                                    echo("<input type='button' class = 'revoca' value = 'Revoca'>");
                                }
                            }
                            
                        }
                    }
                ?>
 <div id="grafica">
                    <form action = "grafica.php" method = "post">
                        <?php
                            //Se l'utente è loggato
                            if(isset($_SESSION['login'])){
                                //Se l'utente è creatore allora può modificare l'aspetto
                                if($creatore[0]==$_SESSION['Email']){
                                    //Creazione di un menù all'interno del quale può scegliere fra diversi temi
                                    echo("<h2>Modifica l'aspetto</h2></br>");
                                   
                                   
                                    
										echo("<div class='box'>");
										
										echo("<select name='aspetto' id='aspetto' value=''>");
										echo("<option value=''>Scegli la grafica");
										$query="SELECT Nome FROM Aspetto";
										$result2=mysqli_query($connessione, $query);
										
										while ($array = mysqli_fetch_array($result2)) {
											//Assegno ad una variabile il primo elemento dell'aray risultante dalla query
											echo("<option>".$array[0]."</p></option>");
											
										};
										echo("</option>");
										echo("</select>");
                                 
                                    echo("<input class = 'btn' type = 'submit' name = 'Cambia' value = 'Cambia'>");
                                }
                            }
                            //Chiusura della connessione
                            mysqli_close($connessione);
                        ?>
                    </form>
                </div>
                        </br></br>
           
<div class='post'>
                    <?php
                    include 'connessione.php';
            
                    //Query per recuperare il nome del blog
                    $idBlog= $_SESSION['ID_Blog'];
                   
                        //Query che recupera il titolo e il testo del post
                        $titoloTesto = "SELECT Titolo, Testo, ID_Post, Utente FROM Post WHERE Blog = '$idBlog'  ORDER BY ID_Post DESC";
                        //Eseguo la query
                        $result = mysqli_query($connessione,$titoloTesto);
                        //Conto i risultati della query
                        $conta = mysqli_num_rows($result);
                        //Controllo se la query è stata eseguita correttamente
                        if (!$result) {
                            printf("Error: %s\n", mysqli_error($connessione));
                            exit();
                        }else{
                            //Se sono presenti più di 5 post aggiungo il pulsante vedi tutti i post
                            if(isset($conta)&&$conta>5){
                                echo("<input type='button' class = 'buttonlog' id='event' value = 'Vedi tutti i post'>");
                            }
                            //Stampo i vari post
                            while($mat = mysqli_fetch_array($result)){
                                //Stampo il titolo e il testo di ogni post
                                echo("<div class = 'spazioPost'><h2 class ='title'>Il titolo è ".$mat[0] ."</h2>");
                                echo("<p class = 'post'>Il Post è ".$mat[1]."</p>");
                                $idPost = $mat[2];
                                    //query che recupera l'immagine eventualmente associata
                                    $qimmagine = "SELECT Contenuto FROM Immagine WHERE Post = '$idPost'";
                                    //Esecuzione della query
                                    $exImg = mysqli_query($connessione,$qimmagine);
                                    //Se nel post non è associata alcuna immagine stampo una stringa vuota
                                    if(!$exImg){
                                        echo("");
                                    }else{
                                        //Altrimenti stampo l'immagine
                                        $conta = mysqli_num_rows($exImg);
                                        if($conta ==1){
                                            $contenuto = mysqli_fetch_array($exImg);
                                            $immagine = $contenuto[0];
                                            echo("<img src='".$immagine."' class = 'fotoPost'alt='Mia Immagine'>");
                                        }
                                    };
                                    echo("<p class = 'autore'>Scritto da"." ".$mat[3]."</p>");
                                     //query per contare i mi piace relativi ad un post
                                $queryContaMiPiace = "SELECT * FROM MiPiace WHERE Post ='$idPost'";
                                //eseguo la query
                                $exMP = mysqli_query($connessione,$queryContaMiPiace);
                                $contaMP = mysqli_num_rows($exMP);
                                //query per contare i commenti relativi ad un post
                                $queryContaCommenti = "SELECT * FROM commento WHERE Post ='$idPost'";
                                //eseguo la query
                                $exCM = mysqli_query($connessione,$queryContaCommenti);
                                $contaCM = mysqli_num_rows($exCM);
                                //Se non sono presenti mi piace o commenti e l'utente è loggato stampo la stringa successiva
                                if($contaMP==0 AND $contaCM==0 AND isset($_SESSION['login'])){
                                    echo("<p class = 'contaMP'>Metti mi piace o commenta per primo</p>");
                                //Stampo le stringhe che contano i mi piace e i commenti
                                }else if($contaMP!=0 AND $contaCM>=2){
                                    echo("<p class = 'contaMP'>".$contaMP." mi piace e ".$contaCM." commenti</p>");
                                }else if($contaCM==0){
                                    echo("<p class = 'contaMP'>".$contaMP." mi piace e ".$contaCM." commenti</p>");
                                }else{
                                    echo("<p class = 'contaMP'>".$contaMP." mi piace e ".$contaCM." commento</p>");
                                }
                                //Genero un pulsante che mi fa vedere il post con commenti relativi
                                echo("<input type ='button' class = 'btnCom' value ='Vai alla pagina di discussione'>");
                                echo("<p class = 'numPost' style = 'display:none'>".$idPost."</p>");
                                //Chiudo il div che contiene i post
                                echo("</div>");
                            }; 
                        };
                    ?>
                   
    
            </div>
    </body>
<div class="foot
">
    <footer>
            <p>Progetto realizzato per il corso di basi di dati A.A. 2021-2022 da: <br/>
            <br/> Isidoro Allegretti: <a href="mailto:i.allegretti@studenti.unipi.it">i.allegretti@studenti.unipi.it</a>
            <br/> Katerina Bigicchi: <a href="mailto:k.bigicchi@studenti.unipi.it">k.bigicchi@studenti.unipi.it</a>
             <br/>Matteo Solini:  <a href="mailto:i.allegretti@studenti.unipi.it">m.solini@studenti.unipi.it</a>
            </p>
    </footer>
                    </div>
</html>