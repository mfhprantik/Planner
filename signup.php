<?php
include 'verify.php';
if ($verified) header("Refresh:0 url=home.php");
?>

<!DOCTYPE html>
<html>
<head>
	<title>Planner | Sign Up</title>
	<link rel="stylesheet" type="text/css" href="main.css">
	<link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
</head>
<body>
	<div class="formLS">
		<form method="post">
			<input type="text" name="name" placeholder="Full Name" required="true"/><br/>
			<input type="email" name="email" placeholder="Email" required="true"/><br/>
			<input type="password" name="password" placeholder="Password" required="true"/></br>
			<input type="password" name="password2" placeholder="Confirm Password" required="true"></br>
			<button name="signup">Sign Up</button></br>
		</form>
		<a href="index.php"><button name="login" style="margin-top: 1px">Login</button></a>
	</div>
</body>

<?php
require_once('Settings/config.php');

$name = $email = $password = $password2 = NULL;
$value = NULL;

if (isset($_POST['signup'])) {
	unset($_POST['signup']);
	$name = $_POST['name'];
	$email = $_POST['email'];
	$password = $_POST['password'];
	$password2 = $_POST['password2'];

	if (strcasecmp($password, $password2) == 0) {
		$sql = "SELECT COUNT(*) FROM `user` WHERE `email`='" . $email . "' LIMIT 1";
		$result = $conn->query($sql);
		$value = $result->fetch_assoc();
		echo $value['COUNT(*)'];

		if ($value['COUNT(*)'] == 0) {
			$sql = "INSERT INTO `user`(`name`, `email`, `password`) VALUES ('" . $name . "','" . $email . "','" . $password . "')";
			$result = $conn->query($sql);

			if ($result) {
				echo "<script type=\"text/javascript\">
				alert(\"Account creation successful.\");
				</script>";
				header("Refresh:0; url=index.php");
			} else {
				echo "<script type=\"text/javascript\">
				alert(\"Something went wrong. Account creation failed.\");
				</script>";
				header("Refresh:0; url=signup.php");
			}
		} else {
			echo "<script type=\"text/javascript\">
			alert(\"Account associated with same email address already exists.\");
			</script>";
			header("Refresh:0; url=signup.php");
		}
	} else {
		echo "<script type=\"text/javascript\">
		alert(\"Passwords do not match.\");
		</script>";
		header("Refresh:0; url=signup.php");
	}
}

?>
</html>