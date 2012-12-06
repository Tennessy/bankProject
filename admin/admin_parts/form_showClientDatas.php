<?php
/*
$db = quickConnectDB();
$clientDatas = mysql_query('SELECT * FROM clients WHERE id_client="'.$_GET['clientID'].'"');
mysql_close($db);*/

$clientDatas = getClientDatas($_GET['clientID']);



echo "<form name='ClientInfo'>
<fieldset>
<legend>Informations Client</legend>";

/*
if(mysql_num_rows($clientDatas) != 0){
	$client = mysql_fetch_array($clientDatas);
*/
if($clientDatas != null){
	for($i=2; $i<17; $i++){

		echo '<label for="'.$i.'">' .$dataName[$i]. ' : </label><input type="text" name="' . $i . '" value="'. $clientDatas[$i] .'" disabled="disabled"/></br>';
	}
}
else{
	echo 'Le client n\'existe pas dans la base de données';
}

echo '</fieldset></form>';




?>