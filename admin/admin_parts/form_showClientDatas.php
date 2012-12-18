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
		$birthday = explode('-', $clientDatas[6]);
		for($i=2; $i<17; $i++){
			switch($i){

				case 6:
				echo '<label for="'.$i.'">' .$dataName[$i]. ' : </label><input type="text" name="' . $i . '" value="'. $birthday[2].'/'.$birthday[1].'/'.$birthday[0] .'" disabled="disabled"/></br>';
				break;

				case 7:
				echo '<label for="'.$i.'">' .$dataName[$i]. ' : </label><input type="text" name="' . $i . '" value="';
				if($clientDatas[7] == 'M') {echo 'Homme';}
				else { echo 'Femme'; }
				echo '" disabled="disabled"/></br>';
				break;

				case 9:
				echo '<label for="'.$i.'">' .$dataName[$i]. ' : </label><input type="text" name="' . $i . '" value="';
				if($clientDatas[9] == 'SI') {echo "Celibataire";}
				else if($clientDatas[9] == 'DI') {echo "Divorcé";}
				else {echo "Marié";}
				echo '" disabled="disabled"/></br>';
				break;

				default:
				echo '<label for="'.$i.'">' .$dataName[$i]. ' : </label><input type="text" name="' . $i . '" value="'. $clientDatas[$i] .'" disabled="disabled"/></br>';
			}
		}
	}
	else{
		echo 'Le client n\'existe pas dans la base de données';
	}

	echo '</fieldset><fieldset><legend>Liste des comptes</legend>';


	$db = quickConnectDB();
	$clientAccounts = mysql_query('SELECT * FROM accounts WHERE id_owner="'.$_GET['clientID'].'"');
	$clientContracts = mysql_query('SELECT * FROM contracts WHERE id_owner="'.$_GET['clientID'].'"');
	

	if(mysql_num_rows($clientAccounts) != 0){
		$i=1;
		while($clientAccount = mysql_fetch_array($clientAccounts)){
			$accountList = mysql_query("SELECT * FROM `accounts-type` WHERE `id_account-type`='{$clientAccount['account-type']}'");
			if(mysql_num_rows($accountList) != 0){
				$account= mysql_fetch_array($accountList);
				$openingDate = explode("-", $clientAccount[3]);

				echo '<fieldset><legend>Compte n°'.$i.'</legend>';

				echo '<label for="accountTypeName"> Nom de compte : </label> <input type="text" name="accountTypeName" disabled="disabled" value=" '. $account['name'].'"/><br/>';
				echo '<label for="accountDocumentRequiered"> Document requis : </label> <input type="text" name="accountDocumentRequiered" disabled="disabled" value=" '. $account['documentsRequired'].'"/><br/>';
				echo '<label for="accountOpeningDate"> Date d\'ouverture : </label> <input type="text" name="accountOpeningDate" disabled="disabled" value=" '. $openingDate[2]. '/' . $openingDate[1]. '/'. $openingDate[0] .'"/><br/>';
				echo '<label for="accountBalance"> Balance du compte : </label> <input type="text" name="accountBalance" disabled="disabled" value=" '. $clientAccount[4].'"/><br/>';
				echo '<label for="accountOverdraft"> Depassement autorisé : </label> <input type="text" name="accountOverdraft" disabled="disabled" value=" '. $clientAccount[5].'"/><br/>';
				echo '</fieldset>';
				$i++;
			}
			
		}
	}

	else{
		echo 'Ce client ne possède aucun compte';
	}


	echo '</fieldset><fieldset><legend>Liste des contracts</legend>';
	if(mysql_num_rows($clientContracts) != 0){
		$i=1;
		while($clientContract = mysql_fetch_array($clientContracts)){
			
			$contractList = mysql_query("SELECT * FROM `contracts-type` WHERE `id_contract-type`='{$clientContract['contract-type']}'");
			if(mysql_num_rows($contractList) != 0){
				$contract = mysql_fetch_array($contractList);
				$openingDate = explode("-", $clientContract[3]);
				echo '<fieldset><legend>Contrat n°'.$i.'</legend>';

				echo '<label for="contractTypeName"> Nom du contract : </label> <input type="text" name="contractTypeName" disabled="disabled" value=" '. $contract['name'].'"/><br/>';
				echo '<label for="contractCost"> Cout mensuel : </label> <input type="text" name="contractCost" disabled="disabled" value=" '. $contract['monthlyCost'].'"/><br/>';
				echo '<label for="contractDocumentRequiered"> Document requis : </label> <input type="text" name="contractDocumentRequiered" disabled="disabled" value=" '. $contract['documentsRequired'].'"/><br/>';
				echo '<label for="contractOpeningDate"> Date d\'ouverture : </label> <input type="text" name="contractOpeningDate" disabled="disabled" value=" '. $openingDate[2]. '/' . $openingDate[1]. '/'. $openingDate[0].'"/><br/>';
				echo '</fieldset>';
				$i++;
			}

		}
	}

	else{
		echo 'Ce client ne possède aucun contract';
	}

	mysql_close($db);
	echo '</fieldset></form>';

	?>