<?php require('./agenda.php'); ?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
	"http://www.w3.org/TR/html4/strict.dtd">
<HTML>
	<HEAD>
	</HEAD>
	<BODY>

		<div class = "calandar">
			<?php

			if(isset($_GET['year']) && !empty($_GET['year']) && is_numeric($_GET['year'])){
				$year = $_GET['year'];
			}
			else{
				$year = date('Y');
			}

			echo '<h2>' . $year . '</h2>';
			?>
			<div class="months">

				<?php
				$dates = getAll($year);
				foreach ($dates as $idm=>$m) {
					echo '<div class="months"><table><thead><tr>'. $months[$idm-1] .'</tr><tr>';

					for($i=0; $i<7; $i++){
						echo '<th>' . $days[$i] . '</th>';
					}

					echo '</tr></thead>';

					echo '<tbody><tr>';

					$endTab = end($m);

					foreach ($m as $d => $w) {
						if($d == 1 && $w != 1){
							echo '<td colspan="' . ($w-1) . '"> </td>';
						}

						echo '<td>' . $d . '</td>';

						if($w == 7){
							echo '</tr><tr>';
						}
					}					
					if($endTab != 7){
						for($i=$endTab; $i != 7; $i++){
							echo '<tr></tr>';
						}
					}

					echo '</tr></tbody>';

					echo '</table></div>';
				}


				?>


				

			</div>
		</div>


	</BODY>
</HTML>