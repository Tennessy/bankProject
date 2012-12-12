<?php
include('../conf.php');

$erreur=false;

// for($i = 0; $i < count($_POST)-1; $i++){
// 	echo $i. '/' . $_POST[$i].'<br/>';
// }
// echo $_POST['mois'];
// echo $_POST['annee'];

for($i = 0; $i < count($_POST)-3; $i++){

	if(!isset($_POST[$i]) || empty($_POST[$i])){
		$erreur=true;
	}	

	else if(($i == 0 || $i ==1) && (!is_numeric($_POST['0']) || !is_numeric($_POST['1']) || $_POST['1'] < 0 || $_POST['0'] < 0 || $_POST['1'] > 99999999 || $_POST['0'] > 99999999)){
		$erreur = true;	
		echo '1';
	}

	else if($i==7 && ($_POST['7'] != 'm' && $_POST['7'] != 'f' )){
		$erreur = true;
		echo '2';
	}

	else if ($i==9 && ($_POST['9'] != 's' && $_POST['9'] != 'm' && $_POST['9'] != 'c')){
		$erreur = true;
		echo '3';
	}

	else if(($i==14 || $i==15) && (!is_numeric($_POST['14']) || !is_numeric($_POST['15']))){
		$erreur = true;
		echo '4';
	}
}
if(isset($_POST['mois']) && !empty($_POST['mois']) && isset($_POST['annee']) && !empty($_POST['annee']))
	$birthDate = $_POST['annee'] . '-' . $_POST['mois'] . '-' . $_POST['6'];
else
	$erreur = true;

if(!$erreur){
	if($bdd = mysql_connect($serverHostDB, $serverUserDB, $serverPasswdDB)){
		if($db = mysql_select_db($nameDB)){
			$query = "UPDATE clients SET lastName='" . $_POST['2'] . "', firstName='".$_POST['3']."', secondName='".$_POST['4']."', thirdName='".$_POST['5']."', birthDate='".$birthDate."', gender='".$_POST['7']."', job='".$_POST['8']."', civilStatus='".$_POST['9']."', address_location='".$_POST['10']."', address_city='".$_POST['11']."', address_zipcode='".$_POST['12']."', address_state='".$_POST['13']."', phone_home='".$_POST['14']."', phone_mobile='".$_POST['15']."', email='".$_POST['16']."' WHERE id_client=".$_POST['0'];
			mysql_query($query);
			header("location: /admin.php?action=showClientDatas&clientID=".$_POST['0']);
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