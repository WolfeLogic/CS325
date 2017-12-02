<?php
/* Display the correct navbar: navbar_FTU or navbar_RU according to the value of logged_in session variable. */
/* Pre-condition: session started & jQuery loaded */

if ( isset($_SESSION['logged_in']) && $_SESSION['logged_in'] ) {
    echo "<script>$('#navBar').load('navBar_RU.html');</script>";
} else {
    echo "<script>$('#navBar').load('navBar_FTU.html');</script>";
}