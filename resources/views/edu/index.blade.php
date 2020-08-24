@extends('layouts.app')

@section('content')
<div class="container" style="width: 100%">
    <div id="toolbar">
        <button class="btn btn-success" id="export-score-report-btn">导出成绩</button>
        <button class="btn btn-success" id="email-all-out-btn">发送所有邮件</button>
    </div>
    <table id="edu-admin" class="table table-condensed table-responsive">
        <thead>
            <tr>
                <th data-field="class_name">
                    班级
                </th>
                @foreach($courses as $course)
                <th data-field="teacher_name_{{$course->id}}" data-formatter="operateFormatter">
                    {{$course->course_name}}
                </th>
                <th data-field="lesson_num_{{$course->id}}">
                     
                </th>
                @endforeach
              <th data-field="users_id" data-formatter="emailCol" data-events="emailActionEvents" data-visible="false">
                  发送
              </th>
            </tr>
        </thead>
    </table>
    
</div>
@endsection

@section('scripts')
    <script src="/js/edu.js?v={{rand()}}"></script>

    <!-- <script src="/js/FileSaver.js"></script> -->
    <!-- <script src="/js/bootstrap-table-export.js"></script> -->
    <!-- <script src="/js/tableexport.js"></script> -->
@endsection