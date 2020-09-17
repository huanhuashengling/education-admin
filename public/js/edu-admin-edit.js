var teachers;
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

  $('#edu-admin').bootstrapTable({
      method: 'post', 
      search: "true",
      url: "/getAdminData",
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
                sclassesId : $("[name='score_report_sclasses_id']").val(),
            termsId : $("[name='score_report_terms_id']").val(),
        };
        return temp;
      },
      responseHandler: function (res) {
          // console.log(res);
          return res;
      },
    });


  $(document)
      .on('change', '.teacher-selection', function (e) {
          var sclassesId = $(this).attr("id").split("-")[2];
          var coursesId = $(this).attr("id").split("-")[3];
          var teachersId = $(this).val();
          e.preventDefault();
          $.ajax({
              type: "POST",
              url: '/updateEduAdminItem',
              data: {sclassesId: sclassesId, coursesId: coursesId, teachersId: teachersId},
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

function operateFormatter(value, row, index) {
  var teacherName = "";
  var coursesId = "";
  if (value && value != "") {
    teacherName = value.split("_")[0];
    coursesId = value.split("_")[1];
  }
    var returnHtml = "<select class='teacher-selection' id='teacher-selection-" + row["sclassesId"] + "-" + coursesId + "'>";
    for(var i=0; i < teachers.length; i++) {
      var selected = "";
      if(teachers[i].id  == row["teachers_id_"+teacherName]) {
        selected = "selected";
      }
      returnHtml += "<option value='" + teachers[i].id + "' " + selected + ">" + teachers[i].teacher_name + "</option>"
    }
    returnHtml += "</select>";
      return [
          returnHtml
      ].join('');
}

