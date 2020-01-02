<?php
include 'verify.php';
if (!$verified) header("Refresh:0 url=index.php");
?>

<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="main.css">
	<link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
</head>
<body>
	<div class="sidebar">
		<a style="text-decoration: none;" href="home.php"><button id="home">Home</button></a><br/>
		<a style="text-decoration: none;" href="plans.php"><button id="plans">My Plans</button></a><br/>
		<a style="text-decoration: none;" href="account.php"><button id="account">Account</button></a><br/>
		<form method="post"><button name="logout" style="margin-top: 320%;">Logout</button></form>
	</div>
</body>

<?php
if (isSet($_POST['logout'])) {
	unset($_POST['logout']);
	unset($_SESSION['email']);
	header("Refresh:0 url=index.php");
}
?>

</html>