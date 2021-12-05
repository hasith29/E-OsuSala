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
    <form method="POST" action="report.php?page=salesReport">

        <!-- Page Wrapper -->
        <div id="wrapper">

            <!-- Content Wrapper -->
            <div id="content-wrapper" class="d-flex flex-column">

                <!-- Main Content -->
                <div id="content">


                    <!-- Begin Page Content -->
                    <div class="container-fluid">

                        <div class="row ">

                            <div class="col-3">
                                <label for="generic">Generic</label><br>
                                <select class="custom-select" id="generic_search" name="generic_search" required>
                                    <option disabled selected>Please select generic..</option>
                                    <?php
                                        $i = 1;
                                        $generic = $conn->query("SELECT * FROM Generic WHERE Active = 1 order by generic_id asc");
                                        while($row=$generic->fetch_assoc()):
                                        ?>

                                    <option value="<?php echo $row["generic_id"] ;?>">
                                        <?php echo $row["name"] ;?>
                                    </option>

                                    <?php endwhile; ?>
                                </select>
                            </div>
                            <div class="col-3">
                                <label for="startdate">StartDate</label><br>
                                <div class="form-group row">
                                    <input type="date" class="form-control form-control-user" id="startdate" required
                                        name="startdate" placeholder="startdate">
                                </div>
                            </div>

                            <div class="col-3">
                                <label for="enddate">EndDate</label><br>
                                <div class="form-group row">
                                    <input type="date" class="form-control form-control-user" id="enddate" required
                                        name="enddate" placeholder="enddate">
                                </div>
                            </div>


                        </div>
                        <br>

                        <!-- DataTales  -->
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h3 class="m-0 font-weight-bold text-primary">Sales Report</h3>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable12" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>Generic</th>
                                                <th>OrderId</th>
                                                <th>Quantity</th>
                                                <th>OrderDate</th>

                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>Generic</th>
                                                <th>OrderId</th>
                                                <th>Quantity</th>
                                                <th>OrderDate</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            <?php
                $k = 1;
                $sql = " SELECT SUM(Bill_item.quantity) as tot,Bill.bill_id as OrderID,Bill.create_date as date,
                GROUP_CONCAT(Product.name) as prod_list,Generic.name as generic
                FROM `Bill_item` , Bill, Product,Generic
                WHERE Bill.status = 1
                AND Bill_item.bill_id = Bill.bill_id
                AND Product.product_id = Bill_item.product_id
                AND Generic.generic_id = Product.Generic_generic_id ";
                if (isset($_POST["startdate"]) && isset($_POST["enddate"]) && isset($_POST["generic_search"])){
                    $gen_id = $_POST["generic_search"];
                    $startdate = $_POST["startdate"];
                    $enddate = $_POST["enddate"];
                    $sql .= " AND Generic.generic_id =  $gen_id AND Date(Bill.create_date) BETWEEN '".$startdate."' AND '".$enddate."' ";

                }
                $sql .= " GROUP BY Generic.generic_id  ";
                $cus = $conn->query($sql);
                if($cus ){
                                        while($row=$cus->fetch_assoc()):
                ?>
                                            <tr>
                                                <td><?php echo $row["generic"];  ?> </td>
                                                <td> <?php echo $row["OrderID"];  ?></td>
                                                <td> <?php echo $row["tot"];  ?></td>
                                                <td> <?php echo $row["date"];  ?></td>
                                            </tr>
                                            <?php
                                                $k++;
                                                endwhile;  } ?>
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
        <a class="scroll-to-top rounded" href="#page-top">
            <i class="fas fa-angle-up"></i>
        </a>
    </form>

</body>



</html>

<script type="text/javascript" language="javascript" >
 $(document).ready(function(){

  $('#dataTable12').DataTable({

   dom: 'lBfrtip',
   buttons: [
     'csv', 'copy'
   ],
   "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ]
  });

 });

</script>
