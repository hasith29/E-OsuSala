<!DOCTYPE html>
<html lang="en">

<?php include '../config/database.php';
    ini_set('display_errors', 1);
    session_start();
    if(!isset($_SESSION["CUID"])){
      header("Location: ../view/login.php");
    }
    ?>

<head>
    <title>E-Osu Sala</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Rubik:400,700|Crimson+Text:400,400i" rel="stylesheet">
    <link rel="stylesheet" href="fonts/icomoon/style.css">

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/magnific-popup.css">
    <link rel="stylesheet" href="css/jquery-ui.css">
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">


    <link rel="stylesheet" href="css/aos.css">

    <link rel="stylesheet" href="css/style.css">

</head>

<body>

<?php 

if(isset($_GET["id"])){
    $id = $_GET["id"];
    $sql3 = " DELETE FROM Bill_item WHERE bill_item_id = $id ";
   $conn->query($sql3);
   header('Location: cart.php');
}


?>

<?php 

if(isset($_POST["add_to_cart"])){

  $customer = $_POST["customer_id"];
  $product = $_POST["product_id"];
  $price = $_POST["price"];
  $quantity = $_POST["quantity"];
  $date = date("Y-m-d H:i:s");
  $sql = " SELECT * FROM `Bill` 
  WHERE customer_id = $customer AND status = 0 ORDER BY bill_id DESC LIMIT 1 ";
  $create_bill = $conn->query($sql);
  $row_count = mysqli_num_rows($create_bill);

  if($row_count == 0){
    $sql1 = " INSERT INTO Bill SET customer_id = $customer,create_date =  '$date'  ";
    $bill = $conn->query($sql1);
    $last_id = $conn->insert_id;
    if($last_id > 0){
      $amount = $price * $quantity;
      $sql1 = " INSERT INTO Bill_item SET bill_id = $last_id,product_id = $product,price = $price, quantity = $quantity, 
      amount = $amount ,create_date =  '$date'  ";
      $bill1 = $conn->query($sql1);
    }
  }else{
    $row = $create_bill->fetch_assoc();
    $bill_id = $row["bill_id"];
    $amount = $price * $quantity;
    $sql1 = " INSERT INTO Bill_item SET bill_id = $bill_id,product_id = $product,price = $price, quantity = $quantity, 
    amount = $amount ,create_date =  '$date'  ";
    $bill1 = $conn->query($sql1);
  }
  header('Location: cart.php');
}

  $CID = $_SESSION["CUID"];
  $sql2 = " SELECT * FROM `Bill_item` ,Bill
  WHERE Bill.customer_id = $CID AND Bill.status = 0 AND Bill_item.bill_id = Bill.bill_id ";
  $item = $conn->query($sql2);
  $item_count = mysqli_num_rows($item);
  ?>

    <div class="site-wrap">


        <div class="site-navbar py-2">

        <!-- Logo -->
            <div class="container">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="logo">
                        <div class="site-logo">
                            <a href="index.html" class="js-logo-clone"><img width="100" height="70" src="../img/logo.jpeg" alt="MISSING JPG"/></a>
                        </div>
                    </div>

            <!-- navbar -->
                    <div class="main-nav d-none d-lg-block">
                        <nav class="site-navigation text-right text-md-center" role="navigation">
                            <ul class="site-menu js-clone-nav d-none d-lg-block">
                                <li><a href="home.php">Home</a></li>
                                <li class="active"><a href="shop.php">Store</a></li>
                                <li><a href="about.html">About</a></li>
                                <li><a href="contact.html">Contact</a></li>
                            </ul>
                        </nav>
                    </div>
                    <div class="icons">

                        <!-- shopping cart icon -->
                        <a href="cart.php" class="icons-btn d-inline-block bag">
                            <span class="icon-shopping-bag"></span>
                            <span class="number"><?php echo $item_count; ?></span>
                        </a>
                        <!-- toggle at md -->
                        <a href="#" class="site-menu-toggle js-menu-toggle ml-3 d-inline-block d-lg-none"><span
                                class="icon-menu"></span></a>
                    </div>
                </div>
            </div>
        </div>
        <!-- second line of nav bar items -->
        <div class="bg-light py-3">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 mb-0">
                        <a href="index.html">Home</a> <span class="mx-2 mb-0">/</span>
                        <strong class="text-black">Cart</strong>
                    </div>
                </div>
            </div>
        </div>
        <!-- Cart table -->
        <div class="site-section">
            <div class="container">
                <div class="row mb-5">
                    <form class="col-md-12" method="post">
                        <div class="site-blocks-table">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th class="product-thumbnail">Image</th>
                                        <th class="product-name">Product</th>
                                        <th class="product-price">Price</th>
                                        <th class="product-quantity">Quantity</th>
                                        <th class="product-total">Total</th>
                                        <th class="product-remove">Remove</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                $k = 1;
                $customer_id = $_SESSION["CUID"];             
                $sql = " SELECT Bill_item.bill_item_id,Product.product_id,Product.name as product,Bill_item.quantity as quantity,
                Bill_item.price as price ,Bill_item.amount as amount FROM `Bill_item` ,Bill,Product
                WHERE Bill.customer_id = $customer_id AND Bill.status = 0 AND Bill_item.bill_id = Bill.bill_id AND 
                Product.product_id = Bill_item.product_id ";
                                        $cus = $conn->query($sql);
                                        while($row=$cus->fetch_assoc()):
                                        ?>

                                        <tr>
                                        <td class="product-thumbnail">
                                            <img src="images/<?php echo $row["product"]; ?>.png" alt="Image" class="img-fluid">
                                        </td>

                                        <td class="product-name">
                                            <h2 class="h5 text-black"><?php echo $row["product"] ?></h2>
                                        </td>

                                        <td>Rs: <?php echo $row["price"] ?></td>

                                        <td>
                                            <div class="input-group mb-3" style="max-width: 120px;">

                                                <div class="input-group-prepend">
                                                    <button class="btn btn-outline-primary js-btn-minus"
                                                        type="button" onclick="deductQuantity(<?php echo $row['bill_item_id'] ?>)" min="0">&minus;</button>
                                                </div>
                                                
                                                <input type="text" id="id_<?php echo $row['bill_item_id']; ?>" readonly class="form-control text-center" value="<?php echo $row["quantity"]; ?>"
                                                    placeholder="" aria-label="Example text with button addon"
                                                    aria-describedby="button-addon1">
                                                <input type="text" hidden id="price_<?php echo $row['bill_item_id']; ?>" value="<?php echo $row["price"] ?>"></input>
                                                
                                                <div class="input-group-append">
                                                    <button class="btn btn-outline-primary js-btn-plus"
                                                        type="button" onclick="addQuantity(<?php echo $row['bill_item_id'] ?>)" min="0">&plus;</button>
                                                </div>
                                            </div>
                                        </td>

                                        <td>Rs: <?php echo $row["amount"] ?></td>
                                        <!-- below used for delete -->
                                        <td><a href="cart.php?id=<?php echo $row['bill_item_id'] ?>" class="btn btn-primary height-auto btn-sm">X</a></td>
                                    </tr>
                                    <?php 
                                    $k++;
                                    endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    </form>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="row mb-5">
                            <!-- <div class="col-md-6 mb-3 mb-md-0">
                                <button class="btn btn-primary btn-md btn-block">Update Cart</button>
                            </div> -->
                            <div class="col-md-6">
                                <a href="shop.php" class="btn btn-outline-primary btn-md btn-block">Continue
                                    Shopping</a>
                            </div>
                        </div>
                       
                    </div>
                    <div class="col-md-6 pl-5">
                        <div class="row justify-content-end">
                            <div class="col-md-7">
                                <div class="row">
                                    <div class="col-md-12 text-right border-bottom mb-5">
                                        <h3 class="text-black h4 text-uppercase">Cart Totals</h3>
                                    </div>
                                </div>

                                <?php 
                
                $CID = $_SESSION["CUID"];
                $sql2 = " SELECT sum(Bill_item.amount) as total,Bill.bill_id  FROM `Bill_item` ,Bill
                WHERE Bill.customer_id = $CID AND Bill.status = 0 AND Bill_item.bill_id = Bill.bill_id ";
                $item = $conn->query($sql2);
                $item_count = mysqli_num_rows($item);
                $row = $item->fetch_assoc();
                if($row["total"] != null){
                  $total = $row["total"];
                  $bill_id = $row["bill_id"];
                }else{
                  $total = 0;
                  $bill_id = "";
                }
                ?>
