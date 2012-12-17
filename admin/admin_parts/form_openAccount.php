<form method="get" action="admin.php" name="form_searchClientById" id="form_searchClientById" class="form_admin">
	<fieldset>
	<legend>Rechercher par id</legend>
	<p> <input type="hidden" name="action" value="openAccount">
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
	<p> <input type="hidden" name="action" value="openAccount">
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
				$query = "SELECT * FROM `accounts-type` WHERE `available`='1'";
				$rep = mysql_query($query);
				if (mysql_num_rows($rep) != 0) {
					echo'
						<form method="post" action="admin.php?action=openAccount" name="form_openAccount" id="form_openAccount" class="form_admin">
							<fieldset>
								<legend>Ouvrir un/des compte(s)</legend>
								<table class="table_openAccount">
									<tr>
										<td>Ouvrir</td>
										<td>Nom</td>
										<td>Document(s) requi(s)</td>
										<td>Montant initial</td>
										<td>Découvert autorisé</td>
									</tr>
						';
					while ($result = mysql_fetch_array($rep)) {
						echo '<tr>';
						echo '<td><input type="checkbox" name="toOpen[]" value="' . $result['id_account-type'] . '" /></td>';
						echo '<td>' . htmlentities($result['name'], ENT_COMPAT, 'UTF-8') . '</td>';
						echo '<td>' . htmlentities($result['documentsRequired'], ENT_COMPAT, 'UTF-8') . '</td>';
						echo '<td><input type="text" name="form_openAccount_balance' . $result['id_account-type'] . '" value="" id="form_openAccount_balance' . $result['id_account-type'] . '" class="table_input"></td>';
						echo '<td><input type="text" name="form_openAccount_overdraft' . $result['id_account-type'] . '" value="" id="form_openAccount_overdraft' . $result['id_account-type'] . '" class="table_input"></td>';
						echo '</tr>';
					}
					echo'
								</table>
								<p> <input type="hidden" name="idClient" value="' . $_GET['idClient'] . '" />
									<input type="submit" value="Vendre" name="post_addEmployee" />
									<input type="reset" value="Réinitialiser" />
								</p>
							</fieldset>
						</form>
					';
				} else {
					echo showFormError('', 'Aucun type de compte disponible dans la base de données.');
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
						echo '<td><a href="admin.php?action=openAccount&idClient=' . $result['id_client'] . '">' . $result['id_client'] . '</a>' . '</td><td>' . $result['lastName'] . '</td><td>' . $result['firstName'] . ' ' . $result['secondName'] . ' ' . $result['thirdName'] . '</td><td>' . $result['address_city'] . '</td>';
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

if (isset($_POST['toOpen']) && isset($_POST['idClient'])) {
	$id_shDB = quickConnectDB();
	if ($id_shDB != null) {
		$toOpenTab = $_POST['toOpen']; 
		for ($i = 0; $i < count($toOpenTab); $i++) {
			if (!empty($_POST['form_openAccount_balance' . $toOpenTab[$i]]) && !empty($_POST['form_openAccount_overdraft' . $toOpenTab[$i]])) {
				if (ctype_digit($_POST['form_openAccount_balance' . $toOpenTab[$i]]) && ctype_digit($_POST['form_openAccount_overdraft' . $toOpenTab[$i]])) {
					$query = sprintf("INSERT INTO `accounts`(`id_account`, `id_owner`, `account-type`, `openingDate`, `balance`, `overdraft`) VALUES ('', '%s', '%s', now(), '%s', '%s');",
					mysql_real_escape_string($_POST['idClient']),
					mysql_real_escape_string($toOpenTab[$i]),
					(int) ($_POST['form_openAccount_balance' . $toOpenTab[$i]]),
					(int) ($_POST['form_openAccount_overdraft' . $toOpenTab[$i]]));
					$validQuery = mysql_query($query);
					if ($validQuery) {
						echo showFormSuccess('Ajout réussi, ID client : #' . htmlentities($_POST['idClient'], ENT_COMPAT, 'UTF-8') . ', ID type contrat : #' . htmlentities($toOpenTab[$i], ENT_COMPAT, 'UTF-8'));
					}
				} else {
					echo showFormError('Ouverture d\'un compte', 'N\'insérez que des chiffres.');
				}
			} else {
				echo showFormError('Ouverture d\'un compte', 'Entrez des valeurs pour le(s) coompte(s).');
			}
		}
		mysql_close($id_shDB);
	}
}

?>
