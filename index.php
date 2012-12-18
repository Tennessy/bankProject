<?php include("header.php"); ?>

<?php

	if (isset($_SESSION['id_employee'])) {
		echo'
		<div id="bloc">
			<p>Accueil<p>
			<p>Accès à la page <a href="admin.php">admin</a></p>
		</div>
		';
	}

?>

<?php include("footer.php"); ?>
