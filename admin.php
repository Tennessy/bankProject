<?php include("header.php"); ?>

<?php
	
	$queryDB = TRUE;
	require_once('admin/navPane.php');
	require('admin/' . $_SESSION['category'] . '.php');

?>

<?php include("footer.php"); ?>
