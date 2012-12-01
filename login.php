<?php include("header.php"); ?>

<?php

	function redirectAutoLogin() {
		if (isset($_SESSION['id_employee'])) {
			$redirectTo = '<meta http-equiv="refresh" content="5; URL= http://' . $_SERVER['HTTP_HOST'] . '/admin.php">';
			return $redirectTo;
		}
	}

?>

<?php include("footer.php"); ?>
