<?php
    session_start();
    require "header.php";
    
    
    $connect = mysqli_connect('localhost', 'root', 'root', 'butcherStore'); // connection
    $currentProductId = $_SESSION['currentProductId'];
    $query = "SELECT * FROM PRODUCTS WHERE productId = $currentProductId";
    $result = mysqli_query($connect, $query); 
                         // execute the query
    if ($result):
        if(mysqli_num_rows($result)>0):
            while($product = mysqli_fetch_assoc($result)):          // store result in associtive array
                
?>


<?php
            endWhile;
        endif;
    endif;
    

?>


