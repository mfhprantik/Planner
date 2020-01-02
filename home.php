<!DOCTYPE html>
<html>
<head>
	<title>Planner | Home</title>
	<link rel="stylesheet" type="text/css" href="main.css">
	<link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
</head>
<body>
	<?php
	include 'sidebar.php';
	?>

	<script type="text/javascript">
		document.getElementById('home').style.backgroundColor = "#212121";
	</script>

	<div class="tabs">
		<div class="home">
			<div class="search">
				<form method="get">
					<input type="text" name="searchText" placeholder="Search"/>
					<button style="width: 120px; height: 40px;">Search</button>
				</form>
			</div>

			<p class="pHeading"><?php echo date("l, j<\s\up>S </\s\up>F, Y"); ?></p><hr>

			<div class="cards">
				<?php
				require_once('Settings/config.php');

				$searchText = "";
				$page = 1;

				if (isSet($_GET['searchText'])) {
					$searchText = $_GET['searchText'];
					unset($_GET['searchText']);
				}

				if (isSet($_GET['page'])) {
					$page = $_GET['page'];
					unset($_GET['page']);
				}

				$records_per_page = 30;
		        $offset = ($page - 1) * $records_per_page;

		        $sql = "SELECT COUNT(*) FROM `plans` WHERE `title` LIKE '%" . $searchText . "%'";
		        $result = $conn->query($sql);
				$value = $result->fetch_assoc();

				$total_pages = ceil($value['COUNT(*)'] / $records_per_page);

				$sql = "SELECT `id`, `title`, `location`, `date` FROM `plans` WHERE `title` LIKE '%" . $searchText . "%' AND `date` > CURRENT_TIMESTAMP && `id` NOT IN (SELECT `pid` from `connections` WHERE `uid`=" . $_SESSION['id'] . ") ORDER BY `date`,`time` LIMIT " . $offset . ", " . $records_per_page;
				$result = $conn->query($sql);

				$start = strtotime(date("Y/m/d"));

				if ($result && $result->num_rows > 0) {
		    		while($row = $result->fetch_assoc()) {
		    			$days = "";
						$end = strtotime($row['date']);
						$days_between = floor(($end - $start) / 86400);
						if ($days_between == 0) $days = "Today";
						else if ($days_between == 1) $days = "Tomorrow";
						else $days = $days_between . " days later";

		        		echo '<div onclick="location.href=\'about.php?pid=' . $row['id'] . '\'" class="card">
		        		<div class="container">
		    				<h3><p class="title">' . $row['title'] . '</p></h3>
							<h4><p class="location">' . $row['location'] . '</p></h4>
		    				<p class="eta">' . $days . '</p>
		  				</div>
		  				</div>';
		    		}
		    	} else {
		    		echo "<h1>No public plans found.</p>";
				}

				echo '<div class="paging">';
				if ($page > 1) echo '<a href="?searchText=' . $searchText . '&page=' . ($page - 1) . '"><button style="width: 200px; height: 40px;">Previous</button></a>';
				if ($total_pages > $page) echo '<a href="?searchText=' . $searchText . '&page=' . ($page + 1) . '"><button style="width: 200px; height: 40px;">Next</button></a>';
				echo '</div>';
				?>
			</div>
		</div>
  	</div>
</body>
</html>