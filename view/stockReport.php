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
                            <label for="status">Stock Status</label><br>
                            <select class="custom-select" id="status" name="status">
                                <option value="" disabled selected>Select status..</option>
                                <option value="Scrap" >Scrap</option>
                                <option value="Order" >Order</option>
                                <option value="Purchase" >Purchase</option>

                            </select>
                        </div>
                        <div class="col-3">
                            <label for="startdate">StartDate</label><br>
                            <div class="form-group row">
                                <input type="date" class="form-control form-control-user" id="startdate" name="startdate" placeholder="startdate">
                            </div>
                        </div>

                        <div class="col-3">
                            <label for="enddate">EndDate</label><br>
                            <div class="form-group row">
                                <input type="date" class="form-control form-control-user" id="enddate" name="enddate" placeholder="enddate">
                            </div>
                        </div>
                    </div>
                    <br>

                    <!-- DataTales  -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h3 class="m-0 font-weight-bold text-primary">Stock Report</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable1" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Generic</th>
                                            <th>StockStatus</th>
                                            <th>ModifiedDate</th>
                                            <th>ModifiedAmount</th>

                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Generic</th>
                                            <th>StockStatus</th>
                                            <th>ModifiedDate</th>
                                            <th>ModifiedAmount</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>

                                    <?php if(isset($_POST["status"]) && isset($_POST["startdate"]) && isset($_POST["enddate"])){
                                            $status =  $_POST['status'] ;
                                            $startdate =  $_POST['startdate'] ;
                                            $enddate =  $_POST['enddate'] ;
                                        $i = 1;
                                        $generic = $conn->query("SELECT Stock_log.*, Generic.name AS generic
                                        FROM Stock_log
                                        INNER JOIN Generic ON Generic.generic_id = Stock_log.gen_id_scrap
                                        WHERE ( date(Stock_log.create_date) between '$startdate' AND '$enddate' )
                                        " );
                                        while($row=$generic->fetch_assoc()):

                                    ?>

                                        <tr>
                                            <td> <?php echo $row["generic"]?> </td>
                                            <td> <?php echo $row["status"]?></td>
                                            <td> <?php echo $row["create_date"]?></td>
                                            <td> <?php echo $row["amount"]?></td>
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
    <!-- <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a> -->

</body>
</html>

<script type="text/javascript" language="javascript" >
 $(document).ready(function(){

  $('#dataTable1').DataTable({

   dom: 'lBfrtip',
   buttons: [
     'csv', 'copy'
   ],
   "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ]
  });

 });

</script>
