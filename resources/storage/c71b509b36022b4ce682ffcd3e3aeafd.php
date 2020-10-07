
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Dashboard</title>
        <link href="<?php echo asset('adminpage/css/styles.css'); ?>" rel="stylesheet"/>
        <link href="<?php echo asset('adminpage/css/pricing.css'); ?>" rel="stylesheet"/>
        <!-- <link href="<?php echo asset('adminpage/css/styles3.css'); ?>" rel="stylesheet"/> -->
        <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
        <link href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css2?family=Raleway:ital,wght@1,300&display=swap" rel="stylesheet"> 
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <a class="navbar-brand" href="<?php echo route('home'); ?>">Exams Portal</a><button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
            ><!-- Navbar Search-->
            <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
                <div class="input-group">
                    <input class="form-control" type="text" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2" />
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="button"><i class="fas fa-search"></i></button>
                    </div>
                </div>
            </form>
            <!-- Navbar-->
            <ul class="navbar-nav ml-auto ml-md-0 ">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                        <a class="dropdown-item" href="#">Settings</a><a class="dropdown-item" href="#">Activity Log</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="<?php echo route('logout'); ?>">Logout</a>
                    </div>
                </li>
            </ul>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading">Core</div>
                            <a class="nav-link" href="<?php echo route('home'); ?>"
                                ><div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Dashboard</a
                            >
                            <a class="nav-link" href="<?php echo route('profile'); ?>"
                                ><div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Profile</a
                            >

                            <div class="row">
                                <div class="col-8">
                                    <div class="sb-sidenav-menu-heading">Courses</div>
                                </div>
                                <div class="col-4">
                                    <div class="sb-sidenav-menu-heading"><div class="sb-nav-link-icon"><a href="<?php echo route('add_course'); ?>"><i class="fas fa-plus-circle"></i></a></div></div>  
                                </div>
                            </div>
                            <?php foreach($courses as $course): ?>
                                
                                <a class="nav-link" href="<?php echo route('exams_page', ['id'=>$course['course_id']]); ?>"
                                ><div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                                <?php echo ucfirst($course['name']); ?></a
                                >
                            
                            <?php endforeach ?>
                            <div class="sb-sidenav-menu-heading">Addons</div>
                            <a class="nav-link" href="charts.html"
                                ><div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                                Charts</a
                            ><a class="nav-link" href="tables.html"
                                ><div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                                Tables</a
                            >
                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                        <div class="small">Logged in as:</div>
                        <?php echo $email; ?>
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid bg">
                        <h1 class="mt-4">Payment</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Pay Me</li>
                        </ol><hr>
                        <div class=" <?php echo (isset($_SESSION['package_status']))? 'alert alert-info title' : ''; ?>"><?php echo (isset($_SESSION['package_status']))? $_SESSION['package_status'] : ''; ?></div>
                        
                        <div class="demo">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-4 col-sm-6">
                                        <div class="pricingTable">
                                            <div class="pricingTable-header">
                                                <h3 class="title">Free</h3>
                                            </div>
                                            <div class="price-value">
                                                <span class="amount">NGN 0</span>
                                                <span class="duration">/year</span>
                                            </div>
                                            <ul class="content-list">
                                                <li class="active">10 questions per exam</li><br>
                                                <li class="active">1 teacher per course</li><br>
                                                <li class="active">1 exam per course </li>
                                                <li>Live Support</li>
                                                <li>Student Allocation</li>
                                                <li>Tension Easing</li>
                                            </ul>
                                            <div class="pricingTable-signup">
                                                <a href="#">Go premium</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-6">
                                        <div class="pricingTable green">
                                            <div class="pricingTable-header">
                                                <h3 class="title">Business</h3>
                                            </div>
                                            <div class="price-value">
                                                <span class="amount">NGN 75000</span>
                                                <span class="duration">/year</span>
                                            </div>
                                            <ul class="content-list">
                                                <li class="active">40 questions per exam</li><br>
                                                <li class="active">3 teachers per course</li><br>
                                                <li class="active">10 Exams per course</li>
                                                <li class="active">Live Support</li>
                                                <li class="active">Student Allocation</li>
                                                <li>Tension Easing</li>
                                            </ul>
                                            <div class="pricingTable-signup">
                                                <a href="<?php echo route('pay', ['price'=>7500000]); ?>">go premium</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-6">
                                        <div class="pricingTable yellow">
                                            <div class="pricingTable-header">
                                                <h3 class="title">Premium</h3>
                                            </div>
                                            <div class="price-value">
                                                <span class="amount">NGN 125000</span>
                                                <span class="duration">/year</span>
                                            </div>
                                            <ul class="content-list">
                                                <li class="active">Unlimited questions per exam</li>
                                                <li class="active">Unlimited teachers per course</li>
                                                <li class="active">Unlimited Exams </li>
                                                <li class="active">Live Support</li>
                                                <li class="active">Student Allocation</li>
                                                <li class="active">Tension Easing</li>
                                            </ul>
                                            <div class="pricingTable-signup">
                                                <a href="<?php echo route('pay', ['price'=>12500000]); ?>">go premium</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; CBT Examination 2020</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="<?php echo asset('adminpage/js/scripts.js'); ?>"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="<?php echo asset('adminpage/assets/demo/chart-area-demo.js'); ?>"></script>
        <script src="<?php echo asset('adminpage/assets/demo/chart-bar-demo.js'); ?>"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
        <script src="<?php echo asset('adminpage/assets/demo/datatables-demo.js'); ?>"></script>
    </body>
</html>
