<?php


if(isset($_POST['actionForm']) && !empty($_POST['actionForm']) && $_POST['actionForm'] == 'change'){

	$erreur=false;

	for($i = 0; $i < count($_POST)-4; $i++){

		if($i != 4 && $i != 5 && $i!= 15 && (!isset($_POST[$i]) || empty($_POST[$i]))){
			$erreur=true;
		}

		else if($i == 4 || $i == 5){
			if(!isset($_POST['4']) || empty($_POST['4'])){
				$_POST['4'] = '';
			}

			if(!isset($_POST['5']) || empty($_POST['5'])){
				$_POST['5'] = '';
			}
		}	

		else if(($i == 0 || $i ==1) && (!is_numeric($_POST['0']) || !is_numeric($_POST['1']) || $_POST['1'] < 0 || $_POST['0'] < 0 || $_POST['1'] > 99999999 || $_POST['0'] > 99999999)){
			$erreur = true;	
		}

		else if($i==7 && ($_POST['7'] != 'M' && $_POST['7'] != 'F' )){
			$erreur = true;
		}

		else if ($i==9 && ($_POST['9'] != 'MA' && $_POST['9'] != 'DI' && $_POST['9'] != 'SI')){
			$erreur = true;
		}

		else if($i==14  && !is_numeric($_POST['14'])){
			$erreur = true;
		}
		else if($i==15){
			if(!isset($_POST['15']) || empty($_POST['15'])){
				$_POST['15'] = '';
			}
		}
	}

	if(isset($_POST['mois']) && !empty($_POST['mois']) && isset($_POST['annee']) && !empty($_POST['annee']))
		$birthDate = $_POST['annee'] . '-' . $_POST['mois'] . '-' . $_POST['6'];

	else{
		$erreur = true;
		echo 'date';
	}

	if(!$erreur){
		if($bdd = mysql_connect($serverHostDB, $serverUserDB, $serverPasswdDB)){
			if($db = mysql_select_db($nameDB)){
				$query = "UPDATE clients SET lastName='" . $_POST['2'] . "', firstName='".$_POST['3']."', secondName='".$_POST['4']."', thirdName='".$_POST['5']."', birthDate='".$birthDate."', gender='".$_POST['7']."', job='".$_POST['8']."', civilStatus='".$_POST['9']."', address_location='".$_POST['10']."', address_city='".$_POST['11']."', address_zipcode='".$_POST['12']."', address_state='".$_POST['13']."', phone_home='".$_POST['14']."', phone_mobile='".$_POST['15']."', email='".$_POST['16']."' WHERE id_client=".$_POST['0'];
				mysql_query($query);
				echo showFormSuccess('Modifications effectuées avec succès');
				
			}

			else{
				echo showFormError('', 'Erreur de connection à la base de données');
			}
		}

		else{
			echo showFormError('', 'Erreur de connection au serveur de bases de données');
		}
	}

	else{
		echo showFormError('', 'Les valeurs entrées sont incorrectes');
	}

}

echo "<form name='ClientInfo' method='POST' action='./admin.php?action=changeClientDatas&clientID=".$_GET['clientID']."' class='form_admin' onSubmit='return verifForm(this)'>
<fieldset>
<legend>Modification des informations client</legend>";
$clientDatas = getClientDatas($_GET['clientID']);

if($clientDatas != null){
	echo '<input type="hidden" name="0" value="'. $clientDatas[0] .'">';
	echo '<input type="hidden" name="1" value="'. $clientDatas[1] .'">';
	$birthDate = explode('-', $clientDatas[6]);

	for($i=2; $i<17; $i++){
		switch ($i){
			case 6:
			echo '<label for="jours">Date de naissance : </label><select name="6">';
			for($j=1; $j<=31; $j++){
				echo '<option value="'.$j.'" ';
				if($birthDate[2] == $j){echo 'selected="selected"';}
				echo '>'.$j.'</option>';
			}
			echo '</select>'; 

			echo '<select name="mois">';
			for($j=1; $j<=12; $j++){
				echo '<option value="'.$j.'" ';
				if($birthDate[1] == $j){echo 'selected="selected"';}
				echo '>'.$j.'</option>';
			}
			echo '</select>';

			echo '<select name="annee">';
			for($j=1900; $j<=Date('Y'); $j++){
				echo '<option value="'.$j.'" ';
				if($birthDate[0] == $j){echo 'selected="selected"';}
				echo '>'.$j.'</option>';
			}
			echo '</select><br/>';
			break;

			case 7:
			echo '<label for="'.$i.'">' .$dataName[$i]. ' : </label> <input type="radio" name="' .$i .'"';
			if($clientDatas['gender'] == 'M'){
				echo   '" checked="checked ';
			}
			echo '" value="M">Homme';

			echo '<input type="radio" name="' .$i;
			if($clientDatas['gender'] == 'F'){
				echo 'checked="checked';
			}
			echo '" value="F">Femme <br/>';
			break;

			case 9:
			echo '<label for="'.$i.'">' .$dataName[$i]. ' : </label> <input type="radio" name="' .$i . '"';
			if($clientDatas['civilStatus'] == 'SI'){ echo 'checked="checked" ';}
			echo 'value="SI" >Célibataire';

			echo '<input type="radio" name="' .$i .'"';
			if($clientDatas['civilStatus'] == 'DI'){ echo 'checked="checked" ';}
			echo 'value="DI" >Divorcé';

			echo '<input type="radio" name="' .$i .'"';
			if($clientDatas['civilStatus'] == 'MA'){ echo 'checked="checked" ';}
			echo 'value="MA" >Marié<br/>';
			break;

			default :
			echo '<label for="'.$i.'">' .$dataName[$i]. ' : </label><input type="text" name="' . $i . '" value="'. $clientDatas[$i] .'" onBlur="verifChamps(this, ';
				if($i==4 || $i==5 || $i==15){
					echo 'true, '; 	
				}
				else{
					echo 'false, '; 	
				}
				
				if($i == 16){
					echo '2';
				}
				else if(is_numeric($clientDatas[$i])){
					echo '0';
				}
				else{
					echo '1';
				}

				echo ', 0';
				
				echo ')"></br>';
			break;
}



}
echo '<input type="hidden" name="actionForm" value="change">';
echo "<input type='submit' name='action' value='Valider'>";
echo "<input type='reset' name='action' value='Réinitialiser'></fieldset></form>";
}

echo '</fieldset></form>';

?>