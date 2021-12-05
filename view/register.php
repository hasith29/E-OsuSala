<!DOCTYPE html>
<html lang="en">
<?php
session_start();
// if(!isset($_SESSION["SUID"])) {
//     header("Location:../view/login.php");
//     }
?>
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>E-OSU SALA</title>

    <!-- Custom fonts for this template-->
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body  style="  background-image: url('login.png'); background-size: 100% 100%;">

<?php

include '../config/database.php';
    ini_set('display_errors', 1);
if(isset( $_SESSION["SUID"])){
$SID = $_SESSION["SUID"];
$sql2 = " SELECT * FROM Supplier
WHERE supplier_id = $SID ";
$item = $conn->query($sql2);
$item_count = mysqli_num_rows($item);
// Associative array
if($item_count == 1){
    $row = mysqli_fetch_assoc($item);
    $firstname = $row["firstname"];
    $lastname = $row["lastname"];
    $gender = $row["gender"];
    $address = $row["address"];
    $contactNo = $row["contactNo"];
    $email = $row["email"];
    $age = $row["age"];
    $city = $row["city"];
}else{
    $firstname = "";
    $lastname = "";
    $gender = "";
    $address = "";
    $contactNo = "";
    $email = "";
    $age = "";
    $city = "";
}
}else{
    $firstname = "";
    $lastname = "";
    $gender = "";
    $address = "";
    $contactNo = "";
    $email = "";
    $age = "";
    $city = "";
}


?>

    <div class="container">
        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">
                <h1 class="h4 text-gray-900 mb-4">Create New Supplier Account</h1>
                <!-- Nested Row within Card Body -->
                <div class="row" style="height: 500px;">
                    <div style="margin-left:26px;" class="toast" id="alert_toast" role="alert" aria-live="assertive"
                        aria-atomic="true" width="100%">
                        <div class="toast-body text-white">
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="alert alert-danger display-error" style="display: none">
                        </div>
                    </div>
                    <div class="col-lg-4">

                        <form action="" method="POST" id="frm_crete_supp">

                            <div class="form-group">
                                <input type="text" class="form-control form-control-user" id="FirstName"
                                    placeholder="FirstName" name="FirstName" value="<?php echo $firstname; ?>">
                            </div>

                            <div class="form-group">
                            <select class="custom-select" id="Gender" name="Gender">
                                        <option <?php if($gender == "Male"){echo "selected"; } ?> value="Male">Male</option>
                                        <option <?php if($gender == "Female"){echo "selected"; } ?> value="Female">Female</option>
                                    </select>
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control form-control-user" id="Password"
                                    placeholder="EnterPassword" name="Password">
                            </div>

                            <div class="form-group">
                                <input type="text" class="form-control form-control-user" id="ContactNo"
                                    placeholder="ContactNo" name="ContactNo" value="<?php echo $contactNo; ?>">
                            </div>
                            <div class="form-group">
                                <input type="email" class="form-control form-control-user" id="Email"
                                    placeholder="E-mail" name="Email" value="<?php echo $email; ?>">
                            </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <input type="text" class="form-control form-control-user" id="LastName"
                                placeholder="LastName" name="LastName" value="<?php echo $lastname; ?>">
                        </div>

                        <div class="form-group">
                            <input type="text" class="form-control form-control-user" id="Address" placeholder="Address"
                                name="Address" value="<?php echo $address; ?>">
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control form-control-user" id="ConfirmPassword"
                                placeholder="ConfirmPassword" name="ConfirmPassword">
                        </div>

                        <div class="form-group">
                            <input type="text" class="form-control form-control-user" id="Age" placeholder="Age"
                                name="Age" value="<?php echo $age; ?>">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control form-control-user" id="City" placeholder="City"
                                name="City" value="<?php echo $city; ?>">
                        </div>

                        <?php
                        if(isset($_GET["id"])){
                            $supp_id = $_GET["id"];
                        }else{
                            $supp_id = "";
                        }
                        ?>
                         <input type="hidden" class="form-control form-control-user" id="supp_id" placeholder="City"
                            name="supp_id" value="<?php echo $supp_id ; ?>">
                            <?php if($supp_id){
                                echo '<button type="button" class="btn btn-primary btn-user btn-block" id="btn_create_supp"> Update
                                Account</button>';
                            }else{
                                echo '<button type="button" class="btn btn-primary btn-user btn-block" id="btn_create_supp"> Create
                                Account</button>';
                            }  ?>

                        </form>
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

</html>\
<script>
$('#btn_create_supp').click(function(e) {

    e.preventDefault()
    let myForm = document.getElementById('frm_crete_supp');
    let formData = new FormData(myForm);

    $.ajax({
            url: '../model/ajax.php?action=save_supplier',
            data: formData,
            dataType: 'json',
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            type: 'POST',
        })
        .done(function(resp) {

            if (resp.code == 200) {
                $('#quoteResponse').modal('hide');
                alert_toast("Supplier data successfully added", 'success');
                $('#frm_crete_supp').get(0).reset();
                setTimeout(function() {
                    var url = "login.php";
                    $(location).attr('href', url);
                }, 1500)

            } else {
                $(".display-error").html("<ul>" + resp.msg + "</ul>");
                $(".display-error").css("display", "block");
            }
        })

})

window.alert_toast = function($msg = 'TEST', $bg = 'success') {
    $('#alert_toast').removeClass('bg-success')
    $('#alert_toast').removeClass('bg-danger')
    $('#alert_toast').removeClass('bg-info')
    $('#alert_toast').removeClass('bg-warning')

    if ($bg == 'success')
        $('#alert_toast').addClass('bg-success')
    if ($bg == 'danger')
        $('#alert_toast').addClass('bg-danger')
    if ($bg == 'info')
        $('#alert_toast').addClass('bg-info')
    if ($bg == 'warning')
        $('#alert_toast').addClass('bg-warning')
    $('#alert_toast .toast-body').html($msg)
    $('#alert_toast').toast({
        delay: 3000
    }).toast('show');
}
</script>
