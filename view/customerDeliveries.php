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
                            <h3 class="m-0 font-weight-bold text-primary">Customer Deliveries</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Supplier</th>
                                            <th>Product List</th>
                                            <th>Order Date</th>
                                            <th>Delivery Status</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Supplier</th>
                                            <th>Product List</th>
                                            <th>Order Date</th>
                                            <th>Delivery Status</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php
                $k = 1;
                $sql = " SELECT Bill.delivery_status,Bill.bill_id,Bill.create_date,Bill_item.bill_item_id, Product.product_id, Product.name AS product, Bill_item.quantity AS quantity,
                Customer.firstname,Customer.lastname,GROUP_CONCAT(Product.name) as prod_list,
                Bill_item.price AS price, Bill_item.amount AS amount
                FROM `Bill_item` , Bill, Product, Customer
                WHERE Bill.status =1
                AND Bill_item.bill_id = Bill.bill_id
                AND Customer.customer_id = Bill.customer_id
                AND Product.product_id = Bill_item.product_id
                GROUP BY Bill.bill_id ";
                $cus = $conn->query($sql);
                if($cus){
                                        while($row=$cus->fetch_assoc()):
                ?>
                                        <tr>
                                            <td><?php echo $row["firstname"]." ".$row["lastname"] ?> </td>
                                            <td><?php  echo $row["prod_list"] ?> </td>
                                            <td> <?php  echo $row["create_date"] ?></td>
                                            <td>

                                                <select onchange="update_del_status(<?php echo $row['bill_id']; ?>,this.value);" class="custom-select" name="delivery_status" id="delivery_status">
                                                    <option <?php if($row['delivery_status'] == "Pending"){ echo "selected"; } ?> value="Pending">Pending</option>
                                                    <option <?php if($row['delivery_status'] == "Packaging"){ echo "selected"; } ?> value="Packaging">Packaging</option>
                                                    <option <?php if($row['delivery_status'] == "Sent to courier"){ echo "selected"; } ?> value="Sent to courier">Sent to courier</option>
                                                    <option <?php if($row['delivery_status'] == "Delivered"){ echo "selected"; } ?> value="Delivered">Delivered</option>
                                                </select>

                                            </td>
                                        </tr>
                                        <?php
                                    $k++;
            endwhile; } ?>
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
$(document).ready(function() {
    $('#IND').DataTable({
        initComplete: function() {
            this.api().columns().every(function() {
                var column = this;
                var select = $(
                        '<select class="custom-select"><option value=""></option></select>')
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

function update_del_status(bill_id,sel_val){
    $.ajax({
            url: 'model/ajax.php?action=del_status_update',
            dataType: 'json',
            data: {
                "sel_val":sel_val,
                "bill_id":bill_id
            },
                dataType: 'json',
                type: 'POST'

        })
        .done(function(resp) {
            if (resp == 1) {
                alert_toast("Data successfully updated", 'success');
                setTimeout(function() {
                    location.reload()
                }, 1500)

            }
        })
}

</script>
