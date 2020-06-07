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
		$oId = $oId['orderId'] + "1";
	}
	foreach($_SESSION['shopping_cart'] as $key=>$product){
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

    if(isset($_POST['write-review-form'])){
        $reviewContent = $_POST['reviewContent'];
        $reviewRating = $_POST['reviewRating'];
        $reviewProductId = $_POST['reviewProductId'];
        $reviewUserId = $_SESSION['userId'];

        $connect = mysqli_connect('localhost', 'root', '', 'butcherStore'); // connection
        $query = "INSERT INTO REVIEWS_FOR (userId, productId, content, rating) VALUES ('$reviewUserId','$reviewProductId','$reviewContent','$reviewRating')";
        
        $connect->query($query);   
            
          
    }
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
				<th width="10%">Price</th>
				<th width="10%">Total Price</th>
				<th width="60%">User Review</th>
                
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
                
                <td >
                    <form method="POST" action="confirmOrder.php" class="form-inline">
                    <textarea style="width:450px;" name="reviewContent" class="form-control mr-4" id="exampleFormControlTextarea1" rows="3"></textarea>
                
                    <div class="col text-center justify-content-center">
                        <p class="row">Rating</p>
                        <select class="row mr-4" id="rating" name="reviewRating"> <!--filter by country-->
                            <option value="5">5</option>
                            <option value="4">4</option>
                            <option value="3">3</option>
                            <option value="2">2</option>
                            <option value="1">1</option>
                        </select>
                        <input type="hidden" name="reviewProductId" value="<?php echo $product['id']; ?>" >
                        
                    </div>
                
            
                    <button type="submit" name="write-review-form" class="btn btn-primary">Write Review</button>
                 
                    </form>
                </td>

                    
			</tr>

			<?php
				$total = $total + ($product['quantity'] * $product['price']);
				endforeach;
			?>
			<tr>
				<td colspan="10" align="right">Total</td>
				<td align="right"><i class="fas fa-dollar-sign"></i> <?php echo number_format($total, 2); ?></td>
			</tr>
			<tr>
				<td colspan="12">
					<?php
						if (isset($_SESSION['shopping_cart'])):
						if (count($_SESSION['shopping_cart']) > 0):
					?>
						<form method="post" action="home.php">
							<button type="submit" name="goHomeBtn" class="btn btn-success btn-block" >Go Back To Main Page</button>
						</form>
						
						<?php
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