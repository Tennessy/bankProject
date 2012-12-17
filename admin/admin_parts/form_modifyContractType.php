<?php

if ($queryDB) {
	$id_shDB = quickConnectDB();
	if ($id_shDB != NULL) {
		$query = sprintf("SELECT * FROM `contracts-type`;");
		$rep = mysql_query($query);
		if (mysql_num_rows($rep) != 0) {
			echo'
				<form method="post" action="admin.php?action=modifyContractType" name="form_modifyContractType" id="form_modifyContractType" class="form_admin">
					<fieldset>
						<legend>Liste des contrats</legend>
						<table class="table_modifyContractType">
							<tr>
								<td>Nom</td>
								<td>Coût mensuel</td>
								<td>Documents requis</td>
							</tr>
				';
			while ($result = mysql_fetch_array($rep)) {
				echo '<tr>';
				echo '<td><a href="admin.php?action=modifyContractType&id_contract-type=' . $result['id_contract-type'] . '">' . htmlentities($result['name'], ENT_COMPAT, 'UTF-8') . '</a></td>';
				echo '<td>' . htmlentities($result['monthlyCost'], ENT_COMPAT, 'UTF-8'). '</td>';
				echo '<td>' . htmlentities($result['documentsRequired'], ENT_COMPAT, 'UTF-8'). '</td>';
				echo '</tr>';
			}
			echo'
						</table>
					</fieldset>
				</form>
			';
		} else {
			echo showFormError('', 'Aucun type de contrat dans la base de donnée');
		}
		mysql_close($id_shDB);
	}
}

if (isset($_GET['id_contract-type'])) {
	if($queryDB) {
		$id_shDB = quickConnectDB();
		if ($id_shDB != NULL) {
			$query = sprintf("SELECT * FROM `contracts-type` WHERE `id_contract-type` = '%s';",
				mysql_real_escape_string($_GET['id_contract-type']));
			$rep = mysql_query($query);
			if (mysql_num_rows($rep) != 0) {
				$result = mysql_fetch_array($rep);
				echo'
				<form method="post" action="admin.php?action=modifyContractType" name="form_modifyContractType" id="form_modifyContractType" class="form_admin">
					<fieldset>
						<legend>Ajouter un type de contrat</legend>
						<p> <label for="input_modifyContractType_name">Nom : </label> <input type="text" name="input_modifyContractType_name" required="required" value="' . $result['name'] . '" id="input_modifyContractType_name" />
						</p>
						<p> <label for="input_modifyContractType_monthlyCost">Coût mensuel : </label> <input type="text" name="input_modifyContractType_monthlyCost" required="required" value="' . $result['monthlyCost'] . '" id="input_modifyContractType_monthlyCost" />
						</p>
						<p> <label for="input_modifyContractType_documentsRequired">Documents requis : </label> <textarea rows="5" name="input_modifyContractType_documentsRequired" required="required" id="input_modifyContractType_documentsRequired" />' . $result['documentsRequired'] . '</textarea>
						</p>
						<p> <input type="submit" value="Modifier" name="post_modifyContractType" /> <input type="reset" value="Réinitialiser" />
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