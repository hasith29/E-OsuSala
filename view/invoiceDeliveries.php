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
                            <h3 class="m-0 font-weight-bold text-primary">Invoice Deliveries</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="IND1" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Supplier</th>
                                            <th>Product </th>
                                            <th>Quantity Supplying</th>
                                            <th>Quantity </th>
                                            <th>Delivery Date</th>
                                            <th>Received</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Supplier</th>
                                            <th>Product </th>
                                            <th>Quantity Supplying</th>
                                            <th>Quantity </th>
                                            <th>Delivery Date</th>
                                            <th>Received</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php
                                        $i = 1;
                                        $rQ = $conn->query("SELECT Awarded.*,Generic.name as generic,Generic.generic_id, Supplier.firstname,Supplier.lastname,
                                        Product.name as product from Awarded
                                        INNER JOIN Generic ON Generic.generic_id = Awarded.Generic_generic_id
                                        INNER JOIN Supplier ON Supplier.supplier_id = Awarded.Supplier_supplier_id
                                        INNER JOIN Product ON Product.product_id = Awarded.product_id AND Awarded.status = 'Accepted' AND Awarded.received_status = 1
                                        ");
                                        if ($rQ) {
                                            while ($row = $rQ->fetch_assoc()) :
                                        ?>
                                                <tr>
                                                    <td><?php echo $row["firstname"] . " " . $row["lastname"] ?> </td>
                                                    <td><?php echo $row["product"] ?> </td>
                                                    <td><?php echo  '<span class="badge badge-success text">Accepted</span>'; ?>
                                                    </td>
                                                    <td> <?php echo $row["quantity"] ?></td>
                                                    <td> <?php echo $row["delevery_date"] ?></td>
                                                    <td> <?php

                                                            if ($row["received_status"] == 0) { ?>
                                                            <a href="#" class="btn btn-primary btn-icon-split" onclick="received(<?php echo $row['award_id'] ?>,<?php echo $row['generic_id'] ?>,<?php echo $row['quantity'] ?>)">
                                                                <span class="icon text-white-50">
                                                                    <i class="fas fa-edit"></i>
                                                                </span>
                                                                <span class="text">Receive</span>
                                                            </a>
                                                        <?php  } else {
                                                                echo  '<span class="badge badge-success text">Received</span>';
                                                            }

                                                        ?>
                                                    </td>
                                                </tr>
                                        <?php endwhile;
                                        } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="row ">
                    <div class="col-8"></div>
                        <div class="col-4">

                            <a href="#" class="btn btn-primary btn-user btn-block" >
                                Run price evaluation
                            </a>
                        </div>


                    </div> -->
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

</html>

<script>
    function received(id, gen_id, quantity) {

        $.ajax({
                url: 'model/ajax.php?action=rec_award',
                data: {
                    "id": id,
                    "gen_id": gen_id,
                    "quantity": quantity
                },
                dataType: 'json',
                type: 'POST'
            })
            .done(function(resp) {

                if (resp == 1) {
                    alert_toast("Generic successfully rejected", 'success');
                    setTimeout(function() {
                        location.reload()
                    }, 1500)
                }
            })

    }

    $(document).ready(function() {
        $('#IND1').DataTable({
            initComplete: function() {
                this.api().columns().every(function() {
                    var column = this;
                    var select = $('<select class="custom-select"><option value=""></option></select>')
                        .appendTo($(column.footer()).empty())
                        .on('change', function() {
                            var val = $.fn.dataTable.util.escapeRegex(
                                $(this).val()
                            );

                            column
                                .search(val ? '^' + val + '$' : '', true, false)
                                .draw();
                        });

                    column.data().unique().sort().each(function(d, j) {
                        select.append('<option value="' + d + '">' + d + '</option>')
                    });
                });
            }
        });
    });
</script>
