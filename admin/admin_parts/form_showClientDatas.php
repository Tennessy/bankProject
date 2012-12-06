<?php
/*
$db = quickConnectDB();
$clientDatas = mysql_query('SELECT * FROM clients WHERE id_client="'.$_GET['clientID'].'"');
mysql_close($db);*/

$clientDatas = getClientDatas($_GET['clientID']);



echo "<form name='ClientInfo' class='form_admin'>
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

echo '</fieldset><fieldset><legend>Liste des comptes</legend>';


$db = quickConnectDB();
$clientAccounts = mysql_query('SELECT * FROM accounts WHERE id_owner="'.$_GET['clientID'].'"');
$clientContracts = mysql_query('SELECT * FROM contracts WHERE id_owner="'.$_GET['clientID'].'"');
mysql_close($db);

if(mysql_num_rows($clientAccounts) != 0){
	$i=1;
	while($clientAccount = mysql_fetch_array($clientAccounts)){
		echo '<fieldset><legend>Compte n°'.$i.'</legend>';

		echo '<label for="accountType"> Type de compte : </label> <input type="text" name="accountType" disabled="disabled" value=" '. $clientAccount[2].'"/><br/>';
		echo '<label for="accountOpeningDate"> Date d\'ouverture : </label> <input type="text" name="accountOpeningDate" disabled="disabled" value=" '. $clientAccount[3].'"/><br/>';
		echo '<label for="accountBalance"> Balance du compte : </label> <input type="text" name="accountBalance" disabled="disabled" value=" '. $clientAccount[4].'"/><br/>';
		echo '<label for="accountOverdraft"> Depassement autorisé : </label> <input type="text" name="accountOverdraft" disabled="disabled" value=" '. $clientAccount[5].'"/><br/>';
		echo '</fieldset>';
		$i++;
	}
}

else{
	echo 'Ce client ne possède aucun compte';
}

echo '</fieldset><fieldset><legend>Liste des contracts</legend>';
if(mysql_num_rows($clientContracts) != 0){
	$i=1;
	while($clientContract = mysql_fetch_array($clientContracts)){
		echo '<fieldset><legend>Contrat n°'.$i.'</legend>';

		echo '<label for="contractType"> Type de compte : </label> <input type="text" name="accountType" disabled="disabled" value=" '. $clientContract[2].'"/><br/>';
		echo '<label for="contractOpeningDate"> Date d\'ouverture : </label> <input type="text" name="accountOpeningDate" disabled="disabled" value=" '. $clientContract[3].'"/><br/>';
		echo '</fieldset>';
		$i++;
	}
}

else{
	echo 'Ce client ne possède aucun contract';
}

echo '</fieldset></form>';

?>