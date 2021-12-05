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

    <!-- nav-bar first line -->
            <div class="container">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="logo">
                        <div class="site-logo">
                            <a href="home.php" class="js-logo-clone">Pharma</a>
                        </div>
                    </div>
                    <div class="main-nav d-none d-lg-block">
                        <nav class="site-navigation text-right text-md-center" role="navigation">
                            <ul class="site-menu js-clone-nav d-none d-lg-block">
                                <li class="active"><a href="home.php">Home</a></li>
                                <li><a href="shop.php">Store</a></li>
                              
                                <li><a href="about.html">About</a></li>
                                <li><a href="contact.html">Contact</a></li>
                            </ul>
                        </nav>
                    </div>
            <!-- nav-bar first line to right -->
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
        <?php 
              if(($_GET["prod_id"])){
                $i = 1;
                $prod_id = $_GET["prod_id"]; 

                $sql = " SELECT Generic.current_stock_level, Generic.name as generic,Product.* FROM `Product` 
                INNER JOIN Generic ON Generic.generic_id = Product.`Generic_generic_id`
                WHERE Product.Active = 1 ";
                $sql .= " AND Product.product_id =  $prod_id ";          
                $sql .= " order by Product.create_date asc ";
                $company = $conn->query($sql);
                $row = $company->fetch_assoc();
                $row_count = mysqli_num_rows($company);
                if($row_count == 1){
                 $current_stock_level = $row["current_stock_level"];
                 $generic = $row["generic"];
                 $product = $row["name"];
                 $price = $row["price"];
                 $prod_id = $row["product_id"];
                }else{
                $current_stock_level = 0;
                $generic = "";
                 $product =  "";
                 $price =  "";
                 $prod_id ="";
                }
              }else{
                $current_stock_level = 0;
                $generic = "";
                $product =  "";
                $price =  "";
                $prod_id = "";
              }
    ?>

 <!-- nav-bar second line -->
        <div class="bg-light py-3">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 mb-0"><a href="home.php">Home</a> <span class="mx-2 mb-0">/</span> 
                    <a href="shop.php">Store</a> <span class="mx-2 mb-0">/</span> <strong
                            class="text-black"><?php echo $product; ?></strong></div>
                </div>
            </div>
        </div>
        <?php 

        // If no get Id
        if(!$_GET["prod_id"] || $row_count <=0){
          echo "No products found";
          exit;
        }
        
        ?>

        <!-- Single product -->
        <div class="site-section">
            <div class="container">
                <div class="row">
                    <div class="col-md-5 mr-auto">
                        <div class="border text-center">
                            <img src="images/<?php echo $product; ?>.png" alt="Image" class="img-fluid p-5">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h2 class="text-black"><?php echo $product; ?></h2>
                        <p><?php echo $generic; ?></p>


                        <p><strong class="text-primary h4">Rs: <?php echo $price; ?></strong></p>

            <!-- Add to cart form -->
                    <form method="POST" action="cart.php">
                        <div class="mb-5">
                            <div class="input-group mb-3" style="max-width: 220px;">

                                <div class="input-group-prepend">
                                    <button class="btn btn-outline-primary js-btn-minus" type="button" id="minus" onclick="check_qty_btn(2)">
                                    &minus;</button>
                                </div>

                                <input type="text" class="form-control text-center" name="quantity" id="quantity" value="1" placeholder=""
                                    aria-label="Example text with button addon" aria-describedby="button-addon1">

                                <div class="input-group-append">
                                    <button class="btn btn-outline-primary js-btn-plus" type="button" onclick="check_qty_btn(1)" id="plus">
                                    &plus;</button>
                                </div>

                            </div>

                        </div>

                        <input type="hidden" name="customer_id"  value="<?php echo $_SESSION["CUID"];  ?>"/>
                        <input type="hidden" name="product_id"  value="<?php echo $prod_id;  ?>"/>
                        <input type="hidden" name="price"  value="<?php echo $price;  ?>"/>
                        <input type="hidden" name="stat"  value="0"/>


                        <button class="buy-now btn btn-sm height-auto px-4 py-3 btn-primary" name="add_to_cart">Add To
                                Cart</button>

                    </form>

                        

   
    </div>

    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/jquery-ui.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/jquery.magnific-popup.min.js"></script>
    <script src="js/aos.js"></script>

    <script src="js/main.js"></script>

    <script>
// for input
        $( "#quantity" ).keyup(function() {
            var v = this.value;
            check_qty(v);
        });

// common
        function check_qty(v){

        var csl = '<?php echo $current_stock_level ?>';
        var cs_val = parseInt(csl);
        var req_val = parseInt(v);
        if(req_val > cs_val){
            alert("Out of stock");
            $( "#quantity" ).val(0);
        }
        }

// for btn
        function check_qty_btn(type){

        var v =  $("#quantity").val();
        if(type == 1){
            var val = (parseInt(v)+1)
            check_qty(val)
        }else{
            var val = (parseInt(v)-1)
            check_qty(val)
        }
        }
    </script>

</body>

</html>