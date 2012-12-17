<?php

if(isset($_SESSION['id_employee']) && $_SESSION['category'] == 'conseiller' && !empty($_SESSION['id_employee']) && is_numeric($_SESSION['id_employee'])){
	$id_conseiller = $_SESSION['id_employee'];
}
else if(isset($_GET['conseillerID']) && !empty($_GET['conseillerID']) && is_numeric($_GET['conseillerID'])){
	$id_conseiller = $_GET['conseillerID'];
}
else{
	$id_conseiller = '';
}

require_once('./agenda.php'); 

if(isset($_POST['actionAgenda']) && !empty($_POST['actionAgenda']) && ($_POST['actionAgenda'] == 'addUnavailability')){
	if(isset($_POST['date']) && !empty($_POST['date']) && isset($_POST['time']) && !empty($_POST['time']) && is_numeric($_POST['time']) && isset($_SESSION['id_employee']) && !empty($_SESSION['id_employee'])){
		$datePost = explode('-', $_POST['date']);
		if(checkdate($datePost[1], $datePost[0], $datePost[2])){
			$ending_time = ($_POST['time']+1).':00:00';
			$time = $_POST['time'].':00:00';
			$datePost = $datePost[2].'-'.$datePost[1].'-'.$datePost[0];

			$dateList = array();
			for($i=0; $i<7; $i++){
				array_push($dateList, "'".date('Y-m-d', strtotime($year.'-'.$month.'-'.$day.'+'.$i.' DAY'))."'");
			}

			$bd = quickConnectDB();
			$verifDispo = mysql_query("SELECT * FROM agenda WHERE id_employee='{$_SESSION['id_employee']}' AND startingDate='{$datePost}'  AND startingTime='{$time}'");
			$verifAvail = mysql_query("SELECT * FROM unavailability WHERE id_employee='{$_SESSION['id_employee']}' AND startingDate='{$datePost}'  AND starting_time='{$time}'");

			if(mysql_num_rows($verifDispo) == 0 && $time != '12:00:00' && mysql_num_rows($verifAvail) == 0){
				mysql_query("INSERT INTO `unavailability` (`id_employee`, `startingDate`, `starting_time`, `ending_time`) VALUES ('{$_SESSION['id_employee']}', '{$datePost}', '{$time}', '{$ending_time}' )");

				mysql_close($bd);
			}
			else{
				echo showFormError('','Cette plage horaire est deja prise');
			}
		}
		else{
			echo showFormError('','Veuillez entrer une date valide');
		}
	}
}


if(isset($_POST['actionAgenda']) && !empty($_POST['actionAgenda']) && ($_POST['actionAgenda'] == 'addEvent')){
	if(isset($_POST['date']) && !empty($_POST['date']) && isset($_POST['time']) && !empty($_POST['time']) && is_numeric($_POST['time'])){
		$datePost = explode('-', $_POST['date']);

		if(checkdate($datePost[1], $datePost[0], $datePost[2])){
			$time = $_POST['time'].':00:00';
			$datePost = $datePost[2].'-'.$datePost[1].'-'.$datePost[0];

			$dateList = array();
			for($i=0; $i<7; $i++){
				array_push($dateList, "'".date('Y-m-d', strtotime($year.'-'.$month.'-'.$day.'+'.$i.' DAY'))."'");
			}

			$bd = quickConnectDB();
			$verifDispo = mysql_query("SELECT * FROM agenda WHERE id_employee='{$_POST['conseillerID']}' AND startingDate='{$datePost}'  AND startingTime='{$time}'");
			$verifAvail = mysql_query("SELECT * FROM unavailability WHERE id_employee='{$_POST['conseillerID']}' AND startingDate='{$datePost}'  AND starting_time='{$time}'");

			if(mysql_num_rows($verifDispo) == 0 && $time != '12:00:00' && mysql_num_rows($verifAvail) == 0){
				mysql_query("INSERT INTO `agenda` (`id_client`, `id_employee`, `startingDate`, `startingTime`, `motif`) VALUES ('{$_POST['clientID']}', '{$_POST['conseillerID']}', '{$datePost}', '{$time}', '{$_POST['motif']}' )");

				$docs = mysql_query("SELECT documentsRequired FROM `accounts-type` WHERE `name` = '{$_POST['motif']}'");
				if(mysql_num_rows($docs) == 0){
					$docs = mysql_query("SELECT documentsRequired FROM `contracts-type` WHERE `name` = '{$_POST['motif']}'");
				}

				mysql_close($bd);
				if(isset($docs)){
					if(mysql_num_rows($docs) != 0){
						while($doc = mysql_fetch_array($docs)){
							echo 'Les documents requis sont les suivants : '.$doc['documentsRequired'];
						}
					}
				}

				else{
					echo showFormError('','Aucun document requis pour ce motif de rendez-vous');
				}
				echo showFormSuccess('Ajout effectué avec succès');
			}

			else{
				echo showFormError('','Veuillez choisir une plage horaire libre');
			}

		}
	}
}

