<?php
include 'sidebarPlan.php';

$sql = "SELECT COUNT(*), `title`, `createdBy` FROM `plans` WHERE `id` = " . $pid;
$result = $conn->query($sql);
$value = $result->fetch_assoc();

$title = $value['title'];

if ($value['COUNT(*)'] == 0) {
	header("Refresh:0 url=home.php");
}

if ($value['createdBy'] != $_SESSION['id']) {
	header("Refresh:0 url=about.php?pid=" . $pid);
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Planner | Delete</title>
	<link rel="stylesheet" type="text/css" href="main.css">
	<link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
</head>
<body>
	<script type="text/javascript">
		document.getElementById('edit').style.backgroundColor = "#212121";
	</script>

	<div class="tabs">
		<div class="delete">
			<p class="pHeading">Delete : <?php echo $title; ?></p><hr>

			<form method="post">
				<input type="password" name="password" placeholder="Password" required="true"/><br/>
				<button name="delete">Confirm Delete</button><br/>
			</form>
			<a href="edit.php?pid=<?php echo $pid;?>"><button style="margin-top: 80px; position: absolute; top: 45%; left: 45%;">Cancel</button></a>
		</div>
	</div>
</body>

<?php

if (isset($_POST['delete'])) {

	unset($_POST['delete']);

	if (strcasecmp($_POST['password'], $_SESSION['password']) != 0) {
		header("Refresh:0 url=edit.php?pid=" . $pid);
	} else {
		$sql = "DELETE FROM `plans` WHERE `id`=" . $pid;
		$result = $conn->query($sql);

		if ($result) {
			header("Refresh:0 url=home.php");
		} else {
			header("Refresh:0 url=edit.php?pid=" . $pid);
		}
	}
}

?>

</html>