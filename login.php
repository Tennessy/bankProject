<?php include("header.php"); ?>

<?php

	function redirectAutoLogin() {
		if (isset($_SESSION['id_employee'])) {
			$redirectTo = '<meta http-equiv="refresh" content="3; URL= http://' . $_SERVER['HTTP_HOST'] . '/admin.php">';
			return $redirectTo;
		}
	}

	if (isset($_SESSION['id_employee'])) {
		echo'
		<div id="bloc">
			<p>Vous êtes maintenant connecté.</p>
			<p>Redirection dans quelques secondes</p>
		</div>
		';
	}

?>

<?php include("footer.php"); ?>
