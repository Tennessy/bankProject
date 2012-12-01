<?php

	session_start();

	include("conf.php");

	// Gère les déconnexions
	if ((isset($_POST['post_Logout']))) {
			// Suppression des variables de session
			$_SESSION = array();
			// Suppression de la session
			session_destroy();
		}

	// Gère les connexions
	if ((isset($_POST['input_Login_Employee']) && !empty($_POST['input_Login_Employee'])) && isset($_POST['input_Login_Passwd']) && !empty($_POST['input_Login_Passwd'])) {
		$id_shDB = mysql_connect($serverHostDB, $serverUserDB, $serverPasswdDB);
		if (!$id_shDB) {
			echo 'Erreur de connexion au serveur de la base de données.';
		} else {
			$id_nDB = mysql_select_db($nameDB);
			if (!$id_nDB) {
				echo 'Erreur de connexion à la base de données.';
			} else {
				// Hashage du mot de passe
				$hLogin_Passwd = sha1($_POST['input_Login_Passwd']);
				$query = sprintf("SELECT * FROM `employees` WHERE `id_employee` = '%s' AND `hPasswd` = '{$hLogin_Passwd}'", mysql_real_escape_string($_POST['input_Login_Employee']));
				//DEBUG print $query;
				$dbReturn = mysql_query($query);
				$dbReturnData = mysql_fetch_array($dbReturn);
				if (($dbReturnData['id_employee'] == $_POST['input_Login_Employee']) && ($dbReturnData['hPasswd'] == $hLogin_Passwd)) {
					// Initialisation des variables SESSION employé
					//DEBUG echo 'Connexion réussie';
					$_SESSION['id_employee'] = $dbReturnData['id_employee'];
					$_SESSION['hPasswd'] = $dbReturnData['hPasswd'];
					$_SESSION['category'] = $dbReturnData['category'];
					$_SESSION['lastName'] = $dbReturnData['lastName'];
					$_SESSION['firstName'] = $dbReturnData['firstName'];
				}
			}
			mysql_close($id_shDB);
		}
	}

?>
