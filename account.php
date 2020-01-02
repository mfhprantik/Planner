<!DOCTYPE html>
<html>
<head>
	<title>Planner | Account</title>
	<link rel="stylesheet" type="text/css" href="main.css">
	<link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
</head>
<body>
	<?php
	include 'sidebar.php';
	?>

	<script type="text/javascript">
		document.getElementById('account').style.backgroundColor = "#212121";
	</script>

	<div class="tabs">
		<div class="account">
			<p class="pHeading">Account</p><hr>

			<p class="eHeading">Email</p><p class="eValue"><?php echo $_SESSION['email'] ?></p><br/>
			<p class="eHeading" style="margin-top: 100px;">Full Name</p><p class="eValue" style="margin-top: 100px;"><?php echo $_SESSION['name'] ?></p>

			<a href="changepw.php"><button>Change Password</button></a>
		</div>
	</div>

</body>
</html>