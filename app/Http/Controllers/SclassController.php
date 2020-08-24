<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sclass;

class SclassController extends Controller
{
    public function index(){
      return view('sclass/index');
    }

    public function getSclassesInfo(Request $request) {
      // $schoolsId = $request->get('schoolsId');
      $sclasses = Sclass::where("schools_id", "=", 1)->get();

      return $sclasses;
    }

    public function updateSclassHeadTacher(Request $request) {
      $headTeachersId = $request->get('headTeachersId');
      $sclassesId = $request->get('sclassesId');

      $sclass = Sclass::find($sclassesId);
      if(isset($sclass)) {
        $sclass->head_teacher_id = $headTeachersId;
        // $sclass->update();
        try{
          $sclass->update();
          return "true";
        } catch (Throwable $e) {
          report($e);
          return "error";
        }
      }
    }

    public function updateSclassSecondTacher(Request $request) {
      $secondTeachersId = $request->get('secondTeachersId');
      $sclassesId = $request->get('sclassesId');

      $sclass = Sclass::find($sclassesId);
      if(isset($sclass)) {
        $sclass->second_teacher_id = $secondTeachersId;
        try{
          $sclass->update();
          return "true";
        } catch (Throwable $e) {
          report($e);
          return "error";
        }
      }
    }
}
