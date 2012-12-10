<?php require_once("header.php"); ?>

<?php
	
	$queryDB = TRUE;
	$incompleteForm = FALSE;
	include_once('admin/navPane.php');
	echo '<div id="content">';
	if(isset($_SESSION['category'])) {
		include_once('admin/' . $_SESSION['category'] . '.php');
	}
	echo '</div>'

?>

<?php require_once("footer.php"); ?>
