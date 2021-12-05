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

                    <!-- Table to add new products -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Add Products</h6>
                        </div>
                       
                        <div class="card-body">
                            <div class="table-responsive">
                                <div class="card-header py-3">

                                    <!-- drop down generic select -->
                                    <div class="form-group">
                                        <select class="custom-select" name="generic" id="generic">
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

                                    <a class='btn btn-secondary' onclick="add_pr_row()"> +</a>
                                </div>
                               <!-- form for table to add -->
                                <form action="" method="POST">

                                    <table class="table table-bordered table-wrapper" id="product_info_table">
                                        <thead>
                                            <tr>
                                                <th style="width:30%">Generic Product</th>
                                                <th style="width:35%">Supplier Product Name</th>
                                                <th style="width:20%">NMRA Reg. NO</th>
                                                <th style="width:20%">Price</th>
                                                <th>Remove</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>

                                    <button type="button" onclick="location.href ='supplierHome.php?page=product';" class="btn btn-default">Back to Products</button>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <button type="submit" class="btn btn-primary" name="create_product">Create
                                        Product</button>
                                </form>

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
function add_pr_row() {

    var generic = $("#generic").val();
    var generic_text = $("#generic option:selected").text();

    var table = $("#product_info_table");
    var count_table_tbody_tr = $("#product_info_table tbody tr").length;
    var row_id = count_table_tbody_tr + 1;

    var html = '<tr id="row_' + row_id + '">' +
        '<td style="text-align:center;font-size: 10pt;">' + generic_text +
        '<input type="hidden" name="gen_id[]" readonly id="gen_id' + row_id + '" class="form-control" value="' +
        generic + '"> <input min="1" max="3" type="text" name="" id="qty_' + row_id +
        '" class="form-control">';
    html += '</td>' +
        '<td><input min="1"  type="text" required name="product[]" id="product_' + row_id +
        '" class="form-control" ></td>' +
        '<td><input min="1"  type="text" required  name="NMRA[]" id="NMRA_' + row_id +
        '" class="form-control" ></td>'  +
        '<td><input min="1"  type="text" required  name="price[]" id="price_' + row_id +
        '" class="form-control" ></td>' +
        '<td><button type="button" class="btn btn-danger" onclick="removeRow(\'' + row_id +
        '\')"><i class="fa fa-close"></i><span>x</span></button></td>' +
        '</tr>';
    if (count_table_tbody_tr >= 1) {
        $("#product_info_table tbody tr:last").after(html);
    } else {
        $("#product_info_table tbody").html(html);
    }
    $("#qty_" + row_id).hide();

}

function removeRow(tr_id) {
    $("#product_info_table tbody tr #row_" + tr_id).remove();
}
</script>

<?php
                                
if(isset($_POST["create_product"]) && isset($_POST["product"])){
    $count_product = count($_POST["product"]);
}else{
    $count_product = 0;
}

if(isset($_POST["create_product"]) && $count_product ==0) {
    echo "<p style='color:red'>Please enter a product</p>";
    return;
 }

if($count_product > 0){

    for($x = 0; $x < $count_product; $x++) {

            $name = $_POST['product'][$x];
            $gen_id = $_POST['gen_id'][$x];
            $NMRA = $_POST['NMRA'][$x];
            $price = $_POST['price'][$x];
                    
                $supp_id = $_SESSION["SUID"];
                $data = " name = '$name' ";
                $data .= ", Supplier_supplier_id = '$supp_id' ";
                $data .= ", Generic_generic_id = '$gen_id' ";
                $data .= ", NMRA_regno = '$NMRA' ";
                $data .= ", price = '$price' ";
                $data .= ", create_date = '".date('Y-m-d H:i:s')."' ";
        
                if(empty($id)){
                    $save = mysqli_query($conn,"INSERT INTO Product set ".$data);
                }
                
            }
            echo '<script>window.location.href = "supplierHome.php?page=product";</script>';
            exit;
        }
        

?>

</html>