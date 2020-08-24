@extends('layouts.app')

@section('content')
<div class="container" style="width: 100%">
    <div id="toolbar">
        <button class="btn btn-success" id="export-score-report-btn">导出成绩</button>
        <button class="btn btn-success" id="email-all-out-btn">发送所有邮件</button>
    </div>
    <table id="lesson-report" class="table table-condensed table-responsive">
        <thead>
            <tr>
                <th data-field="">
                    序号
                </th>
                <th data-field="course_name">
                    学科
                </th>
                <th data-field="teacher_name">
                    姓名
                </th>
                <th data-field="head_teacher_lesson_num" data-formatter="operateFormatter">
                    班主任
                </th>
                <th data-field="second_teacher_lesson_num" data-formatter="operateFormatter">
                    副班<br />主任
                </th>
                <th data-field="course_leader_lesson_num" data-formatter="operateFormatter">
                    教研<br />组长
                </th>
                <th data-field="cross_head_lesson_num" data-formatter="operateFormatter">
                    跨头
                </th>
                <th data-field="position_lesson_num" data-formatter="operateFormatter">
                    岗位
                </th>
                <th data-field="language_lesson_num" data-formatter="operateFormatter">
                    语文
                </th>
                <th data-field="math_lesson_num" data-formatter="operateFormatter">
                    数学
                </th>
                <th data-field="english_lesson_num" data-formatter="operateFormatter">
                    英语
                </th>
                <th data-field="other_lesson_num" data-formatter="operateFormatter">
                    其他
                </th>
                <th data-field="lesson_num_count" data-formatter="operateFormatter">
                    课时<br />合计
                </th>
                <th data-field="workload_num_count" data-formatter="operateFormatter">
                    工作量<br />合计
                </th>
                <th data-field="workload_desc">
                    教学任务及岗位情况
                </th>
                <th data-field="reportText" data-visible="false">
                  阿萨斯
              </th>
            </tr>
        </thead>
    </table>
    
</div>
@endsection

@section('scripts')
    <script src="/js/lesson_report.js?v={{rand()}}"></script>

    <!-- <script src="/js/FileSaver.js"></script> -->
    <!-- <script src="/js/bootstrap-table-export.js"></script> -->
    <!-- <script src="/js/tableexport.js"></script> -->
@endsection