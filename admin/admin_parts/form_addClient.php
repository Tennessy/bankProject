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
	if (!checkdate($birthDate[1], $birthDate[0], $birthDate[2])) {
		echo showFormError('Date de naissance', 'La date entrée n\'est pas correcte.');
		$queryDB = FALSE;
	}
	if(!($_POST['input_addClient_civilStatus'] == 'MA' || $_POST['input_addClient_civilStatus'] == 'DI' || $_POST['input_addClient_civilStatus'] == 'SI')) {
		echo showFormError('Situation familiale', 'DO NOT HACK ME !');
		$queryDB = FALSE;
	}
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
			<input type="text" name="input_addClient_lastName" required="required" value="" id="input_addClient_lastName" />
		</p>
		<p> <label for="input_addClient_firstName">Prénom :</label>
			<input type="text" name="input_addClient_firstName" required="required" value="" id="input_addClient_firstName" />
		</p>
		<p> <label for="input_addClient_secondName">Deuxième prénom:</label>
			<input type="text" name="input_addClient_secondName" value="" id="input_addClient_secondName" />
		</p>
			<input type="text" name="input_addClient_thirdName" value="" id="input_addClient_thirdName" />
		</p>
		<p> <label for="input_addClient_birthDate">Date de naissance :</label>
			<input type="text" name="input_addClient_birthDate" required="required" value="" id="input_addClient_birthDate" />
		</p>
		<p> <label for="select_addClient_civilStatus">Situation familiale :</label>
			<select name="select_addClient_civilStatus" id="select_addClient_civilStatus">
				<option
				<?php
					if ($incompleteForm && isset($_POST['input_addClient_civilStatus'])) {
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
					if ($incompleteForm && isset($_POST['input_addClient_civilStatus'])) {
						if ($_POST['input_addClient_gender'] == 'DI') {
							echo 'selected="selected"';
						}
					}
				?>
				value="DI">Divorcé</option>
				<option 
				<?php
					if ($incompleteForm && isset($_POST['input_addClient_civilStatus'])) {
						if ($_POST['input_addClient_gender'] == 'SI') {
							echo 'selected="selected"';
						}
					}
				?>
				value="SI">Célibataire</option>
			</select>
		</p>
		<p> <label for="input_addClient_job">Emploi :</label>
			<input type="text" name="input_addClient_job" required="required" value="" id="input_addClient_job" />
		</p>
	</fieldset>
	<fieldset>
		<legend>Coordonnées</legend>
		<p> <label for="input_addClient_addressLocation">Rue :</label>
			<input type="text" name="input_addClient_addressLocation" required="required" value="" id="input_addClient_addressLocation" />
		</p>
		<p> <label for="input_addClient_addressCity">Ville :</label>
			<input type="text" name="input_addClient_addressCity" required="required" value="" id="input_addClient_addressCity" />
		</p>
		<p> <label for="input_addClient_addressZipcode">Code postal :</label>
			<input type="text" name="input_addClient_addressZipcode" required="required" value="" id="input_addClient_addressZipcode" />
		</p>
		<p> <label for="input_addClient_addressState">Pays :</label>
			<input type="text" name="input_addClient_addressState" required="required" value="" id="input_addClient_addressState" />
		</p>
		<p> <label for="input_addClient_phoneHome">Téléphone fixe :</label>
			<input type="text" name="input_addClient_phoneHome" required="required" value="" id="input_addClient_phoneHome" />
		</p>
		<p> <label for="input_addClient_phoneMobile">Téléphone mobile :</label>
			<input type="text" name="input_addClient_phoneMobile" value="" id="input_addClient_phoneMobile" />
		</p>
		<p> <label for="input_addClient_email">Courriel :</label>
			<input type="text" name="input_addClient_email" required="required" value="" id="input_addClient_" />
		</p>
		<p> <input type="submit" value="Envoyer" name="post_addClient" />
			<input type="reset" value="Réinitialiser" />
		</p>
	</fieldset>
</form>
