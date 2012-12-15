<?php

$dataName = array('id client', 'id employee', 'Nom', 'Prenom', 'Deuxième prenom', 'Troisième prenom', 'Date de naissance', 'Genre', 'Emploi', 'Status civil', 'Adresse', 'Ville', 'Code postal', 'Etat', 'Numero de Telephone', 'Numero de portable', 'Email');

if($_SESSION['category'] == 'agent'){
	if(isset($_GET['clientID']) && !empty($_GET['clientID'])){

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
