<form method="post" action="admin.php?action=stats" name="form_stats_nbClients" id="form_stats_nbClients" class="form_admin">
	<fieldset>
		<legend>Nombre total de clients</legend>
		<?php
		if (isset($_POST['post_stats_nbClients'])) {
			$id_shDB = quickConnectDB();
			if ($id_shDB != NULL) {
				$query = "SELECT * FROM `clients`;";
				$rep = mysql_query($query);
				$rows = array();
				while($row = mysql_fetch_assoc($rep)) {
					$rows[] = $row;
				}
				$nbClients = count($rows);
				mysql_close($id_shDB);
			}
			echo '<p>Nombre total de clients actuel : ' . $nbClients . '.</p>';
		}
		?>
		<p> <input type="submit" value="Afficher" name="post_stats_nbClients" />
			<input type="reset" value="Réinitialiser" />
		</p>
	</fieldset>
</form>

<form method="post" action="admin.php?action=stats" name="form_stats_nbContracts" id="form_stats_nbContracts" class="form_admin">
	<fieldset>
		<legend>Nombre de contrats souscris entre deux dates</legend>
		<p> <label for="input_stats_nbContracts_dateB">Date de début :</label>
			<input type="text" name="input_stats_nbContracts_dateB" required="required" value="" id="input_stats_nbContracts_dateB" />
		</p>
		<p> <label for="input_stats_nbContracts_dateB">Date de fin :</label>
			<input type="text" name="input_stats_nbContracts_dateE" required="required" value="" id="input_stats_nbContracts_dateE" />
		</p>
		<?php
		if (
			(isset($_POST['post_stats_nbContracts'])) &&
			(isset($_POST['input_stats_nbContracts_dateB']) && !empty($_POST['input_stats_nbContracts_dateB'])) &&
			(isset($_POST['input_stats_nbContracts_dateE']) && !empty($_POST['input_stats_nbContracts_dateE']))
		){
			// On découpe la date dans un tableau, selon la forme JJ/MM/AAAA.
			$dateB = explode('/', $_POST['input_stats_nbContracts_dateB']);
			$dateBOK = FALSE;
			if (count($dateB) == 3) {
				if (is_int(intval($dateB[1])) && is_int(intval($dateB[0])) && is_int(intval($dateB[2]))) {
					if (checkdate(intval($dateB[1]), intval($dateB[0]), intval($dateB[2]))) {
						$dateBOK = TRUE;
						$dateBq = $dateB[2] . '-' . $dateB[1] . '-' . $dateB[0];
					}
				}
			}
			if (!$dateBOK) {
				echo showFormError('Date début', 'La date entrée n\'est pas correcte.');
				$queryDB = FALSE;
			}
			$dateE = explode('/', $_POST['input_stats_nbContracts_dateE']);
			$dateEOK = FALSE;
			if (count($dateE) == 3) {
				if (is_int(intval($dateE[1])) && is_int(intval($dateE[0])) && is_int(intval($dateE[2]))) {
					if (checkdate(intval($dateE[1]), intval($dateE[0]), intval($dateE[2]))) {
						$dateEOK = TRUE;
						$dateEq = $dateE[2] . '-' . $dateE[1] . '-' . $dateE[0];
					}
				}
			}
			if (!$dateEOK) {
				echo showFormError('Date fin', 'La date entrée n\'est pas correcte.');
				$queryDB = FALSE;
			}
			if ($dateEq < $dateBq) {
				$dateTq = $dateEq;
				$dateEq = $dateBq;
				$dateBq = $dateTq;
			}
			if ($queryDB) {
				$id_shDB = quickConnectDB();
				if ($id_shDB != NULL) {
					$query = sprintf("SELECT * FROM `contracts` WHERE `openingDate` BETWEEN '%s' AND '%s';",
						mysql_real_escape_string($dateBq),
						mysql_real_escape_string($dateEq));
					$rep = mysql_query($query);
					$rows = array();
					while($row = mysql_fetch_assoc($rep)) {
						$rows[] = $row;
					}
					$nbContracts = count($rows);
					mysql_close($id_shDB);
				}
				echo '<p>Nombre total de contrats : ' . $nbContracts . '.</p>';
			}
		}
		?>
		<p> <input type="submit" value="Afficher" name="post_stats_nbContracts" />
			<input type="reset" value="Réinitialiser" />
		</p>
	</fieldset>
</form>