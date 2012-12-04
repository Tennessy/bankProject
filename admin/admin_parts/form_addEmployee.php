<?php

if(
	(isset($_POST['input_addEmployee_login']) && !empty($_POST['input_addEmployee_login'])) &&
	(isset($_POST['input_addEmployee_passwd']) && !empty($_POST['input_addEmployee_passwd'])) &&
	(isset($_POST['input_addEmployee_category']) && !empty($_POST['input_addEmployee_category'])) &&
	(isset($_POST['input_addEmployee_lastName']) && !empty($_POST['input_addEmployee_lastName'])) &&
	(isset($_POST['input_addEmployee_firstName']) && !empty($_POST['input_addEmployee_lastName']))
) {

	if (preg_match('#[^a-zA-Z0-9.]#', $_POST['input_addEmployee_login'])) {
		// Si un caractère autre que des lettres [a-zA-Z], des chiffres [0-9] ou un [.],
		// est trouvé dans le login alors on affiche un message d'erreur.
		showFormError('Login', 'Les caractères spéciaux ne sont pas autorisés.');
		$noFormError = FALSE;
	}
	if ($_POST['input_addEmployee_category'] == 'A' || $_POST['input_addEmployee_category'] == 'C') {
		showFormError('Catégorie', 'Inconnu');
		$noFormError = FALSE;
	}
	if ($noFormError) {
		$hPasswd = sha1($_POST['input_addEmployee_passwd']);
		$id_shDB = mysql_connect($serverHostDB, $serverUserDB, $serverPasswdDB);
		if (!$id_shDB) {
			echo 'Erreur de connexion au serveur de la base de données.';
		} else {
			$id_nDB = mysql_select_db($nameDB);
			if (!$id_nDB) {
				echo 'Erreur de connexion à la base de données.';
			} else {
				$query = sprintf("INSERT INTO `employees`(`id_employee`, `login`, `hPasswd`, `category`, `lastName`, `firstName`) VALUES ('', '%s', '{$hPasswd}', '{$category}', '%s', '%s')",
					mysql_real_escape_string($_POST['input_addEmployee_login']),
					mysql_real_escape_string($_POST['input_addEmployee_lastName']),
					mysql_real_escape_string($_POST['input_addEmployee_firstName']));
				mysql_query($query);
			}
			mysql_close($id_shDB);
		}
	}

}

?>

<fieldset>
		<legend>Ajouter un employé</legend>
		<form method="post" action="admin.php?show=addEmployee" name="form_addEmployee" id="form_addEmployee">
			<p> <label for="input_addEmployee_login">Login : </label> <input type="text" name="input_addEmployee_login" id="input_addEmployee_login" />
			</p>
			<p> <label for="input_addEmployee_passwd">Mot de passe : </label> <input type="text" name="input_addEmployee_passwd" id="input_addEmployee_passwd" />
			</p>
			<p> <label for="input_addEmployee_category">Catégorie : </label>
				<input type="radio" name="input_addEmployee_category" value="A">Agent
				<input type="radio" name="input_addEmployee_category" value="C">Conseiller
			</p>
			<p> <label for="input_addEmployee_lastName">Nom : </label> <input type="text" name ="input_addEmployee_lastName" id="input_addEmployee_lastName" />
			</p>
			<p> <label for="input_addEmployee_firstName">Prénom : </label> <input type="text" name ="input_addEmployee_firstName" id="input_addEmployee_firstName" />
			</p>
			<p> <input type="submit" value="Envoyer" name="post_addEmployee" /> <input type="reset" value="Réinitialiser" />
			</p>
		</form>
</fieldset>
