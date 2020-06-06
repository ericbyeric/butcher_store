<?php
    require "header.php";
?>

<main>
    <div class="container">
        <div class="row ">
            <div class="col ">
                <div class="p-5">
                    <h1 class="mb-3" >Signup</h1>
                    <form action="includes/signup.inc.php" method="post" >
                        <input class="col-sm form-control mb-2" type="text" name="uName" placeholder="Username">
                        <input class="col-sm form-control mb-2" type="email" name="uEmail" placeholder="E-mail">
                        <input class="col-sm form-control mb-2" type="password" name="pwd" placeholder="Password">
                        <input class="col-sm form-control mb-2" type="password" name="pwd-repeat" placeholder="Repeat password">
						<input class="col-sm form-control mb-2" type="text" name="uAddress" placeholder="Address"> <!-- by Martin-->
						<input class="col-sm form-control mb-3" type="text" name="uMobile" placeholder="Mobile  e.g., 01012345678"> <!-- by Martin-->
                        <button class="btn btn-primary my-2 my-sm-0" type="submit" name="signup-submit">Signup</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</main> 

<?php
    require "footer.php";
?>