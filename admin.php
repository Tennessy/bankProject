<?php include("header.php"); ?>

<?php
	
	$queryDB = TRUE;
	$incompleteForm = FALSE;
	require_once('admin/navPane.php');
	require('admin/' . $_SESSION['category'] . '.php');

?>

<?php include("footer.php"); ?>
