<?php 

$db = quickConnectDb();
if(isset($_POST['depot']) || isset($_POST['retrait'])){
	if(!empty($_POST['depot']) && is_numeric($_POST['depot']) && isset($_POST['accountID']) && !empty($_POST['accountID']) && is_numeric($_POST['accountID']) && (!isset($_POST['retrait']) || empty($_POST['retrait']))){

		if($_POST['depot']>0){
			$balanceAccount = mysql_fetch_array(mysql_query("SELECT balance FROM `accounts` WHERE id_owner= '{$_GET['clientID']}'"));
			$total = $balanceAccount['balance'] + $_POST['depot'];
			mysql_query("UPDATE accounts SET balance='{$total}' WHERE id_account='{$_POST['accountID']}'");
		}
		else{
			echo 'Merci d\'indiquer un montant positif dans le cas d\'un dépot';
		}

	}

	else if(!empty($_POST['retrait']) && is_numeric($_POST['retrait']) && isset($_POST['accountID']) && !empty($_POST['accountID']) && is_numeric($_POST['accountID']) && (!isset($_POST['depot']) || empty($_POST['depot']))){
		if($_POST['retrait']>0){
			$balanceAccount = mysql_fetch_array(mysql_query("SELECT balance, overdraft FROM `accounts` WHERE id_owner= '{$_GET['clientID']}'"));
			$total = $balanceAccount['balance'] - $_POST['retrait'];
			if($total >= 0 - $balanceAccount['overdraft'])
				mysql_query("UPDATE accounts SET balance='{$total}' WHERE id_account='{$_POST['accountID']}'");
			else
				echo 'Merci de rentrer un montant ne dépassant pas le découvert';
		}
		else{
			echo 'Merci d\'indiquer un montant positif dans le cas d\'un retrait';
		}
	}

	else{
		echo 'Merci de remplir correctement le formulaire';
	}
}


$query = "SELECT * FROM `accounts` WHERE id_owner= '{$_GET['clientID']}'";
$clientAccountList = mysql_query($query);

if(mysql_num_rows($clientAccountList) != 0){
	
	while($clientAccounts = mysql_fetch_array($clientAccountList)){	
		$accountType = mysql_query("SELECT `name` FROM `accounts-type` WHERE `id_account-type`='{$clientAccounts['account-type']}'");
		$accountTypeName = mysql_fetch_array($accountType);

		echo '<form action="admin.php?action=transferMoney&clientID='. $_GET['clientID'] .'" method="POST" ><fieldset><legend>Compte '. $accountTypeName['name'] .'</legend><input type="hidden" name="accountID" value="'.$clientAccounts['id_account'].'"  <label for="balanceAccount">Balance du compte : <input type="text" disabled="disabled" name="balanceAccount" value="'.$clientAccounts['balance'].'€" /></label><br/><label for"depot">Depot : <input type="text" name="depot"/></label><br/><label for"retrait">Retrait : <input type="text" name="retrait"/><br/></label><input type="submit"/> </fieldset> </form>';

	}

	
}

else{
	echo 'Ce client ne possède aucun compte';
}
mysql_close($db);

?>