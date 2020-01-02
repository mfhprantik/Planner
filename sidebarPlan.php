<?php
include 'verify.php';
if (!$verified) header("Refresh:0 url=index.php");

$pid = 0;

if (!isSet($_GET['pid'])) {
	header("Refresh:0 url=home.php");
} else $pid = $_GET['pid'];
?>

<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="main.css">
	<link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
</head>
<body>
	<div class="sidebar">
		<a style="text-decoration: none;" href="about.php?pid=<?php echo $pid;?>"><button id="about">About</button></a><br/>
		<a style="text-decoration: none;" href="discuss.php?pid=<?php echo $pid;?>"><button id="discuss">Discussions</button></a><br/>
		<a style="text-decoration: none;" href="edit.php?pid=<?php echo $pid;?>"><button id="edit">Edit</button></a><br/>
		<a style="text-decoration: none;" href="home.php"><button name="home" style="margin-top: 320%;">Home</button></a></form>
	</div>
</body>

<?php
if (isSet($_POST['logout'])) {
	unset($_POST['logout']);
	unset($_SESSION['email']);
	header("Refresh:0 url=index.php");
}

$sql = "SELECT COUNT(*) FROM `connections` WHERE `uid` = " . $_SESSION['id'] . " AND `pid`=" . $pid . " LIMIT 1";
$result = $conn->query($sql);
$value = $result->fetch_assoc();

if ($value['COUNT(*)'] == 0) {
	echo '<script type="text/javascript">
	document.getElementById("discuss").style.display = "none";
	</script>';

	$buttonText = "Add to my plans";
} else $buttonText = "Remove from my plans";

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
		echo '<script type="text/javascript">
		document.getElementById("edit").style.display = "none";
		</script>';
	}

	$sql = "SELECT `name` FROM `user` WHERE `id` = " . $createdBy . " LIMIT 1";
	$result = $conn->query($sql);
	$value = $result->fetch_assoc();

	$creator = $value['name'];
}
?>

</html>