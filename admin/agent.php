<?php

$dataName = array('id client', 'id employee', 'Nom', 'Prenom', 'Deuxième prenom', 'Troisième prenom', 'Date de naissance', 'Genre', 'Emploi', 'Status civil', 'Adresse', 'Ville', 'Code postal', 'Etat', 'Numero de Telephone', 'Numero de portable', 'Email');

if($_SESSION['category'] == 'agent'){
	if(isset($_GET['clientID']) && !empty($_GET['clientID'])){

		if(isset($_GET['action']) && $_GET['action'] == 'showClientDatas'){
			include('admin/admin_parts/form_showClientDatas.php');
		}

		else if(isset($_GET['action']) && $_GET['action'] == 'changeClientDatas'){
			include('admin/admin_parts/form_changeClientDatas.php');
		}

		else{
			echo("Merci de choisir un action valide");
		}
	}

	else{
		include('admin/admin_parts/form_clientID.php');
	}
}


/*
echo '<nav>
<ul>
<li><a href="./agent.php">Acceuil</li>
<li><a href="./agent.php?action=modifier&selectClient=' . $_GET["selectClient"] .  '">Modifier</li>
<li><a href="./agent.php?action=consulter&selectClient=' . $_GET["selectClient"] .  '">Consulter</li>
<li><a href="./agent.php?action=depot">Depot/Retrait</a></li>
<li><a href="./agent.php?action=rdv">Prendre un rdv</a></li>
</ul>
</nav>';

?>



<?php

if(isset($_GET['name']) && !empty($_GET['name']) && isset($_GET['firstName']) && !empty($_GET['firstName'])){
	if($bdd = mysql_connect($serverHostDB, $serverUserDB, $serverPasswdDB)){
		if($db = mysql_select_db($nameDB)){
			$query = "SELECT * FROM clients WHERE lastName='".$_GET['name']."' AND firstName='".$_GET['firstName']."'";
			$dbReturn = mysql_query($query);
			if(mysql_num_rows($dbReturn) != 0){
				while($client = mysql_fetch_array($dbReturn)){
					echo '<a href="./agent.php?action=consulter&selectClient='. $client[0] .'">'.$client[2]. ' ' . $client[3] . ' ' . $client[4] . "</a><br/>";
				}
			}
			else
				echo "Client non présent dans la base <br/>";
		}
		else
			echo "Erreur de connexion à la base de données <br/>";
	}
	else
		echo "Erreur de connection au serveur de  base de données <br/>";
}

if(!isset($_GET['selectClient']) || empty($_GET['selectClient'])){
	echo '
	<section class="choixClient">
	<form method="GET" action="./agent.php">
	<fieldset>
	<legend>Choix d\'un client</legend>';


	if($bdd = mysql_connect($serverHostDB, $serverUserDB, $serverPasswdDB)){
		if($db = mysql_select_db($nameDB)){

			$query = "SELECT * FROM clients";
			$dbReturn = mysql_query($query);
			if(mysql_num_rows($dbReturn) != 0){
				echo '<select name="selectClient" size="1" >
				<option value="">---------------</option>';
				while($client = mysql_fetch_array($dbReturn)){
					echo '<option value="' . $client[0]. '">' .$client[2]. ' ' .$client[3].'</option>';
				}


				echo '</select>';
				echo '<input type="submit" name="action" value="consulter"/>';
			}

			else{
				echo "Aucun client présent dans la base de données";
			}
		}

		else{
			echo "Erreur de connexion à la base de données";
		}

		mysql_close($bdd);
	}

	else{
		echo "Erreur de connexion au serveur de la base de données";
	}

	echo '</fieldset>
	</form>

	<form name="clientSearch" method="GET" action="./agent.php">
	<fieldset>
	<legend>Recherche d\'un client</legend>
	<label for="firstName">Prenom : </label>
	<input type="text" name="firstName"/>
	<br/>
	<label for="name">Nom : </label>
	<input type="text" name="name"/>
	<br/>
	<input type="submit"/>
	</fieldset>

	</form>
	</section>';


}


else //if(isset($_GET['IDClient']) && !empty($_GET['IDClient']))
{

	if(isset($_GET['action']) && $_GET['action'] == 'modifier'){
		echo "<form name='ClientInfo' method='POST' action='./traitementAgent.php'>
		<fieldset>
		<legend>Modification des informations client</legend>";
		$clientDatas = getClientInfos($_GET['selectClient']);
		if($clientDatas[2] != "" ){

			echo '<input type="hidden" name="0" value="'. $clientDatas[0] .'"/></br>';
			echo '<input type="hidden" name="1" value="'. $clientDatas[1] .'"/></br>';
			for($i=2; $i<17; $i++){
				echo '<input type="text" name="' . $i . '" value="'. $clientDatas[$i] .'"/></br>';
			}

			echo "<input type='submit' name='action' value='modifier'/></fieldset></form>";
		}
	}

	else if(isset($_GET['action']) && $_GET['action'] == 'consulter' ){
		echo "<form name='ClientInfo'>
		<fieldset>
		<legend>Informations Client</legend>";
		$clientDatas = getClientInfos($_GET['selectClient']);
		if($clientDatas[3] != "" ){
			for($i=2; $i<17; $i++){
				echo '<input type="text" name="' . $i . '" value="'. $clientDatas[$i] .'" disabled="disabled"/></br>';
			}
		}
	}

	else if(isset($_GET['action']) && $_GET['action'] == 'depot' ){

	}

	else if(isset($_GET['action']) && $_GET['action'] == 'rdv' ){

	}
}
*/
function getClientDatas($id){
	$db = quickConnectDb();
	$clientDatas = mysql_query('SELECT * FROM clients WHERE id_client="' . $id . '"');
	mysql_close($db);

	if(mysql_num_rows($clientDatas) != 0){
		return mysql_fetch_array($clientDatas);
	}

	return null;
}

?>
