<?php include("header.php"); ?>

<?php
	
	$noFormError = TRUE;
	require_once('admin/navPane.php');
	require('admin/' . $_SESSION['category'] . '.php');

?>

<?php include("footer.php"); ?>
