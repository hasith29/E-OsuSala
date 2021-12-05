<!DOCTYPE html>
<html lang="en">
<?php
session_start();
ini_set('display_errors', 1);
    include '../config/database.php';
    $message="";
    if(count($_POST)>0) {
        if($_POST["user_role"] == 1){
        $passwordHash = sha1($_POST["password"]);
        $result = mysqli_query($conn,"SELECT * FROM Supplier WHERE email='" . $_POST["email"] . "' and password = '". $passwordHash."'");
        $row  = mysqli_fetch_array($result);

        if(is_array($row)) {
        $_SESSION["SUID"] = $row['supplier_id'];
        $_SESSION["Role_id"] = $row['Role_role_id'];
        $_SESSION["Name"] = $row["firstname"]." ". $row["lastname"];
        } else {
         $message = "<p style='text-align:center;color:red;'>Invalid Username or Password!</p>";
         echo $message;
        //  die;
        }
    }else if($_POST["user_role"] == 2){
        $passwordHash = sha1($_POST["password"]);
        $result = mysqli_query($conn,"SELECT * FROM Customer WHERE email='" . $_POST["email"] . "' and password = '". $passwordHash."'");
        $row  = mysqli_fetch_array($result);

        if(is_array($row)) {
        $_SESSION["CUID"] = $row['customer_id'];
        $_SESSION["Role_id"] = $row['Role_role_id'];
        $_SESSION["Name"] = $row["firstname"]." ". $row["lastname"];
        } else {
         $message = "<p style='text-align:center;color:red;'>Invalid Username or Password!</p>";
         echo $message;
        //  die;
        }
    }else if($_POST["user_role"] == 3){
        $passwordHash = sha1($_POST["password"]);
        $result = mysqli_query($conn,"SELECT * FROM Admin WHERE email='" . $_POST["email"] . "' and password = '". $passwordHash."'");
        $row  = mysqli_fetch_array($result);

        if(is_array($row)) {
        $_SESSION["AUID"] = $row['admin_id'];
        $_SESSION["Role_id"] = $row['Role_role_id'];
        $_SESSION["Name"] = $row["firstname"]." ". $row["lastname"];
        } else {
         $message = "<p style='text-align:center;color:red;'>Invalid Username or Password!</p>";
         echo $message;
        //  die;
        }
    }
    }
    if(isset($_SESSION["CUID"])) {
    header("Location:../customer/loggedCustomer.php");
    }
    if(isset($_SESSION["SUID"])) {
        header("Location:../supplierHome.php");
        }
        if(isset($_SESSION["AUID"])) {
            header("Location:../index.php?page=stockDetail");
            }
?>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">


    <title>E-OSU SALA</title>

    <!-- Custom fonts for this template-->
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body   style="  background-image: url('login.png'); background-size: 100% 100%;">

    <div class="container">
        <?php //include 'commonTop.php' ?>
        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <!-- Nested Row within Card Body -->
                <div class="row" style="height: 500px;">
                    <div class="col-lg-4"></div>
                    <div class="col-lg-4">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                            </div>
                            <form class="user" action="" method="POST">
                                <div class="form-group">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" checked name="user_role"
                                            id="user_role1" value="2">
                                        <label class="form-check-label" for="user_role1">Customer</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="user_role"
                                            id="user_role2" value="1">
                                        <label class="form-check-label" for="user_role2">Supplier</label>
                                    </div><br>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="user_role"
                                            id="user_role3" value="3">
                                        <label class="form-check-label" for="user_role3">Admin</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="email" class="form-control form-control-user" id="email" name="email"
                                        aria-describedby="emailHelp" placeholder="Enter Email Address..." required>
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control form-control-user" id="password"
                                        name="password" placeholder="Password" required>
                                </div>

                                <button class="btn btn-primary btn-user btn-block" id="submit"> Login</button>

                                <a href="registerMain.php" class="small">Create an Account!</a>
                        </div>

                        </form>

                    </div>
                </div>
            </div>


        </div>

    </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../js/sb-admin-2.min.js"></script>

</body>

</html>
