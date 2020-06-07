<?php
    session_start();
    require "header.php";
<<<<<<< HEAD
	if (isset($_POST['goHomeBtn'])){
=======


    if (isset($_POST['goHomeBtn'])){
>>>>>>> cdc9b6a4e27ea8055954eec8396497df131f9cf0
        unset($_SESSION['shopping_cart']);
    }
?>

<link rel="stylesheet" href="css/home.css">
        <section id="explore-head-section">
            <!-- ABOUT US -->
            <div class="container">
                <div class="row">
                    <div class="col text-center">
                        <div class="p-5">
                            <h1 class="display-4 font-weight-bold">About <span class="text-danger">Us</span></h1>
                            <p class="lead">Lorem ipsum dolor sit amet consectetur adipisicing elit. Sunt vel officiis quidem necessitatibus. Dignissimos assumenda temporibus quis architecto fugiat odit?</p>
                            <a href="#" class="btn btn-outline-secondary">Find Out More</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- UBOUT US EXPLANATION -->
        <section id="explore-section" class="bg-light text-muted py-5">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                      <img src="./img/butcher_store_pic.jpeg" alt="" class="img-fluid mb-3 ">
                    </div>
                    <div class="col-md-6">
                        <h3>Explore & Connect</h3>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Consectetur sed praesentium repudiandae illum, expedita nisi reprehenderit, totam optio explicabo ratione vel ex nobis, repellendus deserunt reiciendis doloribus numquam neque incidunt!</p>
                        <div class="d-flex flex-row">
                            <div class="p-4 align-self-start">
                                <i class="fa fa-check"></i>
                            </div>
                            <div class="p-4 align-self-end">
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Facere voluptates qui beatae ea magnam voluptatem.
                            </div>
                        </div>
                        <div class="d-flex flex-row">
                            <div class="p-4 align-self-start">
                                <i class="fa fa-check"></i>
                            </div>
                            <div class="p-4 align-self-end">
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Facere voluptates qui beatae ea magnam voluptatem.
                            </div>
                        </div>
                    </div>   
                </div>
            </div>
        </section>

</section>