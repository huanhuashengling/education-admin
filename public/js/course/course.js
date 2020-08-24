var teachers;
$(document).ready(function() {
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  //   $.ajax({
  //     type: "GET",
  //     url: '/getTeachers',
  //     data: {schoolsId: 1},
  //     success: function( data ) {
  //         // console.log(data);
  //         teachers = data;
  //     }
  // });

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
            editFlag : false,
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
      .on('change', '.head-teacher-selection', function (e) {
          // console.log($("#rethink").val());
          // console.log($(this).attr("id"));
          var sclassesId = $(this).attr("id").split("-")[3];
          var teachersId = $(this).val();
          
          e.preventDefault();
          $.ajax({
              type: "POST",
              url: '/updateSclassHeadTacher',
              data: {sclassesId: sclassesId,  headTeachersId: teachersId},
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
      .on('change', '.second-teacher-selection', function (e) {
          // console.log($("#rethink").val());
          // console.log($(this).attr("id"));
          var sclassesId = $(this).attr("id").split("-")[3];
          var teachersId = $(this).val();
          // console.log(sclassesId + teachersId);
          
          e.preventDefault();
          $.ajax({
              type: "POST",
              url: '/updateSclassSecondTacher',
              data: {sclassesId: sclassesId,  secondTeachersId: teachersId},
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

function courseLeaderLessonNumFormatter(value, row, index) {
    console.log(value)
    console.log(row)
    return [
        value
    ].join('');
}
function grade1LessonNumFormatter(value, row, index) {
    console.log(value)
    console.log(row)
    return [
        value
    ].join('');
}

function grade2LessonNumFormatter(value, row, index) {
    console.log(value)
    console.log(row)
    return [
        value
    ].join('');
}

function grade3LessonNumFormatter(value, row, index) {
    console.log(value)
    console.log(row)
    return [
        value
    ].join('');
}

function grade4LessonNumFormatter(value, row, index) {
    console.log(value)
    console.log(row)
    return [
        value
    ].join('');
}

function grade5LessonNumFormatter(value, row, index) {
    console.log(value)
    console.log(row)
    return [
        value
    ].join('');
}

function grade6LessonNumFormatter(value, row, index) {
    console.log(value)
    console.log(row)
    return [
        value
    ].join('');
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