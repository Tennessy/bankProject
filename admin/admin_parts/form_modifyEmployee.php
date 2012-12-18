<?php

if (
	(isset($_POST['input_modifyEmployee_login']) && !empty($_POST['input_modifyEmployee_login'])) &&
	(isset($_POST['input_modifyEmployee_category']) && !empty($_POST['input_modifyEmployee_category'])) &&
	(isset($_POST['input_modifyEmployee_lastName']) && !empty($_POST['input_modifyEmployee_lastName'])) &&
	(isset($_POST['input_modifyEmployee_firstName']) && !empty($_POST['input_modifyEmployee_lastName']))
) {

	if (preg_match('#[^a-zA-Z0-9.\-]#', $_POST['input_modifyEmployee_login'])) {
		// Si un caractère autre que des lettres [a-zA-Z], des chiffres [0-9] ou un [.],
		// est trouvé dans le login alors on affiche un message d'erreur.
		echo showFormError('Login', 'Les caractères spéciaux ne sont pas autorisés.');
		$queryDB = FALSE;
	}
	if (!($_POST['input_modifyEmployee_category'] == 'A' || $_POST['input_modifyEmployee_category'] == 'C')) {
		echo showFormError('Catégorie', 'DO NOT HACK ME !');
		$queryDB = FALSE;
	}

	// Test si le login est déjà existant
	$id_shDB = quickConnectDB();
	if ($id_shDB != NULL) {
		$query = sprintf("SELECT * FROM `employees` WHERE `login` = '%s'",
		mysql_real_escape_string($_POST['input_modifyEmployee_login']));
		$rep = mysql_query($query);
		if (mysql_num_rows($rep) != 0) {
			echo showFormError('Login', 'Déjà existant, changez de login');
			$queryDB = FALSE;
		}
		mysql_close($id_shDB);
	}

	if ($queryDB) {
		$hPasswd = sha1($_POST['input_modifyEmployee_passwd']);
		$id_shDB = quickConnectDB();
		if ($id_shDB) {
			if (isset($_POST['input_modifyEmployee_passwd']) && !empty($_POST['input_modifyEmployee_passwd'])) {
				$query = sprintf("UPDATE `employees` SET `login`='%s', `hPasswd`='{$hPasswd}', `category`='%s', `lastName`='%s', `firstName`='%s' WHERE `id_employee`='%s';",
				mysql_real_escape_string($_POST['input_modifyEmployee_login']),
				mysql_real_escape_string($_POST['input_modifyEmployee_category']),
				mysql_real_escape_string($_POST['input_modifyEmployee_lastName']),
				mysql_real_escape_string($_POST['input_modifyEmployee_firstName']),
				mysql_real_escape_string($_POST['input_modifyEmployee_id_employee']));
			} else {
				$query = sprintf("UPDATE `employees` SET `login`='%s', `category`='%s', `lastName`='%s', `firstName`='%s' WHERE `id_employee`='%s';",
				mysql_real_escape_string($_POST['input_modifyEmployee_login']),
				mysql_real_escape_string($_POST['input_modifyEmployee_category']),
				mysql_real_escape_string($_POST['input_modifyEmployee_lastName']),
				mysql_real_escape_string($_POST['input_modifyEmployee_firstName']),
				mysql_real_escape_string($_POST['input_modifyEmployee_id_employee']));
			}
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
		$query = sprintf("SELECT * FROM `employees`;");
		$rep = mysql_query($query);
		if (mysql_num_rows($rep) != 0) {
			echo'
				<form method="post" action="admin.php?action=modifyEmployee" name="form_modifyEmployee" id="form_modifyEmployee" class="form_admin">
					<fieldset>
						<legend>Liste des types de compte</legend>
						<table class="table_modifyEmployee">
							<tr>
								<td>ID</td>
								<td>Nom</td>
								<td>Prénom</td>
								<td>Catégorie</td>
							</tr>
				';
			while ($result = mysql_fetch_array($rep)) {
				echo '<tr>';
				echo '<td><a href="admin.php?action=modifyEmployee&id_employee=' . $result['id_employee'] . '">' . $result['id_employee'] . '</a></td>';
				echo '<td>' . htmlentities($result['lastName'], ENT_COMPAT, 'UTF-8') . '</td>';
				echo '<td>' . htmlentities($result['firstName'], ENT_COMPAT, 'UTF-8') . '</td>';
				echo '<td>';
				if ($result['category'] == 'A') {
					echo 'Agent';
				}
				if ($result['category'] == 'C') {
					echo 'Conseiller';
				}
				if ($result['category'] == 'D') {
					echo 'Directeur';
				}
				echo '</td>';
				echo '</tr>';
			}
			echo'
						</table>
					</fieldset>
				</form>
			';
		} else {
			echo showFormError('', 'Aucun employé dans la base de données.');
		}
		mysql_close($id_shDB);
	}
}

if (isset($_GET['id_employee'])) {
	if($queryDB) {
		$id_shDB = quickConnectDB();
		if ($id_shDB != NULL) {
			$query = sprintf("SELECT * FROM `employees` WHERE `id_employee` = '%s';",
				mysql_real_escape_string($_GET['id_employee']));
			$rep = mysql_query($query);
			if (mysql_num_rows($rep) != 0) {
				$result = mysql_fetch_array($rep);
				echo'
				<form method="post" action="admin.php?action=modifyEmployee" name="form_modifyEmployee" id="form_modifyEmployee" class="form_admin">
					<fieldset>
						<legend>Nouvel employé</legend>
						<p> <label for="input_modifyEmployee_lastName">Nom : </label>
							<input type="text" name="input_modifyEmployee_lastName" required="required" value="' . $result['lastName'] .'" id="input_modifyEmployee_lastName" />
						</p>
						<p> <label for="input_modifyEmployee_firstName">Prénom : </label>
							<input type="text" name="input_modifyEmployee_firstName" required="required" value="' . $result['firstName'] .'" id="input_modifyEmployee_firstName" />
						</p>
						<p> <label for="input_modifyEmployee_category">Catégorie : </label>
							<input type="radio" name="input_modifyEmployee_category" value="A"
				';
								if ($result['category'] == 'A') {
									echo 'checked="yes"';
								}
				echo'
							>Agent
							<input type="radio" name="input_modifyEmployee_category" value="C"
				';
								if ($result['category'] == 'C') {
									echo 'checked="yes"';
								}
				echo'
							>Conseiller
						</p>
						<p> <label for="input_modifyEmployee_login">Login : </label>
							<input type="text" name="input_modifyEmployee_login" value="' . $result['login'] .'" required="required" id="input_modifyEmployee_login" />
						</p>
						<p> <label for="input_modifyEmployee_passwd">Mot de passe : </label>
							<input type="password" name="input_modifyEmployee_passwd" id="input_modifyEmployee_passwd" />
						</p>
						<p> <input type="hidden" value="' . htmlentities($_GET['id_employee'], ENT_COMPAT, 'UTF-8') . '" name="input_modifyEmployee_id_employee" />
							<input type="submit" value="Envoyer" name="post_modifyEmployee" />
							<input type="reset" value="Réinitialiser" />
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
