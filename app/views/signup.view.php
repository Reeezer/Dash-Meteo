<?php
$title = "Dash Meteo - Login";
$page_class = "signup";

require_once "partials/header.php";

?>

<script>
    function validatePassword()
    {
        if ($('#password').val() == $('#password_confirmation').val())
            return true;
        else
            return false;
    }
</script>

<div class="content">
	<h1>Dash Meteo - Signup</h1>

	<form action="do_signup" method="post" onsubmit="return validatePassword()">
		<input name="email" type="email" placeholder="E-mail">
		<input id="password" name="password" type="password" placeholder="Password">
        <input id="password_confirmation" name="password_confirmation" type="password" placeholder="Repeat Password">
		<input type="submit" value="Submit">
	</form>
</div>

<?php require_once "partials/footer.php" ?>