?>


<div class = "calandar">

	<?php

	if(isset($id_conseiller) && !empty($id_conseiller) && is_numeric($id_conseiller)){

		$yesterday = explode('-', date('Y-m-d', strtotime($year.'-'.$month.'-'.$day . '-7 DAY')));
		$tomorrow = explode('-', date('Y-m-d', strtotime($year.'-'.$month.'-'.$day .  '+7 DAY')));

		if(isset($_GET['clientID']) && !empty($_GET['clientID']) && is_numeric($_GET['clientID'])){
			echo '<a href="./admin.php?action=showAgenda&clientID='.$_GET['clientID'].'&conseillerID='.$id_conseiller.'&day='. $yesterday[2] .'&month='. $yesterday[1] .'&year=' . $yesterday[0] . '"> <<< </a>';
			echo '<a href="./admin.php?action=showAgenda&clientID='.$_GET['clientID'].'&conseillerID='.$id_conseiller.'&day='. $tomorrow[2] .'&month='. $tomorrow[1] .'&year=' . $tomorrow[0] . '"> >>> </a><br/>';

		}
		else{
			echo '<a href="./admin.php?action=showAgenda&day='. $yesterday[2] .'&month='. $yesterday[1] .'&year=' . $yesterday[0] . '"> <<< </a>';
			echo '<a href="./admin.php?action=showAgenda&day='. $tomorrow[2] .'&month='. $tomorrow[1] .'&year=' . $tomorrow[0] . '"> >>> </a><br/>';
		}


		echo '<div class="week">';


		$dates = getWeek($day, $month, $year);

		echo '<br/>';

		echo '<br/>';

		echo '<table><thead><tr>'. $months[$month-1] . ' ' . $year . '</tr><tr>';
		echo '<th></th>';
		for($i=0; $i<5; $i++){

			echo '<th>' . substr($days[$i], 0, 3) . '. ' . date('j', strtotime($year.'-'.$month.'-'.$day.'+'.$i.' DAY')) . '</th>';
		}

		echo '</tr></thead>';

		echo '<tbody>';

		$eventList = getEvents($day, $month, $year, $id_conseiller);
		$indispList = getIndisp($day, $month, $year, $id_conseiller);

		for($i=0; $i<count($horaire)-1; $i++){
			echo '<tr>';
			echo '<td>'. $horaire[$i].'h-'. $horaire[$i+1] .'h</td>';

			$k=0;
			foreach ($dates as $d => $w){
				$currentDate = strtotime(date('Y-m-d', strtotime($year.'-'.$month.'-'.$day.'+'.$k.' DAY')));
				$j=0;
				$event = false;
				while(($j<count($eventList) || $j<count($indispList)) && !$event){

					if(isset($indispList[$currentDate])){
						$l=0;
						while($l < count($indispList[$currentDate]) && !$event){
							if(isset($indispList[$currentDate][$horaire[$i]])){
								echo '<td>/</td>';
								$event = true;
							}
							$l++;
						}
						$j++;
					}

					if(isset($eventList[$currentDate])){
						$l=0;
						while($l<count($eventList[$currentDate]) && !$event){
							if(isset($eventList[$currentDate][$horaire[$i]])){
								echo '<td><a href="./admin.php?action=showAgenda&day='.$day.'&month='.$month.'&year='.$year.'&idRdv='.$eventList[$currentDate][intval($horaire[$i])]["id"].'&clientID='.$eventList[$currentDate][intval($horaire[$i])]['id_client'].'&conseillerID='.$id_conseiller.'">'. $eventList[$currentDate][intval($horaire[$i])]['id_client'] .'</a></td>';
								$event = true;
							}
							$l++;
						}
					}
					$j++;
				}

				if($horaire[$i] == 12){
					echo '<td>/</td>';
				}
				else if(!$event){
					echo '<td></td>';
				}
				$k++;
			}
			echo '</tr>';
		}



		echo '</tbody>';

		echo '</table>';
		echo '</div>';



	}


	else if($_SESSION['category'] != 'conseiller' || ($_SESSION['category'] == 'conseiller' && (!isset($_SESSION['id_employee']) || empty($_SESSION['id_employee']))) && isset($_GET['conseillerID']) && !empty($_GET['conseillerID'])){
		$db = quickConnectDB();
		$conseillerList = mysql_query("SELECT * FROM employees WHERE category='C'");
		mysql_close($db);


		echo '<form name="conseillerID" method="GET" action="admin.php" class="form_admin" > 
		<fieldset><legend>Choix de l\'id conseiller</legend>';

		if(mysql_num_rows($conseillerList) != 0){

			echo '<input type="hidden" name="action" value="showAgenda">
			<input type="hidden" name="clientID" value="'.$_GET['clientID'].'">
			<select name="conseillerID" >';
			while($conseiller = mysql_fetch_array($conseillerList)){
				echo '<option value="'.$conseiller[0].'">'. $conseiller[0] . ' - ' . $conseiller[4] . ' ' . $conseiller[5] . '</option>';
			}
			echo '</select>';
			echo '<input type="submit" value="Valider" />';
		}

		else{
			echo showFormError('','Aucun conseiller présent dans la base de données');
		}

		echo '</fieldset> </form>';
	}


	if(isset($_GET['clientID']) && !empty($_GET['clientID']) && is_numeric($_GET['clientID']) && isset($_GET['idRdv']) && !empty($_GET['idRdv']) && is_numeric($_GET['idRdv']) && isset($_SESSION['id_employee']) && !empty($_SESSION['id_employee'])){
		$db = quickConnectDB();
		$infosRdv = mysql_query("SELECT * FROM agenda WHERE id='{$_GET['idRdv']}'");

		if(mysql_num_rows($infosRdv) != 0){
			echo '<form class="form_admin"><fieldset><legend>Information sur le rendez-vous</legend>';
			$infoRdv = mysql_fetch_array($infosRdv);
			echo '<label for="motif">Motif du rendez-vous : </label><input type="text" disabled="disabled" name="motif" value="'.$infoRdv['motif'].'">';
			$motif = explode('-', $infoRdv['motif']);
			$docs = mysql_query("SELECT documentsRequired FROM `accounts-type` WHERE `name` = '{$motif[1]}'");
			if(mysql_num_rows($docs) == 0){
				$docs = mysql_query("SELECT documentsRequired FROM `contracts-type` WHERE `name` = '{$motif[1]}'");
			}
			$doc = mysql_fetch_array($docs);
			echo '<label for="docs" >Documents requis : </label><textarea name="docs" rows="4" cols="50" disabled="disabled">'. $doc['documentsRequired'] .'</textarea>';
			echo '</fieldset></form>';
		}
		mysql_close($db);
		include_once("form_showClientDatas.php");
	}



	?>


</div>
