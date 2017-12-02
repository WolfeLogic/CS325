<?php
require('../helper/session_start.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{
    //user logging in
    if (isset($_POST['email']) && isset($_POST['password'])) {
        require 'login.php';
    }
    
     //user registering (All form fields required; Controlled by the jQuery script at the bottom)
    elseif (isset($_POST['emailsignup'])) {
        require 'register.php';
    }
}

// Check if user has already logged in and handle this exception
elseif ( isset($_SESSION['logged_in']) && $_SESSION['logged_in'] ) {
    $_SESSION['err_message'] = "You must log out before accessing the login/registration page!";

    if ($prev_page != NULL && !ends_with($prev_page, 'logout.php') && !ends_with($prev_page, 'loginRegister.php')
        && !ends_with($prev_page, 'loginRegister.php#toregister')) {
        $_SESSION['err_redirect'] = $prev_page;
    } else {
        $_SESSION['err_redirect'] = 'HomePage.php';
    }
    header("location: ../error.php");
}
?>

<!DOCTYPE html>
<html lang="en" class="no-js">
    <head>
        <meta charset="UTF-8" />
        <!-- <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">  -->
        <title>Login and Registration Form</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
        <meta name="description" content="Login and Registration Form" />
        <meta name="keywords" content="html5, css3, form, switch, animation, :target, pseudo-class" />
        <meta name="author" content="jgrocott, zhuzhe" />
        <!-- Reference 1: https://www.w3schools.com/howto/howto_css_login_form.asp -->
        <!-- Reference 2: https://tympanus.net/Tutorials/LoginRegistrationForm/ -->
        <link rel="stylesheet" type="text/css" href="css/demo.css" />
        <link rel="stylesheet" type="text/css" href="css/style.css" />
        <link rel="stylesheet" type="text/css" href="css/animate-custom.css" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    </head>

    <body>
        <div class="container">
            <div class="codrops-top">
                
                <?php
                    if ($prev_page != NULL) {
                        echo "<a href='" . $prev_page . "'>";
                    } else{
                        echo "<a href='../HomePage.php'>";
                    }
                ?>
                <!--
                <a href='../HomePage.php'>
                -->
                    <strong>&laquo; Previous Page </strong>
                </a>
                <span class="right">
                    <a href="#"/>
                        <strong></strong>
                    </a>
                </span>
                <div class="clr"></div>
            </div>
            <!-- 
            <header>
                <h1>Login and Registration Form <span></span></h1>
				<nav class="codrops-demos">
					<span>Click <strong>"Join us"</strong></span>
					<a href="index.html" class="current-demo">Demo 1</a>
					<a href="index2.html">Demo 2</a>
					<a href="index3.html">Demo 3</a>
				</nav>
            </header>
            --> 
            <div class="titlebar">
                <h1>
                    <a href="../HomePage.php"><span>Direct Scientific Funding of Orphan Diseases</span>
                    </a>
                    
                </h1>
            </div>

            <section>				
                <div id="container_demo" >
                    
                    <a class="hiddenanchor" id="toregister"></a>
                    <a class="hiddenanchor" id="tologin"></a>

                    <!-- Log In form-->
                    <div id="wrapper">
                        <div id="login" class="animate form">
                            <form action="loginRegister.php" method="post" autocomplete="on"> 
                                <h1>Log in</h1> 
                                <p> 
                                    <label for="email" class="email" data-icon="e" > Your email </label>
                                    <input id="email" name="email" required="required" type="email" placeholder="mymail@mail.com"/>
                                </p>
                                <p> 
                                    <label for="password" class="yourpasswd" data-icon="p"> Your password </label>
                                    <input id="password" name="password" required="required" type="password" placeholder="eg. X8df!90EO" /> 
                                </p>
                                <!--
                                <p class="keeplogin"> 
									<input type="checkbox" name="loginkeeping" id="loginkeeping" value="loginkeeping" /> 
									<label for="loginkeeping">Keep me logged in</label>
                                </p>
                                -->
                                <p class="login button">
                                    <input type="submit" value="Log in" />
								</p>
                                <p class="change_link">
									Not a member yet ?
									<a href="#toregister" class="to_register">Join us</a>
								</p>
                            </form>
                        </div>

                        <!-- Sign Up form-->
                        <div id="register" class="animate form">
                            <form id="signupform" action="loginRegister.php" method="post" autocomplete="on"> 
                                <h1> Sign up </h1> 
                                <p> 
                                    <label for="emailsignup" class="email" data-icon="e">Your email</label>
                                    <input id="emailsignup" name="emailsignup" required="required" type="email" placeholder="mymail@mail.com" />
                                </p>
                                <p> 
                                    <label for="lastname" class="lname" data-icon="u">Your Surname</label>
                                    <input id="lastnamesignup" name="lastnamesignup" required="required" type="text" placeholder="Smith" />
                                </p>
                                <p> 
                                    <label for="firstname" class="fname" data-icon="u">Your Given Name</label>
                                    <input id="firstnamesignup" name="firstnamesignup" required="required" type="text" placeholder="John" />
                                </p>
                                <!--
                                <p> 
                                    <label for="phonenumber" class="pnumber" data-icon="u">Phone Number</label>
                                    <input id="phonenumbersignup" name="phonenumbersignup" type="phonenumber" placeholder="888-888-888 (Optional)" />
                                </p>
                                <p> 
                                    <label for="streetaddresss" class="address" data-icon="u">Street Address</label>
                                    <input id="addresssignup" name="addresssignup" type="text" placeholder="123 River Dr, Quincy, WA (Optional)" />
                                </p>
                                -->
                                <p> 
                                    <label for="passwordsignup" class="yourpasswd" data-icon="p">Your password</label>
                                    <span id='passwd_validity_msg'></span>
                                    <input id="passwordsignup" name="passwordsignup" required="required" type="password" placeholder="eg. X8df!90EO"/>
                                </p>
                                <p> 
                                    <label for="passwordsignup_confirm" class="yourpasswd" data-icon="p">Please re-enter your password <span id='passwd_match_msg'></span></label>
                                    <input id="passwordsignup_confirm" name="passwordsignup_confirm" required="required" type="password" placeholder="eg. X8df!90EO"/>
                                </p>
                                <p> 
									<input id="signupbtn" type="submit" value="SIGN UP"/> 
								</p>
                                <p class="change_link">  
									Already a member ?
									<a href="#tologin" class="to_register"> Go and log in </a>
								</p>
                            </form>
                        </div>

                        <script>
                            // Disable the Sign-Up button by default
                            $("#signupbtn").prop( "disabled", true);

                            var upperCase= new RegExp('[A-Z]');
                            var lowerCase= new RegExp('[a-z]');
                            var passwd_valid = false;
                            var passwd_match = false;
                            $('#emailsignup, #lastnamesignup, #firstnamesignup, #passwordsignup, #passwordsignup_confirm').on('keyup', function () {
                                if($('#passwordsignup').val().match(upperCase) && $('#passwordsignup').val().match(lowerCase) && $('#passwordsignup').val().length >= 8) {
                                    $("#passwd_validity_msg").html("");
                                    passwd_valid = true;
                                }
                                else if ($('#passwordsignup').val() == '' && $('#passwordsignup_confirm').val() == '') {
                                    $("#passwd_validity_msg").html("");
                                    passwd_valid = false;
                                }
                                else {
                                    $("#passwd_validity_msg").html("Must be 8 characters or longer with both upper and lower case letters.").css('color', 'red');
                                    passwd_valid = false;
                                }
                                

                                if ($('#passwordsignup').val() == '' || $('#passwordsignup_confirm').val() == '') {
                                    $("#passwd_match_msg").html("");
                                    passwd_match = false;
                                } else if ($('#passwordsignup').val() == $('#passwordsignup_confirm').val()) {
                                    $('#passwd_match_msg').html('<strong>Matching</strong>').css('color', 'green');
                                    passwd_match = true;
                                } else {
                                    $('#passwd_match_msg').html('<strong>Not Matching</strong>').css('color', 'red');
                                    passwd_match = false;
                                }

                                if($('#emailsignup').val().length > 0 && $('#lastnamesignup').val().length > 0 && $('#firstnamesignup').val().length > 0
                                    && passwd_valid && passwd_match) {
                                    $("#signupbtn").prop( "disabled", false);
                                }
                            });

                            /*
                            $("#signupbtn").click(function () {
                                $(this).prop( "disabled", true);
                            });
                            */
                        </script>
                        
                    </div>
                </div>  
            </section>
        </div>
    </body>
</html>