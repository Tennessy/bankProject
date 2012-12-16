<form method="GET" action="./admin.php" class="form_admin" onSubmit="return verifForm(this)">
    <fieldset>
        <legend>Choix d'un client par ID</legend>
         <input type="hidden" name="action" value="showClientDatas">
        <label for="clientID">ID : </label>
        <input type="text" name="clientID" onBlur="verifChamps(this, false, 0, 0)">
        <input type="submit" value="Valider">
    </fieldset>
</form>

<form method="GET" action="./admin.php" class="form_admin"  onSubmit="return verifForm(this)">
    <fieldset>
        <legend>Recherche d'un client</legend>
        <input type="hidden" name="action" value="searchClientName">
        <label for="clientName">Nom : </label>
        <input type="text" name="clientName" onBlur="verifChamps(this, false, 1, 0)">
        <label for="clientDay">Date de naissance : </label>
        <select name="clientDay">
            <?php
            for($i=1; $i<32; $i++){
                echo '<option value="'.$i.'">'.$i.'</option>';
            }
            ?>
        </select>
        <select name="clientMonth">
            <?php
            for($i=1; $i<13; $i++){
                echo '<option value="'.$i.'">'.$months[$i-1].'</option>';
            }
            ?>
        </select>
        <select name="clientYear">
            <?php
            for($i=1900; $i<(date('Y')+1); $i++){
                echo '<option value="'.$i.'">'.$i.'</option>';
            }
            ?>
        </select>
        <br/>
        <input type="submit" value="Rechercher">

    </fieldset>
</form>


<?php

if(isset($_GET['action']) && $_GET['action'] == 'searchClientName'){
    if(isset($_GET['clientName']) && !empty($_GET['clientName']) && isset($_GET['clientDay']) && !empty($_GET['clientDay']) && is_numeric($_GET['clientDay']) && isset($_GET['clientMonth']) && !empty($_GET['clientMonth']) && is_numeric($_GET['clientMonth']) && isset($_GET['clientYear']) && !empty($_GET['clientYear']) && is_numeric($_GET['clientYear'])){
        $birthDay = $_GET['clientYear'].'-'.$_GET['clientMonth'].'-'.$_GET['clientDay'];
        $db = quickConnectDB();
        $clientList = mysql_query("SELECT * FROM clients WHERE birthDate='{$birthDay}' AND lastName='{$_GET['clientName']}'");
        mysql_close($db);
        if(mysql_num_rows($clientList) != 0){
            while($client = mysql_fetch_array($clientList)){
                echo '<a href="./admin.php?action=showClientDatas&clientID='.$client['id_client'].'">'.$client['id_client'].' - '.$client['lastName']. ' '.$client['firstName'].'</a><br/>';
                
            }
        }
        else{
            echo 'Aucun client n\'à été trouvé';
        }
    }

    else{
        echo 'Veuillez remplir tous les champs';
    }
}
?>