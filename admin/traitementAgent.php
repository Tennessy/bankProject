<?php
include('../conf.php');
if(isset($_POST['action']) && $_POST['action'] == 'modifier'){
	if($bdd = mysql_connect($serverHostDB, $serverUserDB, $serverPasswdDB)){
		if($db = mysql_select_db($nameDB)){
			$query = "UPDATE clients SET lastName='" . $_POST['2'] . "', firstName='".$_POST['3']."', secondName='".$_POST['4']."', thirdName='".$_POST['5']."', birthDate='".$_POST['6']."', gender='".$_POST['7']."', job='".$_POST['8']."', civilStatus='".$_POST['9']."', address_location='".$_POST['10']."', address_city='".$_POST['11']."', address_zipcode='".$_POST['12']."', address_state='".$_POST['13']."', phone_home='".$_POST['14']."', phone_mobile='".$_POST['15']."', email='".$_POST['16']."' WHERE id_client=".$_POST['0'];
			mysql_query($query);
			header("location: ./agent.php?action=consulter&selectClient=".$_POST['0']);
		}

		else{
			echo "erreur de connection à la base de données";
		}
	}

	else{
		echo "erreur de connexion au serveur de base de données";
	}
}

?>