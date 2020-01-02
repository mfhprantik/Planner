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
	<title>Planner | Disscussions</title>
	<link rel="stylesheet" type="text/css" href="main.css">
	<link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
</head>
<body>
	<script type="text/javascript">
		document.getElementById('discuss').style.backgroundColor = "#212121";
	</script>

	<div class="tabs">
		<div class="about">
			<a href="newpost.php?pid=<?php echo($pid);?>"><button class="newpost">New Post</button></a>
			<p class="pHeading">Discussions</p><hr>

			<div class="posts">
				<?php
				require_once('Settings/config.php');

				$page = 1;

				if (isSet($_GET['page'])) {
					$page = $_GET['page'];
					unset($_GET['page']);
				}

				$records_per_page = 20;
		        $offset = ($page - 1) * $records_per_page;

		        $sql = "SELECT COUNT(*) FROM `posts` WHERE `pid`=" . $pid;
		        $result = $conn->query($sql);
				$value = $result->fetch_assoc();

				$total_pages = ceil($value['COUNT(*)'] / $records_per_page);

				$sql = "SELECT `content`, `createdBy`, `createdOn` FROM `posts` WHERE `pid`=" . $pid . " ORDER BY `createdOn` DESC LIMIT " . $offset . ", " . $records_per_page;
				$result = $conn->query($sql);

				if ($result && $result->num_rows > 0) {
		    		while($row = $result->fetch_assoc()) {
		    			$sql = "SELECT `name` from `user` WHERE `id`=" . $row['createdBy'];
		    			$result2 = $conn->query($sql);
		    			$value = $result2->fetch_assoc();

		        		echo '<div class="post">
		        		<div class="container">
		    				<h3><p class="createdBy">' . $value['name'] . '</p></h3>
							<h4><p class="createdOn">' . (new DateTime($row['createdOn']))->format("h:m, l, j<\s\up>S </\s\up>F, Y") . '</p></h4>
		    				<p class="content">' . $row['content'] . '</p>
		  				</div>
		  				</div>';
		    		}
		    	} else {
		    		echo "<h1>No posts found.</p>";
				}

				echo '<div class="paging">';
				if ($page > 1) echo '<a href="?page=' . ($page - 1) . '"><button style="width: 200px; height: 40px;">Previous</button></a>';
				if ($total_pages > $page) echo '<a href="?page=' . ($page + 1) . '"><button style="width: 200px; height: 40px;">Next</button></a>';
				echo '</div>';
				?>
			</div>
		</div>
	</div>
</body>
</html>