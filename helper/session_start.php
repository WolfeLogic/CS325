<?php
ini_set('display_errors', 'On');

require('php_endsWith.php');

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

if ( isset($_SESSION['curr_page']) && isset($_SESSION['prev_page'])
    && ($_SESSION['curr_page'] === $_SERVER['REQUEST_URI'] ||
    (ends_with($_SESSION['curr_page'], 'loginRegister.php#toregister') && ends_with($_SERVER['REQUEST_URI'], 'loginRegister.php'))
    || (ends_with($_SESSION['curr_page'], 'loginRegister.php') && ends_with($_SERVER['REQUEST_URI'], 'loginRegister.php#toregister'))
    ) ) {
    $prev_page = $_SESSION['prev_page'];

    //echo "<p>Option 1" . $prev_page . "</p>";
}
elseif ( isset($_SESSION['curr_page']) && !empty($_SESSION['curr_page']) ) {
    $prev_page = $_SESSION['curr_page'];

    //echo "<p>Option 2" . $prev_page . "</p>";
}
else {
    $prev_page = "";

    //echo "<p>Option 3</p>";
}
$_SESSION['curr_page'] = $_SERVER['REQUEST_URI'];
$_SESSION['prev_page'] = $prev_page;

//echo "<p>" . $_SESSION['curr_page'] . "</p>";
//echo "<p>" . $prev_page . "</p>";
?>