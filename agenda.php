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
	$dateActu = $date;

	while($date < (strtotime(date('Y-m-d', $dateActu) . '+1 MONTH'))){
		$d = date('j', $date);
		$w = str_replace('0', '7', date('w', $date));

		$cal[$d] = $w;

		$date = strtotime(date('Y-m-d', $date) . '+1 DAY');
	}
	return $cal;
}

function getWeek($day, $month, $year){
	

	$cal = array();

	$date = strtotime($year . '-' . $month . '-' . $day);
	$dateActu = $date;
	$i=0;
	while($date < (strtotime(date('Y-m-d', $dateActu) . '+5 DAY'))){
		$d = date('j', $date);
		$w = str_replace('0', '7', date('w', $date));

		$cal[$i] = $w;

		$date = strtotime(date('Y-m-d', $date) . '+1 DAY');
		$i++;
	}
	return $cal;
}

function getEvents($day, $month, $year, $conseillerID){
	$dateList = array();
	for($i=0; $i<7; $i++){
		array_push($dateList, "'".date('Y-m-d', strtotime($year.'-'.$month.'-'.$day.'+'.$i.' DAY'))."'");
	}

	$db = quickConnectDb();
	$rdvList = mysql_query("SELECT * FROM agenda WHERE id_employee='{$_GET['conseillerID']}' AND ( startingDate IN (".implode(',', $dateList)." ))");
	mysql_close($db);

	$r = array();
	while($a = mysql_fetch_array($rdvList)){
		$time = explode(':',$a['startingTime']);
		if($time[0] < 10){
			$time[0] = intval($time[0]);
		}
		$r[strtotime($a['startingDate'])][$time[0]]['id'] = $a['id'];
		$r[strtotime($a['startingDate'])][$time[0]]['id_client'] = $a['id_client'];
	}

	return $r;
}

?>