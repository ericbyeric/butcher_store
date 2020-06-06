<?php
if (isset($_POST['login-submit'])) {
    require 'dbh.inc.php';

    $uNameuEmail = $_POST['uNameuEmail'];
    $password = $_POST['pwd'];

    // CHECK EMPTY INPUT
    if (empty($uNameuEmail) || empty($password)) {
        header("Location: ../index.php?error=emptyfields");
        exit();
    }
    // CHECK USERNAME OR USER EMAIL EXIST IN DB
    else {
        $sql = "SELECT * FROM USERS WHERE userName=? OR userEmail=?";
        $stmt = mysqli_stmt_init($conn);

        // IF ERROR OCCUR WHILE PREPARING SQL STATEMENT
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: ../index.php?error=sqlerror");
            exit();
        }
        // NO ERROR
        else {
            // CREATE SQL QUERY TO CHECK USERNAME OR USEREMAIL MATCH
            mysqli_stmt_bind_param($stmt, "ss", $uNameuEmail, $uNameuEmail);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            // IF WE HAVE ANY RESULT FROM DB
            if ($row = mysqli_fetch_assoc($result)){
                $pwdCheck = password_verify($password, $row['userPassword']);
                
                // IF PASSWORD IS NOT MATCHED
                if ($pwdCheck == false) {
                    header("Location: ../index.php?error=wrongPwd");
                    exit();
                }
                // PASSWORD IS MATCHED WHICH MEANS READY TO LOGIN!
                else if ($pwdCheck == true) {
                    session_start();
                    $_SESSION['userId'] = $row['userId'];
                    $_SESSION['userName'] = $row['userName'];

                    // SEND USER BACK TO INDEX.PHP PAGE
                    header("Location: ../home.php?login=success");
                    exit();
                }
                // IF PASSWORD IS NOT MATCHED AS WELL
                else {
                    header("Location: ../index.php?error=wrongPwd");
                    exit();
                }

            }
            // NO RESULT
            else {
                header("Location: ../index.php?error=noUser");
                exit();
            }
        }
    }
}

else {
    header("Location: ../index.php");
    exit();
}