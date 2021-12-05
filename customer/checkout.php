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
$customer_id = $_SESSION["CUID"];
$sql2 = " SELECT * FROM `Bill_item` ,Bill
  WHERE Bill.customer_id = $customer_id AND Bill.status = 0 AND Bill_item.bill_id = Bill.bill_id ";
  $item = $conn->query($sql2);
  $item_count = mysqli_num_rows($item);

?>
    <div class="site-wrap">


        <div class="site-navbar py-2">
<!-- search -->
            <!-- <div class="search-wrap">
                <div class="container">
                    <a href="#" class="search-close js-search-close"><span class="icon-close2"></span></a>
                    <form action="#" method="post">
                        <input type="text" class="form-control" placeholder="Search keyword and hit enter...">
                    </form>
                </div>
            </div> -->
        <!-- logo -->
            <div class="container">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="logo">
                        <div class="site-logo">
                            <a href="index.html" class="js-logo-clone"><img width="100" height="70" src="../img/logo.jpeg" alt="MISSING JPG"/></a>
                        </div>
                    </div>
            <!-- nav-bar -->
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
<!-- nav-icons -->
                    <div class="icons">
                        <a href="cart.php" class="icons-btn d-inline-block bag">
                            <span class="icon-shopping-bag"></span>
                            <span class="number"><?php echo $item_count; ?></span>
                        </a>
                        <a href="#" class="site-menu-toggle js-menu-toggle ml-3 d-inline-block d-lg-none"><span
                                class="icon-menu"></span></a>
                    </div>

                </div>
            </div>
        </div>
<!-- second line nav-bar -->
        <div class="bg-light py-3">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 mb-0">
                        <a href="home.php">Home</a> <span class="mx-2 mb-0">/</span>
                        <strong class="text-black">Checkout</strong>
                    </div>
                </div>
            </div>
        </div>

        <!-- billing details -->
        <form action="thankyou.php" method="post" enctype="multipart/form-data">
            <div class="site-section">
                <div class="container">

                    <div class="row">
                        <div class="col-md-6 mb-5 mb-md-0">
                            <h2 class="h3 mb-3 text-black">Billing Details</h2>
                            <div class="p-3 p-lg-5 border">
                                <div class="form-group row">

                                    <div class="col-md-6">
                                        <label for="c_phone" class="text-black">Cash <span 
                                        class="text-danger"></span></label>
                                        <input type="radio" value="cash" class="form-control" id="ptype" name="ptype">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="c_postal_zip" class="text-black">Card <span 
                                        class="text-danger"></span></label>
                                        <input type="radio" value="card" class="form-control" id="ptype1" name="ptype">
                                    </div>

                                </div>

                                <div class="form-group row" id="card_div" style="display:none;">
                                    <div class="col-md-6">
                                        <label for="card_number" class="text-black">Card Number <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="card_number" name="card_number"
                                            placeholder="XXXXXXXXXXX">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="card_no" class="text-black">CCV <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="card_no" name="card_no"
                                            placeholder="CCV">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <label for="c_address" class="text-black">Address <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="c_address" name="c_address"
                                            placeholder="Address" required>
                                    </div>
                                </div>
                                <div class="form-group row mb-5">
                                    <div class="col-md-6">
                                        <label for="c_phone" class="text-black">Phone <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="c_phone" name="c_phone"
                                            placeholder="Phone Number" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="c_postal_zip" class="text-black">Postal code / Zip <span
                                                class="text-danger">*</span></label>
                                        <input required type="text" class="form-control" id="c_postal_zip"
                                            name="c_postal_zip">
                                    </div>
                                </div>

                                <div class="form-group row mb-5">
                                    <div class="col-md-12">
                                        <label for="c_prescription" class="text-black">Prescription <span
                                                class="text-danger">*</span></label>
                                        <input type="file" class="form-control" id="prescription" name="prescription"
                                            placeholder="file" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="c_order_notes" class="text-black">Order Notes</label>
                                    <textarea name="c_order_notes" id="c_order_notes" cols="30" rows="5"
                                        class="form-control" placeholder="Write your notes here..."></textarea>
                                </div>

                            </div>
                        </div>

                        <!-- Order details-right -->
                        <div class="col-md-6">

                            <div class="row mb-5">
                                <div class="col-md-12">
                                    <h2 class="h3 mb-3 text-black">Your Order</h2>
                                    <div class="p-3 p-lg-5 border">
                                        <table class="table site-block-order-table mb-5">
                                            <thead>
                                                <th>Product</th>
                                                <th>Total</th>
                                            </thead>
                                            <tbody>
                                            <?php 
                                            
                                            $customer_id = $_SESSION["CUID"];             
                                            $bill_id = $_GET["bill_id"];
                                            $sql = " SELECT Product.name as product,Bill_item.quantity as quantity ,
                                            Bill_item.amount as amount FROM `Bill_item` ,Bill,Product
                                            WHERE Bill.customer_id = $customer_id AND Bill.bill_id = $bill_id  AND Bill.status = 0 
                                            AND Bill_item.bill_id = Bill.bill_id AND Product.product_id = Bill_item.product_id ";
                                            $cus = $conn->query($sql);
                                            if($cus){
                                            while($row=$cus->fetch_assoc()):
                                            ?>
                                            <tr>
                                                <td><?php echo $row["product"] ?> <strong class="mx-2">x</strong>
                                                    <?php echo $row["quantity"] ?></td>
                                                <td>Rs: <?php echo $row["amount"] ?></td>
                                            </tr>
                                            <?php 
                                            endwhile; }?>
                                        </tbody>
                                        </table>


                                        <?php  if($cus){ ?>
                                        <div class="form-group">
                                            <input type="hidden" value="<?php echo $bill_id ?>" class="form-control"
                                                id="bill_id" name="bill_id">
                                            <!-- <button class="btn btn-primary btn-lg btn-block"
                                            onclick="window.location='thankyou.php?bill_id=<?php echo $bill_id ?>'">Place
                                            Order</button> -->
                                            <button type="submit" name="submit" class="btn btn-primary btn-lg btn-block">Place
                                                Order</button>
                                        </div>
                                        <?php } ?>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
        </form>
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
$('input[type=radio][name=ptype]').on('change', function() {
    switch ($(this).val()) {
        case 'card':
            $( "#card_div" ).show();
            $("#card_number").attr("required","true");
            $("#card_no").attr("required","true");
            break;
        case 'cash':
            $( "#card_number" ).val("");
            $( "#card_no" ).val("");
            $("#card_number").removeAttr("required","true");
            $("#card_no").removeAttr("required","true");
            $( "#card_div" ).hide();
            break;
    }
});
</script>