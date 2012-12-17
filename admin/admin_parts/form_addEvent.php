<form method="POST" action="./admin.php?action=showAgenda&clientID=<?php echo $_GET['clientID']; ?>&conseillerID=<?php echo $_GET['conseillerID']; ?>&year=<?php echo $year; ?>&month=<?php echo $month; ?>&day=<?php echo $day; ?>" class="form_admin">
	<fieldset>
		<legend>Prendre rendez-vous</legend>
		<input type="hidden" name="actionAgenda" value="addEvent">
		<?php echo '<input type="hidden" name="clientID" value="'. $_GET['clientID']. '" >' ?>
		<?php echo '<input type="hidden" name="conseillerID" value="'. $_GET['conseillerID'].'" >' ?>
		<select name="date">

			<?php
			for($i=0; $i<5; $i++){
				$currentDate = date('j-n-Y', strtotime($year.'-'.$month.'-'.$day.'+'.$i.' DAY'));
				print_r('<br/>'.$currentDate.'<br/>');
				echo '<option value="' .$currentDate.'">' .$currentDate. '</option>';
			}
			?>

		</select>
		<select name="time">

			<?php
			for($i=0; $i<count($horaire)-1; $i++){
				if($horaire[$i] != 12)
					echo '<option value="' .$horaire[$i].'">' .$horaire[$i].'h-'.$horaire[$i+1]. 'h</option>';
			}
			?>

		</select>

		<select name="motif">
			<?php
				$db = quickConnectDB();
				$accountTypes = mysql_query("SELECT name FROM `accounts-type`");
				$contractTypes = mysql_query("SELECT name FROM `contracts-type`");
				mysql_close($db);

				if(mysql_num_rows($accountTypes) != 0){
					while($accountType = mysql_fetch_array($accountTypes)){
						echo '<option value="Ouvir un compte-'. $accountType['name'] .'">Ouverture de compte '. $accountType['name'] .'</option>';
					}
				}

				if(mysql_num_rows($contractTypes) != 0){
					while($contractType = mysql_fetch_array($contractTypes)){
						echo '<option value="Ouvrir un contrat-'. $contractType['name'] .'">Ouverture de compte '. $contractType['name'] .'</option>';
					}
				}
			?>
			

			<option value="autre">Autre</option>

		</select>
		<br/>
		<input type="submit" value="Ajouter">
		<input type="reset" value="Réinitialiser">
	</fieldset>
</form>