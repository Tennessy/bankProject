<?php

echo "<form name='ClientInfo' method='POST' action='/admin/traitementAgent.php' class='form_admin'>
<fieldset>
<legend>Modification des informations client</legend>";
$clientDatas = getClientDatas($_GET['clientID']);

if($clientDatas != null){

	echo '<input type="hidden" name="0" value="'. $clientDatas[0] .'"/>';
	echo '<input type="hidden" name="1" value="'. $clientDatas[1] .'"/>';
	$birthDate = explode('-', $clientDatas[6]);

	for($i=2; $i<17; $i++){
		switch ($i){
			case 6:
			echo '<label for="jours">Date de naissance : <select name="6">';
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
			if($clientDatas['gender'] == 'm'){
				echo   '" checked="checked ';
			}
			echo '" value="m">Homme';
			echo '<input type="radio" name="' .$i;
			if($clientDatas['gender'] == 'f'){
				echo 'checked="checked';
			}
			echo '" value="f">Femme <br/>';
			break;

			case 9:
			echo '<label for="'.$i.'">' .$dataName[$i]. ' : </label> <input type="radio" name="' .$i . '"';
			if($clientDatas['civilStatus'] == 's'){ echo 'checked="checked" ';}
			echo 'value="s" >Celibataire';

			echo '<input type="radio" name="' .$i .'"';
			if($clientDatas['civilStatus'] == 'c'){ echo 'checked="checked" ';}
			echo 'value="c" >Concubinage';

			echo '<input type="radio" name="' .$i .'"';
			if($clientDatas['civilStatus'] == 'm'){ echo 'checked="checked" ';}
			echo 'value="c" >Marié<br/>';
			break;

			default :
			echo '<label for="'.$i.'">' .$dataName[$i]. ' : </label><input type="text" name="' . $i . '" value="'. $clientDatas[$i] .'"/></br>';
			break;
		}

		
		
	}

	echo "<input type='submit' name='action' value='modifier'/></fieldset></form>";
}

echo '</fieldset></form>';

?>