<?php

if (isset($_POST['toDelete'])) {
	$id_shDB = quickConnectDB();
	if ($id_shDB != null) {
		$toDeleteTab = $_POST['toDelete']; 
		for ($i = 0; $i < count($toDeleteTab); $i++) {
			$query = sprintf("UPDATE `accounts-type` SET `available` = '0' WHERE `id_account-type` = '%s'",
			mysql_real_escape_string($toDeleteTab[$i]));
			$validQuery = mysql_query($query);
			if ($validQuery) {
				echo showFormSuccess('Suppression réussie, ID type compte : #' . htmlentities($toDeleteTab[$i], ENT_COMPAT, 'UTF-8'));
			}
		}
		mysql_close($id_shDB);
	}
}

if ($queryDB) {
	$id_shDB = quickConnectDB();
	if ($id_shDB != NULL) {
		$query = sprintf("SELECT * FROM `accounts-type` WHERE `available` = '1';");
		$rep = mysql_query($query);
		if (mysql_num_rows($rep) != 0) {
			echo'
				<form method="post" action="admin.php?action=deleteAccountType" name="form_deleteAccountType" id="form_deleteAccountType" class="form_admin">
					<fieldset>
						<legend>Liste des types de compte</legend>
						<table class="table_deleteAccountType">
							<tr>
								<td>Supprimer ?</td>
								<td>Nom</td>
								<td>Documents requis</td>
							</tr>
				';
			while ($result = mysql_fetch_array($rep)) {
				echo '<tr>';
				echo '<td><input type="checkbox" name="toDelete[]" value="' . $result['id_account-type'] . '" /></td>';
				echo '<td>' . htmlentities($result['name'], ENT_COMPAT, 'UTF-8') . '</td>';
				echo '<td>' . htmlentities($result['documentsRequired'], ENT_COMPAT, 'UTF-8') . '</td>';
				echo '</tr>';
			}
			echo'
						</table>
						<p> <input type="submit" value="Supprimer" name="post_deleteAccountType" />
							<input type="reset" value="Réinitialiser" />
						</p>
					</fieldset>
				</form>
			';
		} else {
			echo showFormError('', 'Aucun type de compte disponible dans la base de données.');
		}
		mysql_close($id_shDB);
	}
}

?>