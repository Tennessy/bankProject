<?php require('./agenda.php'); ?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
	"http://www.w3.org/TR/html4/strict.dtd">
<HTML>
	<HEAD>
	</HEAD>
	<BODY>
		<?php
			$horaire = array(8, 9, 10, 11, 12 ,13, 14, 15, 16, 17);
		?>

		<div class = "calandar">
			<?php

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

			$yesterday = explode('-', date('Y-m-d', strtotime($year.'-'.$month.'-'.$day . '-7 DAY')));
			$tomorrow = explode('-', date('Y-m-d', strtotime($year.'-'.$month.'-'.$day .  '+7 DAY')));
			echo '<a href="./testAganda.php?day='. $yesterday[2] .'&month='. $yesterday[1] .'&year=' . $yesterday[0] . '"> <<< </a>';
			echo '<a href="./testAganda.php?day='. $tomorrow[2] .'&month='. $tomorrow[1] .'&year=' . $tomorrow[0] . '"> >>> </a>';



			?>
			<div class="week">

				<?php

				

				$dates = getWeek($day, $month, $year);

				echo '<table><thead><tr>'. $months[$month-1] . ' ' . $year . '</tr><tr>';
				echo '<th></th>';
				for($i=0; $i<7; $i++){

					echo '<th>' . substr($days[$i], 0, 3) . '. ' . date('j', strtotime($year.'-'.$month.'-'.$day.'+'.$i.' DAY')) . '</th>';
				}

				echo '</tr></thead>';

				echo '<tbody>';


				$db = quickConnectDb();
				for($i=0; $i<count($horaire)-1; $i++){
					echo '<tr>';
					echo '<td>'. $horaire[$i].'h-'. $horaire[$i+1] .'h</td>';
					foreach ($dates as $d => $w) {

						echo '<td>.</td>';

					}
					echo '</tr>';
				}

				mysql_close($db);

				echo '</tbody>';

				echo '</table>';

				?>


				

			</div>
		</div>


	</BODY>
</HTML>