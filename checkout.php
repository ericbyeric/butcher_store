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
					'productName' => filter_input(INPUT_POST, 'productName'),
					'price' => filter_input(INPUT_POST, 'price'),
					'quantity' => filter_input(INPUT_POST, 'quantity'),
					'country' => filter_input(INPUT_POST, 'country'),
					'grade' => filter_input(INPUT_POST, 'grade'),
					'aging' => filter_input(INPUT_POST, 'aging'),
					'stock' => filter_input(INPUT_POST, 'stock'),
					'type' => filter_input(INPUT_POST, 'type'),
					'cut' => filter_input(INPUT_POST, 'cut'),
					'picture' => filter_input(INPUT_POST, 'picture'),
					'feed' => filter_input(INPUT_POST, 'feed'),
					'growingEnv' => filter_input(INPUT_POST, 'growingEnv')
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
				'productName' => filter_input(INPUT_POST, 'productName'),
				'price' => filter_input(INPUT_POST, 'price'),
				'quantity' => filter_input(INPUT_POST, 'quantity'),
				'country' => filter_input(INPUT_POST, 'country'),
				'grade' => filter_input(INPUT_POST, 'grade'),
				'aging' => filter_input(INPUT_POST, 'aging'),
				'stock' => filter_input(INPUT_POST, 'stock'),
				'type' => filter_input(INPUT_POST, 'type'),
				'cut' => filter_input(INPUT_POST, 'cut'),
				'picture' => filter_input(INPUT_POST, 'picture'),
				'feed' => filter_input(INPUT_POST, 'feed'),
				'growingEnv' => filter_input(INPUT_POST, 'growingEnv')
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
          <h2 class="jumbotron-heading">Your Items</h2>
        </div>
      </section>
	  <div class="table-responsive">      <!-- when window is small, table is scrollable -->
		<table class="table">			<!--Editted Shopping Cart to show price instead of weight -Martin-->
			<tr><th colspan="15"><h3>Items</h3></th></tr>
			<tr>						<!--Added detail info about products with product picture-->
				<th width="10%"></th>
				<th width="20%">Product Name</th>
				<th width="10%">Country</th>
				<th width="10%">Grade</th>
				<th width="10%">Aging</th>
				<th width="10%">Quantity</th>
				<th width="10%">Price</th>
				<th colspan="3" width="15%">Total Price</th>
				<th align="right" width="5%">Action</th>
			</tr>
        
			<?php
			if(!empty($_SESSION['shopping_cart'])):
				$total = 0;

				foreach($_SESSION['shopping_cart'] as $key => $product):
			?>
			<tr>
				<td><img height="300" src="./img/<?php echo $product['picture'];?>"/></td>
				<td><?php echo $product['productName']; ?></td>
				<td><?php echo $product['country'];?></td>
				<td><?php echo $product['grade'];?></td>
				<td><?php echo $product['aging'];?></td>
				<td><?php echo $product['quantity']; ?></td>
				<td><i class="fas fa-dollar-sign"></i> <?php echo $product['price']; ?></td>
				<td colspan="3"><i class="fas fa-dollar-sign"></i> <?php echo number_format($product['quantity'] * $product['price'], 2); ?></td>
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
				<td colspan="10" align="right">Total</td>
				<td align="right"><i class="fas fa-dollar-sign"></i> <?php echo number_format($total, 2); ?></td>
			</tr>
			<tr>
				<td colspan="12">
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