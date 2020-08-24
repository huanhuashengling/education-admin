@extends('layouts.app')

@section('content')
<div class="container">
    <div id="toolbar">
        <button class="btn btn-success" id="export-score-report-btn">导出成绩</button>
        <button class="btn btn-success" id="email-all-out-btn">发送所有邮件</button>
    </div>
    <table id="courses-info" class="table table-condensed table-responsive">
        <thead>
            <tr>
                <th>
                    
                </th>
                <th>
                    序号
                </th>
                <th data-field="course_name">
                    课程
                </th>
                <th data-field="weight_value">
                    权值
                </th>
                <th data-field="basic_order">
                    默认序号
                </th>
                <th data-field="teacher_name">
                    学科组长
                </th>
                <th data-field="course_leader_lesson_num" data-formatter="courseLeaderLessonNumFormatter">
                    组长课时
                </th>
                <th data-field="grade_1_lesson_num" data-formatter="grade1LessonNumFormatter">
                    1年级课时
                </th>
                <th data-field="grade_2_lesson_num" data-formatter="grade2LessonNumFormatter">
                    2年级课时
                </th>
                <th data-field="grade_3_lesson_num" data-formatter="grade3LessonNumFormatter">
                    3年级课时
                </th>
                <th data-field="grade_4_lesson_num" data-formatter="grade4LessonNumFormatter">
                    4年级课时
                </th>
                <th data-field="grade_5_lesson_num" data-formatter="grade5LessonNumFormatter">
                    5年级课时
                </th>
                <th data-field="grade_6_lesson_num" data-formatter="grade6LessonNumFormatter">
                    6年级课时
                </th>
                <th data-field="course_lesson_num">
                    课时合计
                </th>
            </tr>
        </thead>
    </table>
    
</div>
@endsection

@section('scripts')
    <script src="/js/course/course.js?v={{rand()}}"></script>

    <!-- <script src="/js/FileSaver.js"></script> -->
    <!-- <script src="/js/bootstrap-table-export.js"></script> -->
    <!-- <script src="/js/tableexport.js"></script> -->
@endsection