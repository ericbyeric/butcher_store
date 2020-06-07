<?php
    session_start();
    require "header.php";
?>

<link rel="stylesheet" href="css/home.css">
<section id="Order View">
		<div class="row">
            <div class="col text-center">
                <div class="p-5">
					 <img  src="./img/orderPage.jpg" class="img-fluid img-center"/>
                     <h3 class="mt-5 display-4 font-weight-bold">My Orders</h3>
                     <a href="#" class="mt-3 btn btn-outline-secondary">View</a>
                </div>
            </div>

            <div class="col text-center">
                <div class="p-5">
					 <img  src="./img/deliveryTruck.jpg" class="img-fluid img-center"/>
                     <h3 class="mt-5 display-4 font-weight-bold">Shipments</h3>
                     <a href="#" class="mt-3 btn btn-outline-secondary">View</a>
                </div>
            </div>

            <div class="col text-center">
                <div class="p-5">
					 <img  src="./img/accountImg.jpg" class="img-fluid img-center"/>
                     <h3 class="mt-5 display-4 font-weight-bold">Account Info</h3>
                     <a href="accountInfo.php" class="mt-3 btn btn-outline-secondary">View</a>
                </div>
            </div>
        </div>
</section>
<!-- <section id="Shipment View">
	<div class="container">
		<div class="row">
            
        </div>
	</div>
</section>
<section id="Accoung View">
	<div class="container">
		<div class="row">
            
        </div>
	</div>
</section> -->