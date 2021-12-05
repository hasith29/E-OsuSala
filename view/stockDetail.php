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

                            <a href="#" class="btn btn-primary btn-user btn-block" data-toggle="modal"
                                data-target="#addgenericmodal">
                                Add new generic
                            </a>
                        </div>

                    </div>
                    <br>
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h3 class="m-0 font-weight-bold text-primary">Stock Details</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Generic Product</th>
                                            <th>Current Stock Level</th>
                                            <th>Re-Order Stock Level</th>
                                            <th>Scrap Poduct</th>
                                            <th>Buffer Stock</th>
                                            <th>Active</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Generic Product</th>
                                            <th>Current Stock Level</th>
                                            <th>Re-Order Stock Level</th>
                                            <th>Scrap Poduct</th>
                                            <th>Buffer Stock</th>
                                            <th>Active</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php
                                        $i = 1;
                                        $generic = $conn->query("SELECT * FROM Generic order by generic_id asc");
                                        while ($row = $generic->fetch_assoc()) :
                                        ?>
                                        <tr>
                                            <td><?php echo $row["name"]; ?></td>
                                            <td><?php echo $row["current_stock_level"]; ?></td>
                                            <td><?php echo $row["reorder_stock_level"]; ?></td>
                                            <td> <a href="#" class="btn btn-primary btn-user btn-block scrap_btn"
                                                    data-toggle="modal" data-target="#scrapModal"
                                                    data-id="<?php echo $row['generic_id'] ?>">
                                                    Scrap
                                                </a></td>
                                            <td><?php echo $row["buffer_stock_level"]; ?></td>
                                            <td>
                                                <?php
                                                    if ($row["Active"] == 1) {
                                                        echo '<span class="badge badge-success text">Yes</span>';
                                                    } else {
                                                        echo '<span class="badge badge-danger text">No</span>';
                                                    }
                                                    ?>

                                            </td>
                                            <td><a href="" class="btn btn-primary btn-icon-split generic_edit"
                                                    data-toggle="modal" data-target="#addgenericmodal"
                                                    data-name="<?php echo $row['name'] ?>"
                                                    data-category_id="<?php echo $row['Category_category_id'] ?>"
                                                    data-id="<?php echo $row['generic_id'] ?>"
                                                    data-current_stock="<?php echo $row['current_stock_level'] ?>"
                                                    data-reorder_stock="<?php echo $row['reorder_stock_level'] ?>"
                                                    data-buffer_stock="<?php echo $row['buffer_stock_level'] ?>"
                                                    data-status="<?php echo $row['status'] ?>"
                                                    data-monthly-c="<?php echo $row['monthly_consumption'] ?>"
                                                    data-yera-c="<?php echo $row['total_req_per_year'] ?>"
                                                    data-lead-t="<?php echo $row['lead_time'] ?>"
                                                    data-total-s="<?php echo $row['total_space'] ?>"
                                                    data-active="<?php echo $row['Active'] ?>">
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
    <div class="modal fade" id="addgenericmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Generic Details</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger display-error" style="display: none">
                    </div>
                    <form class="user" action="" id="generic_form">
                        <div class="form-group row">
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <label for="status">Generic Name</label><br>
                                <input type="text" class="form-control form-control-user" id="name" name="name"
                                    placeholder="generic name">
                                <input type="hidden" class="form-control form-control-user" id="id" name="id"
                                    placeholder="id">
                            </div>
                            <div class="col-sm-6">
                                <label for="status">Category</label><br>
                                <select class="custom-select" id="category" name="category">

                                    <option value="" disabled selected>Select category..</option>
                                    <?php
                                    $category = $conn->query("SELECT * FROM Category order by category_id asc");
                                    while ($row = $category->fetch_assoc()) :
                                    ?>
                                    <option value="<?php echo $row["category_id"] ?>"><?php echo $row["name"]; ?></option>
                                    <?php endwhile; ?>
                                </select>

                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <label for="status">Current Stock</label><br>
                                <input type="text" class="form-control form-control-user" id="current_stock"
                                    name="current_stock" placeholder="current stock">
                            </div>
                            <div class="col-sm-6">
                                <label for="status">Reorder Stock</label><br>
                                <input type="text" class="form-control form-control-user" id="reorder_stock"
                                    name="reorder_stock" placeholder="reorder stock">
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <label for="status">Buffer Stock</label><br>
                                <input type="text" class="form-control form-control-user" id="buffer_stock"
                                    name="buffer_stock" placeholder="buffer stock">
                            </div>
                        
                            
                            <div class="col-sm-6 mb-3 mb-sm-0" id="active_div">
                            

                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <label for="status">Monthly consumption</label><br>
                                <input type="text" class="form-control form-control-user" id="monthly_consumption"
                                    name="monthly_consumption" placeholder="monthly consumption">
                            </div>
                            <div class="col-sm-6">
                                <label for="status">Yearly consumption</label><br>
                                <input type="text" class="form-control form-control-user" id="year_consumption"
                                    name="year_consumption" placeholder="year consumption">
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <label for="status">Lead Time(Months)</label><br>
                                <input type="text" class="form-control form-control-user" id="lead_time"
                                    name="lead_time" placeholder="leadtime">
                            </div>
                            <div class="col-sm-6">
                                <label for="status">Total Stock Capacity</label><br>
                                <input type="text" class="form-control form-control-user" id="total_space"
                                    name="total_space" placeholder="total space">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-6">
                                <!-- <label for="status">Status</label><br> -->
                                <input type="hidden" class="form-control form-control-user" id="status" name="status"
                                    placeholder="status">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" type="button" data-dismiss="modal"
                                onclick="$('#generic_form').get(0).reset()">Cancel</button>
                            <button type="button" class="btn btn-primary offset-md-3" id="submit"> Save</button>
                        </div>

                    </form>

                </div>

            </div>
        </div>
    </div>
    <!-- scrap Modal-->
    <div class="modal fade" id="scrapModal" tabindex="-1" role="dialog" aria-labelledby="scrapModal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="scrapModal">Enter Scrap quantity</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger display-error" style="display: none">
                    </div>
                    <form class="user" action="" id="scrap_form">
                        <div class="form-group row">
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <label for="status">Scrap quantity</label><br>
                                <input type="text" class="form-control form-control-user" id="scrap_qty"
                                    name="scrap_qty" placeholder="scrap quantity">
                                <input type="hidden" class="form-control form-control-user" id="gen_id_scrap"
                                    name="gen_id_scrap" placeholder="id">
                            </div>

                        </div>

                        <div class="modal-footer">
                            <button class="btn btn-secondary" type="button" data-dismiss="modal"
                                onclick="$('#scrap_form').get(0).reset()">Cancel</button>
                            <button type="button" class="btn btn-primary offset-md-3" id="submit_scrap"> Enter</button>
                        </div>

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

$('#submit_scrap').click(function(e) {
    e.preventDefault()
    let myForm = document.getElementById('scrap_form');
    let formData = new FormData(myForm);

    $.ajax({
            url: 'model/ajax.php?action=save_scrap',
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
                $('#scrapModal').modal('hide');
                alert_toast("Scrapped successfully", 'success');
                $('#scrap_form').get(0).reset();
                setTimeout(function() {
                    location.reload()
                }, 1500)

            } else {
                $(".display-error").html("<ul>" + resp.msg + "</ul>");
                $(".display-error").css("display", "block");
            }
        })

})

$('.scrap_btn').click(function() {

    $("#active_div").html('');
    start_load()
    $('#scrapModal').modal('show');
    $('.display-error').hide();

    var cat = $('#scrap_form')

    $("#gen_id_scrap").val($(this).attr('data-id')).select();
    end_load()
})

$('#addgenericmodal').on('show.bs.modal', function() {
    $("#active_div").html('');
    $('#generic_form').get(0).reset();
})

$('.generic_edit').click(function() {

    $("#active_div").html('');
    start_load()
    $('#addgenericmodal').modal('show');
    $('.display-error').hide();
    $("#active_div").append(
        '<label for="status">Active</label><br>'
    );
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
</script>

</html>
