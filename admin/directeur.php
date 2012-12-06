<?php

	if ($_SESSION['category'] == 'directeur') {
		
		// Actions disponibles
		if (isset($_GET['action']) && $_GET['action'] == 'addEmployee') {
			include_once(adminPhp("form_addEmployee"));
		}
		if (isset($_GET['action']) && $_GET['action'] == 'aboutEmployee') {
			include(adminPhp("form_aboutEmployee"));
		}

	} else {
		// On ne fait rien pour le moment
	}

?>
