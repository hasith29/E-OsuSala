<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>E-OSU SALA</title>

</head>

<body id="page-top">
    <?php include 'config/database.php';
    ini_set('display_errors', 1);
    ?>
    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h3 class="m-0 font-weight-bold text-primary">Received Awards</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>

                                            <th>QTY to Supply</th>
                                            <th>Generic</th>
                                            <th>Supplying Product</th>
                                            <!-- <th>Supplying Product</th> -->
                                            <th>Accept</th>
                                            <th>Reject</th>


                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>QTY to Supply</th>
                                            <th>Generic</th>
                                            <th>Supplying Product</th>
                                            <!-- <th>Supplying Product</th> -->
                                            <th>Accept</th>
                                            <th>Reject</th>

                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php
                                        $supp_id = $_SESSION["SUID"];
                                        $i = 1;
                                        $rQ = $conn->query("SELECT Awarded.*,Generic.name as generic,Generic.generic_id, Supplier.firstname,Supplier.lastname,Product.name as product from Awarded
                                        INNER JOIN Generic ON Generic.generic_id = Awarded.Generic_generic_id
                                        INNER JOIN Supplier ON Supplier.supplier_id = Awarded.Supplier_supplier_id
                                        INNER JOIN Product ON Product.product_id = Awarded.product_id AND Awarded.Supplier_supplier_id = $supp_id
                                        ");
                                        if($rQ){
                                        while($row=$rQ->fetch_assoc()):
								        ?>
                                        <tr>
                                            <td><?php echo $row["quantity"] ?></td>
                                            <td><?php echo $row["generic"] ?></td>
                                            <td><?php echo $row["product"] ?></td>
                                            <!-- <td></td> -->
                                            <td>

                                                <?php if($row["status"] != "Pending" ){

                                                    if ($row["status"] != "Rejected" && ($row["status"] == "Accepted" )){ ?>

                                                <span class="badge badge-success text">Acccepted</span>

                                                <?php   }

                                                ?>

                                                <?php }else{ ?>
                                                <a href="#" class="btn btn-primary btn-icon-split" id="accept"
                                                    onclick='accept(<?php echo $row["award_id"] ?>,<?php echo $row["GenericResponse_generic_response_id"] ?>,<?php echo $row["quantity"] ?>,<?php echo $row["Generic_generic_id"] ?>)'>
                                                    <span class="icon text-white-50">
                                                        <i class="fas fa-edit"></i>
                                                    </span>
                                                    <span class="text">Accept</span>
                                                </a>
                                                <?php } ?>

                                            </td>
                                            <td>
                                                <?php if($row["status"] != "Pending" ){

                                                if($row["status"] != "Accepted" && ($row["status"] == "Rejected" )){ ?>
                                                <span class="badge badge-danger text">Rejected</span>

                                                <?php   }

                                                ?>

                                                <?php }else{ ?>
                                                <a href="#" class="btn btn-primary btn-icon-split"
                                                    onclick='reject(<?php echo $row["award_id"] ?>,<?php echo $row["GenericResponse_generic_response_id"] ?>)'
                                                    id="reject">
                                                    <span class="icon text-white-50">
                                                        <i class="fas fa-edit"></i>
                                                    </span>
                                                    <span class="text">Reject</span>
                                                </a>
                                                <?php } ?>

                                            </td>
                                        </tr>
                                        <?php endwhile; } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->


            </div>
            <!-- End of Main Content -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>


</body>
<script>
$("#supplier").change(function() {
    var id = $(this).val();

    $.ajax({
            url: 'model/ajax.php?action=load_supplier_info',
            data: {
                "id": id
            },
            dataType: 'json',
            type: 'POST'
        })
        .done(function(resp) {
            email = $.trim(resp.email);
            $("#email").val(email);
        })
});

$('#submit').click(function(e) {
    var to_mail = $("#email").val();
    var quantity = $("#quantity").val();

    $.ajax({
            url: 'model/ajax.php?action=send_mail_to_supplier',
            data: {
                "to_mail": to_mail,
                "quantity": quantity
            },
            dataType: 'json',
            type: 'POST'
        })
        .done(function(resp) {

            if (resp.code == 200) {
                $('#quoteinvitation').modal('hide');
                alert_toast("Email successfully sent", 'success');
                $('#supplierQ_form').get(0).reset();
                setTimeout(function() {
                    location.reload()
                }, 1500)

            } else {
                $(".display-error").html("<ul>" + resp.msg + "</ul>");
                $(".display-error").css("display", "block");
            }
        })

})

$("#quote_btn").click(function(e) {
    $(".display-error").hide();
});

function accept(id, res_id, quantity, generic_id) {
    $.ajax({
            url: 'model/ajax.php?action=accept_award',
            data: {
                "id": id,
                "res_id": res_id,
                "quantity": quantity,
                "generic_id": generic_id
            },
            dataType: 'json',
            type: 'POST'
        })
        .done(function(resp) {

            if (resp == 1) {
                alert_toast("Award successfully accepted", 'success');
                setTimeout(function() {
                    location.reload()
                }, 1500)
            }
        })

}

function reject(id, res_id) {
    $.ajax({
            url: 'model/ajax.php?action=reject_award',
            data: {
                "id": id,
                "res_id": res_id
            },
            dataType: 'json',
            type: 'POST'
        })
        .done(function(resp) {

            if (resp == 1) {
                alert_toast("Award successfully rejected", 'success');
                setTimeout(function() {
                    location.reload()
                }, 1500)
            }
        })

}
</script>


</html>
