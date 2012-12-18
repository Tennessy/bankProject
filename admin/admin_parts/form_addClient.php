<?php

if (
	(isset($_POST['input_addClient_gender']) && !empty($_POST['input_addClient_gender'])) &&
	(isset($_POST['input_addClient_lastName']) && !empty($_POST['input_addClient_lastName'])) &&
	(isset($_POST['input_addClient_firstName']) && !empty($_POST['input_addClient_firstName'])) &&
	(isset($_POST['input_addClient_secondName'])) &&
	(isset($_POST['input_addClient_thirdName'])) &&
	(isset($_POST['input_addClient_birthDate']) && !empty($_POST['input_addClient_birthDate'])) &&
	(isset($_POST['select_addClient_civilStatus']) && !empty($_POST['select_addClient_civilStatus'])) &&
	(isset($_POST['input_addClient_job']) && !empty($_POST['input_addClient_job'])) &&
	(isset($_POST['input_addClient_addressLocation']) && !empty($_POST['input_addClient_addressLocation'])) &&
	(isset($_POST['input_addClient_addressCity']) && !empty($_POST['input_addClient_addressCity'])) &&
	(isset($_POST['input_addClient_addressZipcode']) && !empty($_POST['input_addClient_addressZipcode'])) &&
	(isset($_POST['input_addClient_addressState'])) && !empty($_POST['input_addClient_addressState']) &&
	(isset($_POST['input_addClient_phoneHome']) && !empty($_POST['input_addClient_phoneHome'])) &&
	(isset($_POST['input_addClient_phoneMobile'])) &&
	(isset($_POST['input_addClient_email']) && !empty($_POST['input_addClient_email']))
){

	if (!($_POST['input_addClient_gender'] == 'M' || $_POST['input_addClient_gender'] == 'F')) {
		echo showFormError('Genre', 'DO NOT HACK ME !');
		$queryDB = FALSE;
	}
	if (!preg_match('#^[\w.-]+@[\w.-]+\.[a-z]{2,6}$#i', $_POST['input_addClient_email'])) {
		echo showFormError('Courriel', 'Format d\'addresse invalide.');
		$queryDB = FALSE;
	}
	// On découpe la date dans un tableau, selon la forme JJ/MM/AAAA.
	$birthDate = explode('/', $_POST['input_addClient_birthDate']);
	$birthDateOK = FALSE;
	if (count($birthDate) == 3) {
		if (is_int(intval($birthDate[1])) && is_int(intval($birthDate[0])) && is_int(intval($birthDate[2]))) {
			if (checkdate(intval($birthDate[1]), intval($birthDate[0]), intval($birthDate[2]))) {
				$birthDateOK = TRUE;
			}
		}
	}
	if(!$birthDateOK) {
		echo showFormError('Date de naissance', 'La date entrée n\'est pas correcte.');
		$queryDB = FALSE;
	}
	if (!($_POST['select_addClient_civilStatus'] == 'MA' || $_POST['select_addClient_civilStatus'] == 'DI' || $_POST['select_addClient_civilStatus'] == 'SI')) {
		echo showFormError('Situation familiale', 'DO NOT HACK ME !');
		$queryDB = FALSE;
	}
	if (preg_match('#[^0-9]#', $_POST['input_addClient_phoneHome'])) {
		echo showFormError('Téléphone fixe', 'Un numéro de téléphone ne peut contenir que des chiffres.');
		$queryDB = FALSE;
	}
	if (preg_match('#[^0-9]#', $_POST['input_addClient_phoneMobile'])) {
		echo showFormError('Téléphone mobile', 'Un numéro de téléphone ne peut contenir que des chiffres.');
		$queryDB = FALSE;
	}

	if ($queryDB) {
		$id_shDB = quickConnectDB();
		if ($id_shDB) {
			$query = sprintf("INSERT INTO `clients`(`id_client`, `id_employee`, `lastName`, `firstName`, `secondName`, `thirdName`, `birthDate`, `gender`, `job`, `civilStatus`, `address_location`, `address_city`, `address_zipcode`, `address_state`, `phone_home`, `phone_mobile`, `email`, `registeringDate`)
				VALUES ('',  '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', now());",
				mysql_real_escape_string($_SESSION['id_employee']),
				mysql_real_escape_string($_POST['input_addClient_lastName']),
				mysql_real_escape_string($_POST['input_addClient_firstName']),
				mysql_real_escape_string($_POST['input_addClient_secondName']),
				mysql_real_escape_string($_POST['input_addClient_thirdName']),
				mysql_real_escape_string($birthDate[2] . '-' . $birthDate[1] . '-' . $birthDate[0]),
				mysql_real_escape_string($_POST['input_addClient_gender']),
				mysql_real_escape_string($_POST['input_addClient_job']),
				mysql_real_escape_string($_POST['select_addClient_civilStatus']),
				mysql_real_escape_string($_POST['input_addClient_addressLocation']),
				mysql_real_escape_string($_POST['input_addClient_addressCity']),
				mysql_real_escape_string($_POST['input_addClient_addressZipcode']),
				mysql_real_escape_string($_POST['input_addClient_addressState']),
				mysql_real_escape_string($_POST['input_addClient_phoneHome']),
				mysql_real_escape_string($_POST['input_addClient_phoneMobile']),
				mysql_real_escape_string($_POST['input_addClient_email']));
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

<form method="post" action="admin.php?action=addClient" name="form_addClient" id="form_addClient" class="form_admin">
	<fieldset>
		<legend>Identité</legend>
		<p> <label for="input_addClient_gender">Dénommé(e) :</label>
			<input type="radio" name="input_addClient_gender" value="M"
			<?php
				if ($incompleteForm && isset($_POST['input_addClient_gender'])) {
					if ($_POST['input_addClient_gender'] == 'M') {
						echo 'checked="yes"';
					}
				} else {
					echo 'checked="yes"';
				}
			?>
			>Monsieur
			<input type="radio" name="input_addClient_gender" value="F"
			<?php
				if ($incompleteForm && isset($_POST['input_addClient_gender'])) {
					if ($_POST['input_addClient_gender'] == 'F') {
						echo 'checked="yes"';
					}
				}
			?>
			>Madame
		</p>
		<p> <label for="input_addClient_lastName">Nom :</label>
			<input type="text" name="input_addClient_lastName" placeholder="exemple: dupont" required="required" value="<?php if ($incompleteForm && isset($_POST['input_addClient_lastName'])) echo $_POST['input_addClient_lastName']; ?>" id="input_addClient_lastName" />
		</p>
		<p> <label for="input_names">Prénoms :</label>
			<input type="text" name="input_addClient_firstName" placeholder="exemple: martin" required="required" value="<?php if ($incompleteForm && isset($_POST['input_addClient_firstName'])) echo $_POST['input_addClient_firstName']; ?>" id="input_firstName" class="input_names" />
			<input type="text" name="input_addClient_secondName" value="<?php if ($incompleteForm && isset($_POST['input_addClient_secondName'])) echo $_POST['input_addClient_secondName']; ?>" id="input_secondName" class="input_names" />
			<input type="text" name="input_addClient_thirdName" value="<?php if ($incompleteForm && isset($_POST['input_addClient_thirdName'])) echo $_POST['input_addClient_thirdName']; ?>" id="input_thirdName" class="input_names" />
		</p>
		<p> <label for="input_addClient_birthDate">Date de naissance :</label>
			<input type="text" name="input_addClient_birthDate" placeholder="JJ/MM/AAAA" required="required" value="<?php if ($incompleteForm && isset($_POST['input_addClient_birthDate'])) echo $_POST['input_addClient_birthDate']; ?>" id="input_addClient_birthDate" />
		</p>
		<p> <label for="select_addClient_civilStatus">Situation familiale :</label>
			<select name="select_addClient_civilStatus" id="select_addClient_civilStatus">
				<option
				<?php
					if ($incompleteForm && isset($_POST['select_addClient_civilStatus'])) {
						if ($_POST['input_addClient_gender'] == 'MA') {
							echo 'selected="selected"';
						}
					} else {
						echo 'selected="selected"';
					}
				?>
				value="MA">Marié</option>
				<option 
				<?php
					if ($incompleteForm && isset($_POST['select_addClient_civilStatus'])) {
						if ($_POST['input_addClient_gender'] == 'DI') {
							echo 'selected="selected"';
						}
					}
				?>
				value="DI">Divorcé</option>
				<option 
				<?php
					if ($incompleteForm && isset($_POST['select_addClient_civilStatus'])) {
						if ($_POST['input_addClient_gender'] == 'SI') {
							echo 'selected="selected"';
						}
					}
				?>
				value="SI">Célibataire</option>
			</select>
		</p>
		<p> <label for="input_addClient_job">Emploi :</label>
			<input type="text" name="input_addClient_job" required="required" value="<?php if ($incompleteForm && isset($_POST['input_addClient_job'])) echo $_POST['input_addClient_job']; ?>" id="input_addClient_job" />
		</p>
	</fieldset>
	<fieldset>
		<legend>Coordonnées</legend>
		<p> <label for="input_addClient_addressLocation">Rue :</label>
			<input type="text" name="input_addClient_addressLocation" required="required" value="<?php if ($incompleteForm && isset($_POST['input_addClient_addressLocation'])) echo $_POST['input_addClient_addressLocation']; ?>" id="input_addClient_addressLocation" />
		</p>
		<p> <label for="input_addClient_addressCity">Ville :</label>
			<input type="text" name="input_addClient_addressCity" required="required" value="<?php if ($incompleteForm && isset($_POST['input_addClient_addressCity'])) echo $_POST['input_addClient_addressCity']; ?>" id="input_addClient_addressCity" />
		</p>
		<p> <label for="input_addClient_addressZipcode">Code postal :</label>
			<input type="text" name="input_addClient_addressZipcode" required="required" value="<?php if ($incompleteForm && isset($_POST['input_addClient_addressZipcode'])) echo $_POST['input_addClient_addressZipcode']; ?>" id="input_addClient_addressZipcode" />
		</p>
		<p> <label for="input_addClient_addressState">Pays :</label>
			<input type="text" name="input_addClient_addressState" required="required" value="<?php if ($incompleteForm && isset($_POST['input_addClient_addressState'])) echo $_POST['input_addClient_addressState']; ?>" id="input_addClient_addressState" />
		</p>
		<p> <label for="input_addClient_phoneHome">Téléphone fixe :</label>
			<input type="text" name="input_addClient_phoneHome" placeholder="exemple : 0123456789" required="required" value="<?php if ($incompleteForm && isset($_POST['input_addClient_phoneHome'])) echo $_POST['input_addClient_phoneHome']; ?>" id="input_addClient_phoneHome" />
		</p>
		<p> <label for="input_addClient_phoneMobile">Téléphone mobile :</label>
			<input type="text" name="input_addClient_phoneMobile" placeholder="exemple : 0623456789" value="<?php if ($incompleteForm && isset($_POST['input_addClient_phoneMobile'])) echo $_POST['input_addClient_phoneMobile']; ?>" id="input_addClient_phoneMobile" />
		</p>
		<p> <label for="input_addClient_email">Courriel :</label>
			<input type="text" name="input_addClient_email" placeholder="exemple : email.exemple@exemple.com" required="required" value="<?php if ($incompleteForm && isset($_POST['input_addClient_email'])) echo $_POST['input_addClient_email']; ?>" id="input_addClient_" />
		</p>
	</fieldset>
	<fieldset id="fieldset_submit">
		<p> <input type="submit" value="Envoyer" name="post_addClient" />
			<input type="reset" value="Réinitialiser" />
		</p>
	</fieldset>
</form>
