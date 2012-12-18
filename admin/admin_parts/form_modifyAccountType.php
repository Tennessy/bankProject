<?php

if (
	(isset($_POST['input_modifyAccountType_name']) && !empty($_POST['input_modifyAccountType_name'])) &&
	(isset($_POST['input_modifyAccountType_documentsRequired']) && !empty($_POST['input_modifyAccountType_documentsRequired']))
) {

	if ($queryDB) {
		$id_shDB = quickConnectDB();
		if ($id_shDB != NULL) {
			$query = sprintf("UPDATE `accounts-type` SET `name`='%s', `documentsRequired`='%s' WHERE `id_account-type`='%s'",
				mysql_real_escape_string($_POST['input_modifyAccountType_name']),
				mysql_real_escape_string($_POST['input_modifyAccountType_documentsRequired']),
				mysql_real_escape_string($_POST['input_modifyAccountType_id_account-type']));
			$validQuery = mysql_query($query);
			if ($validQuery) {
				echo showFormSuccess('Modification réussie');
			}
			mysql_close($id_shDB);
		}
	}

}

if ($queryDB) {
	$id_shDB = quickConnectDB();
	if ($id_shDB != NULL) {
		$query = sprintf("SELECT * FROM `accounts-type` WHERE `available` = '1';");
		$rep = mysql_query($query);
		if (mysql_num_rows($rep) != 0) {
			echo'
				<form method="post" action="admin.php?action=modifyAccountType" name="form_modifyAccountType" id="form_modifyAccountType" class="form_admin">
					<fieldset>
						<legend>Liste des types de compte</legend>
						<table class="table_modifyAccountType">
							<tr>
								<td>Nom</td>
								<td>Documents requis</td>
							</tr>
				';
			while ($result = mysql_fetch_array($rep)) {
				echo '<tr>';
				echo '<td><a href="admin.php?action=modifyAccountType&id_account-type=' . $result['id_account-type'] . '">' . htmlentities($result['name'], ENT_COMPAT, 'UTF-8') . '</a></td>';
				echo '<td>' . htmlentities($result['documentsRequired'], ENT_COMPAT, 'UTF-8') . '</td>';
				echo '</tr>';
			}
			echo'
						</table>
					</fieldset>
				</form>
			';
		} else {
			echo showFormError('', 'Aucun type de compte dans la base de données.');
		}
		mysql_close($id_shDB);
	}
}

if (isset($_GET['id_account-type'])) {
	if($queryDB) {
		$id_shDB = quickConnectDB();
		if ($id_shDB != NULL) {
			$query = sprintf("SELECT * FROM `accounts-type` WHERE `id_account-type` = '%s';",
				mysql_real_escape_string($_GET['id_account-type']));
			$rep = mysql_query($query);
			if (mysql_num_rows($rep) != 0) {
				$result = mysql_fetch_array($rep);
				echo'
				<form method="post" action="admin.php?action=modifyAccountType" name="form_modifyAccountType" id="form_modifyAccountType" class="form_admin">
					<fieldset>
						<legend>Modifier un type de compte</legend>
						<p> <label for="input_modifyAccountType_name">Nom : </label> <input type="text" name="input_modifyAccountType_name" required="required" value="' . $result['name'] . '" id="input_modifyAccountType_name" />
						</p>
						<p> <label for="input_modifyAccountType_documentsRequired">Documents requis : </label> <textarea rows="5" name="input_modifyAccountType_documentsRequired" required="required" id="input_modifyAccountType_documentsRequired" />' . $result['documentsRequired'] . '</textarea>
						</p>
						<p> <input type="hidden" value="' . htmlentities($_GET['id_account-type'], ENT_COMPAT, 'UTF-8') . '" name="input_modifyAccountType_id_account-type" />
							<input type="submit" value="Modifier" name="post_modifyAccountType" /> <input type="reset" value="Réinitialiser" />
						</p>
					</fieldset>
				</form>
				';
			}
			mysql_close($id_shDB);
		}
	}
}

?>