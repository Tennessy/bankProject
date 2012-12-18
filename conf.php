<?php

	// Initialisation des variables serveur
$serverHostDB = 'localhost';
$serverUserDB = 'root';
$serverPasswdDB = 'root';
$nameDB = 'takl_bank';


	// Connexion rapide à la base de données
function quickConnectDB() {
	$id_shDB = mysql_connect($GLOBALS['serverHostDB'], $GLOBALS['serverUserDB'], $GLOBALS['serverPasswdDB']);
	if (!$id_shDB) {
		echo 'Erreur de connexion au serveur de la base de données.';
	} else {
		$id_nDB = mysql_select_db($GLOBALS['nameDB']);
		if (!$id_nDB) {
			echo 'Erreur de connexion à la base de données.';
		} else {
			return $id_shDB;
		}
	}
	return NULL;
}

	// Génére un token pour le $nom spécifié
function generateToken($nom){
	$token = uniqid(rand(), TRUE);
	$_SESSION[$nom . '_token'] = $token;
	$_SESSION[$nom . '_token_time'] = time();
	return $token;
}

	// Vérifie un token pour un $nom spécifié, et un temps maximum écoulé en secondes [défaut: 10 minutes]
function checkToken($nom, $referer, $temps = '900') {
	if (isset($_SESSION[$nom . '_token']) && isset($_SESSION[$nom . '_token_time']) && isset($_POST['token'])) {
		if ($_SESSION[$nom.'_token'] == $_POST['token']) {
			if ($_SESSION[$nom.'_token_time'] >= (time() - $temps)) {
				return TRUE;
			}
		}
	}
	return false;
}

	// Vérifie un token pour un $nom spécifié, une adresse web absolue (indiquant la provenance de l'utilisateur),
	// et un temps maximum écoulé en secondes [défaut: 10 minutes]
function checkTokenR($nom, $referer, $temps = '900') {
	if (isset($_SESSION[$nom . '_token']) && isset($_SESSION[$nom . '_token_time']) && isset($_POST['token'])) {
		if ($_SESSION[$nom.'_token'] == $_POST['token']) {
			if ($_SESSION[$nom.'_token_time'] >= (time() - $temps)) {
				if ($_SERVER['HTTP_REFERER'] == $referer) {
					return TRUE;
				}
			}
		}
	}
	return false;
}

function showFormSuccess($message) {
	return'
	<div class="form_success">
	<p>' . $message . '</p>
	</div>
	';
}

	// Messages d'erreur
function showFormError($champ, $message) {
	return'
	<div class="form_error">
	<p>Erreur : *' . $champ . '* ' . $message . '</p>
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

	//Obtenir les informations d'un client
function getClientDatas($id){
	$db = quickConnectDb();
	$clientDatas = mysql_query('SELECT * FROM clients WHERE id_client="' . $id . '"');
	mysql_close($db);

	if(mysql_num_rows($clientDatas) != 0){
		return mysql_fetch_array($clientDatas);
	}

	return null;
}


$months = array('Janvier','Fevrier', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Aout', 'Septembre', 'Octobre', 'Novembre', 'Decembre');
$days = array('Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche');
$dataName = array('id client', 'id employee', 'Nom', 'Prenom', 'Deuxième prenom', 'Troisième prenom', 'Date de naissance', 'Genre', 'Emploi', 'Status civil', 'Adresse', 'Ville', 'Code postal', 'Etat', 'Numero de Telephone', 'Numero de portable', 'Email');

?>
