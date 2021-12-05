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
                    <br>

                    <!-- DataTables  -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h3 class="m-0 font-weight-bold text-primary">Quality Assured Quotations</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="example" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Supplier</th>
                                            <th>Product Brand</th>
                                            <th>Registration No</th>

                                            <th>Status for quality</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Supplier</th>
                                            <th>Product Band</th>
                                            <th>Registration No</th>
                                            <th>Status for quality</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php
                                        $i = 1;
                                        $rQ = $conn->query("SELECT Supplier.firstname,Supplier.lastname,Product . * , Generic.name AS generic, GenericResponse.`price_evaluate_status`, GenericResponse.`quality_evaluate_status`,GenericResponse.price
                                        FROM GenericResponse
                                        INNER JOIN Product ON Product.product_id = GenericResponse.Product_product_id
                                        INNER JOIN Generic ON Generic.generic_id = Product.Generic_generic_id
                                        INNER JOIN Supplier ON Supplier.supplier_id = GenericResponse.GenericRequestSupplier_id
                                        WHERE GenericResponse.`quality_evaluate_status` = 1 AND GenericResponse.`price_evaluate_status` = 0
                                        ");
                                        if ($rQ) {
                                            while ($row = $rQ->fetch_assoc()) :
                                        ?>
                                                <tr>
                                                    <td> <?php echo $row["firstname"] . " " . $row["lastname"] ?></td>
                                                    <td> <?php echo $row["name"] ?></td>
                                                    <td> <?php echo $row["NMRA_regno"] ?></td>

                                                    <td><?php
                                                        if ($row["quality_evaluate_status"] == 0) {
                                                            echo '<span class="badge badge-info text">Pending</span>';
                                                        } else if ($row["quality_evaluate_status"] == 1) {
                                                            echo '<span class="badge badge-success text">Accepted</span>';
                                                        } else {
                                                            echo '<span class="badge badge-danger text">Rejected</span>';
                                                        }
                                                        ?> </td>
                                                </tr>
                                        <?php endwhile;
                                        } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row ">
                        <div class="col-8"></div>
                        <div class="col-4">

                            <a href="#" class="btn btn-primary btn-user btn-block" id="price_evo">
                                Run price evaluation
                            </a>
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
    <!-- <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a> -->

</body>



</html>
<script>
    $(document).ready(function() {
        $('#example').DataTable({
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

$("#price_evo").click(function(){

$.ajax({
        url: 'model/ajax.php?action=price_evo',
        dataType: 'json'
    })
    .done(function(resp) {
        if (resp == 1) {
            alert_toast("Data successfully evaluvated", 'success');
            setTimeout(function() {
                location.reload()
            }, 1500)

        }
    })

})
</script>
