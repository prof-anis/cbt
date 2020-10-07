<?php
namespace App\Controllers;

use App\Utilities\DB\QueryBuilder;

class Exams{
    public function getExamDetails($exam_code){
        
        
        $qb = new QueryBuilder;
        $exam = $qb->select()->from('quizzes')->where([['exam_code', $exam_code]])->get();
        if ($exam == NULL) {
            sleep(1);
            $output = "Exam does not exist";
        }else {
            sleep(1);
            $output = '
            <div class="card">
				<div class="card-header">Exam Details</div>
				<div class="card-body">
					<table class="table table-striped table-hover table-bordered">
			';
			
				$output .= '
				<tr>
					<td><b>Exam Title</b></td>
					<td>'.$exam["name"].'</td>
				</tr>
				<tr>
					<td><b>Exam Date & Time</b></td>
					<td>'.$exam["date_time"].'</td>
				</tr>
				<tr>
					<td><b>Exam Duration</b></td>
					<td>'.$exam["duration"].' Minutes</td>
				</tr>
				<tr>
					<td><b>Exam Total Question</b></td>
					<td>'.$exam["no_of_questions"].' </td>
				</tr>
				<tr>
					<td><b>Marks Per Right Answer</b></td>
					<td>'.$exam["right_answer_mark"].' Marks</td>
				</tr>
				<tr>
					<td><b>Marks Per Wrong Answer</b></td>
					<td>-'.$exam["wrong_answer_mark"].' Marks</td>
				</tr>
                ';
            
        
        }
        $_SESSION['exam_code'] = $exam_code;
        session_regenerate_id();
        echo $output;

    }


    public function takeExamPage(){
        
        $exam_code = $_SESSION['exam_code'];
        $qb = new QueryBuilder;
        $exam = $qb->select()->from('quizzes')->where([['exam_code', $exam_code]])->get();
        // var_dump($exam);exit;
        $courses = new Courses;
        $conn = $courses->connectToDb();
        // var_dump($_SESSION);exit;
        if ($_SESSION['is_premium'] == "true") {
            if($_SESSION['package'] == 'business'){
                $limit = 40;
            }elseif($_SESSION['package'] == 'premium'){
                $limit = $exam['no_of_questions'];
            }
        }else{
            $limit = 10;
        }
        $_SESSION['limit'] = $limit;
        $query = "SELECT * FROM questions JOIN question_answers WHERE questions.quiz_id = ".$exam['quiz_id']." AND question_answers.question_id = questions.id LIMIT ".$limit."";
        $query_result = mysqli_query($conn, $query);

        $results = $courses->getAllQuestions($query_result);
        $_SESSION['exam'] = $exam;
        // exit(var_dump($results));
        mysqli_free_result($query_result); //free result
        
        return render('Exams/take_exam', ['email' => $_SESSION['name'], 'questions'=>$results, 'exam'=>$exam]);
    }

    public function markExam(){
        
        if (!(isset($_SESSION['name']))){
            exit('Bad entry');
        }
        $exam = $_SESSION['exam'];
        $increase_mark_by = $exam['right_answer_mark'];
        $decrease_mark_by = $exam['wrong_answer_mark'];
        $student_mark = 0;
        $total_possible_marks = $_SESSION['limit'];

        foreach ($_POST as $key => $value) {
            if ($key != "submit_btn") {
                $qb = new QueryBuilder;
                $question = $qb->select()->from("question_answers")->where([['question_id', $key]])->get();
                ($value == $question['correct_answer'])? $student_mark += $increase_mark_by : $student_mark -= $decrease_mark_by;
            }

        }
        $percentage_student_mark = (($student_mark/$total_possible_marks)*100)."%";
        $reason = (isset($_POST['submit_btn']))? "Submitted successfully" : "Timed out";
        $qbuild = new QueryBuilder;
        $result = $qbuild->insert("exam_results", ['user_id'=>$_SESSION['user_id'], 'exam_id'=>$exam['quiz_id'], 'score'=>$student_mark, 'percent_score'=>$percentage_student_mark, 'reason'=>$reason, 'ip_address'=>$this->getIPAddress()])->get();
        return render('Exams/results_page', ['email'=>$_SESSION['name'], 'exam'=>$exam, 'reason'=>$reason, 'score'=>$student_mark, 'percent_score'=>$percentage_student_mark]);
    }

    function getIPAddress() {  
        $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if(getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if(getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if(getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if(getenv('HTTP_FORWARDED'))
            $ipaddress = getenv('HTTP_FORWARDED');
        else if(getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = 'UNKNOWN';

        return $ipaddress;
    }  
}