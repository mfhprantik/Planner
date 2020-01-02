<?php
include 'sidebarPlan.php';

if (isSet($_GET['toggle'])) {
	unset($_GET['toggle']);

	if (strcmp($buttonText, "Add to my plans") != 0) {
		$sql = "DELETE FROM `connections` WHERE `uid`=" . $_SESSION['id'] . " AND `pid`=" . $pid;
		$result = $conn->query($sql);

		if ($result) {
			$buttonText = "Add to my plans";
			header("Refresh:0 url=about.php?pid=" . $pid);
		}
	} else {
		$sql = "INSERT INTO `connections`(`uid`, `pid`) VALUES (" . $_SESSION['id'] . "," . $pid . ")";
		$result = $conn->query($sql);

		if ($result) {
			$buttonText = "Remove from my plans";
			header("Refresh:0 url=about.php?pid=" . $pid);
		}
	}
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Planner | About</title>
	<link rel="stylesheet" type="text/css" href="main.css">
	<link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
</head>
<body>
	<script type="text/javascript">
		document.getElementById('about').style.backgroundColor = "#212121";
	</script>

	<div class="tabs">
		<div class="about">
			<a href="about.php?toggle=1&pid=<?php echo($pid);?>"><button class="addPlan"><?php echo $buttonText;?></button></a>
			<p class="pHeading"><?php echo $title; ?></p><hr>

			<p class="dHeading">Description</p><br/>
			<p class="description"><?php echo $description ?></p><hr>

			<p class="lHeading">Location</p><br/>
			<p class="location2"><?php echo $location ?></p><hr>

			<p class="tHeading">Date & Time</p><br/>
			<p class="time"><?php echo (new DateTime($date))->format("l, j<\s\up>S </\s\up>F, Y") . str_repeat("&nbsp;", 4) . $time; ?></p><hr>

			<p class="creator">Created by <?php echo $creator;?><br>on <?php echo (new DateTime($createdOn))->format("l, j<\s\up>S </\s\up>F, Y")?></p>
		</div>
	</div>
</body>
</html>