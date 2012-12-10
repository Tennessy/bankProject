<?php include("header_session.php") ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html lang="fr" xml:lang="fr" xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<?php if(function_exists('redirectAutoLogin')) echo redirectAutoLogin(); ?>
	<title>TAKL Bank</title>
	<!--[if lt IE 9]>
		<script src="html5shiv.js"></script>
	<![endif]-->
	<link href="takl_bank.css" media="screen" type="text/css" rel="stylesheet" />
</head>

<body>
	<div id="page">
		<div id="header">
			<div id="header_login">
			<?php
				if (isset($_SESSION['id_employee'])) {
					echo 'Connecté en tant que ' . $_SESSION['category'];
					include(rootPhp("form_logout"));
				} else {
					include(rootPhp("form_login"));
				}
			?>
			</div>
		</div>
