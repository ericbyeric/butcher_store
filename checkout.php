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
                    'price' => filter_input(INPUT_POST, 'price'),
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
                'price' => filter_input(INPUT_POST, 'price'),
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
          <h2 class="jumbotron-heading">Your Items</h2>
        </div>
      </section>
	  <?php 
		$connect = mysqli_connect('localhost', 'root', 'root', 'butcherStore'); // connection
		$query = 'SELECT * FROM PRODUCTS,TYPE,ORIGIN WHERE PRODUCTS.productId = TYPE.productId AND PRODUCTS.country=ORIGIN.country';
		$result = mysqli_query($connect, $query);                       // execute the query
		$prodArray = mysqli_fetch_all($result,MYSQLI_ASSOC);				//load all products into an assoc array -Martin
		$nameList=[];
		foreach($_SESSION['shopping_cart'] as $prodName):				//load names of products in shopping cart -Martin
			array_push($nameList,$prodName['name']);
		endforeach;
		foreach($prodArray as $key):							//Iterate over entire product table to check which are in shopping cart -Martin
			if(in_array($key['productName'],$nameList)){
				$productInfo = $key;							//Assign entire information about products in shopping cart -Martin
			}
		endforeach;
		?>
	  <div class="table-responsive">      <!-- when window is small, table is scrollable -->
		<table class="table">			<!--Editted Shopping Cart to show price instead of weight -Martin-->
			<tr><th colspan="7"><h3>Items</h3></th></tr>
			<tr>						<!--Added detail info about products with product picture-->
				<th width="10%"></th>
				<th width="40%">Product Name</th>
				<th width="10%">Country</th>
				<th width="10%">Grade</th>
				<th width="10%">Aging</th>
				<th width="10%">Quantity</th>
				<th width="20%">Price</th>
				<th width="15%">Total Price</th>
				<th width="5%">Action</th>
			</tr>
        
			<?php
			if(!empty($_SESSION['shopping_cart'])):
				$total = 0;

				foreach($_SESSION['shopping_cart'] as $key => $product):
			?>
			<tr>
				<td><img src="./img/<?php echo $productInfo['picture'];?>"/></td>
				<td><?php echo $product['name']; ?></td>
				<td><?php echo $productInfo['country'];?></td>
				<td><?php echo $productInfo['grade'];?></td>
				<td><?php echo $productInfo['aging'];?></td>
				<td><?php echo $product['quantity']; ?></td>
				<td><i class="fas fa-dollar-sign"></i> <?php echo $product['price']; ?></td>
				<td><i class="fas fa-dollar-sign"></i> <?php echo number_format($product['quantity'] * $product['price'], 2); ?></td>
				<td>
					<a class="mb-2" href="shop_beef.php?action=delete&id=<?php echo $product['id']; ?>">
						<div class="btn btn-danger">Remove</div>
					</a>
				</td>
			</tr>

			<?php
				$total = $total + ($product['quantity'] * $product['price']);
				endforeach;
			?>
			<tr>
				<td colspan="7" align="right">Total</td>
				<td align="right"><i class="fas fa-dollar-sign"></i> <?php echo number_format($total, 2); ?></td>
			</tr>
			<tr>
				<td colspan="8">
					<?php
						if (isset($_SESSION['shopping_cart'])):
						if (count($_SESSION['shopping_cart']) > 0):
					?>
						<a href="checkout.php" class="btn btn-primary btn-block" >Confirm Order</a>
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