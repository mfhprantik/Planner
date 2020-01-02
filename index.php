<?php
include 'verify.php';
if ($verified) header("Refresh:0 url=home.php");
?>

<!DOCTYPE html>
<html>
<head>
	<title>Planner | Login</title>
	<link rel="stylesheet" type="text/css" href="main.css">
	<link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
</head>
<body>
	<div class="formLS">
		<form method="post">
			<input type="email" name="email" placeholder="Email" required="true"/><br/>
			<input type="password" name="password" placeholder="Password" required="true"/></br>
			<button name="login">Login</button></br>
		</form>
		<a href="signup.php"><button name="signup" style="margin-top: 1px">Sign Up</button></a>
	</div>
</body>

<?php
require_once('Settings/config.php');
$email = $password = NULL;

if (isset($_POST['login'])) {
	unset($_POST['login']);
	$email = $_POST['email'];
	$password = $_POST['password'];

	$sql = "SELECT COUNT(*), `name`, `id` FROM `user` WHERE `email`='" . $email . "' AND `password`='" . $password . "' LIMIT 1";
	$result = $conn->query($sql);
	$value = $result->fetch_assoc();

	if ($value['COUNT(*)'] == 1) {
		header("Refresh:0; url=home.php");
		$_SESSION['email'] = $email;
		$_SESSION['password'] = $password;
		$_SESSION['name'] = $value['name'];
		$_SESSION['id'] = $value['id'];
	} else {
		echo "<script type=\"text/javascript\">
		alert(\"Incorrect email or/and password.\");
		</script>";
		header("Refresh:0; url=index.php");
	}
}
?>

</html>