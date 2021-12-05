<!DOCTYPE html>
<html lang="en">
<?php
session_start();
include '../config/database.php';
    ini_set('display_errors', 1);

    // if(!isset($_SESSION["CUID"])){
    //     header("Location: ../view/login.php");
    //   }
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

    <div class="site-wrap">

        <div class="site-navbar py-2">
<!-- search -->
            <div class="search-wrap">
                <div class="container">
                    <a href="#" class="search-close js-search-close"><span class="icon-close2"></span></a>
                    <form action="home.php" method="POST">
                        <input type="text" class="form-control" name="serch_prod"
                            placeholder="Search the genric or the prescribed brand here...">
                    </form>
                </div>
            </div>
        <!-- logo -->
            <div class="container">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="logo">
                        <div class="site-logo">
                            <a href="home.php" class="js-logo-clone"><img width="100" height="70" src="../img/logo.jpeg" alt="MISSING JPG"/></a>
                        </div>
                    </div>
                    <!-- nav-bar first -->
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
<!-- taking count for shopping bucket- removed in this page -->
                    <?php

                    $sql2 = " SELECT * FROM `Bill_item` ,Bill
                    WHERE  Bill.status = 0 AND Bill_item.bill_id = Bill.bill_id ";
                    $item = $conn->query($sql2);
                    $item_count = mysqli_num_rows($item);

                    ?>

                    <div class="icons">
                        <a href="#" class="icons-btn d-inline-block js-search-open"><span
                                class="icon-search"></span></a>
                        <!-- <a href="cart.php" class="icons-btn d-inline-block bag">
                            <span class="icon-shopping-cart"></span>
                            <span class="number"><?php echo $item_count; ?></span>
                        </a> -->

                    <!-- Icon for customerHome & login & signUp -->
                        <a href="customerHome.php" class="icons-btn d-inline-block"><span class="icon-user"></span></a>
                        <a href="#" class="site-menu-toggle js-menu-toggle ml-3 d-inline-block d-lg-none"><span
                                class="icon-menu"></span></a>
                    </div>

                    <a href="../view/registerMain.php" class="btn btn-primary px-1 py-1">SignUp</a>
                    <a href="../view/login.php" class="btn btn-primary px-1 py-1">Login</a>
                </div>
            </div>
        </div>

        <div class="site-blocks-cover" style="background-image: url('images/home2.jpg');">

            <div class="container">

                <div class="row">
                    <div class="col-md-6 col-lg-4 mb-4 mb-lg-0">

                        <div class="block-7" style="color:black">
                            <h3>Your health is prime but the brand or the prestige is tributary</h3>
                            <p style="color:black">We are your truested partner on choosing the lowest product with the
                                quality</p>
                        </div>

                    </div>

                    <div class="col-md-6 col-lg-2">
                    </div>
                    <div class="col-md-6 col-lg-2">
                    </div>
                    <div class="col-md-6 col-lg-2">
                        <img align ="left" width="500" height="300" src="images/home_image.png" alt="Image">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Category types -->
    <div class="site-section">
        <div class="container">
            <div class="row align-items-stretch section-overlap">
                <div class="col-md-6 col-lg-4 mb-4 mb-lg-0">
                    <div class="banner-wrap bg-primary h-100"
                        style="background-image: url('images/medicine.png');height:100px">
                        <a href="loggedCustomer.php?category=1" class="h-100">
                            <br> <br>
                            <h5 style="font-weight: bold;">Medicines</h5>

                        </a>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 mb-4 mb-lg-0">
                    <div class="banner-wrap bg-primary h-100"
                        style="background-image: url('images/med_devices.png');height:100px">
                        <a href="loggedCustomer.php?category=2" class="h-100">
                            <br> <br>
                            <h5 style="font-weight: bold;">Medicinal<br> Devices</h5>

                        </a>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 mb-4 mb-lg-0">
                    <div class="banner-wrap bg-primary h-100"
                        style="background-image: url('images/wellness_prod.png');height:100px">
                        <a href="loggedCustomer.php?category=3" class="h-100">
                            <br> <br>
                            <h5 style="font-weight: bold;">Wellness<br> Products</h5>

                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Product catalog -->
    <div class="site-section">
        <div class="container">
            <div class="row">
                <div class="title-section text-center col-12">
                </div>
            </div>
            <!-- without category -->
            <div class="row">
                <?php
                if(!isset($_GET["category"])){
                $i = 1;

                $sql = " SELECT Generic.name as generic,Product.* FROM `Product`
                INNER JOIN Generic ON Generic.generic_id = Product.`Generic_generic_id`
                WHERE Product.Active = 1 ";
                if(isset($_POST["serch_prod"])){
                    $txt = $_POST["serch_prod"];
                    $sql .= " AND (Product.name LIKE '%$txt%' OR Generic.name LIKE '%$txt%')  ";
                    $txt = "";
                }
                $sql .= " order by Product.create_date asc ";
                $company = $conn->query($sql);
                while($row=$company->fetch_assoc()):
                    $name=$row["name"]
                ?>
                <!-- Each product -->
                <div class="col-sm-6 col-lg-4 text-center item mb-4">
                    <span class="tag">Sale</span>
                    <a href="shop-single.php?prod_id=<?php echo $row["product_id"] ?>"> <img width="300" height="300" src="images/<?php echo $name;?>.png" alt="Image"></a>
                    <h3 class="text-dark">
                        <a href="shop-single.php?prod_id=<?php echo $row["product_id"] ?>"><?php echo $row["name"];?></a>
                    </h3>
                    <p class="price">Rs. <?php echo $row["price"];?></p>
                </div>
                <?php
            $i++;
            endwhile;
        }else{

            $i = 1;
            $category = $_GET["category"];
            $sql = " SELECT Generic.name as generic,Product.* FROM `Product`
            INNER JOIN Generic ON Generic.generic_id = Product.`Generic_generic_id`
            WHERE Product.Active = 1 AND Generic.Category_category_id =  $category ";
            $sql .= " order by Product.create_date asc ";
            $company = $conn->query($sql);
            while($row=$company->fetch_assoc()): 
                $name=$row["name"]?>

                <div class="col-sm-6 col-lg-4 text-center item mb-4">
                    <span class="tag">Sale</span>
                    <a href="shop-single.php?prod_id=<?php echo $row["product_id"] ?>"> <img width="300" height="300"
                            src="images/product_0<?php echo $name;?>.png" alt="Image"></a>
                    <h3 class="text-dark"><a
                            href="shop-single.php?prod_id=<?php echo $row["product_id"] ?>"><?php echo $row["name"];?></a>
                    </h3>
                    <p class="price">Rs. <?php echo $row["price"];?></p>
                </div>

                <?php   $i++;
            endwhile;

        }
            ?>
            </div>

        </div>
    </div>

    </div>

    <footer class="site-footer">
        <div class="container">
            <div class="row">
            <div class="col-md-6 col-lg-4 mb-4 mb-lg-0">

                <div class="block-7">
                <h3 class="footer-heading mb-4">Our Vision</h3>
                <p>To increase the validity & benefit for the public of the Essential Medicines Concept 
                    introduced in past decades using the present technological concepts.</p>
                </div>

            </div>
            <div class="col-lg-2 mx-auto mb-5 mb-lg-0">
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="block-5 mb-5">
                <h3 class="footer-heading mb-4">Contact Info</h3>
                <ul class="list-unstyled">
                    <li class="address">1008, Parakrama Rd, Colombo 05</li>
                    <li class="phone"><a href="tel://0112345456">011-2345456</a></li>
                    <li class="email">eosusala@gmail.com</li>
                </ul>
                </div>


            </div>
            </div>
        </div>
        </footer>

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
