<?php
include 'sidebarPlan.php';

$title = $location = $date = $time = $description = $createdOn = NULL;
$privacy = $createdBy = -1;

$sql = "SELECT * FROM `plans` WHERE `id` = " . $pid;
$result = $conn->query($sql);

if ($result && $result->num_rows == 0) {
	header("Refresh:0 url=home.php");
} else {
	$row = $result->fetch_assoc();

	$title = $row['title'];
	$location = $row['location'];
	$date = $row['date'];
	$time = $row['time'];
	$description = $row['description'];
	$createdBy = $row['createdBy'];
	$createdOn = $row['createdOn'];

	if ($createdBy != $_SESSION['id']) {
		header("Refresh:0 url=home.php");
	}
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Planner | Edit</title>
	<link rel="stylesheet" type="text/css" href="main.css">
	<link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
</head>
<body>
	<script type="text/javascript">
		document.getElementById('edit').style.backgroundColor = "#212121";
	</script>

	<div class="tabs">
		<div class="edit">
			<p class="pHeading">Edit : <?php echo $title; ?></p><hr>

			<form method="post">
				<p class="tHeading">Title</p><br/>
				<textarea name="title" rows="1"><?php echo $title ?></textarea><hr>

				<p class="dHeading">Description</p><br/>
				<textarea name="description" rows="4"><?php echo $description ?></textarea><hr>

				<p class="lHeading">Location</p><br/>
				<textarea name="location" rows="1"><?php echo $location ?></textarea><hr>

				<p class="tHeading">Date & Time</p><br/>
				<input name="date" type="text" value="<?php echo $date;?>"/>
				<input name="time" type="text" value="<?php echo $time;?>"/><hr>
					<button style="position: absolute; left: 75%; margin-top: 30px;"name="save">Save Changes</button>
			</form>
			<a href="delete.php?pid=<?php echo $pid;?>"><button style="position: absolute; left: 75%; margin-top: 70px; margin-bottom: 30px;">Delete</button></a>
		</div>
	</div>
</body>

<?php

if (isset($_POST['save'])) {
	unset($_POST['save']);

	$title = $_POST['title'];
	$description = $_POST['description'];
	$location = $_POST['location'];
	$date = $_POST['date'];
	$time = $_POST['time'];

	$sql = "UPDATE `plans` SET `title`='" . $title . "',`location`='" . $location . "',`date`='" . $date . "',`time`='" . $time . "',`description`='" . $description . "' WHERE `id`=" . $pid;
	$result = $conn->query($sql);

	header("Refresh:0 url=about.php?pid=" . $pid);
}

?>

</html>