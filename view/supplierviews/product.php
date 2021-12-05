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

                            <a href="supplierHome.php?page=add_product" class="btn btn-primary btn-user btn-block">
                                Add Product
                            </a>
                        </div>

                    </div>
                    <br>
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h3 class="m-0 font-weight-bold text-primary">Products</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>View</th>
                                            <th>Generic</th>
                                            <th>Name</th>
                                            <th>NMRA Reg.NO</th>
                                            <th>Price</th>
                                            <th>Edit</th>

                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                        <th>View</th>
                                            <th>Generic</th>
                                            <th>Name</th>
                                            <th>NMRA Reg.NO</th>
                                            <th>Price</th>
                                            <th>Edit</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php
                                        $supplier_id = $_SESSION["SUID"];
                                        $i = 1;
                                        $company = $conn->query("SELECT Generic.name as generic,Product.* FROM `Product`
                                        INNER JOIN Generic ON Generic.generic_id = Product.`Generic_generic_id`
                                        WHERE Product.Supplier_supplier_id = $supplier_id
                                        GROUP BY Product.`Generic_generic_id` order by Product.create_date asc");
                                        while($row=$company->fetch_assoc()):
								        ?>
                                        <tr>
                                            <td> <a href="supplierHome.php?page=edit_product&id=<?php echo $row["Generic_generic_id"] ?>&type=view" class="btn btn-primary btn-icon-split"
                                                     id="quote_btn">
                                                    <span class="icon text-white-50">
                                                        <i class="fas fa-edit"></i>
                                                    </span>
                                                    <span class="text">View</span>
                                                </a></td>
                                            <td><?php echo $row["generic"] ?></td>
                                            <td><?php echo $row["name"] ?></td>
                                            <td><?php echo $row["NMRA_regno"] ?></td>
                                            <td><?php echo $row["price"] ?></td>
                                            <td> <a href="supplierHome.php?page=edit_product&id=<?php echo $row["Generic_generic_id"] ?>" class="btn btn-primary btn-icon-split generic_edit"
                                                     id="quote_btn">
                                                    <span class="icon text-white-50">
                                                        <i class="fas fa-edit"></i>
                                                    </span>
                                                    <span class="text">Edit</span>
                                                </a></td>
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

    <!-- generic Modal-->
    <div class="modal fade bd-example-modal-xl" id="companydata" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Product Details</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger display-error" style="display: none">
                    </div>
                    <form class="user" action="" id="generic_form">
                        <select class="custom-select" multiple id="category" name="category">
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                            <option value="4">Four</option>
                            <option value="5">Five</option>
                        </select>
                    </form>

                </div>

            </div>
        </div>
    </div>

</body>

<script>
$('#submit').click(function(e) {
    e.preventDefault()
    let myForm = document.getElementById('generic_form');
    let formData = new FormData(myForm);

    $.ajax({
            url: 'model/ajax.php?action=save_generic',
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
                $('#addgenericmodal').modal('hide');
                alert_toast("Data successfully submitted", 'success');
                $('#generic_form').get(0).reset();
                setTimeout(function() {
                    location.reload()
                }, 1500)

            } else {
                $(".display-error").html("<ul>" + resp.msg + "</ul>");
                $(".display-error").css("display", "block");
            }
        })

})

$('.generic_edit').click(function() {

    $("#active_div").html('');
    start_load()
    $('#addgenericmodal').modal('show');
    $('.display-error').hide();
    $("#active_div").append(
        '<select class="custom-select" id="active" name="active"> <option value="1">Yes</option><option value="0">No</option> </select>'
    );

    var cat = $('#generic_form')
    cat.get(0).reset()
    cat.find("[name='id']").val($(this).attr('data-id'))
    cat.find("[name='name']").val($(this).attr('data-name'))
    cat.find("[name='current_stock']").val($(this).attr('data-current_stock'))
    cat.find("[name='reorder_stock']").val($(this).attr('data-reorder_stock'))
    cat.find("[name='buffer_stock']").val($(this).attr('data-buffer_stock'))
    cat.find("[name='status']").val($(this).attr('data-status'))
    cat.find("[name='monthly_consumption']").val($(this).attr('data-monthly-c'))
    cat.find("[name='year_consumption']").val($(this).attr('data-yera-c'))
    cat.find("[name='lead_time']").val($(this).attr('data-lead-t'))
    cat.find("[name='total_space']").val($(this).attr('data-total-s'))
    $("#active").val($(this).attr('data-active')).change();
    $("#category").val($(this).attr('data-category_id')).select();
    end_load()
})

$('#addgenericmodal').on('show.bs.modal', function() {
    $("#active_div").html('');
    $('#generic_form').get(0).reset();
})
</script>

</html>
