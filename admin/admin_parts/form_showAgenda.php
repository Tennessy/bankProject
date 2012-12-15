<?php require('./agenda.php'); ?>

<?php
$horaire = array(8, 9, 10, 11, 12 ,13, 14, 15, 16, 17);


if(isset($_GET['year']) && !empty($_GET['year']) && is_numeric($_GET['year'])){
	$year = $_GET['year'];
}
else{
	$year = date('Y');
}

if(isset($_GET['month']) && !empty($_GET['month']) && is_numeric($_GET['month'])){
	$month = $_GET['month'];
}
else{
	$month = date('m');
}

if(isset($_GET['day']) && !empty($_GET['day']) && is_numeric($_GET['day'])){
	$day = $_GET['day'];
}
else{
	$day = date('d');
}

$temp = date('w', strtotime($year . '-' . $month . '-' . $day));

if($temp != 0){	
	$date = explode('-', date('Y-m-d', strtotime($year.'-'.$month.'-'.$day.'-'.($temp-1).' DAY')));
	$day = $date[2];
	$month = $date[1];
	$year = $date[0];
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

			if(mysql_num_rows($verifDispo) == 0 && $time != '12:00:00'){
				mysql_query("INSERT INTO `agenda` (`id_client`, `id_employee`, `startingDate`, `startingTime`, `motif`) VALUES ('{$_POST['clientID']}', '{$_POST['conseillerID']}', '{$datePost}', '{$time}', '{$_POST['motif']}' )");

				$motif=explode('-', $_POST['motif']);
				if($motif[0] == "openAccount"){
					$docs = mysql_query("SELECT documentsRequired FROM `accounts-type` WHERE `name` = '{$motif[1]}'");
				}
				else if($motif[0] == "openContract"){
					$docs = mysql_query("SELECT documentsRequired FROM `contracts-type` WHERE `name` = '{$motif[1]}'");
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
					echo 'Aucun document requis pour ce motif de rendez-vous';
				}
			}

			else{
				echo 'Veuillez choisir une plage horaire libre';
			}

		}
	}
}

?>


<div class = "calandar">

	<?php

	if(isset($_GET['conseillerID']) && !empty($_GET['conseillerID']) && is_numeric($_GET['conseillerID'])){

		$yesterday = explode('-', date('Y-m-d', strtotime($year.'-'.$month.'-'.$day . '-7 DAY')));
		$tomorrow = explode('-', date('Y-m-d', strtotime($year.'-'.$month.'-'.$day .  '+7 DAY')));
		echo '<a href="./admin.php?action=showAgenda&clientID='.$_GET['clientID'].'&conseillerID='.$_GET['conseillerID'].'&day='. $yesterday[2] .'&month='. $yesterday[1] .'&year=' . $yesterday[0] . '"> <<< </a>';
		echo '<a href="./admin.php?action=showAgenda&clientID='.$_GET['clientID'].'&conseillerID='.$_GET['conseillerID'].'&day='. $tomorrow[2] .'&month='. $tomorrow[1] .'&year=' . $tomorrow[0] . '"> >>> </a><br/>';

		

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

		$eventList = getEvents($day, $month, $year, $_GET['conseillerID']);

		for($i=0; $i<count($horaire)-1; $i++){
			echo '<tr>';
			echo '<td>'. $horaire[$i].'h-'. $horaire[$i+1] .'h</td>';

			$k=0;
			foreach ($dates as $d => $w){
				$currentDate = strtotime(date('Y-m-d', strtotime($year.'-'.$month.'-'.$day.'+'.$k.' DAY')));
				$j=0;
				$event = false;

				while($j<count($eventList) && !$event){
					if(isset($eventList[$currentDate])){
						$l=0;
						while($l<count($eventList[$currentDate]) && !$event){
							if(isset($eventList[$currentDate][$horaire[$i]])){
								echo '<td>'. $eventList[$currentDate][intval($horaire[$i])]['id_client'] .'</td>';
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
					echo '<td>.</td>';
				}
				$k++;
			}
			echo '</tr>';
		}



		echo '</tbody>';

		echo '</table>';
		echo '</div>';

		include("admin/admin_parts/form_addEvent.php");

	}


	else{
		$db = quickConnectDB();
		$conseillerList = mysql_query("SELECT * FROM employees WHERE category='C'");
		mysql_close($db);

		echo '<form name="conseillerID" method="GET" action="admin.php" class="form_admin" > 
		<fieldset><legend>Choix de l\'id conseiller</legend>';

		if(mysql_num_rows($conseillerList) != 0){

			echo '<input type="hidden" name="action" value="showAgenda"/><input type="hidden" name="clientID" value="'.$_GET['clientID'].'"/>
			<select name="conseillerID" >';
			while($conseiller = mysql_fetch_array($conseillerList)){
				echo '<option value="'.$conseiller[0].'">'. $conseiller[0] . ' - ' . $conseiller[4] . ' ' . $conseiller[5] . '</option>';
			}
			echo '</select>';
			echo '<input type="submit" value="Valider" />';
		}

		else{
			echo 'Aucun conseiller présent dans la base de données';
		}

		echo '</fieldset> </form>';
	}


	?>


</div>
