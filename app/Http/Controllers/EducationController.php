<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Course;
use App\Models\Sclass;
use App\Models\GradeCourseLessonNum;
use App\Models\SclassCourseTeacher;
use App\Models\CourseLeader;
use App\Models\Position;
use App\Models\Teacher;

class EducationController extends Controller
{
  public function index(){
      $courses = Course::orderBy("basic_order")->get();
      // dd($courses);
      return view('edu/index', compact("courses"));
    }

  public function getAdminData() {
      $dataset = [];
      $sclasses = Sclass::all();
      foreach ($sclasses as $key => $sclass) {
        $gradeNum = $sclass->grade_num;
        $sclassesId = $sclass->id;
        $gradeCourseLessonNums = GradeCourseLessonNum::select("grade_course_lesson_nums.lesson_num", "courses.id as coursesId", "grade_course_lesson_nums.courses_id", "courses.basic_order")
        ->join("courses", 'courses.id', '=', 'courses_id')
        ->where("grade_num", "=", $gradeNum)->where("lesson_num", "<>", 0.0)->get();
        
        $gradeDataset = [];
        $gradeDataset["class_name"] = $sclass->class_name;
        $gradeDataset["sclassesId"] = $sclass->id;

        foreach ($gradeCourseLessonNums as $key => $gradeCourseLessonNum) {
          
          $sclassCourseTeacher = SclassCourseTeacher::select("courses.basic_order", "teachers.teacher_name", "teachers.id as teachers_id")
          ->join("courses", 'courses.id', '=', 'courses_id')
          ->join("teachers", 'teachers.id', '=', 'teachers_id')
          ->where("sclasses_id", "=", $sclassesId)
          ->where("courses_id", "=", $gradeCourseLessonNum->courses_id)
          ->first();
          // dd($sclassCourseTeacher->basic_order);
          // $basicOrder = $sclassCourseTeacher->basic_order
          // $tData = [];
          if(isset($sclassCourseTeacher)) {
            $gradeDataset["teacher_name_".$gradeCourseLessonNum->coursesId] = $sclassCourseTeacher->teacher_name . "_" . $gradeCourseLessonNum->coursesId;
            $gradeDataset["teachers_id_".$sclassCourseTeacher->teacher_name] = $sclassCourseTeacher->teachers_id;
            $gradeDataset["lesson_num_".$gradeCourseLessonNum->coursesId] = $gradeCourseLessonNum->lesson_num;
          } else {
            $gradeDataset["teacher_name_".$gradeCourseLessonNum->coursesId] = " _" . $gradeCourseLessonNum->coursesId;
            $gradeDataset["lesson_num_".$gradeCourseLessonNum->coursesId] = $gradeCourseLessonNum->lesson_num;
          }
          // $gradeDataset[] = $tData;
        }

        $dataset[] = $gradeDataset;
        // if ($sclass->id == 12) {
        //   break;
        // }
      }
      return $dataset;
    }

    public function eduAdminEdit() {
      $courses = Course::orderBy("basic_order")->get();
      // dd($courses);
      return view('edu/edu_admin_edit', compact("courses"));
    }

    public function updateEduAdminItem(Request $request) {
      $sclassesId = $request->get('sclassesId');
      $coursesId = $request->get('coursesId');
      $teachersId = $request->get('teachersId');

      $SCT = SclassCourseTeacher::where("sclasses_id", "=", $sclassesId)
          ->where("courses_id", "=", $coursesId)
          ->first();

      if(isset($SCT)) {
        $SCT->teachers_id = $teachersId;
        try{
          $SCT->update();
          return "true";
        } catch (Throwable $e) {
          report($e);
          return "error";
        }
      } else {
        $SCT = new SclassCourseTeacher();
        $SCT->schools_id = 1;
        $SCT->sclasses_id = $sclassesId;
        $SCT->courses_id = $coursesId;
        $SCT->teachers_id = $teachersId;
        $SCT->save();
      }
    }

    public function getTeachers(Request $request) {
      $schoolsId = $request->get('schoolsId');
      $teachers = Teacher::select("id", "teacher_name")->where("schools_id", "=", $schoolsId)->get();
      return $teachers;
    }

  public function lessonReport() {
      return view('edu/lesson_report');
    }

