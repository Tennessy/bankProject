<?php
	
	echo '<div id="side_nav">';
	echo '<p>Menu : </p>';
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
		echo 	'<li><a href="admin.php?action=addEmployee">Ajouter un employé</a></li>';
		echo 	'<li><a href="admin.php?action=aboutEmployee">Infos employé</a></li>';
		echo '</ul>';
	}
	echo '</div>';

?>