<!-- can remove one from the below  total and sub -->
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <span class="text-black">Subtotal</span>
                                    </div>
                                    <div class="col-md-6 text-right">
                                        <strong class="text-black">Rs: <?php echo $total; ?></strong>
                                    </div>
                                </div>
                                <div class="row mb-5">
                                    <div class="col-md-6">
                                        <span class="text-black">Total</span>
                                    </div>
                                    <div class="col-md-6 text-right">
                                        <strong class="text-black">Rs: <?php echo $total; ?></strong>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <button class="btn btn-primary btn-lg btn-block"
                                            onclick="window.location='checkout.php?bill_id=<?php echo $bill_id; ?>'">Proceed
                                            To Checkout</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/jquery-ui.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/jquery.magnific-popup.min.js"></script>
    <script src="js/aos.js"></script>

    <script src="js/main.js"></script>

</body>

</html>

<script>

function addQuantity(id){
    qty = $("#id_"+id).val();
    price = $("#price_"+id).val();
    qty = parseInt(qty)+1;
    
    if(qty < 0){
        return;
    }
    
    $.ajax({
            url: '../model/ajax.php?action=add_quantity',
            data: {
                "quantity": qty,
                "id": id,
                "price":price
            },
            dataType: 'json',
            type: 'POST'
        })
        .done(function(resp) {
            location.reload();
        })


}

function deductQuantity(id){
    qty = $("#id_"+id).val();
    price = $("#price_"+id).val();
    qty = parseInt(qty)-1;

    if(qty < 0){
        return;
    }
    
    $.ajax({
            url: '../model/ajax.php?action=deduct_quantity',
            data: {
                "quantity": qty,
                "id": id,
                "price":price
            },
            dataType: 'json',
            type: 'POST'
        })
        .done(function(resp) {
            location.reload();
        })


}
    
</script>