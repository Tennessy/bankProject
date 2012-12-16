<?php

$dataName = array('id client', 'id employee', 'Nom', 'Prenom', 'Deuxième prenom', 'Troisième prenom', 'Date de naissance', 'Genre', 'Emploi', 'Status civil', 'Adresse', 'Ville', 'Code postal', 'Etat', 'Numero de Telephone', 'Numero de portable', 'Email');
$months = array('Janvier','Fevrier', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Aout', 'Septembre', 'Octobre', 'Novembre', 'Decembre');

if($_SESSION['category'] == 'agent'){
	if(isset($_GET['clientID']) && !empty($_GET['clientID']) && getClientDatas($_GET['clientID']) != null){

		if(isset($_GET['action']) && $_GET['action'] == 'showClientDatas'){
			include('admin/admin_parts/form_showClientDatas.php');
		}

		else if(isset($_GET['action']) && $_GET['action'] == 'changeClientDatas'){
			include('admin/admin_parts/form_changeClientDatas.php');
		}

		else if(isset($_GET['action']) && $_GET['action'] == 'transferMoney'){
			include('admin/admin_parts/form_moneyTransfer.php');
		}

		else if(isset($_GET['action']) && $_GET['action'] == 'showAgenda'){
			include('admin/admin_parts/form_showAgenda.php');
		}

		else{
			echo("Merci de choisir un action valide");
		}
	}

	else{
		if(isset($_GET['clientID']) && !empty($_GET['clientID'])){
			echo 'Ce client n\'éxiste pas dans la base de donnée';
		}
		include('admin/admin_parts/form_clientID.php');
	}
}

function getClientDatas($id){
	$db = quickConnectDb();
	$clientDatas = mysql_query('SELECT * FROM clients WHERE id_client="' . $id . '"');
	mysql_close($db);

	if(mysql_num_rows($clientDatas) != 0){
		return mysql_fetch_array($clientDatas);
	}

	return null;
}

?>
