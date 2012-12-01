<?php
include("../header.php"); 
?>


<nav>
	<ul>
		<li><a href="./agent.php">Acceuil</li>
		<li><a href="./agent.php?action=modifier">Modifier</li>
		<li><a href="./agent.php?action=consulter">Consulter</li>
		<li><a href="./agent.php?action=depot">Depot/Retrait</a></li>
		<li><a href="./agent.php?action=rdv">Prendre un rdv</a></li>
	</ul>
</nav>

<?php

if(!isset($_GET['selectClient']) || empty($_GET['selectClient'])){
	echo '
	Veuillez choisir un client
	<section class="choixClient">
	<form method="GET" action="./agent.php">
	<fieldset>
	<legend>Choix d\'un client</legend>';
	

	if($bdd = mysql_connect($serverHostDB, $serverUserDB, $serverPasswdDB)){
		if($db = mysql_select_db($nameDB)){

			$query = "SELECT * FROM clients";
			$dbReturn = mysql_query($query);
			if(mysql_num_rows($dbReturn) != 0){
				echo '<select name="selectClient" size="1">
				<option value="">---------------</option>';
				while($client = mysql_fetch_array($dbReturn)){
					echo '<option value="' . $client[0]. '">' .$client[2]. ' ' .$client[3].'</option>';
				}


				echo '</select>';
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

	<fieldset>
	<legend>Recherche d\'un client</legend>
	<label for="prenom">Prenom : </label>
	<input type="text" name="prenom"/>
	<br/>
	<label for="nom">Nom : </label>
	<input type="text" name="nom"/>
	<br/>
	<input type="submit"/>
	</fieldset>

	</form>
	</section>';
	

}


else //if(isset($_GET['IDClient']) && !empty($_GET['IDClient']))
{

	if(isset($_GET['action']) && $_GET['action'] == 'modifier'){

	}

	else if(isset($_GET['action']) && $_GET['action'] == 'consulter' ){

	}

	else if(isset($_GET['action']) && $_GET['action'] == 'depot' ){

	}

	else if(isset($_GET['action']) && $_GET['action'] == 'rdv' ){

	}
}


?>



<?php include("../footer.php"); ?>