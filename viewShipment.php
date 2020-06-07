<?php
    session_start();
    require "header.php";
    
    
    $connect = mysqli_connect('localhost', 'root', '', 'butcherStore'); // connection
    $validUserId = $_SESSION['userId'];
    $query = "SELECT * FROM USERS WHERE userId = $validUserId";
    
    if (mysqli_query($connect, $query)):
        $result = mysqli_query($connect, $query);                       // execute the query
      
        //var_dump($result);
        $userInfo = mysqli_fetch_assoc($result);          // store result in associtive array  
            
    ?>          

        <link rel="stylesheet" href="css/home.css">
        <section id="explore-head-section">
            <!-- ABOUT US -->
            <div class="container">
                <div class="row">
                    <div class="col text-center">
                        <div class="p-5">
                            <h1 class="display-4 font-weight-bold">User <span class="text-primary">Info</span></h1>
                            <p class="lead">User Profile</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        <section id="explore-section" class="bg-light text-muted py-5">
            <div class="container">
                <div class="row justify-content-center">
                    
                    <div class="col-md-8 text-center">
                        <div class="d-flex flex-row text-center">
                            <div class="p-1 align-self-start">
                                <h3>User Name</h3>
                            </div>
                            <div class="ml-4 align-self-end">
                                <h2 style="color:grey;"><?php echo $userInfo['userName']; ?></h2>
                            </div>
                        </div>
                        <div class="d-flex flex-row text-center">
                            <div class="p-1 align-self-start">
                                <h3>User Email</h3>
                            </div>
                            <div class="ml-4 align-self-end">
                                <h2 style="color:grey;"><?php echo $userInfo['userEmail']; ?></h2>
                            </div>
                        </div>
                        <div class="d-flex flex-row text-center">
                            <div class="p-1 align-self-start">
                                <h3>User Address</h3>
                            </div>
                            <div class="ml-4 align-self-end">
                                <h2 style="color:grey;"><?php echo $userInfo['userAddress']; ?></h2>
                            </div>
                        </div>
                        <div class="d-flex flex-row text-center">
                            <div class="p-1 align-self-start">
                                <h3>User Mobile</h3>
                            </div>
                            <div class="ml-4 align-self-end">
                                <h2 style="color:grey;"><?php echo $userInfo['userMobile']; ?></h2>
                            </div>
                        </div>
                    </div>   
                </div>
            </div>
        </section>

        <?php
        
    endif;
?>

</body>
</html>