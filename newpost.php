<?php
include 'sidebarPlan.php';

$sql = "SELECT * FROM `plans` WHERE `id` = " . $pid;
$result = $conn->query($sql);

if ($result && $result->num_rows == 0) {
	header("Refresh:0 url=home.php");
}

$sql = "SELECT COUNT(*) FROM `connections` WHERE `uid`=" . $_SESSION['id'] . " AND `pid`=" . $pid;
$result = $conn->query($sql);
$value = $result->fetch_assoc();

if ($value['COUNT(*)'] == 0) {
	header("Refresh:0 url=home.php");
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Planner | Add New Post</title>
	<link rel="stylesheet" type="text/css" href="main.css">
	<link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
</head>
<body>
	<script type="text/javascript">
		document.getElementById('discuss').style.backgroundColor = "#212121";
	</script>

	<div class="tabs">
		<div class="addpost">
			<p class="pHeading">New Post</p><hr>

			<form method="post">
				<textarea name="content" rows="4" placeholder="Write something here." required="true"></textarea><br/>
				<button style="" name="addPost">Add Post</button>
			</form>
			<a href="discuss.php?pid=<?php echo $pid;?>"><button style="margin-top: 160px; position: absolute; top: 45%; left: 45%;">Cancel</button></a>
		</div>
	</div>
</body>

<?php

if (isset($_POST['addPost'])) {
	unset($_POST['addPost']);

	$content = $_POST['content'];

	$sql = "INSERT INTO `posts`(`content`, `createdBy`, `pid`) VALUES ('" . $content . "'," . $_SESSION['id'] . "," . $pid . ")";
	$result = $conn->query($sql);

	if ($result) {
		echo "<script type=\"text/javascript\">
		alert(\"Post added successfully.\");
		</script>";

		header("Refresh:0; url=discuss.php?pid=" . $pid);
	} else {
		echo "<script type=\"text/javascript\">
		alert(\"Something went wrong.\");
		</script>";
		header("Refresh:0; url=discuss.php?pid=" . $pid);
	}
}

?>

</html>