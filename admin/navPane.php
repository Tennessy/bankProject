<?php

	if ($_SESSION['category'] == 'agent') {
		echo '<ul>';
		echo '</ul>';
	}

	if ($_SESSION['category'] == 'conseiller') {
		echo '<ul>';
		echo '</ul>';
	}

	if ($_SESSION['category'] == 'directeur') {
		echo '<ul>';
		echo 	'<li><a href="admin.php?show=addEmployee">Ajouter un employé</a></li>';
		echo '</ul>';
	}

?>