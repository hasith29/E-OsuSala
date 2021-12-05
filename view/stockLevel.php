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
                            <h3 class="m-0 font-weight-bold text-primary">Stock Level</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Generic Product</th>
                                            <th>Current Stock Level</th>
                                            <th>Re-Order Stock Level</th>
                                            <th>Quote</th>
                                            <th>Status</th>

                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Generic Product</th>
                                            <th>Current Stock Level</th>
                                            <th>Re-Order Stock Level</th>
                                            <th>Quote</th>
                                            <th>Buffer Stock</th>

                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php
                                        $i = 1;
                                        $generic = $conn->query("SELECT * FROM Generic order by generic_id asc");
                                        while($row=$generic->fetch_assoc()):
								        ?>
                                        <tr>
                                            <td><?php echo $row["name"]; ?> </td>
                                            <td><?php echo $row["current_stock_level"]; ?></td>
                                            <td><?php echo $row["reorder_stock_level"]; ?></td>
                                            <td>
                                                <?php
                                            $generic_id = $row["generic_id"];
                                            // Generic_generic_id = $id AND generic_order_status = 1
                                            $generic_req_qry = $conn->query("SELECT * FROM GenericRequest where Generic_generic_id = $generic_id AND generic_order_status = 1 ");
                                            if($generic_req_qry ){
                                            $rowcount=mysqli_num_rows($generic_req_qry);
                                            }else{
                                                $rowcount = 0;
                                            }
                                            if(($row["reorder_stock_level"] >= $row["current_stock_level"])){
                                                 ?>
                                                <a href="" dissabled class="btn btn-primary btn-icon-split quote_edit"
                                                    data-toggle="modal" data-target="#quoteinvitation" id="quote_btn"
                                                    data-gen-name="<?php echo $row["name"]; ?>"
                                                    data-gen-id="<?php echo $row["generic_id"]; ?>"
                                                    data-total-space="<?php echo $row["total_space"]; ?>"
                                                    data-c-stock="<?php echo $row["current_stock_level"]; ?>"
                                                    data-monthly-con="<?php echo $row["monthly_consumption"]; ?>"
                                                    data-lead-time="<?php echo $row["lead_time"]; ?>">
                                                    <span class="icon text-white-50">
                                                        <i class="fas fa-edit"></i>
                                                    </span>
                                                    <span class="text">Quote</span>
                                                </a> <?php  } ?>

                                            </td>
                                            <td> <?php
                                                if($row["Active"] == 1){
                                                    echo '<span class="badge badge-success text">Yes</span>';
                                                }else{
                                                    echo '<span class="badge badge-danger text">No</span>';
                                                }
                                                ?></td>
                                        </tr>
                                        <?php endwhile; ?>

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

    <!-- generic send mail Modal-->
    <div class="modal fade" id="quoteinvitation" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Send invitation to supplier</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger display-error" style="display: none">
                    </div>
                    <form class="user" action="" id="supplierQ_form">
                        <div class="form-group row">
                            <div class="col-sm-12 mb-3 mb-sm-0">
                                <select class="custom-select" id="supplier" name="supplier[]" size="10" multiple
                                    required>
                                    <option value="" disabled selected>Select supplier..</option>
                                    <?php
                                        $category = $conn->query("SELECT * FROM Supplier order by supplier_id asc");
                                        while($row=$category->fetch_assoc()):
								        ?>
                                    <option value="<?php echo $row["supplier_id"] ?>">
                                        <?php echo $row["firstname"]." ".$row["lastname"]; ?></option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-12 mb-3 mb-sm-0">
                                <input hidden type="text" class="form-control form-control-user" id="email" name="email"
                                    placeholder="email">
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-12 mb-3 mb-sm-0">
                              <label for="quantity">Quantity</label><br>
                                <input type="text" class="form-control form-control-user" id="quantity" name="quantity"
                                    placeholder="quantity">
                                <!-- <input type="hidden" class="form-control form-control-user" id="supp_id" name="supp_id"
                                    placeholder="supp_id"> -->
                                <input type="hidden" class="form-control form-control-user" id="gen_id" name="gen_id"
                                    placeholder="gen_id">
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button class="btn btn-secondary" type="button" data-dismiss="modal"
                                onclick="$('#supplierQ_form').get(0).reset()">Cancel</button>
                            <button type="button" class="btn btn-primary offset-md-3" id="submit"> Send Mail</button>
                        </div>

                    </form>

                </div>

            </div>
        </div>
    </div>

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
            // email = $.trim(resp.email);
            // supp_id = $.trim(resp.supplier_id);
            // $("#email").val(email);
            // $("#supp_id").val(supp_id);
        })
});

$('#submit').click(function(e) {
    $("#submit").prop("disabled", true);
    // var to_mail = $("#email").val();
    var quantity = $("#quantity").val();
    var supp_id = $("#supplier").val();
    var gen_id = $("#gen_id").val();

    $.ajax({
            url: 'model/ajax.php?action=send_mail_to_supplier',
            data: {
                "quantity": quantity,
                "supp_id": supp_id,
                "gen_id": gen_id
            },
            dataType: 'json',
            type: 'POST'
        })
        .done(function(resp) {

            if (resp.code == 200) {
                $('#quoteinvitation').modal('hide');
                alert_toast("Email successfully sent", 'success');
                $('#supplierQ_form').get(0).reset();
                // setTimeout(function() {
                //     location.reload()
                // }, 1500)

            } else {
                $("#submit").prop("disabled", false);
                $(".display-error").html("<ul>" + resp.msg + "</ul>");
                $(".display-error").css("display", "block");
            }
        })

})

$(".quote_edit").click(function(e) {
    $(".display-error").hide();
});

$('.quote_edit').click(function() {
    start_load()
    var cat = $('#supplierQ_form')
    cat.get(0).reset()
    cat.find("[name='gen_id']").val($(this).attr('data-gen-id'))

    total_spce = $(this).attr('data-total-space')
    c_stock = $(this).attr('data-c-stock')
    m_con = $(this).attr('data-monthly-con')
    lead_time = $(this).attr('data-lead-time')
    qty = (parseInt(total_spce) - parseInt(c_stock)) + (parseInt(m_con) * parseInt(lead_time));
    $('#quantity').val(qty);
    end_load()
})
</script>


</html>
