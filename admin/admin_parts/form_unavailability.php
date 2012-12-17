<form class="form_admin" method="POST" action="./admin.php?action=showAgenda&day=<?php echo $day ?>&month=<?php echo $month ?>&year=<?php echo $year ?>">
	<fieldset><legend>Ajouter une indisponibilité</legend>
		<input type="hidden" name="actionAgenda" value="addUnavailability">
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


		<input type="submit" value="Valider">

	</fieldset>
</form>

<?php


?>