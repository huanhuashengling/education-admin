<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/edu-admin/', 'EducationController@index');
Route::get('/edu-admin-edit/', 'EducationController@eduAdminEdit');
Route::get('/getTeachers/', 'EducationController@getTeachers');
Route::post('/getAdminData/', 'EducationController@getAdminData');
Route::post('/updateEduAdminItem/', 'EducationController@updateEduAdminItem');

Route::get('/lesson-report/', 'EducationController@lessonReport');
Route::post('/getLessonReport/', 'EducationController@getLessonReport');

Route::get('/teacher-info-edit/', 'TeacherController@index');
Route::get('/getTeachersInfo/', 'TeacherController@getTeachersInfo');
Route::post('/updateTeacherInfo/', 'TeacherController@updateTeacherInfo');

Route::get('/sclass-info-edit/', 'SclassController@index');
Route::get('/getSclassesInfo/', 'SclassController@getSclassesInfo');
Route::post('/updateSclassHeadTacher/', 'SclassController@updateSclassHeadTacher');
Route::post('/updateSclassSecondTacher/', 'SclassController@updateSclassSecondTacher');

Route::get('/course-info/', 'CourseController@index');
Route::get('/course-info-edit/', 'CourseController@courseInfoEdit');
Route::get('/getCoursesInfo/', 'CourseController@getCoursesInfo');
Route::post('/updateGradeCourseLessonNum/', 'CourseController@updateGradeCourseLessonNum');
Route::post('/updateCourseLeaderNum/', 'CourseController@updateCourseLeaderNum');
Route::post('/updateCourseLeaderTeacher/', 'CourseController@updateCourseLeaderTeacher');
