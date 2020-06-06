<?php
    session_start();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" herf="style.css">
    <link rel="stylesheet" href="bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
</head>
<body>

    <header>

        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <a href="./index.php">
                <img src="./img/butcher_store_logo.png" alt="logo" width="100" height="100">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarColor01">
                <ul class="ml-5 navbar-nav mr-auto">
                <?php
                        // CHECK SESSION VARIABLE FOR CHECKING THE USER LOGIN 
                        if (isset($_SESSION['userId'])) {
                            echo '<li class="nav-item"><a href="home.php" class="nav-link">About Us</a></li>
                                <li class="nav-item"><a href="shop_by_category.php" class="nav-link">SHOP BY CATEGORY</a></li>
                                    <li class="nav-item"><a href="shop_all_products.php" class="nav-link">SHOP ALL PRODUCTS</a></li>
                                    <li class="nav-item"><a href="myAccount.php" class="nav-link">My Account</a></li>';
                        }

                        else {
                            echo '<li class="nav-item"><a href="home.php" class="nav-link">About Us</a></li>';
                        }
                ?>
                </ul>
                <div class="form-inline float-right">
                    <?php
                        // CHECK SESSION VARIABLE FOR CHECKING THE USER LOGIN 
                        if (isset($_SESSION['userId'])) {
                            echo '<form class=" my-2 my-lg-0 ml-2" action="includes/logout.inc.php" method="post">
                                    <button class="btn btn-secondary my-2 my-sm-0" type="submit" name="logout-submit">Logout</button>
                                </form>';
                        }
                        // IF NO SESSION VARIABLE FOR USERID
                        else {
                            echo '<form class=" my-2 my-lg-0 ml-2" action="includes/login.inc.php" method="post">
                                    <input class="form-control mr-sm-2" type="text" name="uNameuEmail" placeholder="Username or E-mail">
                                    <input class="form-control mr-sm-2" type="password" name="pwd" placeholder="Password">
                                    <button class="btn btn-secondary my-2 my-sm-0" type="submit" name="login-submit">Login</button>
                                </form>
                                
                                <a class="btn btn-info ml-2 " href="signup.php">Signup</a>';
                        }
                    ?>
                </div>

            </div>
        </nav>



    </header>