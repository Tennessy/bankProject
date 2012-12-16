
<?php

$dataName = array('id client', 'id employee', 'Nom', 'Prenom', 'Deuxième prenom', 'Troisième prenom', 'Date de naissance', 'Genre', 'Emploi', 'Status civil', 'Adresse', 'Ville', 'Code postal', 'Etat', 'Numero de Telephone', 'Numero de portable', 'Email');
$months = array('Janvier','Fevrier', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Aout', 'Septembre', 'Octobre', 'Novembre', 'Decembre');

if($_SESSION['category'] == 'agent'){
	if(isset($_GET['clientID']) && !empty($_GET['clientID']) && getClientDatas($_GET['clientID']) != null){

		if(isset($_GET['action']) && $_GET['action'] == 'showClientDatas'){
			include('admin/admin_parts/form_showClientDatas.php');
		}

		else if(isset($_GET['action']) && $_GET['action'] == 'changeClientDatas'){
			include('admin/admin_parts/form_changeClientDatas.php');
		}

		else if(isset($_GET['action']) && $_GET['action'] == 'transferMoney'){
			include('admin/admin_parts/form_moneyTransfer.php');
		}

		else if(isset($_GET['action']) && $_GET['action'] == 'showAgenda'){
			include('admin/admin_parts/form_showAgenda.php');
		}

		else{
			echo("Merci de choisir un action valide");
		}
	}

	else{
		if(isset($_GET['clientID']) && !empty($_GET['clientID'])){
			echo 'Ce client n\'éxiste pas dans la base de donnée';
		}
		include('admin/admin_parts/form_clientID.php');
	}
}

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
<script type="text/javascript">
function verifChamps(champ, acceptVide, type, limite){
	console.log('ERROR');
	var error = false;
	var reg = new RegExp('^[a-z0-9]+([_|\.|-]{1}[a-z0-9]+)*@[a-z0-9]+([_|\.|-]{1}[a-z0-9]+)*[\.]{1}[a-z]{2,6}$', 'i');

	if(!acceptVide && champ.value.length <= 0){
		champ.style.backgroundColor = 'red';
		error = true;
		console.log('VIDE');
	}

	if(type == 0){
		if(isNaN(champ.value)){
			console.log('Not A Number');
			champ.style.backgroundColor = 'red';
			error = true;
		}
	}
	else if(type == 2){
		if(!reg.test(champ.value)){
			console.log('Pas un Email');
			champ.style.backgroundColor = 'red';
			error = true;
		}
	}
	
	if(limite>0){
		if(champ.value.length > limite){
			console.log('Trop Long');
			champ.style.backgroundColor = 'red';
			error = true;
		}
	}

	if(!error){
		champ.style.backgroundColor = 'white';
	}

	return error;
}

function verifForm(form){
	var inputList = form.getElementsByTagName('input');
	//alert(inputList[1].value);

	for(var i=0; i<inputList.length; i++){
		console.log(inputList[i].value)
		if(inputList[i].value.length <= 0){
			alert('Veuillez remplir tous les champs');
			return false;
		}
		if(inputList[i].style.backgroundColor == 'red'){
			alert('Merci de remplir correctement tous les champs');
			return false;
		}
	}
	return true;
}

function verifTransfer(form){
		var dep = form.elements['depot'];
		var ret = form.elements['retrait'];
		var bal = form.elements['balanceAccount']

		if(dep.value.length>0 && ret.value.length>0){
			alert('Merci de ne remplir qu\'un seul champ');
			return false;
		}

		else if(dep.value.length<=0 && ret.value.length<=0){
			alert('Merci de remplir un des deux champs');
			return false;
		}

}

</script>