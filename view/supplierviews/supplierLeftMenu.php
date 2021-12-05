    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-secondary sidebar sidebar-dark accordion" id="accordionSidebar">

        <!-- Sidebar - Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="supplierHome.php">
            <div class="sidebar-brand-text mx-3"><img width="100" height="70" src="img/logo.jpeg" alt="MISSING JPG"/></div>
        </a>

        <!-- Divider -->
        <hr class="sidebar-divider my-0">
        <?php

        if(isset($_GET["page"]) &&  !empty($_GET["page"])){
          $page = $_GET["page"];
        }else{
          $page = '';
        }

         ?>
        <!-- Nav Item - Dashboard -->
        <li class="nav-item <?php if($page == "company") echo 'active' ?>">
            <a class="nav-link" href="supplierHome.php?page=company">

                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Company</span></a>
        </li>
        <!-- Divider -->
        <hr class="sidebar-divider">
        <!-- Nav Item - Dashboard -->
        <li class="nav-item  <?php if($page == "product") echo 'active' ?>">
            <a class="nav-link" href="supplierHome.php?page=product">

                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Products</span></a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider">
        <!-- Nav Item - Dashboard -->
        <li class="nav-item <?php if($page == "supplierRequest") echo 'active' ?>">
            <a class="nav-link" href="supplierHome.php?page=supplierRequest">

                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Requests for Quotes</span></a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Nav Item - Dashboard -->
        <li class="nav-item <?php if($page == "awardedRequest") echo 'active' ?>">
            <a class="nav-link" href="supplierHome.php?page=awardedRequest">

                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Received Awards</span></a>
        </li>

    </ul>
    <!-- End of Sidebar -->
