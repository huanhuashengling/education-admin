var teachers;
var lessonNumArr = [0, 0.5, 1, 1.5, 2, 3, 4, 5, 6, 7, 8];
$(document).ready(function() {
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

    $.ajax({
      type: "GET",
      url: '/getTeachers',
      data: {schoolsId: 1},
      success: function( data ) {
          // console.log(data);
          teachers = data;
      }
    });

  $('#courses-info').bootstrapTable({
        method: 'get', 
        search: "true",
        url: "/getCoursesInfo",
        pagination:"true",
        pageList: [50, 30], 
        pageSize: 50,
        pageNumber: 1,
        toolbar:"#toolbar",
        showExport: true,          //是否显示导出
        showColumns: "true",           
        exportDataType: "basic",              //basic', 'all', 'selected'.
      queryParams: function(params) {
        var temp = { 
            editFlag : true,
        };
        return temp;
      },
      clickToSelect: true,
      columns: [{  
                    checkbox: true  
                },{  
                    title: '序号',
                    formatter: function (value, row, index) {  
                        return index+1;  
                    }  
                }],
        responseHandler: function (res) {
            // console.log(res);
            return res;
        },
    });

    $(document)
      .on('change', '.grade-course-lesson-num-selection', function (e) {
          var coursesId = $(this).attr("id").split("-")[1];
          var gradeNum = $(this).attr("id").split("-")[2];
          var lessonNum = $(this).val();
          
          e.preventDefault();
          $.ajax({
              type: "POST",
              url: '/updateGradeCourseLessonNum',
              data: {coursesId: coursesId, gradeNum: gradeNum, lessonNum:lessonNum},
              success: function( data ) {
                  // console.log(data);
                  if("true" == data) {
                    alert("更新成功！");
                  } else {
                    alert("更新失败！");
                  }
              }
          });
      })
      .on('change', '.course-leader-num-selection', function (e) {
          var coursesId = $(this).attr("id").split("-")[1];
          var lessonNum = $(this).val();
          
          e.preventDefault();
          $.ajax({
              type: "POST",
              url: '/updateCourseLeaderNum',
              data: {coursesId: coursesId, lessonNum: lessonNum},
              success: function( data ) {
                  // console.log(data);
                  if("true" == data) {
                    alert("更新成功！");
                  } else {
                    alert("更新失败！");
                  }
              }
          });
      })
      .on('change', '.teacher-selection', function (e) {
          var coursesId = $(this).attr("id").split("-")[2];
          var teachersId = $(this).val();
          
          e.preventDefault();
          $.ajax({
              type: "POST",
              url: '/updateCourseLeaderTeacher',
              data: {coursesId: coursesId, teachersId: teachersId},
              success: function( data ) {
                  // console.log(data);
                  if("true" == data) {
                    alert("更新成功！");
                  } else {
                    alert("更新失败！");
                  }
              }
          });
      })
});

function teacherFormatter(value, row, index) {
  // console.log("row.teachers_id "+row.teachers_id);
  var returnHtml = "<select class='teacher-selection' id='teacher-selection-" + row.id + "'><option value='0'></option>";
    for(var i=0; i < teachers.length; i++) {
      var selected = "";
      if(teachers[i].id  == row.teachers_id) {
        selected = "selected";
      }
      returnHtml += "<option value='" + teachers[i].id + "' " + selected + ">" + teachers[i].teacher_name  + "</option>"
    }
    returnHtml += "</select>";
    return [
        returnHtml
    ].join('');
}

function courseLeaderLessonNumFormatter(value, row, index) {
  var sHtml = buildLeaderSelectHtml(value, row.id)
    return [
        sHtml
    ].join('');
}
function grade1LessonNumFormatter(value, row, index) {
    var gradeNum = 1;
    var sHtml = buildSelectHtml(value, row.id, gradeNum);
    return [
        sHtml
    ].join('');
}

function grade2LessonNumFormatter(value, row, index) {
    var gradeNum = 2;
    var sHtml = buildSelectHtml(value, row.id, gradeNum);
    return [
        sHtml
    ].join('');
}

function grade3LessonNumFormatter(value, row, index) {
    var gradeNum = 3;
    var sHtml = buildSelectHtml(value, row.id, gradeNum);
    return [
        sHtml
    ].join('');
}

function grade4LessonNumFormatter(value, row, index) {
    var gradeNum = 4;
    var sHtml = buildSelectHtml(value, row.id, gradeNum);
    return [
        sHtml
    ].join('');
}

function grade5LessonNumFormatter(value, row, index) {
    var gradeNum = 5;
    var sHtml = buildSelectHtml(value, row.id, gradeNum);
    return [
        sHtml
    ].join('');
}

function grade6LessonNumFormatter(value, row, index) {
    var gradeNum = 6;
    var sHtml = buildSelectHtml(value, row.id, gradeNum);
    return [
        sHtml
    ].join('');
}

function buildSelectHtml(value, coursesId, gradeNum) {
  var returnHtml = "<select class='grade-course-lesson-num-selection' id='gclnselection-" + coursesId + "-" + gradeNum + "'>";
  for (var i = 0; i < lessonNumArr.length; i++) {
    var selected = "";
    if(value == lessonNumArr[i]) {
      // console.log(i + " arr " +lessonNumArr[i]);
      selected = "selected";
    }
    returnHtml += "<option value='"+lessonNumArr[i]+"' "+ selected +">"+lessonNumArr[i]+"</option>"
  }
  returnHtml += "</select>";
  return returnHtml;
}

function buildLeaderSelectHtml(value, coursesId) {
  var returnHtml = "<select class='course-leader-num-selection' id='clnselection-" + coursesId + "'>";
  for (var i = 0; i < lessonNumArr.length; i++) {
    var selected = "";
    if(value == lessonNumArr[i]) {
      // console.log(i + " arr " +lessonNumArr[i]);
      selected = "selected";
    }
    returnHtml += "<option value='"+lessonNumArr[i]+"' "+ selected +">"+lessonNumArr[i]+"</option>"
  }
  returnHtml += "</select>";
  return returnHtml;
}

function secondTeacherFormatter(value, row, index) {
  var teacherName = "";
  // console.log(row);
  for(var i=0; i < teachers.length; i++) {
    if(teachers[i].id == value) {
      teacherName = teachers[i].teacher_name;
    }
  }
    var returnHtml = "<select class='second-teacher-selection' id='second-teacher-selection-" + row.id + "'>";
    for(var i=0; i < teachers.length; i++) {
      var selected = "";
      if(teachers[i].id  == value) {
        selected = "selected";
      }
      returnHtml += "<option value='" + teachers[i].id + "' " + selected + ">" + teachers[i].teacher_name  + "</option>"
    }
    returnHtml += "</select>";
      return [
          returnHtml
      ].join('');
}