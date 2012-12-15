<?php

if (
	(isset($_POST['input_addEmployee_login']) && !empty($_POST['input_addEmployee_login'])) &&
	(isset($_POST['input_addEmployee_passwd']) && !empty($_POST['input_addEmployee_passwd'])) &&
	(isset($_POST['input_addEmployee_category']) && !empty($_POST['input_addEmployee_category'])) &&
	(isset($_POST['input_addEmployee_lastName']) && !empty($_POST['input_addEmployee_lastName'])) &&
	(isset($_POST['input_addEmployee_firstName']) && !empty($_POST['input_addEmployee_lastName']))
) {

	if (preg_match('#[^a-zA-Z0-9.\-]#', $_POST['input_addEmployee_login'])) {
		// Si un caractère autre que des lettres [a-zA-Z], des chiffres [0-9] ou un [.],
		// est trouvé dans le login alors on affiche un message d'erreur.
		echo showFormError('Login', 'Les caractères spéciaux ne sont pas autorisés.');
		$queryDB = FALSE;
	}
	if (!($_POST['input_addEmployee_category'] == 'A' || $_POST['input_addEmployee_category'] == 'C')) {
		echo showFormError('Catégorie', 'DO NOT HACK ME !');
		$queryDB = FALSE;
	}

	if ($queryDB) {
		$hPasswd = sha1($_POST['input_addEmployee_passwd']);
		$id_shDB = quickConnectDB();
		echo $id_shDB;
		if ($id_shDB) {
			$query = sprintf("INSERT INTO `employees`(`id_employee`, `login`, `hPasswd`, `category`, `lastName`, `firstName`) VALUES ('', '%s', '{$hPasswd}', '%s', '%s', '%s');",
				mysql_real_escape_string($_POST['input_addEmployee_login']),
				mysql_real_escape_string($_POST['input_addEmployee_category']),
				mysql_real_escape_string($_POST['input_addEmployee_lastName']),
				mysql_real_escape_string($_POST['input_addEmployee_firstName']));
			$validQuery = mysql_query($query);
			if ($validQuery) {
				echo showFormSuccess('Ajout réussi');
			}
			mysql_close($id_shDB);
		}
	}

} else {
	$incompleteForm = TRUE;
}

?>

<form method="post" action="admin.php?action=addEmployee" name="form_addEmployee" id="form_addEmployee" class="form_admin">
	<fieldset>
		<legend>Nouvel employé</legend>
		<p> <label for="input_addEmployee_lastName">Nom : </label>
			<input type="text" name="input_addEmployee_lastName" required="required" value="<?php if ($incompleteForm && isset($_POST['input_addEmployee_lastName'])) echo $_POST['input_addEmployee_lastName']; ?>" id="input_addEmployee_lastName" />
		</p>
		<p> <label for="input_addEmployee_firstName">Prénom : </label>
			<input type="text" name="input_addEmployee_firstName" required="required" value="<?php if ($incompleteForm && isset($_POST['input_addEmployee_firstName'])) echo $_POST['input_addEmployee_firstName']; ?>" id="input_addEmployee_firstName" />
		</p>
		<p> <label for="input_addEmployee_category">Catégorie : </label>
			<input type="radio" name="input_addEmployee_category" value="A"
			<?php
				if ($incompleteForm && isset($_POST['input_addEmployee_category'])) {
					if ($_POST['input_addEmployee_category'] == 'A') {
						echo 'checked="yes"';
					}
				} else {
					echo 'checked="yes"';
				}
			?>
			>Agent
			<input type="radio" name="input_addEmployee_category" value="C"
			<?php
				if ($incompleteForm && isset($_POST['input_addEmployee_category'])) {
					if ($_POST['input_addEmployee_category'] == 'C') {
						echo 'checked="yes"';
					}
				}
			?>
			>Conseiller
		</p>
		<p> <label for="input_addEmployee_login">Login : </label>
			<input type="text" name="input_addEmployee_login" required="required" id="input_addEmployee_login" />
		</p>
		<p> <label for="input_addEmployee_passwd">Mot de passe : </label>
			<input type="password" name="input_addEmployee_passwd" required="required" id="input_addEmployee_passwd" />
		</p>
		<p> <input type="submit" value="Envoyer" name="post_addEmployee" />
			<input type="reset" value="Réinitialiser" />
		</p>
	</fieldset>
</form>
