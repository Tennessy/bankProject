<?php

?>

<form method="get" action="admin.php" name="form_searchEmployeeById" id="form_searchEmployeeById" class="form_admin">
	<fieldset>
	<legend>Rechercher par id</legend>
	<p> <input type="hidden" name="action" value="aboutEmployee">
	</p>
	<p> <label for="input_searchEmployeeById">ID Employé : </label> <input type="text" name="idEmployee" required="required" value="<?php if (isset($_GET['idEmployee'])) echo $_GET['idEmployee']; ?>" id="input_searchEmployeeById" />
	</p>
	<p> <input type="submit" value="Envoyer" name="" /> <input type="reset" value="Réinitialiser" />
	</p>
	</fieldset>
</form>

<?php

if (
	(isset($_GET['idEmployee']) && !empty($_GET['idEmployee']))
) {

	if ($queryDB) {
		$id_shDB = quickConnectDB();
		if ($id_shDB != NULL) {
			$query = sprintf("SELECT * FROM `employees` WHERE `id_employee` = '%s'", mysql_real_escape_string($_GET['idEmployee']));
			$rep = mysql_query($query);
			if (mysql_num_rows($rep) != 0) {
				$result = mysql_fetch_array($rep);
				echo '<p>Nom : ' . htmlentities($result['lastName'], ENT_COMPAT, 'UTF-8') . ' Prénom : ' . htmlentities($result['firstName'], ENT_COMPAT, 'UTF-8') . '</p>';
				echo '<p>Login : ' . $result['login'] . ' Catégorie : ' . $result['category'] . '</p>';
			} else {
				echo 'Aucun employé ne correspond à l\'id #' . htmlentities($_GET['idEmployee'], ENT_COMPAT, 'UTF-8') . '.';
			}
			mysql_close($id_shDB);
		}
	}

} else {
	$incompleteForm = TRUE;
}

?>
