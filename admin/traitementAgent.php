<?php
include('../conf.php');

$erreur=false;

for($i = 0; $i < count($_POST)-1; $i++){
	echo $i. '/' . $_POST[$i].'<br/>';
}

for($i = 0; $i < count($_POST)-1; $i++){
	if(!isset($_POST[$i]) || empty($_POST[$i])){
		$erreur=true;
	}	

	else if(($i == 0 || $i ==1) && (!is_numeric($_POST['0']) || !is_numeric($_POST['1']) || $_POST['1'] < 0 || $_POST['0'] < 0 || $_POST['1'] > 99999999 || $_POST['0'] > 99999999)){
		$erreur = true;	
	}

	else if($i==9 && ($_POST['9'] != 'm' && $_POST['9'] != 'f' )){
		$erreur = true;
	}

	else if ($i==11 && ($_POST['11'] != 's' && $_POST['11'] != 'm' && $_POST['11'] != 'c')){
		$erreur = true;
	}

	else if(($i==16 || $i==17) && (!is_numeric($_POST['16']) || !is_numeric($_POST['17']))){
		$erreur = true;
	}
}



if(!$erreur){
	if($bdd = mysql_connect($serverHostDB, $serverUserDB, $serverPasswdDB)){
		if($db = mysql_select_db($nameDB)){
			$query = "UPDATE clients SET lastName='" . $_POST['2'] . "', firstName='".$_POST['3']."', secondName='".$_POST['4']."', thirdName='".$_POST['5']."', birthDate='".$_POST['6']."', gender='".$_POST['7']."', job='".$_POST['8']."', civilStatus='".$_POST['9']."', address_location='".$_POST['10']."', address_city='".$_POST['11']."', address_zipcode='".$_POST['12']."', address_state='".$_POST['13']."', phone_home='".$_POST['14']."', phone_mobile='".$_POST['15']."', email='".$_POST['16']."' WHERE id_client=".$_POST['0'];
			mysql_query($query);
			//header("location: /admin.php?action=showClientDatas&clientID=".$_POST['0']);
		}

		else{
			echo "erreur de connection à la base de données";
		}
	}

	else{
		echo "erreur de connexion au serveur de base de données";
	}
}

else{
	echo "Les entrees sont invalides";	
}

?>