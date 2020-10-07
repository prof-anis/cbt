<?php

namespace App\Controllers;

use App\Utilities\DB\QueryBuilder;
use App\Utilities\DB\Connection;

class Courses
{
    public $conn;

    public function addCoursePage(){
        

        if (!isset($_SESSION['logged_in'])) {
			header('Location: /project/index');
        }
        
        $status = $this->checkCourseForm();
        $courses = $this->getCourses();
        if ($status == 1) {
            $course_name = $_POST['course_name'];
            //Course Added Successfully
            $message = "Course '" . $course_name . "' added successfully";
        } else {
            $message = '';
        }
        // var_dump($_SESSION);
        // exit;


        return render('Courses/add_course', ['courses' => $courses, 'message' => $message]);
    }

    public function checkCourseForm()
    {
        if (isset($_POST['add_course']) && !empty($_POST['course_name'])) {
            $course = $this->addCourse($_POST['course_name']);
            return $course;
        }
    }

    public function addCourse($course_name)
    {
        $qb = new QueryBuilder();
        $new_course = $qb->insert('courses', ['name' => $course_name])->get();
        return $new_course;
    }

    public function getCourses()
    {
        $qb = new QueryBuilder;
        $courses = $qb->select()->from('courses')->get();
        // exit(($courses));
        // $courses->closeconn();
        return $courses;
    }

    public function examsPage($course_id)
    {
        
        if (!isset($_SESSION['logged_in'])) {
			header('Location: /project/index');
        }
        $_SESSION['course_id'] = $course_id;
        $conn = $this->connectToDb();
        $courses = $this->getCourses();
        $course = $this->getCourse($course_id);



        $query = "SELECT quizzes.quiz_id, quizzes.exam_code, quizzes.duration, courses.name as course_name ,courses.course_id, quizzes.name as quiz_name\n"

            . "FROM quizzes\n"

            . "INNER JOIN courses ON quizzes.course_id=courses.course_id\n"

            . "WHERE quizzes.course_id=" . $course_id;

        // . "ORDER BY courses.course_id";


        $query_result = mysqli_query($conn, $query);
        // $result = $this->getOneExam($query_result);
        // $message = "Quiz Id: ".$result['quiz_id']."<br>";
        // $message .= "Course Id: ".$result['course_id']."<br>";
        // $message .= "Quiz Name: ".$result['quiz_name']."<br>";
        // $message .= "Course Name: ".$result['course_name']."<br>";
        // $message = ($result)? "Here are the available exams under this course": "";

        $results = $this->getAllExams($query_result);
        mysqli_free_result($query_result); //free result

        $message = ($results) ? "Here are the available exams under this course" : "";

        // exit(var_dump($message));

        // exit(var_dump($results));

        return render('Courses/examspage', ['courses' => $courses, 'message' => $message, 'exams' => $results]);
    }

    public function connectToDb()
    {
        //Connection for queries not supported by the Query Builder Class
        $dbName = config('database.DBNAME');
        $dbPass = config('database.DBPASS');
        $host = config('database.DBHOST');
        $user = config('database.DBUSER');

        // $conn = mysqli_connect($host, $user, $dbPass, $dbName);
        $conn = mysqli_connect('localhost', 'root', '', 'mvc_framework_test');
        // exit(var_dump($conn));

        if (!$conn) {
            throw new \Exception("Failed to connect: " . mysqli_connect_error());
        }

        return $conn;
    }
    public function getCourse($course_id)
    {
        $qb = new QueryBuilder;
        $course = $qb->select()->from('courses')->where([['course_id', $course_id]])->get();
        return $course;
        exit(var_dump($course));
    }
    public function getOneExam($query_result)
    {
        return mysqli_fetch_assoc($query_result);
    }
    public function getAllExams($query_result)
    {
        return mysqli_fetch_all($query_result, MYSQLI_ASSOC);
    }

    public function addExamPage()
    {
        
        if (!isset($_SESSION['logged_in'])) {
			header('Location: /project/index');
        }
        $courses = $this->getCourses();

        $message = '';
        if (isset($_POST['add_exam']) && !empty($_POST['exam_name']) && isset($_POST['add_exam'])) {
            $status = $this->addExam();
            if ($status == 1) {
                //Exam created successfully
                $message = 'Exam created successfully';
            } else {
                $message = "Could not create exam, please contact the support for help";
            }
        }

        return render('Courses/add_exam', ['courses' => $courses, 'message' => $message]);
    }

