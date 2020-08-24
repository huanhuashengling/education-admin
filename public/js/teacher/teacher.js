$(document).ready(function() {
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  $('#teachers-info').bootstrapTable({
        method: 'get', 
        search: "true",
        url: "/getTeachersInfo",
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
      .on('click', '.update-btn', function (e) {
          // console.log($("#rethink").val());
          console.log($(this).attr("id"));
          var teachersId = $(this).attr("id").split("-")[2];
          var lessonNum = $("#input-"+teachersId).val();
          if (lessonNum == "") {
            alert("数值不能为空！");
            return;
          }
          e.preventDefault();
          $.ajax({
              type: "POST",
              url: '/updateTeacherInfo',
              data: {crossHeadLessonNum: lessonNum,  teachersId: teachersId},
              success: function( data ) {
                  console.log(data);
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
  // console.log(row);
  var result = "";
  if (value != 0) {
    result = value;
  } 
    return [
        "<input style='width:50px' type='text' value='" + result + "' id='input-" + row.id + "' /> " +
        " <button class='btn btn-success update-btn' id='update-btn-" + row.id + "'>更新</button>"
    ].join('');
}