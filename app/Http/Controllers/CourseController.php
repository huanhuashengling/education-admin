<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Teacher;
use App\Models\CourseLeader;
use App\Models\GradeCourseLessonNum;

class CourseController extends Controller
{
    public function index(){
      return view('course/index');
    }

    public function getCoursesInfo(Request $request) {
      $editFlag = $request->get('editFlag');
      // dd($editFlag);
      $courses = Course::select("teachers.teacher_name", "teachers.id as teachers_id", "courses.*", "course_leaders.lesson_num as course_leader_lesson_num")
      ->where("courses.schools_id", "=", 1)
      ->leftJoin("course_leaders", 'course_leaders.courses_id', '=', 'courses.id')
      ->leftJoin("teachers", 'teachers.id', '=', 'course_leaders.teachers_id')
      ->orderBy("basic_order")->get();

      $courseGradeLessonNum["grade_1_lesson_num"] = 0;
      $courseGradeLessonNum["grade_2_lesson_num"] = 0;
      $courseGradeLessonNum["grade_3_lesson_num"] = 0;
      $courseGradeLessonNum["grade_4_lesson_num"] = 0;
      $courseGradeLessonNum["grade_5_lesson_num"] = 0;
      $courseGradeLessonNum["grade_6_lesson_num"] = 0;
      $courseGradeLessonNum["course_lesson_num"] = 0;
      $dataset = [];
      foreach ($courses as $key => $course) {
        $tData = [];
        $tData["id"] = $course->id;
        $tData["course_name"] = $course->course_name;
        $tData["teacher_name"] = $course->teacher_name;
        $tData["teachers_id"] = $course->teachers_id;
        $tData["course_leader_lesson_num"] = $course->course_leader_lesson_num;
        $tData["basic_order"] = $course->basic_order;
        $tData["weight_value"] = $course->weight_value;
        $tLessonNum = 0;
        for ($i=1; $i <= 6; $i++) { 
          $gradeCourseLessonNum = GradeCourseLessonNum::select("lesson_num")
          ->where("grade_num", "=", $i)
          ->where("courses_id", "=", $course->id)->first();
          if(isset($gradeCourseLessonNum)) {
            $tLessonNum += $gradeCourseLessonNum->lesson_num;
            $tData["grade_" . $i . "_lesson_num"] = $gradeCourseLessonNum->lesson_num;
            $courseGradeLessonNum["grade_" . $i . "_lesson_num"] += $gradeCourseLessonNum->lesson_num;
            $courseGradeLessonNum["course_lesson_num"] += $gradeCourseLessonNum->lesson_num;
          } else {
            continue;
          }
        }
        $tData["course_lesson_num"] = $tLessonNum;
        $dataset[] = $tData;
      }
      if($editFlag == "false") {
        $dataset[] = $courseGradeLessonNum;
      }
      return $dataset;
    }

    public function courseInfoEdit() {
      return view('course/course_info_edit');
    }

    public function updateGradeCourseLessonNum(Request $request) {
      $coursesId = $request->get('coursesId');
      $gradeNum = $request->get('gradeNum');
      $lessonNum = $request->get('lessonNum');

      $GCLM = GradeCourseLessonNum::where("grade_num", "=", $gradeNum)
      ->where("courses_id", "=", $coursesId)->first();
      $GCLM->lesson_num = $lessonNum;
        $GCLM->update();
      if(isset($GCLM)) {
        $GCLM->lesson_num = $lessonNum;
        $GCLM->update();
        // try{
        //   $GCLM->update();
        //   return "true";
        // } catch (Throwable $e) {
        //   report($e);
        //   return "error";
        // }
      }
    }

    public function updateCourseLeaderNum(Request $request) {
      $coursesId = $request->get('coursesId');
      $lessonNum = $request->get('lessonNum');

      $courseLeader = CourseLeader::where("courses_id", "=", $coursesId)
      ->where("schools_id", "=", 1)->first();
      if(isset($courseLeader)) {
        $courseLeader->lesson_num = $lessonNum;
        try{
          $courseLeader->update();
          return "true";
        } catch (Throwable $e) {
          report($e);
          return "false";
        }
      }
    }

    public function updateCourseLeaderTeacher(Request $request) {
      $coursesId = $request->get('coursesId');
      $teachersId = $request->get('teachersId');
      // dd($teachersId);
      $courseLeader = CourseLeader::where("courses_id", "=", $coursesId)
      ->where("schools_id", "=", 1)->first();
      if(isset($courseLeader)) {
        if("0" == $teachersId) {
          try{
            $courseLeader->delete();
            return "true";
          } catch (Throwable $e) {
            report($e);
            return "false";
          }
        }

        $courseLeader->teachers_id = $teachersId;
        try{
          $courseLeader->update();
          return "true";
        } catch (Throwable $e) {
          report($e);
          return "false";
        }
      } else {
        $courseLeader = new CourseLeader();
        $courseLeader->schools_id = 1;
        $courseLeader->teachers_id = $teachersId;
        $courseLeader->courses_id = $coursesId;
        $courseLeader->lesson_num = 0;
        try{
          $courseLeader->save();
          return "true";
        } catch (Throwable $e) {
          report($e);
          return "false";
        }

      }
    }
}
