<?PHP

$dbhost = 'classmysql.engr.oregonstate.edu';
$dbuser = 'cs361_zhuzhe';
$dbpass = 'Group23@361';
$dbname = 'cs361_zhuzhe';

// Create connection
$conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set CharSet to UTF-8
if (!$conn->set_charset("utf8")) {
    printf("Error loading character set utf8: %s\n", $conn->error);
}

?>