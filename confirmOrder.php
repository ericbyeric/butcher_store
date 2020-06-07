<?php
    session_start();
    require "header.php";
?>



<main role="main">

      <section class="jumbotron text-center">
        <div class="container">
          <h2 class="jumbotron-heading">Order <span class="text-primary">Completed!</span></h2>
        </div>
      </section>
	  <?php 
        $connect = mysqli_connect('localhost', 'root', 'root', 'butcherStore'); // connection
        $userId = $_SESSION['userId'];
		$query = "SELECT * FROM ORDERS WHERE userId = $userId";
		$result = mysqli_query($connect, $query);                       // execute the query
		$orderListOfUser = mysqli_fetch_all($result,MYSQLI_ASSOC);				//load all order lists into an assoc array 
		
		?>
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
						<?php endif; endif; ?>
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