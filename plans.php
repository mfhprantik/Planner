<!DOCTYPE html>
<html>
<head>
	<title>Planner | Plans</title>
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
		<div class="plans">
			<div class="search">
				<form method="get">
					<input type="text" name="searchText" placeholder="Search"/>
					<button style="width: 120px; height: 40px;">Search</button><br/>
				</form>
			</div>

			<div class="planTabs">
				<a href="addplan.php"><button style="position: absolute; left: 75%; ">Add new plan</button></a>
				<p class="pHeading">Today</p><hr>
				<div class="cards">
					<?php
					require_once('Settings/config.php');

					$searchText = "";

					if (isSet($_GET['searchText'])) {
						$searchText = $_GET['searchText'];
					}

			        $sql = "SELECT COUNT(*) FROM `plans` WHERE `title` LIKE '%" . $searchText . "%'";
			        $result = $conn->query($sql);
					$value = $result->fetch_assoc();

					$total_pagesT = ceil($value['COUNT(*)'] / $records_per_pageT);

					$sql = "SELECT `id`, `title`, `location`, `date` FROM `plans` WHERE `title` LIKE '%" . $searchText . "%' AND `date` >= CURRENT_TIMESTAMP && `id` IN (SELECT `pid` from `connections` WHERE `uid`=" . $_SESSION['id'] . ") ORDER BY `date`,`time`";
					$result = $conn->query($sql);

					$start = strtotime(date("Y/m/d"));

					if ($result && $result->num_rows > 0) {
			    		while($row = $result->fetch_assoc()) {
			    			$days = "";
							$end = strtotime($row['date']);
							$days_between = floor(($end - $start) / 86400);
							if ($days_between == 0) {
								$days = "Today";

				        		echo '<div onclick="location.href=\'about.php?pid=' . $row['id'] . '\'" class="card">
				        		<div class="container">
				    				<h3><p class="title">' . $row['title'] . '</p></h3>
									<h4><p class="location">' . $row['location'] . '</p></h4>
				    				<p class="eta">' . $days . '</p>
				  				</div>
				  				</div></a>';
			  				}
			    		}
			    	} else {
			    		echo "<h1>No plans today.</p>";
					}
					
					?>

				</div>


				<p class="pHeading">Upcoming</p><hr>
				<div class="cards">
					<?php

					$searchText = "";
					$pageU = $pageH = 1;

					if (isSet($_GET['searchText'])) {
						$searchText = $_GET['searchText'];
					}

					if (isSet($_GET['pageU'])) {
						$pageU = $_GET['pageU'];
					}

					if (isSet($_GET['pageU'])) {
						$pageH = $_GET['pageH'];
					}

					$records_per_pageU = 18;
			        $offsetU = ($pageU - 1) * $records_per_pageU;

			        $sql = "SELECT COUNT(*) FROM `plans` WHERE `title` LIKE '%" . $searchText . "%'";
			        $result = $conn->query($sql);
					$value = $result->fetch_assoc();

					$total_pagesU = ceil($value['COUNT(*)'] / $records_per_pageU);

					$sql = "SELECT `id`, `title`, `location`, `date` FROM `plans` WHERE `title` LIKE '%" . $searchText . "%' AND `date` >= CURRENT_TIMESTAMP && `id` IN (SELECT `pid` from `connections` WHERE `uid`=" . $_SESSION['id'] . ") ORDER BY `date`,`time` LIMIT " . $offsetU . ", " . $records_per_pageU;
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
			  				</div></a>';
			    		}
			    	} else {
			    		echo "<h1>No upcoming plans found.</p>";
					}

					echo '<div class="paging">';
					if ($pageU > 1) echo '<a href="?searchText=' . $searchText . '&pageH=' . ($pageH) . '&pageU=' . ($pageU - 1) . '"><button style="width: 200px; height: 40px;">Previous</button></a>';
					if ($total_pagesU > $pageU) echo '<a href="?searchText=' . $searchText . '&pageH=' . ($pageH) . '&pageU=' . ($pageU + 1) . '"><button style="width: 200px; height: 40px;">Next</button></a>';
					echo '</div>';
					?>
				</div>

				<p class="pHeading">History</p><hr>
				<div class="cards">
					<?php

					$records_per_pageH = 12;
			        $offsetH = ($pageH - 1) * $records_per_pageH;

			        $sql = "SELECT COUNT(*) FROM `plans` WHERE `title` LIKE '%" . $searchText . "%'";
			        $result = $conn->query($sql);
					$value = $result->fetch_assoc();

					$total_pagesH = ceil($value['COUNT(*)'] / $records_per_pageH);

					$sql = "SELECT `id`, `title`, `location`, `date` FROM `plans` WHERE `title` LIKE '%" . $searchText . "%' AND `date` < CURRENT_TIMESTAMP && `id` IN (SELECT `pid` from `connections` WHERE `uid`=" . $_SESSION['id'] . ") ORDER BY `date`,`time` LIMIT " . $offsetH . ", " . $records_per_pageH;
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
			    		echo "<h1>No history of plans found.</p>";
					}

					echo '<div class="paging">';
					if ($pageH > 1) echo '<a href="?searchText=' . $searchText . '&pageU=' . ($pageU) . '&pageH=' . ($pageH - 1) . '"><button style="width: 200px; height: 40px;">Previous</button></a>';
					if ($total_pagesH > $pageH) echo '<a href="?searchText=' . $searchText . '&pageU=' . ($pageU) . '&pageH=' . ($pageH + 1) . '"><button style="width: 200px; height: 40px;">Next</button></a>';
					echo '</div>';
					?>
				</div>

			</div>
		</div>
	</div>
</body>
</html>