@extends('layouts.app')

@section('content')
<div class="container">
    <div id="toolbar">
    </div>
    <table id="teachers-info" class="table table-condensed table-responsive">
        <thead>
            <tr>
                <th>
                    
                </th>
                <th>
                    序号
                </th>
                <th data-field="teacher_name">
                    姓名
                </th>
                <th data-field="gender">
                    性别
                </th>
                <th data-field="birth_date">
                    出生日期
                </th>
                <th data-field="cross_head_lesson_num" data-formatter="operateFormatter">
                    跨头课时
                </th>
                <th data-field="course_name">
                    任教学科
                </th>
                <th data-field="basic_order">
                    默认序号
                </th>
                <th data-field="is_lock">
                    是否锁定
                </th>
                <th data-field="is_formal">
                    是否在编
                </th>
                <th data-field="users_id" data-formatter="emailCol" data-events="emailActionEvents" data-visible="false">
                    发送
                </th>
            </tr>
        </thead>
    </table>
    
</div>
@endsection

@section('scripts')
    <script src="/js/teacher/teacher.js?v={{rand()}}"></script>

    <!-- <script src="/js/FileSaver.js"></script> -->
    <!-- <script src="/js/bootstrap-table-export.js"></script> -->
    <!-- <script src="/js/tableexport.js"></script> -->
@endsection