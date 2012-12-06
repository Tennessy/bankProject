<?php

$db = quickConnectDB();
$clientList = mysql_query("SELECT * FROM clients");
mysql_close($db);

$action = 'showClientDatas';
if(isset($_GET['action']) && !empty($_GET['action'])){
	$action = $_GET['action'];
}

echo '<form name="clientID" method="GET" action="admin.php" > 
<fieldset><legend>Choix de l\'id client</legend>';

if(mysql_num_rows($clientList) != 0){
	
	echo '<input type="hidden" name="action" value="'.$action.'"/>
	<select name="clientID" >';
	while($client = mysql_fetch_array($clientList)){
		echo '<option value="'.$client[0].'">'. $client[0] . ' - ' . $client[2] . ' ' . $client[3] . '</option>';
	}
	echo '</select>';
	echo '<input type="submit" value="Valider" />';
}

else{
	echo 'Aucun client présent dans la base de données';
}

echo '</fieldset> </form>';




?>