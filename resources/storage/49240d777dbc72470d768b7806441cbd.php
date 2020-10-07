
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Dashboard - Student</title>
        <link href="<?php echo asset('adminpage/css/styles.css'); ?>" rel="stylesheet"/>
        <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script>
         
         $(function() {
            submit_btn = document.querySelector('#exam_code_submit');
            submit_btn.disabled = true;

            $("#exam_code_field").keyup(function() {
            // validate and process form here
            result = document.querySelector('#result');
            exam_code_field = document.getElementById('exam_code_field').value;

            if (exam_code_field.length == 0) {
                result.innerText = '';
                submit_btn.disabled = true;
            }else if(exam_code_field.length <= 5){
                submit_btn.disabled = true;
                result.innerText = '';
            }else if(exam_code_field.length >= 6){
                // All are filled out
                exam_code = exam_code_field;
                result.innerText = 'Please Wait ...'
                $.post("<?php echo route('get_exam_details', ['exam_code'=>'"+""+exam_code+""+"']); ?>", function(data){
                    // Display the returned data in browser
                    $("#result").html(data);
                        submit_btn.disabled = false;

                });
    
            }
            });

            // $("#exam_code_submit").click(function() {
                // event.preventDefault();
                // submit_btn = document.querySelector('#exam_code_submit');
                // exam_code_field = document.getElementById('exam_code_field').value;
                // exam_code = exam_code_field;
                // result.innerText = 'Please Wait ...';
                // formValues = $("exam_field").serialize();
                // $.post("<?php echo route('get_exam_details', ['exam_code'=>'"+""+exam_code+""+"']); ?>", function(data){
                    // Display the returned data in browser
                    // $("#result").html(data);

                // });

            // });
        });

        </script>
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <a class="navbar-brand" href="<?php echo route('student_home'); ?>">Student Portal</a><button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button
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
                            <a class="nav-link" href="<?php echo route('student_home'); ?>"
                                ><div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Dashboard</a
                            >
                            <a class="nav-link" href="<?php echo route('student_profile'); ?>"
                                ><div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Profile</a
                            >

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
            <div id="layoutSidenav_content"  class="bg-secondary">
                <main>
                    <div class="container">
                        <br />
                        <br />
                        <br />
                        <br />
                        <br />
                        <br />

                        <div class="row">
                            <div class="col-md-3"></div>
                            <div class="col-md-6">
                            <div id="result"></div>
                                <form id="exam_field" method="POST" action="<?php echo route('take_exam'); ?>">
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" placeholder="Type the exam code to take an exam" name="exam_code_field" id="exam_code_field">
                                        <div class="input-group-append">
                                            <input class="btn btn-primary" type="submit" value="Take Exam" name="exam_code_submit" id="exam_code_submit">
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-3"></div>
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
        <script src="<?php echo asset('adminpage/js/scripts.js'); ?>"></script>
    </body>
</html>
