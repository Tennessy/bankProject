<?php

	if ($_SESSION['category'] == 'directeur') {
		
		// Actions disponibles
		if (isset($_GET['action']) && $_GET['action'] == 'addEmployee') {
			include_once(adminPhp("form_addEmployee"));
		}
		if (isset($_GET['action']) && $_GET['action'] == 'aboutEmployee') {
			include_once(adminPhp("form_aboutEmployee"));
		}
		if (isset($_GET['action']) && $_GET['action'] == 'addAccountType') {
			include_once(adminPhp("form_addAccountType"));
		}
		if (isset($_GET['action']) && $_GET['action'] == 'addContractType') {
			include_once(adminPhp("form_addContractType"));
		}

	} else {
		// On ne fait rien pour le moment
	}

?>
