$(document).ready(function(){
    var type_txt;
    if(language == "th"){
        $(".table").DataTable({
            responsive: true,
            "order": [[ 0, "asc" ]],
            "columnDefs": [
                { "targets": [1,3], "orderable": false }
            ],
            "oLanguage":{
                "sEmptyTable":     "ไม่มีข้อมูลในตาราง",
                "sInfo":           "แสดง _START_ ถึง _END_ จาก _TOTAL_ แถว",
                "sInfoEmpty":      "แสดง 0 ถึง 0 จาก 0 แถว",
                "sInfoFiltered":   "(กรองข้อมูล _MAX_ ทุกแถว)",
                "sInfoPostFix":    "",
                "sInfoThousands":  ",",
                "sLengthMenu":     "แสดง _MENU_ แถว",
                "sLoadingRecords": "กำลังโหลดข้อมูล...",
                "sProcessing":     "กำลังดำเนินการ...",
                "sSearch":         "ค้นหา: ",
                "sZeroRecords":    "ไม่พบข้อมูล",
                "oPaginate": {
                    "sFirst":    "หน้าแรก",
                "sPrevious": "ก่อนหน้า",
                    "sNext":     "ถัดไป",
                "sLast":     "หน้าสุดท้าย"
                },
                "oAria": {
                    "sSortAscending":  ": Enabled การเรียงข้อมูลจากน้อยไปมาก",
                "sSortDescending": ": Enabled การเรียงข้อมูลจากมากไปน้อย"
                }
            }
        });
    }else{
        $(".table").DataTable({
            responsive: true,
            "order": [[ 0, "asc" ]],
            "columnDefs": [
                { "targets": [1,3], "orderable": false }
            ],
        });
    }
  

    if(msg){

        if(status == true){
            type_txt = "success";
        }else{
            type_txt = "error";
        }

    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
      });
    

      Toast.fire({
        type: type_txt,
        title: "&nbsp;&nbsp;"+msg
      })

    }
})


$("#checkall").on("click", function(){
    if($(this).is(':checked')){
        $("input[name='ch[]']").prop("checked", true);
        $(".btn-delete-all").prop("disabled", false);
    }else{
        $("input[name='ch[]']").prop("checked", false);
        $(".btn-delete-all").prop("disabled", true);
    }
   
})  

$("input[name='ch[]']").on("click", function(){
    var ch_len = $("input[name='ch[]']:checked").length;
    if($(this).is(':checked')){
        $(".btn-delete-all").prop("disabled", false);
    }else{
        if(ch_len <= 0 ){
            $("#checkall").prop("checked", false);
            $(".btn-delete-all").prop("disabled", true);
        }
        
    }
})

$('#modalDelete').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget)
    var driver_id = button.data('driver-id')
    var driver_name = button.data('driver-name')
    var modal = $(this)
    modal.find('.modal-body span').text(alert_delete_modal)

    $("#modalDelete .btn-continue").off();
    $("#modalDelete .btn-continue").on("click", function(){
        window.location.href="apps/driver/do_driver.php?action=delete&driver_id="+driver_id
    })
  })

$("#modalDeleteAll .btn-continue").off();
$("#modalDeleteAll .btn-continue").on("click", function(){
    $("#frm").submit();
})

$(".driver-edit").off("click");
$(".driver-edit").on("click", function(){
    var driver_id = $(this).attr("data-driver-id");
    var driver_name = $(this).attr("data-driver-name");
    var driver_is_active = $(this).attr('data-driver-is-active')

    if(driver_is_active == "Y"){
        $("#is_active").prop("checked", true);
    }else{
        $("#is_active").prop("checked", false);
    }

    $("#driver_id").val(driver_id);
    $("#driver_name").val(driver_name);
})

$("#forminfo").validate({
    rules: {
        driver_name: "required",
    },
    messages: {
        driver_name: required_name,
    },
    errorElement: "em",
    errorPlacement: function (error, element) {
        // Add the `invalid-feedback` class to the error element
        error.addClass("invalid-feedback");
        error.insertAfter(element);
        
  
    },
    highlight: function (element, errorClass, validClass) {
        $(element).addClass("is-invalid").removeClass("is-valid");
    },
    unhighlight: function (element, errorClass, validClass) {
        $(element).removeClass("is-invalid");
    }
  });

//   $(".btn-plus").on("click", function(){
//       var count = parseFloat($("#hdcount").val()) + 1;
//       $("#hdcount").val(count);
//   })