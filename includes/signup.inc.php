<?php
    
if (isset($_POST['signup-submit'])) { // check signup-submit button is clicked properly
    require 'dbh.inc.php';

    $username = $_POST['uName'];
    $email = $_POST['uEmail'];
    $password = $_POST['pwd'];
    $passwordRepeat = $_POST['pwd-repeat'];
	$address = $_POST['uAddress'];
	$mobile = $_POST['uMobile'];

    // CHECK EMPTY INPUT
    if (empty($username) || empty($email) || empty($password) || empty($passwordRepeat)|| empty($address) || empty($mobile)) {	// editted by Martin
        // Back to the signup form
        header("Location: ../signup.php?error=emptyfields&uName=".$username."&uEmail=".$email);
        exit();
    }
    // CHECK USERNAME & EMAIL AT THE SAME TIME
    else if (!filter_var($email, FILTER_VALIDATE_EMAIL) && !preg_match("/^[a-zA-Z0-9]*$/", $username)) {
        header("Location: ../signup.php?error=invaliduNameuEmail");
        exit();
    }
    // CHECK INVALID INPUT EMAIL
    else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: ../signup.php?error=invalidEmail&uName=".$username);
        exit();
    }
    // CHECK INVALID INPUT USERNAME
    else if (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
        header("Location: ../signup.php?error=invaliduName&uEmail=".$email);
        exit();
    }
    // CHECK PASSWORD MATCH WITH PASSWORDREPEAT
    else if ($password !== $passwordRepeat) {
        header("Location: ../signup.php?error=passwordcheck&uName=".$username."&uEmail=".$email);
        exit();
    }
	//CHECK ADDRESS by Martin
	else if(!preg_match("/^[a-zA-Z0-9]*$/", $address)){
		header("Location: ../signup.php?error=invaliduAddress".$address);
		exit();
	}
	//CHECK PHONE by Martin
	else if(!preg_match("/^[a-zA-Z0-9]*$/", $mobile)){
		header("Location: ../signup.php?error=invaliduPhone".$mobile);
		exit();
	}
    // CHECK USERNAME ALREADY EXISTS IN DATABASE
    else {
        // connect to the DB and check USERNAME in DB
        $sql = "SELECT userId FROM USERS WHERE userName = ?";
        $stmt = mysqli_stmt_init($conn);

        // IF ERROR OCCUR WHILE PREPARING SQL STATEMENT
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: ../signup.php?error=sqlerror");
            exit();
        }
        // IF NO ERROR
        else {
            mysqli_stmt_bind_param($stmt, "s", $username);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);    // WHERE WE GOT THE RESULT FROM SQL QUERY
            $resultCheck = mysqli_stmt_num_rows($stmt);

            // IF USERNAME IS ALREADY TAKEN
            if ($resultCheck > 0) {
                header("Location: ../signup.php?error=userTaken&email=".$email);
                exit();
            }
            // IF INPUT USERNAME DOESN'T EXIST IN DB
            else {
                $sql = "INSERT INTO USERS (userName, userEmail, userPassword, userAddress, userMobile) VALUES (?, ?, ?, ?, ?)";
                $stmt = mysqli_stmt_init($conn);

                // IF ERROR OCCUR WHILE PREPARING SQL STATEMENT
                if (!mysqli_stmt_prepare($stmt, $sql)) {
                    header("Location: ../signup.php?error=sqlerror");
                    exit();
                }
                // NO ERROR
                else {

                    // HASH THE PASSWORD
                    $hashedPwd = password_hash($password, PASSWORD_DEFAULT);

                    mysqli_stmt_bind_param($stmt, 'sssss', $username, $email, $hashedPwd, $address, $mobile);
                    mysqli_stmt_execute($stmt);

                    // RETURN TO SIGNUP PAGE WITH SUCCESS MESSAGE
                    header("Location: ../signup.php?signup=success");
                    exit();
                    
                }
            }
        }
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);

}

else {
    // JUST SENDTING USER BACK TO SIGNUP PAGE
    header("Location: ../signup.php?signup=success");
    exit();
}