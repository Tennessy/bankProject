<?php include("header.php"); ?>

<?php

	function redirectAutoLogin() {
		if (isset($_SESSION['id_employee'])) {
			if ($_SESSION['category'] == 'A') {
				$categoryAdmin = 'agent';
			} else if ($_SESSION['category'] == 'C') {
				$categoryAdmin = 'conseiller';
			} else if ($_SESSION['category'] == 'D') {
				$categoryAdmin = 'directeur';
			}
			$redirectTo = '<meta http-equiv="refresh" content="10; URL= http://' . $_SERVER['HTTP_HOST'] . $categoryAdmin . '.php">';
			return $redirectTo;
		}
	}

?>

<?php include("footer.php"); ?>
