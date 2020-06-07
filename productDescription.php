<?php
    session_start();
    require "header.php";

    if (isset($_POST['go_to_product_description'])):
        if(filter_input(INPUT_GET, 'action') == 'productDetail'):
            $currentProductId = filter_input(INPUT_GET, 'id');
        endif;
    endif;
            
    $connect = mysqli_connect('localhost', 'root', 'root', 'butcherStore'); // connection
    $query = "SELECT * FROM PRODUCTS,ORIGIN,REVIEWS_FOR WHERE PRODUCTS.productId = '$currentProductId' AND PRODUCTS.country = ORIGIN.country";
    
    if (mysqli_query($connect, $query)):
        $result = mysqli_query($connect, $query);                 
        $product = mysqli_fetch_assoc($result); 
      

              
?>
<link rel="stylesheet" href="css/home.css">
        <section id="explore-head-section">
            <!-- ABOUT US -->
            <div class="container">
                <div class="row">
                    <div class="col text-center">
                        <div class="p-5">
                            <h1 class="display-4 font-weight-bold"><?php echo $product['productName']?> <span class="text-success">Detail</span></h1>
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
                      <img src="./img/<?php echo $product['picture']?>" alt="" class="img-fluid mb-3 ">
                    </div>
                    <div class="col-md-6">
                        <h3>Product Information</h3>
                        <div class="d-flex flex-row">
                            <div class="mt-4 align-self-start">
                                <p>Product each weight :</p>
                            </div>
                            <div class="ml-5 pb-3 align-self-end">
                                <?php echo $product['productEachWeight']?> lb
                            </div>
                        </div>
                        <div class="d-flex flex-row">
                            <div class="mt-1 align-self-start">
                                <p>country :</p>
                            </div>
                            <div class="ml-5 pb-3 align-self-end">
                                <?php echo $product['country']?>
                            </div>
                        </div>
                       
                       <div class="d-flex flex-row">
                            <div class="mt-1 align-self-start">
                                <p>growing environment :</p>
                            </div>
                            <div class="ml-5 pb-3 align-self-end">
                                <?php echo $product['growingEnv']?>
                            </div>
                        </div>
                        <div class="d-flex flex-row">
                            <div class="mt-1 align-self-start">
                                <p>Feed :</p>
                            </div>
                            <div class="ml-5 pb-3 align-self-end">
                                <?php echo $product['feed']?>
                            </div>
                        </div>

                        <h3 class="mt-4">USER REVIEWS</h3>
        
        <?php
        endif;
                mysqli_free_result($result); 
                mysqli_close();

            $connect = mysqli_connect('localhost', 'root', 'root', 'butcherStore');
            $query = "SELECT * FROM REVIEWS_FOR WHERE REVIEWS_FOR.productId = '$currentProductId'";
            if (mysqli_query($connect, $query)):
                $result = mysqli_query($connect, $query);
                if($result):                 
                $reviews = mysqli_fetch_all($result, MYSQLI_ASSOC); 
                foreach($reviews as $review):
        ?>
                    <div class="row">
                    
                        <div class="col-md-6">
                           
                        <div class="card flex-md-row mb-4 box-shadow h-md-250">
                            <div class="card-body d-flex flex-column align-items-start">
                            <div>Rating <strong class="d-inline-block mb-2 text-primary"><?php echo $review['rating'] ?> </strong></div>
                            <p class="mb-0">
                                <div class="mb-1 text-muted"><a class="text-dark">UserId: </a><?php echo $review['userId']?></div>
                            </p>
                            <p>Review Content:</p>
                            <p class="card-text mb-auto"><?php echo $review['content']?></p>
                            </div>
                        </div>
                        </div>
                    
                    </div>
                    </div>
                    </div>   
                </div>
            </div>
        </section>

<?php
                endforeach;
                else :
?>
                <p>Review for this product doesn't exist</p>
<?php
                endif;
            else:
                mysqli_free_result($result); 
                mysqli_close();
                endif;
               
        
?>


</body>
</html>
