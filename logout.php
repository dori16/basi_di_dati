<?php require_once('Include/Sessions.php') ?>
<?php require_once('Include/functions.php') 


/*Mi collego al database e recupero i dati dalla sessione*/ ?>
<?php	

include 'connessione.php';
$_SESSION['user_id'] = null;
session_destroy();
Redirect_To('login.php');

?>


