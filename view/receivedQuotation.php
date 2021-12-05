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

                    <div class="row ">
                    </div>
                    <br>

                    <!-- DataTales  -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h3 class="m-0 font-weight-bold text-primary">Received Quotations</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="example" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Product</th>
                                            <th>Generic</th>
                                            <th>Registration No</th>
                                            <th>Quality Evaluation Status</th>
                                            <th>Price Amount</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                    <?php
                                    if(isset($_GET["type"])){
                                        $type = $_GET["type"];
                                        $str = "  GenericResponse.pri_stat = 1  AND GenericResponse.quality_evaluate_status = 1 ORDER BY GenericResponse.price ASC ";
                                    }else{
                                        $type = "";
                                        $str = " GenericResponse.quality_evaluate_status = 0 ";
                                    }
                                        $i = 1;
                                        $rQ = $conn->query("SELECT Product . * , Generic.name AS generic, GenericResponse.`quality_evaluate_status`,
                                        GenericResponse.price
                                        FROM GenericResponse
                                        INNER JOIN Product ON Product.product_id = GenericResponse.Product_product_id
                                        INNER JOIN Generic ON Generic.generic_id = Product.Generic_generic_id WHERE
                                         $str
                                        ");

                                        if($rQ){
                                        while($row=$rQ->fetch_assoc()):
								        ?>
                                        <tr>
                                            <td><?php echo $row["name"]; ?> </td>
                                            <td> <?php echo $row["generic"]; ?></td>
                                            <td> <?php echo $row["NMRA_regno"]; ?> </td>
                                            <td> <?php
                                            if( $row["quality_evaluate_status"] == 0) {
                                                echo '<span class="badge badge-info text">Pending</span>';
                                            }else if($row["quality_evaluate_status"] == 1) {
                                                echo '<span class="badge badge-success text">Accepted</span>';
                                            }else{
                                                echo '<span class="badge badge-danger text">Rejected</span>';
                                            }
                                            ?> </td>
                                            <td> <?php echo $row["price"]; ?> </td>
                                        </tr>
                                        <?php endwhile; } ?>

                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Product</th>
                                            <th>Generic</th>
                                            <th>Registration No</th>
                                            <th>Quality Evaluation Status</th>
                                            <th>Price Amount</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row ">
                        <div class="col-8"></div>
                        <div class="col-4">
                      <?php  if(isset($_GET["type"])){

                            }else{
                                echo ' <a href="#" class="btn btn-primary btn-user btn-block" id="quality_evo">
                                Run quality evaluation
                            </a> ';
                            } ?>

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

$("#quality_evo").click(function(){

    $.ajax({
            url: 'model/ajax.php?action=quality_evo',
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
