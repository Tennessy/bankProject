<?php

	// Initialisation des variables serveur
	$serverHostDB = 'localhost';
	$serverUserDB = 'root';
	$serverPasswdDB = 'root';
	$nameDB = 'takl_bank';

	// Messages d'erreur
	function showFormError($champ, $message) {
		echo'
			<div class=\"form_error\">
				<p>Erreur dans le formulaire : *' . $champ . '* ' . $message . '</p>
			</div>
		';
	}

	// Raccourci
	function rootPhp($fileName) {
		return ("root_parts/" . $fileName . ".php");
	}
	function adminPhp($fileName) {
		return ("admin_parts/" . $fileName . ".php");
	}

?>
