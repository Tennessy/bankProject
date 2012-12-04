<?php

	session_start();

	include("conf.php");

	// Gère les déconnexions
	if ((isset($_POST['post_logout']))) {
		// Suppression des variables de session
		$_SESSION = array();
		// Suppression de la session
		session_destroy();
	}

	// Gère les connexions
	if ((isset($_POST['input_login_employee']) && !empty($_POST['input_login_employee'])) && isset($_POST['input_login_passwd']) && !empty($_POST['input_login_passwd'])) {
		$id_shDB = mysql_connect($serverHostDB, $serverUserDB, $serverPasswdDB);
		if (!$id_shDB) {
			echo 'Erreur de connexion au serveur de la base de données.';
		} else {
			$id_nDB = mysql_select_db($nameDB);
			if (!$id_nDB) {
				echo 'Erreur de connexion à la base de données.';
			} else {
				// Hashage du mot de passe
				$hLogin_Passwd = sha1($_POST['input_login_passwd']);
				$query = sprintf("SELECT * FROM `employees` WHERE `login` = '%s' AND `hPasswd` = '{$hLogin_Passwd}'", mysql_real_escape_string($_POST['input_login_employee']));
				//DEBUG print $query;
				$dbReturn = mysql_query($query);
				$dbReturnData = mysql_fetch_array($dbReturn);
				if (($dbReturnData['login'] == $_POST['input_login_employee']) && ($dbReturnData['hPasswd'] == $hLogin_Passwd)) {
					// Initialisation des variables SESSION
					//DEBUG echo 'Connexion réussie';
					$_SESSION['id_employee'] = $dbReturnData['id_employee'];
					$_SESSION['login'] = $dbReturnData['login'];
					$_SESSION['hPasswd'] = $dbReturnData['hPasswd'];
					// Initialise la catégorie
					if ($dbReturnData['category'] == 'A') {
						$_SESSION['category'] = 'agent';
					} else if ($dbReturnData['category'] == 'C') {
						$_SESSION['category'] = 'conseiller';
					} else if ($dbReturnData['category'] == 'D') {
						$_SESSION['category'] = 'directeur';
					}
					$_SESSION['lastName'] = $dbReturnData['lastName'];
					$_SESSION['firstName'] = $dbReturnData['firstName'];
				}
			}
			mysql_close($id_shDB);
		}
	}

?>
