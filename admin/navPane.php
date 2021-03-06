<?php

	echo '<div id="side_nav">';
	echo '<p id="nav_menu">Menu</p>';
	echo '<p>';


	if (isset($_SESSION['category'])) {
		if ($_SESSION['category'] == 'agent') {

			if(isset($_GET['clientID']) && !empty($_GET['clientID']))
				$clientID=$_GET['clientID'];
			else
				$clientID = '';
			echo '<b>Client</b>';
			echo '<ul>';
			echo 	'<li><a href="admin.php">Choisir un client</a></li>';
			echo 	'<li><a href="admin.php?action=showClientDatas&clientID='.$clientID.'">Consulter la fiche client</a></li>';
			echo 	'<li><a href="admin.php?action=changeClientDatas&clientID='.$clientID.'">Modifier la fiche client</a></li>';
			echo 	'<li><a href="admin.php?action=transferMoney&clientID='.$clientID.'">Dépot/Retrait</a></li>';
			echo '</ul>';
			echo '<b>Agenda</b>';
			echo '<ul>';
			echo 	'<li><a href="admin.php?action=showAgenda&clientID='.$clientID.'">Prendre rendez-vous</a></li>';
			echo '</ul>';
		}

		if ($_SESSION['category'] == 'conseiller') {
			echo '<b>Client</b>';
			echo '<ul>';
			echo 	'<li><a href="admin.php?action=addClient">Ajouter un client</a></li>';
			echo 	'<li><a href="admin.php?action=sellContract">Vendre un contrat</a></li>';
			echo 	'<li><a href="admin.php?action=openAccount">Ouvrir un compte</a></li>';
			echo 	'<li><a href="admin.php?action=modifyOverdraft">Modifier le découvert</a></li>';
			echo 	'<li><a href="admin.php?action=deleteContract">Résilier un contrat</a></li>';
			echo 	'<li><a href="admin.php?action=deleteAccount">Résilier un compte</a></li>';
			echo '</ul>';
			echo '<b>Agenda</b>';
			echo '<ul>';
			echo 	'<li><a href="admin.php?action=showAgenda">Planning</a></li>';
			echo '</ul>';
		}

		if ($_SESSION['category'] == 'directeur') {
			echo '<b>Employé</b>';
			echo '<ul>';
			echo 	'<li><a href="admin.php?action=addEmployee">Ajouter un employé</a></li>';
			echo 	'<li><a href="admin.php?action=modifyEmployee">Modifier un employé</a></li>';
			echo '</ul>';
			echo '<b>Comptes et Contrats</b>';
			echo '<ul>';
			echo 	'<li><a href="admin.php?action=addAccountType">Ajouter un type de compte</a></li>';
			echo 	'<li><a href="admin.php?action=addContractType">Ajouter un type de contrat</a></li>';
			echo 	'<li><a href="admin.php?action=modifyAccountType">Modifier un type de compte</a></li>';
			echo 	'<li><a href="admin.php?action=modifyContractType">Modifier un type de contrat</a></li>';
			echo 	'<li><a href="admin.php?action=deleteAccountType">Supprimer un type de compte</a></li>';
			echo 	'<li><a href="admin.php?action=deleteContractType">Supprimer un type de contrat</a></li>';
			echo '</ul>';
			echo '<b>Statistiques</b>';
			echo '<ul>';
			echo 	'<li><a href="admin.php?action=stats">Afficher</a></li>';
			echo '</ul>';
		}
	}

	echo '</p>';
	echo '</div>';

?>
