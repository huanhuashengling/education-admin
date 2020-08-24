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
});

function operateFormatter(value, row, index) {
  var result = "";
  if (value != "") {
    result = value.split("_")[0];
  } 
    return [
        result
    ].join('');
}