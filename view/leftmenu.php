    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-dark sidebar sidebar-dark accordion" id="accordionSidebar">

        <!-- Sidebar - Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
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
        <li class="nav-item <?php if($page == "stockDetail") echo 'active' ?>">
            <a class="nav-link" href="index.php?page=stockDetail">

                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Stock Details</span></a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider">
        <!-- Nav Item - Charts -->
        <li class="nav-item <?php if($page == "stockLevel") echo 'active' ?> ">
            <a class="nav-link" href="index.php?page=stockLevel">
                <i class="fas fa-fw fa-chart-area"></i>
                <span>Stock Levels</span></a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider">
        <!-- Nav Item - Tables -->
        <li class="nav-item <?php if($page == "receivedQuotation") echo 'active' ?>">
            <a class="nav-link" href="index.php?page=receivedQuotation">
                <i class="fas fa-fw fa-table"></i>
                <span>Received Quotations</span></a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider">
        <li class="nav-item <?php if($page == "qualityAssured") echo 'active' ?>">
            <a class="nav-link" href="index.php?page=qualityAssured">
                <i class="fas fa-fw fa-table"></i>
                <span>Quality Assured Quotations</span></a>
        </li>

        <!-- <li class="nav-item">
            <a class="nav-link" href="index.php?page=receivedQuotation&type=price">
                <i class="fas fa-fw fa-table"></i>
                <span>Price Evaluation</span></a>
        </li> -->

        <hr class="sidebar-divider">
        <li class="nav-item <?php if($page == "priceEvaluated") echo 'active' ?>">
            <a class="nav-link" href="index.php?page=priceEvaluated">
                <i class="fas fa-fw fa-table"></i>
                <span>Price Evaluated Products</span></a>
        </li>

        <hr class="sidebar-divider">
        <li class="nav-item <?php if($page == "pendingDeliveries") echo 'active' ?>">
            <a class="nav-link" href="index.php?page=pendingDeliveries">
                <i class="fas fa-fw fa-table"></i>
                <span>Pending Deliveries</span></a>
        </li>

        <hr class="sidebar-divider">
        <li class="nav-item <?php if($page == "invoiceDeliveries") echo 'active' ?>">
            <a class="nav-link" href="index.php?page=invoiceDeliveries">
                <i class="fas fa-fw fa-table"></i>
                <span>Invoiced Deliveries</span></a>
        </li>

        <hr class="sidebar-divider">
        <li class="nav-item <?php if($page == "customerDeliveries") echo 'active' ?>">
            <a class="nav-link" href="index.php?page=customerDeliveries">
                <i class="fas fa-fw fa-table"></i>
                <span>Customer Deliverables</span></a>
        </li>

        <hr class="sidebar-divider">
        <li class="nav-item">
            <a class="nav-link" href="view/report.php">
                <i class="fas fa-fw fa-table"></i>
                <span>Transation-Overview</span></a>
        </li>




    </ul>
    <!-- End of Sidebar -->
