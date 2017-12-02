<?php
/* Submitting a new SME application
 */
require('helper/sql_connect.php');

// Format all $_POST variables to protect against SQL injections
$expertiseSubmit = $conn->escape_string($_POST['expertise']);
$educationSubmit = $conn->escape_string($_POST['education']);
$experienceSubmit = $conn->escape_string($_POST['experience']);
$referencesSubmit = $conn->escape_string($_POST['references']);
$reasonSubmit = $conn->escape_string($_POST['reason']);

// Obtain userID
$userID = $_SESSION['userID'];

// Check if disease with the OrphaNumber already exists
$checkdisease_result = $conn->query("SELECT * FROM Disease WHERE OrphaNumber=$expertiseSubmit");

// Case 1: Disease doesn't exist in the database
if ( $checkdisease_result->num_rows != 1 ) {
    
    $_SESSION['err_message'] = 'Incorrect OrphaNumber!';
    $_SESSION['err_redirect'] = 'SMEAppForm.php';
    header("location: error.php");
}
// Case 2: Disease exists, check if the user has already had a submitted SME application with "submitted" status

else{
    $getSMEApp_result = $conn->query("SELECT * FROM SME_Application WHERE userID='$userID'");
                    
    $hasSubmittedSMEApp = FALSE;
    
    if ( $getSMEApp_result->num_rows != 0 ) {
        // SME Application(s) exist
        // Note: Allow only ONE SME application with stutas "submitted" & ZERO application with status "approved" for RU
        while($SMEAppRow = $getSMEApp_result->fetch_assoc()) {
            if ($SMEAppRow['applicationStatus'] == 'submitted' || $SMEAppRow['applicationStatus'] == 'approved') {
                $hasSubmittedSMEApp = TRUE;
                break;
            }
        }
    }
    
    // if there exists a submitted or approved application
    if ($hasSubmittedSMEApp) {
        $_SESSION['err_message'] = 'You have already submitted an SME application. Only one application is allowed.';
        $_SESSION['err_redirect'] = 'myAccount.php';
        header("location: error.php");
    }
    
    // otherwise, proceed...
    else {

        $insert_smeapp_sql = "INSERT INTO SME_Application (userID, expertise, education, experience, ref, why) " 
            . "VALUES ('$userID','$expertiseSubmit','$educationSubmit','$experienceSubmit','$referencesSubmit','$reasonSubmit')";
        
        // Add sme application to the database
        if ( $conn->query($insert_smeapp_sql) ){
	
            // Success. Redirect to myAccount.php page
            header("location: myAccount.php"); 
        }

	    // Handle exception
    
        else {
            $_SESSION['err_message'] = 'SME Application submission failed!';
            $_SESSION['err_redirect'] = 'SMEAppForm.php';
            header("location: error.php");
        }
    }
}