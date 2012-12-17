
<?php


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
			if(isset($_GET['conseillerID']) && !empty($_GET['conseillerID']))
				include("admin/admin_parts/form_addEvent.php");
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


?>
<script type="text/javascript">
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

function verifForm(form){
	var inputList = form.getElementsByTagName('input');
	//alert(inputList[1].value);

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

function verifTransfer(input){
	if(isNaN(input.value) || input.value < 0){
		input.style.backgroundColor = 'red';
	}
	else{
		input.style.backgroundColor = 'white';
	}
}

</script>