<?php
	
	echo '<div id="side_nav">';
	echo '<p>Menu : <br />';
	if ($_SESSION['category'] == 'agent') {

		if(isset($_GET['clientID']))
			$clientID=$_GET['clientID'];
		else
			$clientID='';

		echo '<ul>';
		echo 	'<li><a href="admin.php">Choisir un client</a></li>';
		echo 	'<li><a href="admin.php?action=showClientDatas&clientID='.$clientID.'">Consulter la fiche client</a></li>';
		echo 	'<li><a href="admin.php?action=changeClientDatas&clientID='.$clientID.'">Modifier la fiche client</a></li>';
		echo '</ul>';
	}

	if ($_SESSION['category'] == 'conseiller') {
		echo '<ul>';
		echo '</ul>';
	}

	if ($_SESSION['category'] == 'directeur') {
		echo '<b>Employé</b>';
		echo '<ul>';
		echo 	'<li><a href="admin.php?action=addEmployee">Ajouter un employé</a></li>';
		echo 	'<li><a href="admin.php?action=aboutEmployee">Infos employé</a></li>';
		echo '</ul>';
		echo '<b>Comptes et Contrats</b>';
		echo '<ul>';
		echo 	'<li><a href="admin.php?action=addAccountType">Ajouter un type de compte</a></li>';
		echo 	'<li><a href="admin.php?action=addContractType">Ajouter un type de contrat</a></li>';
		echo '</ul>';
	}
	echo '</p>';
	echo '</div>';

?>
