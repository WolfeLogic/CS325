<?php
require('../helper/sql_connect.php');

// Escape email to protect against SQL injections
$email = $conn->escape_string($_POST['email']);
$checkuser_result = $conn->query("SELECT * FROM User WHERE email='$email'");

if ( $checkuser_result->num_rows != 1 ){ // User doesn't exist
    $_SESSION['err_message'] = "User with this email doesn't exist!";
    $_SESSION['err_redirect'] = 'LoginRegistrationForm/loginRegister.php';
    header("location: ../error.php");
}
else { // User exists
    $user = $checkuser_result->fetch_assoc();

    if ( password_verify($_POST['password'], $user['password']) ) {
        
        $_SESSION['userID'] = $user['id'];
        $_SESSION['logged_in'] = TRUE;

        //echo "<p>".$prev_page."</p>";

        if ($prev_page != NULL && !ends_with($prev_page, 'logout.php') && !ends_with($prev_page, 'loginRegister.php')
            && !ends_with($prev_page, 'loginRegister.php#toregister')) {
            //echo "<p>".$prev_page."</p>";
            header("location: " . $prev_page);
        } else {
            //echo "<p>My Account</p>";
            header("location: ../myAccount.php");
        }
        
    }
    else {
        $_SESSION['err_message'] = "You have entered an incorrect password. Try again!";
        $_SESSION['err_redirect'] = 'LoginRegistrationForm/loginRegister.php';
        header("location: ../error.php");
    }
}

?>