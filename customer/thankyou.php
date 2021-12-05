<!DOCTYPE html>
<html lang="en">
<?php include '../config/database.php';
    ini_set('display_errors', 1);
    session_start();
    if(!isset($_SESSION["CUID"])){
        header("Location: ../view/login.php");
      }
    ?>
<?php 
$customer_id = $_SESSION["CUID"];
$sql2 = " SELECT * FROM `Bill_item` ,Bill
  WHERE Bill.customer_id = $customer_id AND Bill.status = 0 AND Bill_item.bill_id = Bill.bill_id ";
  $item = $conn->query($sql2);
  $item_count = mysqli_num_rows($item);

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
if(isset($_POST["bill_id"]) && isset($_POST["submit"])){

   
    $bill_id = $_POST["bill_id"];
    $sql = "SELECT Generic.generic_id,Product.name as product,Bill_item.quantity as quantity ,Bill_item.amount as amount 
            FROM `Bill_item` ,Bill,Product,Generic
            WHERE  Bill.bill_id = $bill_id  AND Bill.status = 0 AND Bill_item.bill_id = Bill.bill_id
            AND Product.product_id = Bill_item.product_id  AND Generic.generic_id = Product.Generic_generic_id";
            $cus = $conn->query($sql);

                    if($cus){
                    while($row=$cus->fetch_assoc()){
                     $quantity = $row["quantity"];
                     $generic_id = $row["generic_id"];

                     $sql2 = " UPDATE Generic SET current_stock_level = current_stock_level-$quantity where generic_id = $generic_id 
                     AND current_stock_level > $quantity  ";
                     $res = $conn->query($sql2);  
                        if($res){
                        $date = date("Y-m-d H:i:s");
                        $save2 = " INSERT INTO Stock_log set create_date = '$date', status = 'Order', amount = ".$quantity.", 
                        gen_id_scrap = ".$generic_id;
                        $bill2 = $conn->query($save2);  
                        }

                }
            

                        $sql1 = " UPDATE Bill SET status = 1 where bill_id = $bill_id  ";
                        $bill = $conn->query($sql1);

                        $address = $_POST['c_address'];
                        $phone = $_POST['c_phone'];
                        $postal = $_POST['c_postal_zip'];
                        $ptype = $_POST['ptype'];
                        $note = $_POST['c_order_notes'];
                        $card_number = $_POST["card_number"];
                        $card_no = $_POST["card_no"];


                        $sql3 = " UPDATE Bill SET address = '$address',phone = '$phone',postal_code = '$postal',payment_type = '$ptype',
                        note = '$note',card_number = '$card_number', CCV ='$card_no' where bill_id = $bill_id  ";
                        $bill3 = $conn->query($sql3);

                        $target_dir = "prescriptions/";
                        $target_file = $target_dir . basename($_FILES["prescription"]["name"]);
                        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
                        move_uploaded_file($_FILES["prescription"]["tmp_name"], $target_dir . $bill_id.".".$imageFileType);


                    if(!$bill){
                        echo "Error saving data";
                        exit;
                    } 
                    header('Location: thankyou.php');

                    }
    }

?>

    <div class="site-wrap">

        <div class="site-navbar py-2">

            <div class="search-wrap">
                <div class="container">
                    <a href="#" class="search-close js-search-close"><span class="icon-close2"></span></a>
                    <form action="#" method="post">
                        <input type="text" class="form-control" placeholder="Search keyword and hit enter...">
                    </form>
                </div>
            </div>

            <div class="container">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="logo">
                        <div class="site-logo">
                            <a href="home.php" class="js-logo-clone"><img width="100" height="70" src="../img/logo.jpeg" alt="MISSING JPG"/></a>
                        </div>
                    </div>
                    <div class="main-nav d-none d-lg-block">
                        <nav class="site-navigation text-right text-md-center" role="navigation">
                            <ul class="site-menu js-clone-nav d-none d-lg-block">
                                <li><a href="home.php">Home</a></li>
                                <li><a href="shop.php">Store</a></li>

                                <li><a href="about.php">About</a></li>
                                <li class="active"><a href="contact.html">Contact</a></li>
                            </ul>
                        </nav>
                    </div>
                    <div class="icons">
                        <a href="#" class="icons-btn d-inline-block js-search-open"><span
                                class="icon-search"></span></a>
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

        <div class="bg-light py-3">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 mb-0"><a href="index.html">Home</a> <span class="mx-2 mb-0">/</span> 
                    <strong class="text-black">Thank You</strong></div>
                </div>
            </div>
        </div>

        <div class="site-section">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <span class="icon-check_circle display-3 text-success"></span>
                        <h2 class="display-3 text-black">Thank you!</h2>
                        <p class="lead mb-5">You order was successfuly completed.</p>
                        <p><a href="shop.php" class="btn btn-md height-auto px-4 py-3 btn-primary">Back to store</a></p>
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