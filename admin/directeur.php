<?php

	if ($_SESSION['category'] == 'directeur') {
		
		// Actions disponibles
		if (isset($_GET['action']) && $_GET['action'] == 'addEmployee') {
			include_once(adminPhp("form_addEmployee"));
		}
		if (isset($_GET['action']) && $_GET['action'] == 'modifyEmployee') {
			include_once(adminPhp("form_modifyEmployee"));
		}
		if (isset($_GET['action']) && $_GET['action'] == 'addAccountType') {
			include_once(adminPhp("form_addAccountType"));
		}
		if (isset($_GET['action']) && $_GET['action'] == 'addContractType') {
			include_once(adminPhp("form_addContractType"));
		}
		if (isset($_GET['action']) && $_GET['action'] == 'modifyAccountType') {
			include_once(adminPhp("form_modifyAccountType"));
		}
		if (isset($_GET['action']) && $_GET['action'] == 'modifyContractType') {
			include_once(adminPhp("form_modifyContractType"));
		}
		if (isset($_GET['action']) && $_GET['action'] == 'deleteAccountType') {
			include_once(adminPhp("form_deleteAccountType"));
		}
		if (isset($_GET['action']) && $_GET['action'] == 'deleteContractType') {
			include_once(adminPhp("form_deleteContractType"));
		}
		if (isset($_GET['action']) && $_GET['action'] == 'stats') {
			include_once(adminPhp("form_stats"));
		}

	} else {
		// On ne fait rien pour le moment
	}

?>
