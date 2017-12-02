<?php
/* Displays all error messages */
/* Pre-condition:
    $_SESSION['err_message'] and $_SESSION['err_redirect'] set
   Post-condition:
    $_SESSION['err_message'] and $_SESSION['err_redirect'] set to NULL
*/
ini_set('display_errors', 'On');

function is_session_started()
{
    if ( php_sapi_name() !== 'cli' ) {
        if ( version_compare(phpversion(), '5.4.0', '>=') ) {
            return session_status() === PHP_SESSION_ACTIVE ? TRUE : FALSE;
        } else {
            return session_id() === '' ? FALSE : TRUE;
        }
    }
    return FALSE;
}

if ( is_session_started() === FALSE ) session_start();
?>

<!DOCTYPE html>
<html>
<head>
  <title>Error</title>
</head>
<body>
<div>
    <h1>Error</h1>
    <p>
    <?php 
    if( isset($_SESSION['err_message']) AND !empty($_SESSION['err_message']) ) {
        echo $_SESSION['err_message'];
        unset($_SESSION['err_message']);
    } else {
        header( "location: HomePage.php" );
    }
    ?>
    </p>
    <?php 
    if( isset($_SESSION['err_redirect']) AND !empty($_SESSION['err_redirect']) ) {
        echo "<a href='" . $_SESSION['err_redirect'] . "'><button>Go On</button></a>";
        unset($_SESSION['err_redirect']);
    }
    else {
        header( "location: HomePage.php" );
    }
    ?>
    
</div>
</body>
</html>