<?php

namespace App\Controllers;

use App\Utilities\DB\QueryBuilder;

class Courses{
    public function addCoursePage(){
        session_start();
        $status = $this->checkCourseForm();
        $courses = $this->getCourses();
        // if ($status == 1){
        //     //Course Added Successfully
        //     $courses = $this->getCourses();
        //     // exit(var_dump($courses));
        // }
        

        return render('Courses/add_course', ['courses' => $courses]);
    }

    public function checkCourseForm(){
        if (isset($_POST['add_course']) && !empty($_POST['course_name'])) {
            $course = $this->addCourse($_POST['course_name']);
            return $course;
        }
    }

    public function addCourse($course_name){
        $qb = new QueryBuilder();
        $new_course = $qb->insert('courses', ['name'=>$course_name])->get();
        return $new_course;
    }

    public function getCourses(){
        $qb = new QueryBuilder;
        $courses = $qb->select()->from('courses')->get();
        // exit(($courses));
        // $courses->closeconn();
        return $courses;
    }
}