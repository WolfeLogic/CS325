<?php
require('helper/session_start.php');
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <title>Search Results</title>
    <meta name="viewport" content="width=device-width, initialscale=1" />
    <meta name="author" content="zhuzhe" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    
</head>

<body>
    <div id="navBar"></div>
    <?php include('display_navbar.php'); ?>

    <div class="container">
        
        <?PHP
            //echo 'Current PHP version: ' . phpversion();
			
			require('helper/sql_connect.php');
			
			if( isset($_GET['disease']) && $_GET['disease'] != "") {
				$sql = "SELECT * FROM `Disease` d WHERE";
				$sql .= " d.Name LIKE '%" . $_GET['disease'] . "%'";
                $sql .= " OR d.SynonymList LIKE '%" . $_GET['disease'] . "%'";
                
                echo "<h2 class='content-subhead'>Search Results</h2>";
			} else {
                $sql = "SELECT * FROM `Disease`";

                echo "<h2 class='content-subhead'>List of Orphan Diseases</h2>";
            }
			
			$result = $conn->query($sql);
			
			if ($result->num_rows > 0) {
                $row_cnt = $result->num_rows;
                echo "<h4 class='chapter-head'>Number of Diseases: " . $row_cnt . "<br><br>";
			    echo "<table class='table table-bordered table-hover table-responsive'>";	# start new table
			    echo "<thead><tr><th style='text-align:center'>OrphaNumber</th><th style='text-align:center'>Name</th><th style='text-align:center'>SynonymList</th></tr></thead>";	# table header	
			    echo "<tbody>";	# table body
			    while($row = $result->fetch_assoc()) {
				    echo "<tr><td><a href='Disease.php?OrphaNumber=" . $row["OrphaNumber"] . "'>" . $row["OrphaNumber"] . "</a></td><td>" . $row["Name"] . "</td><td>" . $row["SynonymList"] . "</td>";
			    }
			echo "</tbody></table>";

		} else {
			echo "Found no entry.";
		}
		
		?>
    </div>

</body>

</html>