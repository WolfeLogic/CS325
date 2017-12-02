<?php
/* Submitting a new project
 */
require('helper/sql_connect.php');

// Format all $_POST variables to protect against SQL injections
$projectTitleSubmit = $conn->escape_string($_POST['projectTitle']);
$targetDiseaseSubmit = $conn->escape_string($_POST['targetDisease']);
$fullDescriptionSubmit = $conn->escape_string($_POST['fullDescription']);
$fundingGoalSubmit = number_format($_POST['fundingGoal'], 2, '.', '');

// Obtain userID
$userID = $_SESSION['userID'];

// Check if disease with the OrphaNumber already exists
$checkdisease_result = $conn->query("SELECT * FROM Disease WHERE OrphaNumber=$targetDiseaseSubmit");

// Case 1: Disease doesn't exist in the database
if ( $checkdisease_result->num_rows != 1 ) {
    
    $_SESSION['err_message'] = 'Incorrect OrphaNumber!';
    $_SESSION['err_redirect'] = 'PrjctAppForm.php';
    header("location: error.php");
}
// Case 2: Disease exists, proceed...
else {

    $insert_project_sql = "INSERT INTO Project (projName, creator, description, targetDisease, goal) " 
            . "VALUES ('$projectTitleSubmit','$userID','$fullDescriptionSubmit','$targetDiseaseSubmit','$fundingGoalSubmit')";

    // Add project to the database
    if ( $conn->query($insert_project_sql) ){
	
        // Redirect to the project info page
        header("location: Project.php?id=" . $conn->insert_id); 
    }

	// Handle exception
    else {
        $_SESSION['err_message'] = 'Project submission failed!';
        $_SESSION['err_redirect'] = 'PrjctAppForm.php';
        header("location: error.php");
    }
}