    public function addExam()
    {
        $qb = new QueryBuilder;
        $exam_code = $this->getExamCode(7);
        $status = $qb->insert('quizzes', ['course_id' => $_SESSION['course_id'], 'name' => $_POST['exam_name'], 'duration' => $_POST['exam_duration'], 'exam_code' => $exam_code])->get();
        return $status;
    }

    public function getExamCode($length)
    {
        $alphabets = range('A', 'Z');
        $numbers = range('0', '9');
        $additional_characters = array('_', '=');
        $password = '';
        $final_array = array_merge($alphabets, $numbers, $additional_characters);
        while ($length--) {
            $key = array_rand($final_array);

            $password .= $final_array[$key];
        }
        if (preg_match('/[A-Za-z0-9]/', $password)) {
            return $password;
        } else {
            return  $this->getExamCode($length);
        }
    }

    public function questionsPage($exam_id)
    {
        
        if (!isset($_SESSION['logged_in'])) {
			header('Location: /project/index');
        }
        $_SESSION['exam_id'] = $exam_id;
        $conn = $this->connectToDb();
        $courses = $this->getCourses();



        $query = "SELECT questions.id, questions.quiz_id, questions.title, quizzes.name as quiz_name ,quizzes.quiz_id, question_answers.correct_answer"

            . " FROM questions\n"

            . "INNER JOIN quizzes ON quizzes.quiz_id=questions.quiz_id\n"
            
            . "LEFT JOIN question_answers ON question_answers.question_id = questions.id\n"

            . "WHERE questions.quiz_id=" . $exam_id;

        $query_result = mysqli_query($conn, $query);

        $results = $this->getAllQuestions($query_result);
        // exit(var_dump($results));
        mysqli_free_result($query_result); //free result

        $message = ($results) ? "Here are the available questions under this exam" : "";

        // if (isset($_POST['question_button_action'])){
        //     $this->addQuestion();
        // }

        return render('Courses/questions_page', ['courses' => $courses, 'message' => $message, 'questions' => $results, 'exam_id'=>$exam_id]);
    }

    public function getOneQuestion($query_result)
    {
        return mysqli_fetch_assoc($query_result);
    }
    public function getAllQuestions($query_result)
    {
        return mysqli_fetch_all($query_result, MYSQLI_ASSOC);
    }

    public function addQuestion($exam_id){
        
        $question_title = $_POST['add_question_title'];
        $option_1 = $_POST['option_title_1'];
        $option_2 = $_POST['option_title_2'];
        $option_3 = $_POST['option_title_3'];
        $option_4 = $_POST['option_title_4'];
        $answer_option = $_POST['answer_option'];

        //insert the questions to questions table and answers to answers table
        $insert_status = $this->insertQuestion($exam_id, $question_title);
        $message = 'Operation failed';
        if ($insert_status == 1) {
            $inserted_question = $this->getInsertedQuestion($question_title);
            if ($inserted_question != NULL) {
                //Add options and answer at $inserted_question['id'];
                $insert_answers_status = $this->insertAnswers($inserted_question, $option_1, $option_2, $option_3, $option_4, $answer_option);
                if ($insert_answers_status == 1) {
                    $message = 'Question added successfully. Refresh page to see effect.';
                }else{
                    $message = 'Could not create the question, contact the administrator for help';
                }
            }else {
                $message = 'Could not create the question, contact the administrator for help';
            }
        }else{
            $message = 'Operation failed, contact the administrator for help';
        }

        // $message = ($insert_status == 1) ? $this->getInsertedQuestion($question_title) : 'Operation failed, contact the administrator for help';
        sleep(2);
        echo $message;

    }

    public function insertQuestion($exam_id, $question_title){
        $qb = new QueryBuilder;
        $insert_status = $qb->insert('questions', ['quiz_id'=>$exam_id, 'title'=>$question_title])->get();
        return $insert_status;

    }
    
    public function getInsertedQuestion($question_title){
        $qb = new QueryBuilder;
        $question = $qb->select()->from('questions')->where([['title', $question_title]])->get();
        // $question = var_dump($question);
        return $question;
    }

    public function insertAnswers($inserted_question, $option_1, $option_2, $option_3, $option_4, $answer_option){
        $qb = new QueryBuilder;
        $insert_status = $qb->insert('question_answers', ['question_id'=>$inserted_question['id'], 'option_a'=>$option_1, 'option_b'=>$option_2, 'option_c'=>$option_3, 'option_d'=>$option_4, 'correct_answer'=>$answer_option])->get();
        return $insert_status;
    }
    
}
