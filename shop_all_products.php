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

	<div class="container">
        <div class="sorters form-inline mt-2">
            <h4 class="mt-1 mr-2">Sort by: </h4>
            <form method="POST" action="./shop_all_products.php">

               <select id="sortType" name="sortType">
                  <option value="PHighToLow" >Price High to Low</option>
                  <option value="PLowToHigh">Price Low to High</option>
                  <option value="RHighToLow">Rating High to Low</option>
                  <option value="NAtoZ">Name A to Z</option>
                  <option value="NZtoA">Name Z to A</option>
				</select>
				<select id="typeFilter" name="typeFilter">
                  <option value="beef" >Beef</option>
                  <option value="pork">Pork</option>
                  <option value="lamb">Lamb</option>
				</select>
				<select id="cutFilter" name="cutFilter">
                  <option value="fillet" >Fillet</option>
                  <option value="roast">Roast</option>
                  <option value="brisket">Brisket</option>
				  <option value="skirt" >Skirt</option>
                  <option value="flank">Flank</option>
                  <option value="sirloin">Sirloin</option>
				  <option value="shortribs" >Shortribs</option>
                  <option value="flatiron">Flatiron</option>
                  <option value="striploin">Striploin</option>
				  <option value="tenderloin" >Tenderloin</option>
                  <option value="shank">Shank</option>
                  <option value="tbone">Tbone</option>
				  <option value="rack" >Rack</option>
                  <option value="leg">Leg</option>
                  <option value="shoulder">Shoulder</option>
				  <option value="saddle" >Saddle</option>
                  <option value="loinchops">Loinchops</option>
                  <option value="vealchops">Vealchops</option>
				  <option value="breast" >Breast</option>
                  <option value="belly">Belly</option>
                  <option value="butt">Butt</option>
				  <option value="ribs" >Ribs</option>
                  <option value="tomahawk">Tomahawk</option>
                  <option value="chops">Chops</option>
				  <option value="loin" >Loin</option>
                  <option value="porchetta">Porchetta</option>
                  <option value="ham">Ham</option>
				</select>
               <input type="submit" name="apply" value="Apply"/>
            </form>
         </div>
    <div class="row">
    <?php
		if(isset($_POST['sortType'])){
			$sort = $_POST['sortType'];
			if($sort == "PHighToLow"){
				$sortAtt = "Type.price";
				$sortOrder = "DESC";
			}
			else if($sort == "PLowToHigh"){
				$sortAtt = "Type.price";
				$sortOrder = "ASC";
			}
			else if($sort == "RHighToLow"){
				$sortAtt = "reviews_for";
				$sortOrder = "DESC";
			}
			else if($sort == "NZtoA"){
				$sortAtt = "productName";
				$sortOrder = "DESC";
			}
			else if($sort == "NAtoZ"){
				$sortAtt = "productName";
				$sortOrder = "ASC";
			}
			else{
			$sortAtt = "productName";
			$sortOrder="ASC";
			}
		}
		else{
			$sortAtt = "productName";
			$sortOrder="ASC";
		}
		$orderLine =' ORDER by '.$sortAtt.' '.$sortOrder;
	
		if(isset($_POST['typeFilter'])){
			$typeF = ' AND type="'.$_POST['typeFilter'].'"';
		}
		else{
			$typeF = '';
		}
		if(isset($_POST['cutFilter'])){
				$cutF = ' AND cut="'.$_POST['cutFilter'].'"';
		}
		else{
			$cutF = '';
		}
    $connect = mysqli_connect('localhost', 'root', '', 'butcherStore'); // connection
    $query = 'SELECT * FROM PRODUCTS,TYPE WHERE PRODUCTS.productId = TYPE.productId'.$typeF.$cutF.$orderLine;
    $result = mysqli_query($connect, $query);                       // execute the query

    if ($result):
        if(mysqli_num_rows($result)>0):
            while($product = mysqli_fetch_assoc($result)):          // store result in associtive array
               
            ?>
            
            <div class="col-sm-3 mb-5 mt-4">                         
                <form method="POST" action="shop_all_products.php?action=add&id=<?php echo $product['productId']; ?>">
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
                <a class="mb-2" href="shop_all_products.php?action=delete&id=<?php echo $product['id']; ?>">
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
</html>

