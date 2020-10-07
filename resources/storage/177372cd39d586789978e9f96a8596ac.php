<?php
    // $query = "SELECT quizzes.quiz_id, courses.name as course_name ,courses.course_id, quizzes.name as quiz_name\n"

    // . "FROM quizzes\n"

    // . "INNER JOIN courses ON quizzes.course_id=courses.course_id"
?>


<!DOCTYPE html>
<html>
	<head>
    <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Questions</title>
        <link href="<?php echo asset('adminpage/css/styles.css'); ?>" rel="stylesheet"/>
        <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <link href="<?php echo asset('adminpage/css/style.css'); ?>" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
        
    <script>
         $(function() {
            $(".button").click(function() {
            // validate and process form here
            event.preventDefault();
            submit_btn = document.querySelector('.button');
            form_error_field = document.querySelector('#form_error_field');
            form_success_field = document.querySelector('#form_success_field');
            question_title = document.getElementById('add_question_title').value;
            option_title_1 = document.getElementById('option_title_1').value;
            option_title_2 = document.getElementById('option_title_2').value;
            option_title_3 = document.getElementById('option_title_3').value;
            option_title_4 = document.getElementById('option_title_4').value;
            answer_option = document.getElementById('answer_option').value;
            // console.log(question_title+option_title_1+option_title_2+option_title_3+option_title_4+answer_option);
            if ((question_title === "") && (option_title_1 === "") && (option_title_2 === "") && (option_title_3 === "") && (option_title_4 === "") && (answer_option === "")) {
                // All are not filled out
                form_error_field.innerText = "Please, fill out the form";
            
            }else if(question_title === ""){
                form_error_field.innerText = "Please, fill out the question title field";
            }else if(option_title_1 === ""){
                form_error_field.innerText = "Please, fill out the Option1 field";
            }
            else if(option_title_2 === ""){
                form_error_field.innerText = "Please, fill out the Option2 field";
            }
            else if(option_title_3 === ""){
                form_error_field.innerText = "Please, fill out the Option3 field";
            }else if(option_title_4 === ""){
                form_error_field.innerText = "Please, fill out the Option4 field";
            }else if(answer_option === ""){
                form_error_field.innerText = "Please, Select an answer from the dropdown";
                
            }else{
                // All are filled out
                form_error_field.innerText = '';
                form_success_field.innerText = '';
                submit_btn.value = 'please wait...';
                formValues= $("#question_form").serialize();
                $.post("<?php echo route('add_question', ['id'=>$exam_id]); ?>", formValues, function(data){

                    // Display the returned data in browser

                    $("#form_success_field").html(data);
                    submit_btn.value = 'Add';

                });
    
            }
            });
        });
        
    
    </script>
	</head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <a class="navbar-brand" href="<?php echo route('home'); ?>">Exam Portal</a><button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button
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
                        <?php echo $_SESSION['name']; ?>
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
            <main class="loggedin">
                <div class="container-fluid">
                            <h2 class="mt-4">Exam Questions</h2>
                            <ol class="breadcrumb mb-4">
                                <li class="breadcrumb-item ">Questions</li>
                                <li class="breadcrumb-item active">All</li>
                            </ol>
                            

                    <div class="content">
                    <div class="card mb-4">
                            <div class="card-header"><i class="fas fa-table mr-1"></i><?php echo $message; ?></div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Question Name</th>
                                                <th>Correct Answer</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>No</th>
                                                <th>Question Name</th>
                                                <th>Correct Answer</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                        <?php foreach($questions as $question): ?>

                                            <tr>
                                                <td><?php echo  $question['id'] ; ?></td>
                                                <td><a class="nav-link " href="<?php echo route('questions_page', ['id'=>$question['quiz_id']]); ?>"><?php echo  $question['title'] ; ?>?</a></td>
                                                <td><?php echo isset($question['correct_answer'])? $question['correct_answer'] : 'Not set yet'; ?></td>
                                            </tr>
                                        <?php endforeach?>   
                                        </tbody>
                                    </table>
                                    
                                </div>
                                <ul class="nav nav-pills justify-content-end">
    
                                    <li class="nav-item">
                                    <button class="nav-link active" data-toggle="modal" data-target="#questionModal">Add questions</button>
                                    </li>
                                    
                                </ul>
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
        <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
        <script src="<?php echo asset('adminpage/assets/demo/datatables-demo.js'); ?>"></script>
    </body>


<div class="modal fade" id="questionModal">
  	<div class="modal-dialog modal-lg">
    	<form method="post" id="question_form">
      		<div class="modal-content">
      			<!-- Modal Header -->
        		<div class="modal-header">
          			<h4 class="modal-title" id="question_modal_title">Add Question</h4>
          			<button type="button" class="close" data-dismiss="modal">&times;</button>
        		</div>

        		<!-- Modal body -->
        		<div class="modal-body">    
                        <p class="text-danger text-sm-center" id="form_error_field"></p>
                        <p class="text-success text-sm-center" id="form_success_field"></p>
          			<div class="form-group">
            			<div class="row">
              				<label class="col-md-4 text-right">Question Title <span class="text-danger">*</span></label>
	              			<div class="col-md-8">
	                			<input type="text" name="add_question_title" id="add_question_title" autocomplete="off" class="form-control" />
	                		</div>
            			</div>
          			</div>
          			<div class="form-group">
            			<div class="row">
              				<label class="col-md-4 text-right">Option 1 <span class="text-danger">*</span></label>
	              			<div class="col-md-8">
	                			<input type="text" name="option_title_1" id="option_title_1" autocomplete="off" class="form-control" />
	                		</div>
            			</div>
          			</div>
          			<div class="form-group">
            			<div class="row">
              				<label class="col-md-4 text-right">Option 2 <span class="text-danger">*</span></label>
	              			<div class="col-md-8">
	                			<input type="text" name="option_title_2" id="option_title_2" autocomplete="off" class="form-control" />
	                		</div>
            			</div>
          			</div>
          			<div class="form-group">
            			<div class="row">
              				<label class="col-md-4 text-right">Option 3 <span class="text-danger">*</span></label>
	              			<div class="col-md-8">
	                			<input type="text" name="option_title_3" id="option_title_3" autocomplete="off" class="form-control" />
	                		</div>
            			</div>
          			</div>
          			<div class="form-group">
            			<div class="row">
              				<label class="col-md-4 text-right">Option 4 <span class="text-danger">*</span></label>
	              			<div class="col-md-8">
	                			<input type="text" name="option_title_4" id="option_title_4" autocomplete="off" class="form-control" />
	                		</div>
            			</div>
          			</div>
          			<div class="form-group">
            			<div class="row">
              				<label class="col-md-4 text-right">Answer <span class="text-danger">*</span></label>
	              			<div class="col-md-8">
	                			<select name="answer_option" id="answer_option" class="form-control">
	                				<option value="">Select</option>
	                				<option value="option_a">Option 1</option>
	                				<option value="option_b">Option 2</option>
	                				<option value="option_c">Option 3</option>
	                				<option value="option_d">Option 4</option>
	                			</select>
	                		</div>
            			</div>
          			</div>
        		</div>

	        	<!-- Modal footer -->
	        	<div class="modal-footer">
	          		<input type="hidden" name="action" id="hidden_action" value="Edit" />
	          		<input type="submit" name="question_button_action" id="question_button_action" name="question_button_action" class="btn btn-success btn-sm button" value="Add"/>
	          		<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
	        	</div>
        	</div>
    	</form>
  	</div>
</div>
</html>














