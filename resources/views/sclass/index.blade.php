@extends('layouts.app')

@section('content')
<div class="container">
    <div id="toolbar">
        <button class="btn btn-success" id="export-score-report-btn">导出成绩</button>
        <button class="btn btn-success" id="email-all-out-btn">发送所有邮件</button>
    </div>
    <table id="sclasses-info" class="table table-condensed table-responsive">
        <thead>
            <tr>
                <th>
                    
                </th>
                <th>
                    序号
                </th>
                <th data-field="class_name">
                    班级
                </th>
                <th data-field="grade_num">
                    年级数
                </th>
                <th data-field="class_num">
                    班级数
                </th>
                <th data-field="head_teacher_id" data-formatter="headTeacherFormatter">
                    班主任
                </th>
                <th data-field="second_teacher_id" data-formatter="secondTeacherFormatter">
                    副班主任
                </th>
            </tr>
        </thead>
    </table>
    
</div>
@endsection

@section('scripts')
    <script src="/js/sclass/sclass.js?v={{rand()}}"></script>

    <!-- <script src="/js/FileSaver.js"></script> -->
    <!-- <script src="/js/bootstrap-table-export.js"></script> -->
    <!-- <script src="/js/tableexport.js"></script> -->
@endsection