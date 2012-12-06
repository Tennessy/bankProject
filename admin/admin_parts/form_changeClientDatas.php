<?php

echo "<form name='ClientInfo' method='POST' action='/admin/traitementAgent.php' class='form_admin'>
<fieldset>
<legend>Modification des informations client</legend>";
$clientDatas = getClientDatas($_GET['clientID']);

if($clientDatas != null){

	echo '<input type="hidden" name="0" value="'. $clientDatas[0] .'"/></br>';
	echo '<input type="hidden" name="1" value="'. $clientDatas[1] .'"/></br>';

	for($i=2; $i<17; $i++){
		switch ($i){
			case 7:
			echo '<label for="'.$i.'">' .$dataName[$i]. ' : </label> <input type="radio" name="' .$i;
			if($clientDatas['gender'] == 'm'){
				echo   'checked="checked ';
			}
			echo '" value="m">Homme';
			echo '<input type="radio" name="' .$i;
			if($clientDatas['gender'] == 'f'){
				echo 'checked="checked';
			}
			echo '" value="f">Femme <br/>';
			break;

			case 9:
			echo '<label for="'.$i.'">' .$dataName[$i]. ' : </label> <input type="radio" name="' .$i;
			if($clientDatas[9] == )
			echo '<input type="radio" name="' .$i. '" value="c">Concubinage';
			echo '<input type="radio" name="' .$i. '" value="m">Marié <br/>';
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