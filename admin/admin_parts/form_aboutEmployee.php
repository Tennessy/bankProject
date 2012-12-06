<?php

if(
	(isset($_GET['idEmployee']) && !empty($_GET['idEmployee']))
) {

	if ($queryDB) {
		$id_shDB = quickConnectDB();
		if ($id_shDB != NULL) {
			$query = sprintf("SELECT * FROM `employees` WHERE `id_employee` = '%s'", mysql_real_escape_string($_GET['idEmployee']));
			$rep = mysql_query($query);
			if (mysql_num_rows($rep) != 0) {
				$result = mysql_fetch_array($rep);
				echo '<p>Nom : ' . htmlentities($result['lastName']) . ' Prénom : ' . htmlentities($result['firstName']) . '</p>';
				echo '<p>Login : ' . $result['login'] . ' Catégorie : ' . $result['category'] . '</p>';
			}
			mysql_close($id_shDB);
		}
	}

} else {
	$incompleteForm = TRUE;
}

?>