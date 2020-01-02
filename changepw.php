<!DOCTYPE html>
<html>
<head>
	<title>Planner | Change Password</title>
	<link rel="stylesheet" type="text/css" href="main.css">
	<link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
</head>
<body>
	<?php
	include 'sidebar.php';
	?>

	<div class="tabs">
		<div class="changepw">
			<p class="pHeading">Change Password</p><hr>

			<form method="post">
				<input type="password" name="password1" placeholder="Old Password" required="true"/><br/>
				<input type="password" name="password2" placeholder="New Password" required="true"/></br>
				<input type="password" name="password3" placeholder="Confirm New Password" required="true"/></br>
				<button name="change">Change</button></br>
			</form>
		</div>
	</div>
</body>

<?php
require_once('Settings/config.php');
$password1 = $password2 = $password3 = NULL;

if (isset($_POST['change'])) {
	unset($_POST['change']);
	$password1 = $_POST['password1'];
	$password2 = $_POST['password2'];
	$password3 = $_POST['password3'];

	if (strcasecmp($password1, $_SESSION['password']) == 0) {
		if (strcasecmp($password2, $password3) == 0) {
			$sql = "UPDATE `user` SET `password`='" . $password2 . "' WHERE `id`=" . $_SESSION['id'];
			$result = $conn->query($sql);

			if ($result) {
				echo "<script type=\"text/javascript\">
				alert(\"Password changed successfully.\");
				</script>";

				$_SESSION['password'] = $password2;
				header("Refresh:0; url=account.php");
			} else {
				echo "<script type=\"text/javascript\">
				alert(\"Something went wrong.\");
				</script>";
				header("Refresh:0; url=changepw.php");
			}
		} else {
			echo "<script type=\"text/javascript\">
			alert(\"Passwords do not match.\");
			</script>";
			header("Refresh:0; url=changepw.php");
		}
	} else {
		echo "<script type=\"text/javascript\">
		alert(\"Incorrect old password.\");
		</script>";
		header("Refresh:0; url=changepw.php");
	}
}
?>

</html>