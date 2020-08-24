$(document).ready(function() {
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  $('#lesson-report').bootstrapTable({
        method: 'post', 
        search: "true",
        url: "/getLessonReport",
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
      // clickToSelect: true,
      columns: [{  
                    title: '序号',
                    formatter: function (value, row, index) {  
                        return index+1;  
                    }  
                }],
        responseHandler: function (res) {
            console.log(res);
            return res;
        },
    });
});

function operateFormatter(value, row, index) {
  var result = Math.round(value * 10) / 10;
  if (value == 0) {
    result = "";
  }
    return [
        result
    ].join('');
}