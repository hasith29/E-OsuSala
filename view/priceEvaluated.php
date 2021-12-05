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

                        <div class="col-4">
                           Generic  <select class="custom-select" id="generic_search" name="generic_search">
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
                        <div class="col-1"></div>
                        <div class="col-3">
                            <div class="form-group row">
                              Required    <input type="text" class="form-control form-control-user" id="required" name="required"
                                    placeholder="required">
                            </div>
                        </div>

                        <div class="col-3">
                            <div class="form-group row">
                               Fullfilled <input type="text" class="form-control form-control-user" id="fullfilled"
                                    name="fullfilled" placeholder="fullfilled">
                            </div>
                        </div>


                    </div>
                    <br>

                    <!-- Tables  -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h3 class="m-0 font-weight-bold text-primary">Price Evaluated Quotations</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="priceEvoTbl" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Supplier</th>
                                            <th>Generic</th>
                                            <th>Product Band</th>
                                            <th>Price eval status</th>
                                            <th>status of quality</th>
                                            <th>Award to supplier</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Supplier</th>
                                            <th>Generic</th>
                                            <th>Product Band</th>
                                            <th>Price eval status</th>
                                            <th>status of quality</th>
                                            <th>Award to supplier</th>
                                            <th>Status</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php
                                        $i = 1;
                                        $rQ = $conn->query("SELECT Supplier.email,Supplier.supplier_id,Supplier.firstname,Supplier.lastname,Product . * , Generic.name AS generic,
                                        GenericResponse.`price_evaluate_status`, GenericResponse.`quality_evaluate_status`,GenericResponse.price,
                                        GenericResponse.award_acceptance,Generic.generic_id,GenericRequest.generic_request_id,
                                        GenericResponse.quantity,GenericResponse.price,GenericResponse.generic_response_id,GenericResponse.deliverydate
                                        FROM GenericResponse
                                        INNER JOIN Product ON Product.product_id = GenericResponse.Product_product_id
                                        INNER JOIN Generic ON Generic.generic_id = Product.Generic_generic_id
                                        INNER JOIN Supplier ON Supplier.supplier_id = GenericResponse.GenericRequestSupplier_id
                                        INNER JOIN GenericRequest ON GenericRequest.generic_request_id = GenericResponse.GenericRequest_generic_request_id
                                        WHERE GenericResponse.`quality_evaluate_status` = 1 AND GenericResponse.pri_stat =
                                         1 ORDER BY GenericResponse.price_evaluate_status");

                                        if($rQ){
                                        while($row=$rQ->fetch_assoc()):

                                            $gen_res_id = $row["generic_response_id"];
                                            $generic_res_sql = $conn->query("SELECT * FROM Awarded WHERE GenericResponse_generic_response_id = $gen_res_id ");
                                            $num_row = mysqli_num_rows($generic_res_sql);
                                            ?>

                                            <tr>
                                            <td><?php echo $row["firstname"]." ".$row["lastname"] ?> </td>
                                            <td><?php echo $row["generic"] ?> </td>
                                            <td><?php echo $row["name"] ?> </td>
                                            <td> <?php
                                            if( $row["price_evaluate_status"] == 0) {
                                                echo '<span class="badge badge-info text">Pending</span>';
                                            }else if($row["price_evaluate_status"] == 1) {
                                                echo '<span class="badge badge-success text">Accepted</span>';
                                            }else{
                                                echo '<span class="badge badge-danger text">Rejected</span>';
                                            }
                                            ?> </td>
                                            <td><?php
                                            if( $row["quality_evaluate_status"] == 0) {
                                                echo '<span class="badge badge-info text">Pending</span>';
                                            }else if($row["quality_evaluate_status"] == 1) {
                                                echo '<span class="badge badge-success text">Accepted</span>';
                                            }else{
                                                echo '<span class="badge badge-danger text">Rejected</span>';
                                            }
                                            ?> </td>
                                            <td>
                                            <?php if($num_row == 0){ ?>
                                            <a href="" class="btn btn-primary btn-icon-split send_quote_stat"
                                                    data-toggle="modal" data-target="#awardmail"
                                                    data-supp-nam="<?php echo $row["firstname"]." ".$row["lastname"]; ?>"
                                                    data-supp-id="<?php echo $row["supplier_id"]; ?>"
                                                    data-supp-email="<?php echo $row["email"]; ?>"
                                                    data-gen-name="<?php echo $row["generic"]; ?>"
                                                    data-gen-id="<?php echo $row["generic_id"]; ?>"
                                                    data-prod-name="<?php echo $row["name"]; ?>"
                                                    data-prod-id="<?php echo $row["product_id"]; ?>"
                                                    data-quantity="<?php echo $row["quantity"]; ?>"
                                                    data-price="<?php echo $row["price"]; ?>"
                                                    data-gen-res-id="<?php echo $row["generic_response_id"]; ?>"
                                                    data-gen-req-id="<?php echo $row["generic_request_id"]; ?>"
                                                    data-del-date="<?php echo $row["deliverydate"]; ?>"
                                                    >
                                                    <span class="icon text-white-50">
                                                        <i class="fas fa-edit"></i>
                                                    </span>
                                                    <span class="text">Send mail</span>
                                                </a>
                                            <?php }
                                            else{
                                                echo '<span class="badge badge-info text">Sent</span>';
                                            }
                                            ?>
                                            </td>
                                            <td><?php
                                            if( $row["award_acceptance"] == "Pending") {
                                                echo '<span class="badge badge-info text">Pending</span>';
                                            }else if($row["award_acceptance"] == "Accepted") {
                                                echo '<span class="badge badge-success text">Accepted</span>';
                                            }else{
                                                echo '<span class="badge badge-danger text">Rejected</span>';
                                            }
                                            ?> </td>

                                        </tr>
                                        <?php endwhile; } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row ">
                        <div class="col-8"></div>
                        <div class="col-4">

                            <!-- <a href="#" class="btn btn-primary btn-user btn-block">
                                Run price evaluation
                            </a> -->
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
    <!-- mail Modal-->
    <div class="modal fade" id="awardmail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Award to Supplier</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger display-error" style="display: none">
                    </div>
                    <form class="user" action="" id="price_evo" method="POST">
                        <div class="form-group row">
                            <div class="col-sm-12 mb-3 mb-sm-0">
                            <label for="status">Supplier Name</label><br>
                                <input type="text" class="form-control form-control-user" id="supplier" name="supplier"
                                    placeholder="supplier">
                                    <input type="hidden" class="form-control form-control-user" id="supplier_id" name="supplier_id"
                                    placeholder="supplier">
                                    <input type="hidden" class="form-control form-control-user" id="gen_res_id" name="gen_res_id"
                                    placeholder="supplier">
                                    <input type="hidden" class="form-control form-control-user" id="product_id" name="product_id"
                                    placeholder="supplier">
                                    <input type="hidden" class="form-control form-control-user" id="gen_req_id" name="gen_req_id"
                                    placeholder="supplier">
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-12 mb-3 mb-sm-0">
                            <label for="status">Supplier Email</label><br>
                                <input type="text" class="form-control form-control-user" id="email" name="email"
                                    placeholder="email">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-12 mb-3 mb-sm-0">
                            <label for="status">Generic</label><br>
                                <input type="text" class="form-control form-control-user" id="generic" name="generic"
                                    placeholder="generic">
                                    <input type="hidden" class="form-control form-control-user" id="generic_id" name="generic_id"
                                    placeholder="generic">
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-12 mb-3 mb-sm-0">
                            <label for="status">Product</label><br>
                                <input type="text" class="form-control form-control-user" id="product" name="product"
                                    placeholder="product">
                            </div>
                        </div>


                        <div class="form-group row">
                            <div class="col-sm-12 mb-3 mb-sm-0">
                            <label for="status">Quantity</label><br>
                                <input type="text" class="form-control form-control-user" id="quantity" name="quantity"
                                    placeholder="quantity">
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-12 mb-3 mb-sm-0">
                            <label for="status">Price</label><br>
                                <input type="text" class="form-control form-control-user" id="price" name="price"
                                    placeholder="price">
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-12 mb-3 mb-sm-0">
                            <label for="status">Delivery Date</label><br>
                                <input type="text" class="form-control form-control-user" id="del_date" name="del_date"
                                    placeholder="del_date">
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button class="btn btn-secondary" type="button" data-dismiss="modal"
                                onclick="$('#generic_form').get(0).reset()">Cancel</button>
                            <button type="button" class="btn btn-primary offset-md-3" id="submit"> Send Mail</button>
                        </div>

                    </form>


                </div>

            </div>
        </div>
    </div>
</body>



</html>

<script>

$('.send_quote_stat').click(function() {
    $(".display-error").hide();
    start_load()
    var cat = $('#price_evo')
    cat.get(0).reset()
    cat.find("[name='supplier']").val($(this).attr('data-supp-nam'))
    cat.find("[name='supplier_id']").val($(this).attr('data-supp-id'))
    cat.find("[name='email']").val($(this).attr('data-supp-email'))
    cat.find("[name='generic_id']").val($(this).attr('data-gen-id'))
    cat.find("[name='generic']").val($(this).attr('data-gen-name'))
    cat.find("[name='product']").val($(this).attr('data-prod-name'))
    cat.find("[name='product_id']").val($(this).attr('data-prod-id'))
    cat.find("[name='quantity']").val($(this).attr('data-quantity'))
    cat.find("[name='price']").val($(this).attr('data-price'))
    cat.find("[name='gen_res_id']").val($(this).attr('data-gen-res-id'))
    cat.find("[name='gen_req_id']").val($(this).attr('data-gen-req-id'))
    cat.find("[name='del_date']").val($(this).attr('data-del-date'))

    end_load()
})

$('#submit').click(function(e) {
    e.preventDefault()
    let myForm = document.getElementById('price_evo');
    let formData = new FormData(myForm);
    $("#submit").prop("disabled",true);

    $.ajax({
            url: 'model/ajax.php?action=send_mail_to_supplier_award',
            data: formData,
            dataType: 'json',
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            type: 'POST'
        })
        .done(function(resp) {
            if (resp.code == 200) {
                $('#awardmail').modal('hide');
                alert_toast("Email successfully sent", 'success');

                var fullfiled_text = $("#fullfilled").val();
                var qty = $("#quantity").val();
                var ffval = parseInt(fullfiled_text)+parseInt(qty);
                fullfiled_text = $("#fullfilled").val(ffval);
                $('#price_evo').get(0).reset();
                setTimeout(function() {
                    location.reload()
                }, 1500)

            } else {
                $("#submit").prop("disabled",false);
                $(".display-error").html("<ul>" + resp.msg + "</ul>");
                $(".display-error").css("display", "block");
            }
        })

})

$("#generic_search").change(function() {
    var id = $(this).val();
    $("#required").val();
    $("#fullfilled").val();

    $.ajax({
            url: 'model/ajax.php?action=load_generic_request_info',
            data: {
                "id": id
            },
            dataType: 'json',
            type: 'POST'
        })
        .done(function(resp) {
            if(resp){
            quantity = $.trim(resp.quantity);
            quote_value = $.trim(resp.quote_value)
            $("#required").val(quantity);
            $("#fullfilled").val(quote_value);
            }else{
                alert()
                $("#required").val();
                 $("#fullfilled").val();
            }

        })
});

$(document).ready(function() {
    $('#priceEvoTbl').DataTable( {
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
