<?php include("header_session.php") ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html lang="fr" xml:lang="fr" xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title>Login</title>
	<link href="index.css" media="screen" type="text/css" rel="stylesheet" />
</head>

<body>
	<div id="page">
		<header>
			<?php
				if (isset($_SESSION['id_employee'])) {
					include(htmlFileInPhp("form_logout"));
				} else {
					include(htmlFileInPhp("form_login"));
				}
			?>
		</header>

		<body>