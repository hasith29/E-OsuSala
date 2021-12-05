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
                                data-target="#companydata">
                                Add Company
                            </a>
                        </div>

                    </div>
                    <br>
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h3 class="m-0 font-weight-bold text-primary">Companies</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>View</th>
                                            <th>CompanyName</th>
                                            <th>Address</th>
                                            <th>Contact</th>
                                            <th>Email</th>
                                            <th>Reg.NO</th>
                                            <th>Edit</th>

                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                        <th>View</th>
                                            <th>CompanyName</th>
                                            <th>Address</th>
                                            <th>Contact</th>
                                            <th>Email</th>
                                            <th>Reg.NO</th>
                                            <th>Edit</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php
                                        $supplier_id = $_SESSION["SUID"];
                                        $i = 1;
                                        $company = $conn->query("SELECT * FROM SupplierCompany
                                         WHERE Supplier_supplier_id = $supplier_id  order by create_date asc");
                                        while($row=$company->fetch_assoc()):
								        ?>
                                        <tr>
                                            <td> <a href="" class="btn btn-primary btn-icon-split company_view"
                                                    data-toggle="modal" data-target="#" id="">
                                                    <span class="icon text-white-50">
                                                        <i class="fas fa-edit"></i>
                                                    </span>
                                                    <span class="text">View</span>
                                                </a></td>
                                            <td><?php echo $row["name"];?></td>
                                            <td><?php echo $row["address"];?></td>
                                            <td><?php echo $row["contactNo"];?></td>
                                            <td><?php echo $row["email"];?></td>
                                            <td><?php echo $row["regnNo"];?></td>
                                            <td> <a href="" class="btn btn-primary btn-icon-split company_edit"
                                                    data-toggle="modal" data-target="#companydata" id="company_btn"
                                                    data-com-id="<?php echo $row["company_id"]; ?>"
                                                    data-name="<?php echo $row["name"]; ?>"
                                                    data-address="<?php echo $row["address"]; ?>"
                                                    data-contact="<?php echo $row["contactNo"]; ?>"
                                                    data-email="<?php echo $row["email"]; ?>"
                                                    data-reg="<?php echo $row["regnNo"]; ?>"
                                                    data-city="<?php echo $row["city"]; ?>"
                                                    data-year_estab="<?php echo $row["year_established"]; ?>"
                                                    data-active="<?php echo $row["Active"]; ?>"
                                                    >
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
    <div class="modal fade" id="companydata" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Company Details</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger display-error" style="display: none">
                    </div>
                    <form class="user" action="" id="company_form">

                        <div class="form-group row">
                            <div class="col-sm-6 mb-3 mb-sm-0">
                            <label for="status">Company Name</label><br>
                                <input type="text" class="form-control form-control-user" id="name" name="name"
                                    placeholder="CompanyName">
                                    <input type="hidden" class="form-control form-control-user" id="id" name="id"
                                    placeholder="id">
                            </div>
                            <div class="col-sm-6">
                            <label for="status">Address</label><br>
                                <input type="text" class="form-control form-control-user" id="address" name="address"
                                    placeholder="Address">
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-6 mb-3 mb-sm-0">
                            <label for="status">Office Contac tNo</label><br>
                                <input type="text" class="form-control form-control-user" id="contact" name="contact"
                                    placeholder="OfficeContactNo">
                            </div>
                            <div class="col-sm-6">
                            <label for="status">Email</label><br>
                                <input type="email" class="form-control form-control-user" id="email" name="email"
                                    placeholder="Email">
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-6 mb-3 mb-sm-0">
                            <label for="status">Company Re gNo</label><br>
                                <input type="text" class="form-control form-control-user" id="reg_no" name="reg_no"
                                    placeholder="CompanyRegNo">
                            </div>
                            <div class="col-sm-6">
                            <label for="status">City</label><br>
                                <input type="text" class="form-control form-control-user" id="city" name="city"
                                    placeholder="City">
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-6 mb-3 mb-sm-0">
                            <label for="status">Year Established</label><br>
                                <input type="text" class="form-control form-control-user" id="year_estab"
                                    name="year_estab" placeholder="YearEstablished">
                            </div>

                        </div>

                        <div class="form-group row">
                            <div class="col-sm-6 mb-3 mb-sm-0" id="active_div">

                            </div>
                        </div>

                        <div class="modal-footer">
                            <button class="btn btn-secondary" type="button" data-dismiss="modal"
                                onclick="$('#company_form').get(0).reset()">Cancel</button>
                            <button type="button" class="btn btn-primary offset-md-3" id="submit"> Save</button>
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
    let myForm = document.getElementById('company_form');
    let formData = new FormData(myForm);

    $.ajax({
            url: 'model/ajax.php?action=save_company',
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
                $('#companydata').modal('hide');
                alert_toast("Data successfully submitted", 'success');
                $('#company_form').get(0).reset();
                setTimeout(function() {
                    location.reload()
                }, 1500)

            } else {
                $(".display-error").html("<ul>" + resp.msg + "</ul>");
                $(".display-error").css("display", "block");
            }
        })

})

$('.company_edit').click(function() {

    $("#active_div").html('');
    start_load()
    $('#companydata').modal('show');
    $('.display-error').hide();
    $("#active_div").append(
        '<select class="custom-select" id="active" name="active"> <option value="1" selected="selected">Yes</option><option value="0">No</option> </select>'
    );

    var cat = $('#company_form')
    cat.get(0).reset()
    cat.find("[name='id']").val($(this).attr('data-com-id'))
    cat.find("[name='name']").val($(this).attr('data-name'))
    cat.find("[name='address']").val($(this).attr('data-address'))
    cat.find("[name='contact']").val($(this).attr('data-contact'))
    cat.find("[name='email']").val($(this).attr('data-email'))
    cat.find("[name='reg_no']").val($(this).attr('data-reg'))
    cat.find("[name='city']").val($(this).attr('data-city'))
    cat.find("[name='year_estab']").val($(this).attr('data-year_estab'))
    $("#active").val($(this).attr('data-active')).change();
    end_load()
})

$('#companydata').on('show.bs.modal', function() {
    $("#active_div").html('');
    $('#company_form').get(0).reset();
})
</script>

</html>
