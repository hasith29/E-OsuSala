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

                    <!-- DataTales  -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h3 class="m-0 font-weight-bold text-primary">Requests for Quotes</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>

                                            <th>Generic Product</th>
                                            <th>Requested Quantity</th>
                                            <th>Quote</th>
                                            <th>Requested Date</th>
                                            <th>Reject</th>

                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Generic Product</th>
                                            <th>Requested Quantity</th>
                                            <th>Quote</th>
                                            <th>Requested Date</th>
                                            <th>Reject</th>

                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php
                                        $supplier_id = $_SESSION["SUID"];

                                        $i = 1;
                                        $generic = $conn->query("SELECT *,GenericRequestSupplier.create_date as reDate,GenericRequest.Active as Act FROM GenericRequestSupplier
                                        INNER JOIN GenericRequest ON GenericRequest.generic_request_id = GenericRequestSupplier.generic_request_id
                                        INNER JOIN Generic ON Generic.generic_id = GenericRequest.Generic_generic_id
                                         WHERE GenericRequestSupplier.Supplier_supplier_id = $supplier_id AND GenericRequest.Active = 1 order by GenericRequest.create_date asc");
                                        if ($generic) {
                                            while ($row = $generic->fetch_assoc()) :
                                                $gen_req_id = $row["generic_request_id"];
                                                $generic_req_sum_sql = $conn->query("SELECT SUM(`quantity`) AS TotalItemsOrdered FROM GenericResponse WHERE `GenericRequest_generic_request_id` = $gen_req_id");
                                                $sum = $generic_req_sum_sql->fetch_object()->TotalItemsOrdered;
                                                if ($sum) {
                                                    $sum = $sum;
                                                } else {
                                                    $sum = 0;
                                                }
                                        ?>
                                                <tr>
                                                    <td><?php echo $row["name"]; ?> </td>
                                                    <td><?php echo $row["quantity"]; ?></td>
                                                    <td>
                                                        <?php if ($row["Act"] == 1 && $sum < $row["quantity"]) { ?>
                                                            <a href="" class="btn btn-primary btn-icon-split quote_req" data-toggle="modal" data-target="#quoteResponse" id="quote_btn" data-gen-req-id="<?php echo $row["generic_request_id"]; ?>">
                                                                <span class="icon text-white-50">
                                                                    <i class="fas fa-edit"></i>
                                                                </span>
                                                                <span class="text">Quote</span>
                                                            </a>
                                                        <?php } else {
                                                            echo '<span class="badge badge-success text">Quoted</span>';
                                                        } ?>
                                                    </td>
                                                    <td><?php echo $row["reDate"] ?></td>
                                                    <td>
                                                        <?php if ($row["Act"] == 1 && $sum < $row["quantity"]) { ?>
                                                            <a href="#" class="btn btn-primary btn-icon-split" onclick='reject(<?php echo $row["generic_request_id"] ?>)' id="reject">
                                                                <span class="icon text-white-50">
                                                                    <i class="fas fa-edit"></i>
                                                                </span>
                                                                <span class="text">Reject</span>
                                                            </a>
                                                        <?php } else {
                                                            echo '<span class="badge badge-success text">Quoted</span>';
                                                        } ?>
                                                    </td>
                                                </tr>
                                        <?php endwhile;
                                        } ?>
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
    <!-- <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a> -->

    <!-- quotation Modal-->
    <div class="modal fade" id="quoteResponse" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Send Quotation</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger display-error" style="display: none">
                    </div>
                    <form class="user" action="" id="supplierQ_res_form">

                        <div class="form-group row">
                            <div class="col-sm-12 mb-3 mb-sm-0">
                                <select class="custom-select" id="product" name="product">

                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-12 mb-3 mb-sm-0">
                                <label for="enddate">Delivery Date</label><br>
                                <div class="form-group row">
                                    <input type="date" class="form-control form-control-user" id="deliverydate" name="deliverydate" placeholder="deliverydate">
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-12 mb-3 mb-sm-0">
                                <label for="status">Capable Amount to supply</label><br>
                                <input type="text" class="form-control form-control-user" id="quantity" name="quantity" placeholder="Capable Amount to supply">
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-12 mb-3 mb-sm-0">
                                <label for="status">Quoted Price</label><br>
                                <input type="text" class="form-control form-control-user" id="price" name="price" placeholder="Quoted Price">
                            </div>
                        </div>


                        <div class="form-group row">
                            <div class="col-sm-12 mb-3 mb-sm-0">
                                <label for="status">Registration No</label><br>
                                <input type="text" class="form-control form-control-user" id="regno" name="regno" placeholder="Registration No">
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-12 mb-3 mb-sm-0">
                                <label for="status">Manufacturer Name</label><br>
                                <input type="text" class="form-control form-control-user" id="manuname" name="manuname" placeholder="Manufacturer Name">
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-12 mb-3 mb-sm-0">
                                <label for="status">Manufacturer Country</label><br>
                                <input type="text" class="form-control form-control-user" id="manucountry" name="manucountry" placeholder="Manufacturer Country">
                                <input type="hidden" class="form-control form-control-user" id="gen_req_id" name="gen_req_id" placeholder="gen_req_id">
                                <input type="hidden" class="form-control form-control-user" id="gen_req_id" name="gen_req_supp_id" placeholder="gen_req_supp_id" value="<?php echo $supplier_id; ?>">
                            </div>

                        </div>

                        <div class="modal-footer">
                            <button class="btn btn-secondary" type="button" data-dismiss="modal" onclick="$('#supplierQ_res_form').get(0).reset()">Cancel</button>
                            <button type="button" class="btn btn-primary offset-md-3" id="submit"> Send
                                Quotation</button>
                        </div>

                    </form>

                </div>

            </div>
        </div>
    </div>
</body>
<script>
    $("#product").change(function() {
        var id = $(this).val();

        $.ajax({
                url: 'model/ajax.php?action=load_product_info',
                data: {
                    "id": id
                },
                dataType: 'json',
                type: 'POST'
            })
            .done(function(resp) {
                $("#regno").val(resp.NMRA_regno);
                $("#manuname").val(resp.manufacture_name);
                $("#manucountry").val(resp.manufacture_country);
            })
    });

    $('#submit').click(function(e) {

        e.preventDefault()
        let myForm = document.getElementById('supplierQ_res_form');
        let formData = new FormData(myForm);
        $("#submit").prop("disabled", true);

        $.ajax({
                url: 'model/ajax.php?action=save_generic_response',
                data: formData,
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                type: 'POST',
            })
            .done(function(resp) {
                if (resp.code == 200) {
                    alert_toast("Data successfully submitted", 'success');
                    $('#supplierQ_res_form').get(0).reset();
                    setTimeout(function() {
                        location.reload()
                    }, 1500)

                } else {
                    $("#submit").prop("disabled", false);
                    $(".display-error").html("<ul>" + resp.msg + "</ul>");
                    $(".display-error").css("display", "block");
                }
            })

    })

    $(".quote_req").click(function(e) {
        $(".display-error").hide();
    });

    $('.quote_req').click(function() {
        start_load()
        var cat = $('#supplierQ_res_form')
        cat.get(0).reset()
        cat.find("[name='gen_req_id']").val($(this).attr('data-gen-req-id'))
        end_load();
        $("#product").html("");
        load_product();
    })

    function load_product() {
        var gen_req_id = $("#gen_req_id").val();

        $.ajax({
                url: 'model/ajax.php?action=load_product_by_gen_id',
                data: {
                    "gen_req_id": gen_req_id
                },
                dataType: 'json',
                type: 'POST'
            })
            .done(function(resp) {
                $("#product").html("");

                var option = '<option value="" disabled selected>Select Product..</option>';
                for (var i = 0; i < resp.length; i++) {
                    option += '<option value="' + resp[i]["product_id"] + '">' + resp[i]["name"] + ' </option>';
                }
                $("#product").append(option);

            })

    }

    function reject(id) {

        $.ajax({
                url: 'model/ajax.php?action=reject_generic_request',
                data: {
                    "id": id
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
</script>

</html>
