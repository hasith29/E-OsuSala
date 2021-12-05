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
    <?php include '../config/database.php';
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

                    <!-- DataTales for past orders -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">My Past Orders</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="example" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Delivery Status</th>
                                            <th>Item Count</th>
                                            <th>Price</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Date</th>
                                            <th>Delivery Status</th>
                                            <th>Item Count</th>
                                            <th>Price</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php
                                        $customer_id = $_SESSION["CUID"];
                                        $sql = " SELECT Generic.generic_id,Bill.delivery_status as delivery_status,
                                        count(Bill_item.quantity) as quantity ,sum(Bill_item.amount) as amountm,Bill_item.create_date 
                                        FROM `Bill_item` ,Bill,Product,Generic
                                        WHERE Bill.customer_id = $customer_id AND Bill_item.bill_id = Bill.bill_id
                                         AND Product.product_id = Bill_item.product_id  AND 
                                         Generic.generic_id = Product.Generic_generic_id AND Bill.delivery_status = 'Delivered' 
                                         GROUP BY Bill.bill_id";
                                        $cus = $conn->query($sql);
                                        if($cus){
                                        while($row=$cus->fetch_assoc()):
								        ?>
                                        <tr>
                                            <td><?php echo $row["create_date"] ?></td>
                                            <td><?php echo $row["delivery_status"] ?></td>
                                            <td><?php echo $row["quantity"] ?></td>
                                            <td><?php echo $row["amountm"] ?></td>
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

</html>

<script>

$(document).ready(function() {
    $('#example').DataTable( {
        initComplete: function () {
            this.api().columns().every( function () {
                var column = this;
                var select = $('<select class="custom-select"><option value=""></option></select>')
                    .appendTo( $(column.footer()).empty() )
                    .on( 'change', function () {
                        var val = $.fn.dataTable.util.escapeRegex(
                            $(this).val()
                        );

                        column
                            .search( val ? '^'+val+'$' : '', true, false )
                            .draw();
                    } );

                column.data().unique().sort().each( function ( d, j ) {
                    select.append( '<option value="'+d+'">'+d+'</option>' )
                } );
            } );
        }
    } );
} );
</script>
