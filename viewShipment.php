<?php
	session_start();
	require "header.php";
?>
<link rel="stylesheet" href="css/home.css">
        <section id="explore-head-section">
            <!-- ABOUT US -->
            <div class="container">
                <div class="row">
                    <div class="col text-center">
                        <div class="p-5">
                            <h1 class="display-4 font-weight-bold">Shipment <span class="text-primary">Info</span></h1>
                        </div>
                    </div>
                </div>
            </div>
        </section>
		<?php
			$connect = mysqli_connect('localhost', 'root', '', 'butcherStore');
			$validUserId = $_SESSION['userId'];
			$query = "SELECT * FROM ORDERS, SHIPMENT,PRODUCTS WHERE ORDERS.userId=$validUserId AND ORDERS.orderId=SHIPMENT.orderId AND ORDERS.productId=PRODUCTS.productId";
			$result = mysqli_query($connect,$query);
			$shipments = mysqli_fetch_all($result,MYSQLI_ASSOC);
			$orders = array();
			foreach($shipments as $shipment):
				$orders[$shipment['orderId']][] = $shipment;
			endforeach;
			foreach($orders as $order):
		?>

		<section id="explore-section" class="bg-light text-muted py-5">
            <div class="container">
                <div class="row justify-content-center">
                    
                    <div class="col-md-8 text-center">
                        <div class="row">
							<img height="300" src="./img/<?php echo $order[0]['picture']; ?>"/>
							<div class="column">
								<h4>Order ID <?php echo $order[0]['orderId']?></h4>
								<h5>Order Date:   <?php echo$order[0]['orderDate']?></h5>
								<?php 
									foreach($order as $item):
										echo "<h5>".$item['productName']." ".$item['productQuant']."</h5>";
									endforeach;
									echo "<h5>Shipment ID: ".$item['shipId']."</h5>";
									echo "<h5>Shipment Date:".$item['shipDate']."<h5>";
								?>
							</div>
						</div>
                    </div>   
                </div>
            </div>
        </section>
		<?php
			endforeach;
		?>
</body>
</html>