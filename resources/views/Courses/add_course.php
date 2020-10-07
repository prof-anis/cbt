<!DOCTYPE html>
<html>
	<head>
    <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Courses - Add</title>
        <link href="{{asset('adminpage/css/styles.css')}}" rel="stylesheet"/>
        <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous"></script>
        <link href="{{asset('adminpage/css/style.css')}}" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
	</head>
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <a class="navbar-brand" href="{{route('home')}}">Exam Portal</a><button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button
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
            <ul class="navbar-nav ml-auto ml-md-0">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                        <a class="dropdown-item" href="#">Settings</a><a class="dropdown-item" href="#">Activity Log</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{route('logout')}}">Logout</a>
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
                            <a class="nav-link" href="{{route('home')}}"
                                ><div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Dashboard</a
                            >
                            <a class="nav-link" href="{{route('profile')}}"
                                ><div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Profile</a
                            >
                            <div class="row">
                                <div class="col-8">
                                    <div class="sb-sidenav-menu-heading">Courses</div>
                                </div>
                                <div class="col-4">
                                    <div class="sb-sidenav-menu-heading"><div class="sb-nav-link-icon"><a href="{{route('add_course')}}"><i class="fas fa-plus-circle"></i></a></div></div>  
                                </div>
                            </div>

                            <?php foreach($courses as $course): ?>
                                
                                <a class="nav-link" href="{{route('exams_page', ['id'=>$course['course_id']])}}"
                                ><div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                                {{ucfirst($course['name'])}}</a
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
                        {{$_SESSION['name']}}
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
            <main class="loggedin">
                <div class="container-fluid">
                            <h1 class="mt-4">Add Course</h1>
                            <ol class="breadcrumb mb-4">
                                <li class="breadcrumb-item ">Courses</li>
                                <li class="breadcrumb-item active">Add</li>
                            </ol>
                            

                    <div class="content">
                        <div>
                            <p>Please input the course name in the field below</p>
                            <form method="POST">
                                <table>
                                <tr>
                                    <div class="alert alert-{{isset($_SESSION['error'])? 'danger' : 'light'}}" role="alert">
                                        <small id="emailHelp" class="form-text text-muted">{{$message}}</small>
                                    </div>
                                </tr>
                                <tr>
                                        <td>
                                            Course Name
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" name="course_name" id="" value="{{isset($_POST['course_name'])? $_POST['course_name'] : ''}}">
                                        </td>
                                    </tr>
                                    
                                </table>
                                <ul class="nav nav-pills justify-content-end">
    
                                    <li class="nav-item">
                                    <input type="submit" class="nav-link active" value="Add" name="add_course">
                                    </li>
                                    
                                </ul>
                            </form>
                        </div>
                    </div>

                </div>
            </main>



















                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; CBT Technologies 2020</div>
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
        <script src="{{asset('adminpage/js/scripts.js')}}"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
        <script src="{{asset('adminpage/assets/demo/datatables-demo.js')}}"></script>
    </body>
</html>














