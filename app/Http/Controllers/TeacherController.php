<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Teacher;

class TeacherController extends Controller
{
    public function index(){
      $teachers = Teacher::orderBy("basic_order")->get();
      return view('teacher/index');
    }

    public function getTeachersInfo(Request $request) {
      $teachers = Teacher::select("courses.course_name", "teachers.*")
      ->join("courses", 'courses.id', '=', 'default_courses_id')
      ->where("teachers.schools_id", "=", 1)
      ->orderBy("basic_order")->get();

      return $teachers;
    }

    public function updateTeacherInfo(Request $request) {
      $crossHeadLessonNum = $request->get('crossHeadLessonNum');
      $teachersId = $request->get('teachersId');

      $teacher = Teacher::find($teachersId);
      if(isset($teacher)) {
        $teacher->cross_head_lesson_num = $crossHeadLessonNum;
        try{
          $teacher->update();
          return "true";
        } catch (Throwable $e) {
          report($e);
          return "error";
        }
      }
    }
}
