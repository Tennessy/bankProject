<?php

	if ($_SESSION['category'] == 'conseiller') {
		
		// Actions disponibles
		if (isset($_GET['action']) && $_GET['action'] == 'addClient') {
			include_once(adminPhp("form_addClient"));
		}

	} else {
		// On fait rien pour le moment
	}

?>
