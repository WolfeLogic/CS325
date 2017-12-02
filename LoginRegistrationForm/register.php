<?php
/* Registration process, inserts user info into the database 
 */
require('../helper/sql_connect.php');



// Escape all $_POST variables to protect against SQL injections
$firstnamesignup = $conn->escape_string($_POST['firstnamesignup']);
$lastnamesignup = $conn->escape_string($_POST['lastnamesignup']);
$emailsignup = $conn->escape_string($_POST['emailsignup']);
$passwordsignup_hashed = $conn->escape_string(password_hash($_POST['passwordsignup'], PASSWORD_BCRYPT));

// Check if user with that email already exist
$checkuser_result = $conn->query("SELECT * FROM User WHERE email='$emailsignup'");

// We know user email exists if the rows returned are more than 0
if ( $checkuser_result->num_rows > 0 ) {
    
    $_SESSION['err_message'] = 'User with this email already exists!';
    $_SESSION['err_redirect'] = 'LoginRegistrationForm/loginRegister.php#toregister';
    header("location: ../error.php");
    
}
else { // Email doesn't already exist in a database, proceed...

    // active is 0 by DEFAULT (no need to include it here)
    $insert_sql = "INSERT INTO User (fname, lname, email, password) " 
            . "VALUES ('$firstnamesignup','$lastnamesignup','$emailsignup','$passwordsignup_hashed')";

    // Add user to the database
    if ( $conn->query($insert_sql) ){
        // Set session variables to be used on myAccount.php page
        // User logged in at this moment
        $_SESSION['userID'] = $conn->insert_id;
        $_SESSION['logged_in'] = TRUE;
        //echo "<p>" . $_SESSION['logged_in'] . "</p>";
        header("location: ../myAccount.php"); 
    }

    else {
        $_SESSION['err_message'] = 'Registration failed!';
        $_SESSION['err_redirect'] = 'LoginRegistrationForm/loginRegister.php#toregister';
        header("location: ../error.php");
    }
}