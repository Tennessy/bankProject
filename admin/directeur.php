<?php

	if ($_SESSION['category'] == 'directeur') {
		
		// Actions disponibles
		if ($_GET['show'] == 'addEmployee') {
			include(adminPhp("form_addEmployee"));
		}
	} else {
		// On ne fait rien pour le moment
	}

?>
