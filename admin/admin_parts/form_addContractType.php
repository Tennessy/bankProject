<?php

if (
	(isset($_POST['input_addContractType_name']) && !empty($_POST['input_addContractType_name'])) &&
	(isset($_POST['input_addContractType_documentsRequired']) && !empty($_POST['input_addContractType_documentsRequired']))
) {

	if(preg_match('#[^0-9]#', $_POST['input_addContractType_monthlyCost'])) {
		echo showFormError('Coût mensuel', 'Veuillez entrer un chiffre.');
		$queryDB = FALSE;
	}
	if ($queryDB) {
		$id_shDB = quickConnectDB();
		if ($id_shDB != NULL) {
			$query = sprintf("INSERT INTO `contracts-type`(`id_contract-type`, `name`, `monthlyCost`, `documentsRequired`) VALUES ('', '%s', '%s', '%s')",
				mysql_real_escape_string($_POST['input_addContractType_name']),
				mysql_real_escape_string($_POST['input_addContractType_monthlyCost']),
				mysql_real_escape_string($_POST['input_addContractType_documentsRequired']));
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

<form method="post" action="admin.php?action=addContractType" name="form_addContractType" id="form_addContractType" class="form_admin">
	<fieldset>
		<legend>Ajouter un type de contrat</legend>
		<p> <label for="input_addContractType_name">Nom : </label> <input type="text" name="input_addContractType_name" required="required" value="<?php if ($incompleteForm && isset($_POST['input_addContractType_name'])) echo $_POST['input_addContractType_name']; ?>" id="input_addContractType_name" />
		</p>
		<p> <label for="input_addContractType_monthlyCost">Coût mensuel : </label> <input type="text" name="input_addContractType_monthlyCost" required="required" value="<?php if ($incompleteForm && isset($_POST['input_addContractType_monthlyCost'])) echo $_POST['input_addContractType_monthlyCost']; ?>" id="input_addContractType_monthlyCost" />
		</p>
		<p> <label for="input_addContractType_documentsRequired">Documents requis : </label> <textarea rows="5" name="input_addContractType_documentsRequired" required="required" id="input_addContractType_documentsRequired" /><?php if ($incompleteForm && isset($_POST['input_addContractType_documentsRequired'])) echo $_POST['input_addContractType_documentsRequired']; ?></textarea>
		</p>
		<p> <input type="submit" value="Envoyer" name="post_addContractType" /> <input type="reset" value="Réinitialiser" />
		</p>
	</fieldset>
</form>
