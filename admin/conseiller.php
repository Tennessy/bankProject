<?php

	if ($_SESSION['category'] == 'conseiller') {
		
		// Actions disponibles
		if (isset($_GET['action']) && $_GET['action'] == 'addClient') {
			include_once(adminPhp("form_addClient"));
		}
		if (isset($_GET['action']) && $_GET['action'] == 'sellContract') {
			include_once(adminPhp("form_sellContract"));
		}
		if (isset($_GET['action']) && $_GET['action'] == 'openAccount') {
			include_once(adminPhp("form_openAccount"));
		}
		if (isset($_GET['action']) && $_GET['action'] == 'modifyOverdraft') {
			include_once(adminPhp("form_modifyOverdraft"));
		}

	} else {
		// On fait rien pour le moment
	}

?>
