<form method="get" action="admin.php" name="form_searchClientById" id="form_searchClientById" class="form_admin">
	<fieldset>
	<legend>Rechercher par id</legend>
	<p> <input type="hidden" name="action" value="deleteContract">
	</p>
	<p> <label for="input_searchClientById">ID Client :</label> <input type="text" name="idClient" required="required" value="<?php if (isset($_GET['idClient'])) echo $_GET['idClient']; ?>" id="input_searchClientById" />
	</p>
	<p> <input type="submit" value="Envoyer" name="" /> <input type="reset" value="Réinitialiser" />
	</p>
	</fieldset>
</form>

<form method="get" action="admin.php" name="form_searchClientByName" id="form_searchClientByName" class="form_admin">
	<fieldset>
	<legend>Rechercher par nom, prénom</legend>
	<p> <input type="hidden" name="action" value="deleteContract">
	</p>
	<p> <label for="input_searchClientByName_lastName">Nom :</label> <input type="text" name="lastName" value="<?php if (isset($_GET['lastName'])) echo $_GET['lastName']; ?>" id="input_searchClientByName_lastName" />
	</p>
	<p> <label for="input_searchClientByName_firstName">Prénom :</label> <input type="text" name="firstName" value="<?php if (isset($_GET['firstName'])) echo $_GET['firstName']; ?>" id="input_searchClientByName_firstName" />
	</p>
	<p> <input type="submit" value="Rechercher" name="" /> <input type="reset" value="Réinitialiser" />
	</p>
	</fieldset>
</form>

<?php

if (
	(isset($_GET['idClient']) && !empty($_GET['idClient']))
) {

	if ($queryDB) {
		$id_shDB = quickConnectDB();
		if ($id_shDB != NULL) {
			$query = sprintf("SELECT * FROM `clients` WHERE `id_client` = '%s'", mysql_real_escape_string($_GET['idClient']));
			$rep = mysql_query($query);
			if (mysql_num_rows($rep) != 0) {
				$query = sprintf("SELECT * FROM `contracts` WHERE `id_owner` = '%s'", mysql_real_escape_string($_GET['idClient']));
				$rep = mysql_query($query);
				if (mysql_num_rows($rep) != 0) {
					echo'
						<form method="post" action="admin.php?action=deleteContract" name="form_deleteContract" id="form_deleteContract" class="form_admin">
							<fieldset>
								<legend>Résilier un contrat</legend>
								<table class="table_deleteContract">
									<tr>
										<td>Résilier</td>
										<td>Nom</td>
										<td>Date d\'ouverture</td>
										<td>Coût mensuel</td>
									</tr>
						';
					while ($result = mysql_fetch_array($rep)) {
						$query = sprintf("SELECT * FROM `contracts-type` WHERE `id_contract-type` = '%s'", $result['contract-type']);
						$rep2 = mysql_query($query);
						if (mysql_num_rows($rep2) != 0) {
							$result2 = mysql_fetch_array($rep2);
							echo '<tr>';
							echo '<td><input type="checkbox" name="toDelete[]" value="' . $result['id_contract'] . '" /></td>';
							echo '<td>' . htmlentities($result2['name'], ENT_COMPAT, 'UTF-8') . '</td>';
							echo '<td>' . htmlentities($result['openingDate'], ENT_COMPAT, 'UTF-8') . '</td>';
							echo '<td>' . htmlentities($result2['monthlyCost'], ENT_COMPAT, 'UTF-8') . '</td>';
							echo '</tr>';
						}
					}
					echo'
								</table>
								<p> <input type="hidden" name="idClient" value="' . $_GET['idClient'] . '" />
									<input type="submit" value="Supprimer" name="post_deleteContract" />
									<input type="reset" value="Réinitialiser" />
								</p>
							</fieldset>
						</form>
					';
				} else {
					echo showFormError('', 'Aucun contrat dans la base de donnée');
				}
			} else {
				echo showFormError('ID Client', 'Aucun client ne correspond à cet ID');
			}
			mysql_close($id_shDB);
		}
	}

} else {
	if (isset($_GET['lastName']) || isset($_GET['firstName'])) {
		if ($queryDB) {
			$id_shDB = quickConnectDB();
			if ($id_shDB != null) {
				$query = "SELECT * FROM `clients` WHERE lower(concat_ws(' ', `lastName`, `firstName`)) LIKE lower('%" . mysql_real_escape_string($_GET['lastName']). "% %" . mysql_real_escape_string($_GET['firstName']) . "%');";
				$rep = mysql_query($query);
				if (mysql_num_rows($rep) != 0) {
					echo'
						<form class="form_admin">
							<fieldset>
								<legend>Résultat de la recherche</legend>
								<table class="table_searchClient">
									<tr>
										<td>ID</td>
										<td>Nom</td>
										<td>Prénoms</td>
										<td>Ville</td>
									</tr>
						';
					while ($result = mysql_fetch_array($rep)) {
						echo '<tr>';
						echo '<td><a href="admin.php?action=deleteContract&idClient=' . $result['id_client'] . '">' . $result['id_client'] . '</a>' . '</td><td>' . $result['lastName'] . '</td><td>' . $result['firstName'] . ' ' . $result['secondName'] . ' ' . $result['thirdName'] . '</td><td>' . $result['address_city'] . '</td>';
						echo '</tr>';
					}
					echo'
								</table>
							</fieldset>
						</form>
					';
				}
				mysql_close($id_shDB);
			}
		}
	} else {
		$incompleteForm = TRUE;
	}
}

if (isset($_POST['toDelete']) && isset($_POST['idClient'])) {
	$id_shDB = quickConnectDB();
	if ($id_shDB != null) {
		$toDeleteTab = $_POST['toDelete']; 
		for ($i = 0; $i < count($toDeleteTab); $i++) {
			$query = sprintf("DELETE FROM `contracts` WHERE `id_contract` = '%s'",
			mysql_real_escape_string($toDeleteTab[$i]));
			$validQuery = mysql_query($query);
			if ($validQuery) {
				echo showFormSuccess('Suppression réussie, ID client : #' . htmlentities($_POST['idClient'], ENT_COMPAT, 'UTF-8') . ', ID type contrat : #' . htmlentities($toDeleteTab[$i], ENT_COMPAT, 'UTF-8'));
			}
		}
		mysql_close($id_shDB);
	}
}

?>