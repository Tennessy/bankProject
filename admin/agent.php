<?php

if($_SESSION['category'] == 'agent'){
		// Si le client selectionné existe
	if(isset($_GET['clientID']) && !empty($_GET['clientID']) && getClientDatas($_GET['clientID']) != null){
			//Afficher les informations clients
		if(isset($_GET['action']) && $_GET['action'] == 'showClientDatas'){
			include('admin/admin_parts/form_showClientDatas.php');
		}
			//Modifier les informations clients
		else if(isset($_GET['action']) && $_GET['action'] == 'changeClientDatas'){
			include('admin/admin_parts/form_changeClientDatas.php');
		}
			//Depot/Retrait
		else if(isset($_GET['action']) && $_GET['action'] == 'transferMoney'){
			include('admin/admin_parts/form_moneyTransfer.php');
		}
			//Afficher l'agenda
		else if(isset($_GET['action']) && $_GET['action'] == 'showAgenda'){
			include('admin/admin_parts/form_showAgenda.php');

				//Ajouter un rendez-vous au planning d'un conseiller, si celui-ci a été choisis
			if(isset($_GET['conseillerID']) && !empty($_GET['conseillerID']) && is_numeric($_GET['conseillerID']))
				include("admin/admin_parts/form_addEvent.php");
		}

		else{
			echo showFormError('',"Merci de choisir un action valide");
		}
	}

	else{
		if(isset($_GET['clientID']) && !empty($_GET['clientID'])){
			echo showFormError('','Ce client n\'éxiste pas dans la base de donnée');
		}
			//Formulaire de selection/recherche de client
		include('admin/admin_parts/form_clientID.php');
	}
}


?>
<script type="text/javascript">

	//Verification des champs lors d'un onBlur 
		//champ -> l'input a verifier
		//acceptVide -> true->Peut etre vide   false->Ne doit pas etre vide
		//type -> 0->Contient du texte	1->Contient des chiffres	2->Contient un e-mail
		//limite -> Taille maximum de caractère accepté		0-> Pas de limite
function verifChamps(champ, acceptVide, type, limite){
	var error = false;
	var reg = new RegExp('^[a-z0-9]+([_|\.|-]{1}[a-z0-9]+)*@[a-z0-9]+([_|\.|-]{1}[a-z0-9]+)*[\.]{1}[a-z]{2,6}$', 'i');

	if(!acceptVide && champ.value.length <= 0){
		champ.style.backgroundColor = 'red';
		error = true;
	}

	if(type == 0){
		if(isNaN(champ.value)){
			champ.style.backgroundColor = 'red';
			error = true;
		}
	}

	else if(type == 1){
		if(!isNaN(champ.value)){
			champ.style.backgroundColor = 'red';
			error = true;
		}
	}

	else if(type == 2){
		if(!reg.test(champ.value)){
			champ.style.backgroundColor = 'red';
			error = true;
		}
	}
	
	if(limite>0){
		if(champ.value.length > limite){
			champ.style.backgroundColor = 'red';
			error = true;
		}
	}

	if(!error){
		champ.style.backgroundColor = 'white';
	}

	return error;
}

	//Verifie si le form est remplie correctement
function verifForm(form){
	var inputList = form.getElementsByTagName('input');

	for(var i=0; i<inputList.length; i++){
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

	//Verifie au moment de l'envois si le form pour le transfere d'argent est remplie correctement
		//Si oui -> renvois true
		//Sinon -> renvois false et empèche l'envois
function verifTransferSubmit(form){
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

		else if(dep.value.length > 0 && dep.value <0 || ret.value.length > 0 && ret.value <0){
			alert('Merci d\'entrer une valeur positive');
			return false;
		}

		return true;
}

	//Verifie que l'on entre un nombre positif lors d'un onBlur pour le transfert d'argent
function verifTransfer(input){
	if(isNaN(input.value) || input.value < 0){
		input.style.backgroundColor = 'red';
	}
	else{
		input.style.backgroundColor = 'white';
	}
}

</script>