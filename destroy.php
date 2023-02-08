<?php
	//Pagina php per la distruzione della session
	include'salvaSessione.php';
	session_unset();
	session_destroy();
?>