<?php

if (
	(isset($_POST['input_addAccountType_name']) && !empty($_POST['input_addAccountType_name'])) &&
	(isset($_POST['input_addAccountType_documentsRequired']) && !empty($_POST['input_addAccountType_documentsRequired']))
) {

	if ($queryDB) {
		$id_shDB = quickConnectDB();
		if ($id_shDB != NULL) {
			$query = sprintf("INSERT INTO `accounts-type`(`id_account-type`, `name`, `documentsRequired`) VALUES ('', '%s', '%s')",
				mysql_real_escape_string($_POST['input_addAccountType_name']),
				mysql_real_escape_string($_POST['input_addAccountType_documentsRequired']));
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

<form method="post" action="admin.php?action=addAccountType" name="form_addAccountType" id="form_addAccountType" class="form_admin">
	<fieldset>
		<legend>Ajouter un type de compte</legend>
		<p> <label for="input_addAccountType_name">Nom : </label> <input type="text" name="input_addAccountType_name" required="required" value="<?php if ($incompleteForm && isset($_POST['input_addAccountType_name'])) echo $_POST['input_addAccountType_name']; ?>" id="input_addAccountType_name" />
		</p>
		<p> <label for="input_addAccountType_documentsRequired">Documents requis : </label> <textarea rows="5" name="input_addAccountType_documentsRequired" required="required" id="input_addAccountType_documentsRequired"><?php if ($incompleteForm && isset($_POST['input_addAccountType_documentsRequired'])) echo $_POST['input_addAccountType_documentsRequired']; ?></textarea>
		</p>
		<p> <input type="submit" value="Envoyer" name="post_addAccountType" /> <input type="reset" value="Réinitialiser" />
		</p>
	</fieldset>
</form>
