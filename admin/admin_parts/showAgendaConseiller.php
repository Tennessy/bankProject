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

		

	}
	?>

</div>