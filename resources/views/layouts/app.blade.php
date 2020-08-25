<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>{{ trans("layouts.title") }}</title>
    <link rel="icon" href="/img/oic.ico" type="image/x-icon" />
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/jquery-ui.css" rel="stylesheet">
    <link href="/css/bootstrap-table.css" media="all" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    <script src="/js/jquery-3.2.1.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    <script src="/js/bootstrap-table.js"></script>

    <!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.2/css/select2.min.css" rel="stylesheet" /> -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.2/js/select2.min.js"></script> -->

</head>
<body id="app-layout">
    <nav class="navbar navbar-default navbar-static-top">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ trans("layouts.project_name") }}
                </a>
                <ul class="nav navbar-nav">
                    <li><a href="{{ url('/lesson-report/') }}">工作量表</a></li>
                    <li><a href="{{ url('/edu-admin/') }}">工作安排</a></li>
                    <li><a href="{{ url('/edu-admin-edit/') }}">工作安排修改</a></li>
                    <li><a href="{{ url('/teacher-info-edit/') }}">教师信息</a></li>
                    <li><a href="{{ url('/sclass-info-edit/') }}">班级信息</a></li>
                    <li><a href="{{ url('/course-info/') }}">学科信息</a></li>
                    <li><a href="{{ url('/course-info-edit/') }}">学科信息修改</a></li>
                </ul>
            </div>

        </div>
    </nav>

    @yield('content')
    @yield('scripts')

</body>
</html>