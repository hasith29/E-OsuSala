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

            <form action="" method="POST">

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <div class="row ">
                        <div class="col-3">
                            <label for="supplier">Supplier</label><br>
                            <select class="custom-select" id="supplier" name="supplier" required>

                                <option value="" disabled selected>Select supplier..</option>
                                <?php
                                        $supplier = $conn->query("SELECT * FROM Supplier order by supplier_id asc");
                                        while($row=$supplier->fetch_assoc()):
								        ?>
                                <option value="<?php echo $row["supplier_id"] ?>">
                                    <?php echo $row["firstname"]." ".$row["lastname"]; ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="col-3">
                            <label for="generic">Generic</label><br>
                            <select class="custom-select" id="generic" name="generic" required>
                                <option value="" disabled selected>Select supplier..</option>
                                <?php
                                        $generic = $conn->query("SELECT * FROM Generic order by generic_id asc");
                                        while($row=$generic->fetch_assoc()):
								        ?>
                                <option value="<?php echo $row["generic_id"] ?>">
                                    <?php echo $row["name"]; ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="col-3">
                            <label for="startdate">StartDate</label><br>
                            <div class="form-group row">
                                <input type="date" class="form-control form-control-user" id="startdate"
                                    name="startdate" placeholder="startdate" required>
                            </div>
                        </div>

                        <div class="col-3">
                            <label for="enddate">EndDate</label><br>
                            <div class="form-group row">
                                <input type="date" class="form-control form-control-user" id="enddate" name="enddate"
                                    placeholder="enddate" required>
                            </div>
                        </div>

                        <div class="col-3">
                            <div class="form-group row">
                                <!-- <a href="#" class="btn btn-primary btn-user btn-block">
                                Generate Report
                            </a> -->
                            <!-- <button type="submit" class="btn btn-primary btn-user btn-block">
                                Generate Report
                            </button> -->
                            </div>
                        </div>


                    </div>
                    <br>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h3 class="m-0 font-weight-bold text-primary">Purchases Report</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable123" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>

                                            <th>Supplier</th>
                                            <th>Generic</th>
                                            <th>PurchasedDate</th>
                                            <th>Quantity</th>
                                            <th>Price</th>

                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Supplier</th>
                                            <th>Generic</th>
                                            <th>PurchasedDate</th>
                                            <th>Quantity</th>
                                            <th>Price</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                    <?php if(isset($_POST["supplier"]) && isset($_POST["generic"]) && isset($_POST["startdate"]) && isset($_POST["enddate"])){
                                            $supplier_id =  $_POST['supplier'] ;
                                            $genericid =  $_POST['generic'] ;
                                            $startdate =  $_POST['startdate'] ;
                                            $enddate =  $_POST['enddate'] ;
                                        $i = 1;
                                        // $generic = $conn->query("SELECT GenericRequestSupplier.create_date,
                                        // Supplier.firstname, Supplier.lastname, Generic.name AS generic, GenericRequest.quantity
                                        // FROM GenericRequestSupplier
                                        // INNER JOIN Supplier ON Supplier.supplier_id = GenericRequestSupplier.Supplier_supplier_id
                                        // INNER JOIN GenericRequest ON GenericRequest.generic_request_id = GenericRequestSupplier.generic_request_id
                                        // INNER JOIN Generic ON Generic.generic_id = GenericRequest.Generic_generic_id
                                        // WHERE GenericRequestSupplier.Supplier_supplier_id = $supplier_id AND GenericRequest.Generic_generic_id = $genericid AND ( date(GenericRequestSupplier.create_date) between '$startdate' AND '$enddate' )
                                        // " );
                                        $generic = $conn->query("SELECT GenericResponse.create_date,
                                        Supplier.firstname, Supplier.lastname, Generic.name AS generic, GenericResponse.quantity,GenericResponse.price
                                        FROM GenericResponse
                                        INNER JOIN Supplier ON Supplier.supplier_id = GenericResponse.GenericRequestSupplier_id
                                        INNER JOIN GenericRequest ON GenericRequest.generic_request_id = GenericResponse.GenericRequest_generic_request_id
                                        INNER JOIN Generic ON Generic.generic_id = GenericRequest.Generic_generic_id
                                        WHERE GenericResponse.GenericRequestSupplier_id = $supplier_id AND GenericRequest.Generic_generic_id = $genericid AND ( date(GenericResponse.create_date) between '$startdate' AND '$enddate' )
                                        " );
                                        while($row=$generic->fetch_assoc()):

                                    ?>

                                        <tr>
                                            <td><?php echo $row["firstname"]." ". $row["lastname"]?> </td>
                                            <td> <?php echo $row["generic"]?> </td>
                                            <td> <?php echo $row["create_date"]?></td>
                                            <td> <?php echo $row["quantity"]?></td>
                                            <td> <?php echo $row["price"]?></td>
                                        </tr>
                                        <?php
                                    endwhile;
                                    } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row ">
                        <div class="col-8"></div>
                        <div class="col-4">

                        <button type="submit" class="btn btn-primary btn-user btn-block">
                                Generate Report
                            </button>
                        </div>
                                        </form>

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

<script type="text/javascript" language="javascript" >
 $(document).ready(function(){

  $('#dataTable123').DataTable({

   dom: 'lBfrtip',
   buttons: [
     'csv', 'copy'
   ],
   "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ]
  });

 });

</script>
