<?php
    require "header.php";
    
    // CHECK IF Add to Cart button has been submitted
    if(filter_input(INPUT_POST, 'add_to_cart')){
        if(isset($_SESSION['shopping_cart'])){
            // keep track of how many products are in the shopping cart
            $count = count($_SESSION['shopping_cart']);   

            // create sequantial array for matching array keys to products id's
            $product_ids = array_column($_SESSION['shopping_cart'], 'id');

            if (!in_array(filter_input(INPUT_GET, 'id'), $product_ids)){      // check if id is in product_id
                $_SESSION['shopping_cart'][$count] = array
                (
                    'id' => filter_input(INPUT_GET, 'id'),
                    'name' => filter_input(INPUT_POST, 'name'),
                    'weight' => filter_input(INPUT_POST, 'weight'),
                    'quantity' => filter_input(INPUT_POST, 'quantity')
                );
            } else { // product already exists, increase quantity
                // if product already exists (match array key to id of the product being added to the cart)
                for ($i = 0; $i < count($product_ids); $i++){
                    if ($product_ids[$i] == filter_input(INPUT_GET, 'id')){
                        // add item quantity to the existing product in the array
                        $_SESSION['shopping_cart'][$i]['quantity'] += filter_input(INPUT_POST, 'quantity');
                    }
                }
            }

        } else { // if shopping cart doesn't exist, create first product with array key 0
            // create array using submitted from data, start from key - and fill it with values
            $_SESSION['shopping_cart'][0] = array
            (
                'id' => filter_input(INPUT_GET, 'id'),
                'name' => filter_input(INPUT_POST, 'name'),
                'weight' => filter_input(INPUT_POST, 'weight'),
                'quantity' => filter_input(INPUT_POST, 'quantity')
            );
        }
    }


    // remove item
    if(filter_input(INPUT_GET, 'action') == 'delete'){
        // loop through all products in the shopping cart until it matches with GET id variable
        foreach($_SESSION['shopping_cart'] as $key => $product){
            if ($product['id'] == filter_input(INPUT_GET, 'id')){
                // remove product from the shopping cart when it matches with the GET id
                unset($_SESSION['shopping_cart'][$key]);
            }
        }

        // reset session array keys so they match with $product_ids numeric array
        $_SESSION['shopping_cart'] == array_values($_SESSION['shopping_cart']);     // sort our array
        
    }
?>

<main role="main">

      <section class="jumbotron text-center">
        <div class="container">
          <h2 class="jumbotron-heading">Beef</h2>
        </div>
      </section>

        <div class="row"><!--Load Beef Products-->
			<?php
				$connect = mysqli_connect('localhost', 'root', '', 'butcherStore'); // connection
				$query = 'SELECT * FROM PRODUCTS,TYPE WHERE PRODUCTS.productId = TYPE.productId AND type="beef"';
				$result = mysqli_query($connect, $query);                       // execute the query
				if ($result):
					if(mysqli_num_rows($result)>0):
						while($product = mysqli_fetch_assoc($result)):          // store result in associtive array
						?>
						<div class="col-sm-3 mb-5 mt-4">                         
							<form method="POST" action="shop_beef.php?action=add&id=<?php echo $product['productId']; ?>">
								<div class="products">
									<!-- PRODUCT IMAGE -->
									<img src="./img/<?php echo $product['picture']; ?>" class="img-responsive card-img-top"  />

									<!-- PRODUCT NAME -->
									<h4 class="text-info card-text"> <?php echo $product['productName']; ?> </h4>

									<!-- PRODUCT Weight-->
									<h5>weight <?php echo $product['productEachWeight'] ?> </h5>
                        
									<input type="text" name="quantity" class="form-control" value="1" />
									<input type="hidden" name="name" value="<?php echo $product['productName']; ?>" >
									<input type="hidden" name="weight" value="<?php echo $product['productEachWeight']; ?>" >
									<input type="submit" name="add_to_cart" style="margin-top:5px;" class="btn btn-sm btn-outline-secondary" value="Add to Cart" />
								</div>
							</form>
						</div>
							<?php
          
										endwhile;
									endif;
								endif;
								?>
		</div> 

	<div style="clear:both"></div>
	<br />

	<div class="table-responsive">      <!-- when window is small, table is scrollable -->
		<table class="table">
			<tr><th colspan="5"><h3>Order Detail</h3></th></tr>
			<tr>
				<th width="40%">Product Name</th>
				<th width="10%">Quantity</th>
				<th width="20%">Weight</th>
				<th width="15%">Total weight</th>
				<th width="5%">Action</th>
			</tr>
        
			<?php
			if(!empty($_SESSION['shopping_cart'])):
				$total = 0;

				foreach($_SESSION['shopping_cart'] as $key => $product):
			?>
			<tr>
				<td><?php echo $product['name']; ?></td>
				<td><?php echo $product['quantity']; ?></td>
				<td><i class="fas fa-pound-sign"></i> <?php echo $product['weight']; ?></td>
				<td><i class="fas fa-pound-sign"></i> <?php echo number_format($product['quantity'] * $product['weight'], 2); ?></td>
				<td>
					<a class="mb-2" href="shop_beef.php?action=delete&id=<?php echo $product['id']; ?>">
						<div class="btn btn-danger">Remove</div>
					</a>
				</td>
			</tr>

			<?php
				$total = $total + ($product['quantity'] * $product['weight']);
				endforeach;
			?>
			<tr>
				<td colspan="3" align="right">Total</td>
				<td align="right"><i class="fas fa-pound-sign"></i> <?php echo number_format($total, 2); ?></td>
			</tr>
			<tr>
				<td colspan="5">
					<?php
						if (isset($_SESSION['shopping_cart'])):
						if (count($_SESSION['shopping_cart']) > 0):
					?>
						<a href="#" class="btn btn-primary btn-block" >Checkout</a>
						<?php endif; endif; ?>
				</td>
			</tr>
			<?php
				endif;
			?>


		</table>

		</div>
		</div>
</body>
</main>