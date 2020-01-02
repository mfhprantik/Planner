<!DOCTYPE html>
<html>
<head>
	<title>Planner | Add New Plan</title>
	<link rel="stylesheet" type="text/css" href="main.css">
	<link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
</head>
<body>
	<?php
	include 'sidebar.php';
	?>

	<script type="text/javascript">
		document.getElementById('plans').style.backgroundColor = "#212121";
	</script>

	<div class="tabs">
		<div class="addplan">
			<p class="pHeading">New Plan</p><hr>

			<form method="post">
				<p class="tHeading">Title</p><br/>
				<textarea name="title" rows="1" placeholder="Title" required="true"></textarea><hr>

				<p class="dHeading">Description</p><br/>
				<textarea name="description" rows="4" placeholder="Description"></textarea><hr>

				<p class="lHeading">Location</p><br/>
				<textarea name="location" rows="1" placeholder="Location"></textarea><hr>

				<p class="tHeading">Date & Time</p><br/>
				<input name="date" type="text" placeholder="Date (yyyy-mm-dd)"/>
				<input name="time" type="text" placeholder="Time (HH:MM)"/><hr>

				<button style="position: absolute; left: 75%; margin-top: 30px;" name="add">Add Plan</button>
			</form>
			<a href="plans.php"><button style="position: absolute; left: 75%; margin-top: 70px; margin-bottom: 30px;">Cancel</button></a>
		</div>
	</div>
</body>

<?php

if (isset($_POST['add'])) {
	unset($_POST['add']);

	$title = $_POST['title'];
	$description = $_POST['description'];
	$location = $_POST['location'];
	$date = $_POST['date'];
	$time = $_POST['time'];

	$sql = "INSERT INTO `plans`(`title`, `location`, `date`, `time`, `description`, `createdBy`) VALUES ('" . $title . "','" . $location . "','" . $date . "','" . $time . "','" . $description . "'," . $_SESSION['id'] . ")";
	$result = $conn->query($sql);

	if ($result) {
		echo "<script type=\"text/javascript\">
		alert(\"Plan added successfully.\");
		</script>";

		$sql = "SELECT `id` from plans WHERE `createdBy`=" . $_SESSION['id'] . " ORDER BY `createdOn` DESC LIMIT 1";
		$result = $conn->query($sql);
		$value = $result->fetch_assoc();

		$sql = "INSERT INTO `connections`(`uid`, `pid`) VALUES (" . $_SESSION['id'] . "," . $value['id'] . ")";
		$result = $conn->query($sql);

		header("Refresh:0; url=about.php?pid=" . $value['id']);
	} else {
		echo "<script type=\"text/javascript\">
		alert(\"Something went wrong.\");
		</script>";
		header("Refresh:0; url=addplan.php");
	}
}

?>

</html>