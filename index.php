<?php
    require "header.php";
?>

<main>
    <div class="container">
        <div class="row">
            <div class="col text-center">
                <div class="p-5">
                    <?php
                        // CHECK SESSION VARIABLE FOR CHECKING THE USER LOGIN 
                        if (isset($_SESSION['userId'])) {
                            echo '<p class="lead bg-success text-white py-3">You are logged in!</p>';
                        }
                        // IF NO SESSION VARIABLE FOR USERID
                        else {
                            echo '<p class="lead bg-warning text-white py-3">You are logged out!</p>';
                        }
                    ?>
                </div>
            </div>
        </div> 
    </div>

</main> 

<?php
    require "footer.php";
?>