  public function getLessonReport() {
      $dataset = [];
      $teachers = Teacher::orderBy("basic_order")->get();
      foreach ($teachers as $key => $teacher) {
        $tData = [];
        $workloadDesc = "";

        $tData["course_name"] = $this->returnCourseName($teacher->default_courses_id);

        $tData["cross_head_lesson_num"] = $teacher->cross_head_lesson_num;
        $tData["teacher_name"] = $teacher->teacher_name;
        $sclass = Sclass::where("head_teacher_id", "=", $teacher->id)->first();
        if (isset($sclass)) {
          $tData["head_teacher_lesson_num"] = 9;
          $workloadDesc .= $sclass->class_name . "班班主任, ";
        } else {
          $tData["head_teacher_lesson_num"] = 0;
        }

        $sclass = Sclass::where("second_teacher_id", "=", $teacher->id)->first();
        if (isset($sclass)) {
          $tData["second_teacher_lesson_num"] = 1;
          $workloadDesc .= $sclass->class_name . "班副班主任, ";
        } else {
          $tData["second_teacher_lesson_num"] = 0;
        }

        $courseLeader = CourseLeader::where("teachers_id", "=", $teacher->id)->first();
        if (isset($courseLeader)) {
          $tData["course_leader_lesson_num"] = $courseLeader->lesson_num;
          $tCourseName = $this->returnCourseName($courseLeader->courses_id);
          $workloadDesc .= $tCourseName . "组长, ";
        } else {
          $tData["course_leader_lesson_num"] = 0;
        }

        $position = Position::where("teachers_id", "=", $teacher->id)->first();
        if (isset($position)) {
          $tData["position_lesson_num"] = $position->position_lesson_num;
          $workloadDesc .= $position->position_name . ", ";
        } else {
          $tData["position_lesson_num"] = 0;
        }

        //language
        $returnData = $this->returnTeacherCourseData($teacher->id, "语文");
        $tData["language_lesson_num"] = $returnData["courseLessonNum"];
        $workloadDesc .= $returnData["workloadDesc"];
        
        //math
        $returnData = $this->returnTeacherCourseData($teacher->id, "数学");
        $tData["math_lesson_num"] = $returnData["courseLessonNum"];
        $workloadDesc .= $returnData["workloadDesc"];

        //english
        $returnData = $this->returnTeacherCourseData($teacher->id, "英语");
        $tData["english_lesson_num"] = $returnData["courseLessonNum"];
        $workloadDesc .= $returnData["workloadDesc"];

         //other
        $returnData = $this->returnTeacherOtherCourseData($teacher->id);
        $tData["other_lesson_num"] = $returnData["courseLessonNum"];
        $workloadDesc .= $returnData["workloadDesc"];

        $tData["lesson_num_count"] = $tData["language_lesson_num"] * 1.3 + $tData["math_lesson_num"] * 1.3 + $tData["english_lesson_num"] * 1.1 + $tData["other_lesson_num"];

        $tData["workload_num_count"] = $tData["lesson_num_count"] + $tData["head_teacher_lesson_num"] + $tData["second_teacher_lesson_num"] + $tData["course_leader_lesson_num"] + $tData["cross_head_lesson_num"] + $tData["position_lesson_num"];

        $tData["workload_desc"] = $workloadDesc;
        $dataset[] = $tData;
      }
      return $dataset;
    }

    public function returnTeacherCourseData($teachersId, $courseName) {
      $returnData = [];
      $returnData["courseLessonNum"] = 0;
      $returnData["workloadDesc"] = "";
      $SCTItems = SclassCourseTeacher::select("courses.id as courses_id", "courses.course_name", "sclasses.grade_num", "sclasses.class_name")
          ->join("courses", 'courses.id', '=', 'sclass_course_teachers.courses_id')
          ->join("sclasses", 'sclasses.id', '=', 'sclass_course_teachers.sclasses_id')
          ->where("teachers_id", "=", $teachersId)
          ->where("courses.course_name", "=", $courseName)
          ->get();

      // dd($SCTItems);
      if (count($SCTItems) > 0) {
        foreach ($SCTItems as $key => $SCTItem) {
          if (isset($SCTItem)) {
            $GCLNum = GradeCourseLessonNum::select("lesson_num")
            ->where("grade_num", "=", $SCTItem->grade_num)
            ->where("lesson_num", "<>", 0.0)
            ->where("courses_id", "=", $SCTItem->courses_id)
            ->first();

            $returnData["courseLessonNum"] += $GCLNum->lesson_num;
            $returnData["workloadDesc"] .= $SCTItem->class_name . "班". $SCTItem->course_name . $GCLNum->lesson_num . "节, ";
          }
        }
      }
      return $returnData;
    }

    public function returnTeacherOtherCourseData($teachersId) {
      $returnData = [];
      $returnData["courseLessonNum"] = 0;
      $returnData["workloadDesc"] = "";
      $SCTItems = SclassCourseTeacher::select("courses.id as courses_id", "courses.course_name", "sclasses.grade_num", "sclasses.class_name")
          ->join("courses", 'courses.id', '=', 'sclass_course_teachers.courses_id')
          ->join("sclasses", 'sclasses.id', '=', 'sclass_course_teachers.sclasses_id')
          ->where("teachers_id", "=", $teachersId)
          ->where("courses.course_name", "<>", "语文")
          ->where("courses.course_name", "<>", "数学")
          ->where("courses.course_name", "<>", "英语")
          ->where("courses.course_name", "<>", "少队")
          ->get();

      // dd($SCTItems);
      if (count($SCTItems) > 0) {
        foreach ($SCTItems as $key => $SCTItem) {
          if (isset($SCTItem)) {
            $GCLNum = GradeCourseLessonNum::select("lesson_num")
            ->where("grade_num", "=", $SCTItem->grade_num)
            ->where("courses_id", "=", $SCTItem->courses_id)
            ->where("lesson_num", "<>", 0.5)
            ->first();
            if (isset($GCLNum)) {
              $returnData["courseLessonNum"] += $GCLNum->lesson_num;
              $returnData["workloadDesc"] .= $SCTItem->class_name . "班". $SCTItem->course_name . $GCLNum->lesson_num . "节, ";
            }
            
          }
        }
      }
      return $returnData;
    }

    public function returnCourseName($coursesId)
    {
      $course = Course::find($coursesId);
      return $course->course_name;
    }
}
