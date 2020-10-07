
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Dashboard - Student</title>
        <link href="{{asset('adminpage/css/styles.css')}}" rel="stylesheet"/>
        <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous"></script>
        <script defer src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <a class="navbar-brand" href="{{route('student_home')}}">Student Portal</a><button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button
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
                            <a class="nav-link" href="{{route('student_home')}}"
                                ><div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Dashboard</a
                            >
                            <a class="nav-link" href="{{route('student_profile')}}"
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
                        {{$email}}
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
            
                <main>
                <div class="container-fluid">
                            <h3 class="mt-4">{{$exam['name']}}</h3>
                            <ol class="breadcrumb mb-4">
                                <li class="breadcrumb-item active">Exam Code: {{$exam['exam_code']}}</li>
                                <li class="breadcrumb-item justify-content-end">
                                    <li id="date_and_time">0:0</li>
                                </li>
                            </ol>

                    <div class="content">
                        <form action="{{route('mark_exam')}}" method="POST" id="question_form">
                            <?php
                            $i=1;
                            ?>
                        <?php foreach($questions as $question): ?>
                            <div class="question" counter={{ $i }}>
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">
                                        <div class="alert alert-primary" role="alert">
                                            <h4><p>{{ucfirst($question['title'])}}?</p></h4>
                                        </div>
                                        </h5>
                                        <h6 class="card-subtitle mb-2 text-muted">Question {{$i}} of {{count($questions)}}</h6>
                                        <p class="card-text">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="{{$question['question_id']}}" id="{{$question['question_id']}}1" value="option_a" >
                                                <label class="form-check-label" for="{{$question['question_id']}}1">
                                                    {{ucfirst($question['option_a'])}}
                                                </label>
                                                </div><br>
                                                <div class="form-check">
                                                <input class="form-check-input" type="radio" name="{{$question['question_id']}}" id="{{$question['question_id']}}2" value="option_b">
                                                <label class="form-check-label" for="{{$question['question_id']}}2">
                                                    {{ucfirst($question['option_b'])}}
                                                </label>
                                                </div> <br>
                                                <div class="form-check">
                                                <input class="form-check-input" type="radio" name="{{$question['question_id']}}" id="{{$question['question_id']}}3" value="option_c">
                                                <label class="form-check-label" for="{{$question['question_id']}}3">
                                                    {{ucfirst($question['option_c'])}}
                                                </label>
                                                </div> <br>
                                                <div class="form-check">
                                                <input class="form-check-input" type="radio" name="{{$question['question_id']}}" id="{{$question['question_id']}}4" value="option_d">
                                                <label class="form-check-label" for="{{$question['question_id']}}4">
                                                    {{ucfirst($question['option_d'])}}
                                                </label>
                                            </div><br>
                                        </p>
                                    </div>
                                </div>
                                
                                
                                <?php $i++;  ?>
                            </div>
                        <?php endforeach ?>
                            <ul class="nav nav-pills justify-content-end">

                                <li class="nav-item">
                                <button type="button" class="nav-link active" id="prev_btn">Prev</button>
                                </li>

                                <li class="nav-item">
                                <button type="button" class="nav-link active" id="next_btn">Next</button>
                                </li>

                                <li class="nav-item">
                                <input type="submit" class="nav-link active" id="submit_btn" name="submit_btn" value="Submit">
                                </li>
                                
                            </ul>

                        </form>
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
        <script>
            $(document).ready(function(){
                $(".question").hide();
                $("#prev_btn").attr('disabled',true);
                $(".question:first").show();
                $("#prev_btn").click(function(e){
                    e.preventDefault();
                    let counter = $(".question:visible").attr('counter');
                    counter--;
                    if ((counter == NaN) || (counter == 0)) {
                        $("#prev_btn").attr('disabled',true);
                        counter = 1;
                    }
                    $(".question:visible").hide();
                    $("[counter~='"+counter+"']").show();
                })

                $("#next_btn").click(function(e){
                    e.preventDefault();
                    $("#prev_btn").attr('disabled',false);
                    let counter = $(".question:visible").attr('counter');
                    $(".question:visible").hide();
                    if ((counter == NaN) || (counter == $(".question").length)) {
                        $(".question:last").show();
                        return
                    }
                    counter++;
                    $("[counter~='"+counter+"']").show();
                })   

                let min  = "{{$exam['duration'] - 1}}";
                let sec = 60;
                setInterval(function(){
                    $("#date_and_time").html(min+":"+sec);
                    sec--;
                    if (sec == 0 && min != 0) {
                        sec = 60;
                        min--;
                    }
                    if (sec==0 && min ==0) {
                        $("#date_and_time").html("Time Up");
                        
                        
                        $("#question_form").submit();
                    }
                },1000);   

            })

            
        </script>
    </body>
</html>
