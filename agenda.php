<?php

	$days = array('Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche');
	$months = array('Janvier','Fevrier', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Aout', 'Septembre', 'Octobre', 'Novembre', 'Decembre');

	function getAll($startY){
		$cal = array();

		$date = strtotime($startY . '-01-01');
		$dateActu = $date;
		
		while($date < strtotime(date('Y-m-d', $dateActu).'+1 YEAR')){

			$m = date('n', $date);
			$d = date('j', $date);
			$w = str_replace('0', '7', date('w', $date));

			$cal[$m][$d] = $w;
			

			$date = strtotime(date('Y-m-d', $date) . '+1 DAY');

		}

		return $cal;
	}

	function getMonth($month, $year){
		$cal = array();

		$date = strtotime($year . '-' . $month . '-01');

		while($date < (strtotime(date($year.'-'.$month.'-01') . '+1 MONTH'))){
			$d = date('j', $date);
			$w = str_replace('0', '7', date('w', $date));

			$cal[$d] = $w;

			$date = $date = strtotime(date('Y-m-d', $date) . '+1 DAY');
		}
	}

?>