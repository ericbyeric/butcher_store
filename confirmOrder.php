<?php
    session_start();
    require "header.php";	//save current shopping cart into order table
    $connect = mysqli_connect('localhost', 'root', '', 'butcherStore'); // connection
	$query = "SELECT orderId FROM ORDERS ORDER BY orderId DESC LIMIT 1";
	$result = mysqli_query($connect,$query);
	$oId = mysqli_fetch_assoc($result);
	if($oId == null){
		$oId = 1;
	}
	else{
		print_r($oId['orderId']);
		$oId = $oId['orderId'] + "1";
		print_r($oId);
	}
	foreach($_SESSION['shopping_cart'] as $key=>$product){
		echo $product['id'];
		$date = strtotime("today");
		$date = date('Y-m-d',$date);
		$pId = $product['id'];
		$pQuant = $product['quantity'];
		$uId = $_SESSION['userId'];
		$query = "INSERT INTO ORDERS(orderId,orderType,orderDate,productId,productQuant,userId) 
				  VALUES('$oId','order','$date','$pId','$pQuant','$uId')";
		$connect->query($query);
	} 
	$deliveryDate = new DateTime($date);
	$deliveryDate->add(new DateInterval('P7D'));
	$deliveryDate = $deliveryDate->format('Y-m-d');
	$query = "INSERT INTO SHIPMENT(orderId,shipDate,shipCost)
			  VALUES ('$oId','$deliveryDate','5.50')";
	$connect->query($query);
	
		
?>



<main role="main">

      <section class="jumbotron text-center">
        <div class="container">
          <h2 class="jumbotron-heading">Order <span class="text-primary">Completed!</span></h2>
        </div>
      </section>
	  <div class="table-responsive">      <!-- when window is small, table is scrollable -->
		<table class="table">			<!--Editted Shopping Cart to show price instead of weight -Martin-->
			<tr><th colspan="7"><h3>Items</h3></th></tr>
			<tr>						<!--Added detail info about products with product picture-->
			
				<th width="10%">Product Name</th>

				<th width="10%">Quantity</th>
				<th width="20%">Price</th>
				<th width="15%">Total Price</th>
				<th width="50%">Action</th>
			</tr>
        
			<?php
			if(!empty($_SESSION['shopping_cart'])):
				$total = 0;

				foreach($_SESSION['shopping_cart'] as $key => $product):
			?>
			<tr>
			
				<td><?php echo $product['productName']; ?></td>

				<td><?php echo $product['quantity']; ?></td>
				<td><i class="fas fa-dollar-sign"></i> <?php echo $product['price']; ?></td>
				<td><i class="fas fa-dollar-sign"></i> <?php echo number_format($product['quantity'] * $product['price'], 2); ?></td>
				<td>
					<a class="mb-2" href="checkout.php?action=delete&id=<?php echo $product['id']; ?>">
						<div class="btn btn-danger">Remove</div>
					</a>
				</td>
			</tr>

			<?php
				$total = $total + ($product['quantity'] * $product['price']);
				endforeach;
			?>
			<tr>
				<td colspan="8" align="right">Total</td>
				<td align="right"><i class="fas fa-dollar-sign"></i> <?php echo number_format($total, 2); ?></td>
			</tr>
			<tr>
				<td colspan="10">
					<?php
						if (isset($_SESSION['shopping_cart'])):
						if (count($_SESSION['shopping_cart']) > 0):
					?>
						<a href="confirmOrder.php" class="btn btn-primary btn-block" >Confirm Order</a>
						<?php
							unset($_SESSION['shopping_cart']);
							endif; 
							endif;
						?>
				</td>
			</tr>
			<?php
				endif;
			?>


		</table>

		</div>
		</div>

      
</main>

</body>
</html>