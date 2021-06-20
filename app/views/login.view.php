<?php
$title = "Dash Meteo - Login";
$page_class = "login";

require_once "partials/header.php";

?>

<div class="content">
	<h1>Dash Meteo - Login</h1>

	<form action="do_login" method="post">
		<input name="email" type="email" placeholder="E-mail" >
		<input name="password" type="password" placeholder="Password">
		<input type="submit" value="Submit">
	</form>
</div>

<?php require_once "partials/footer.php" ?>