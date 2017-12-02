<?php
/* Log out process, unsets and destroys session variables */
require('../helper/session_start.php');

// Check if user is logged in
if ( !isset($_SESSION['logged_in']) || $_SESSION['logged_in'] == FALSE ) {
  $_SESSION['err_message'] = "You must log in before trying to log out!";
  if ($prev_page != NULL) {
      $_SESSION['err_redirect'] = $prev_page;
  } else {
      $_SESSION['err_redirect'] = 'HomePage.php';
  }
  header("location: ../error.php");
} else {
  session_unset();
  session_destroy(); 
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Logging Out</title>
    <meta name="viewport" content="width=device-width, initialscale=1" />
    <meta name="author" content="zhuzhe" />
</head>

<body>
    <div>
              
        <h2><?= 'You have been logged out!'; ?></h2>
          
        <a href="../HomePage.php"><button>Home Page</button></a>

    </div>
</body>
</html>