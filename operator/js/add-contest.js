function readURL(input, output) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $(output).attr('src', e.target.result);
        };
        reader.readAsDataURL(input.files[0]);
    }
}
$(document).ready(function(){
    $('#previewpane').load('http://localhost/sweepstake/');
    $('#default').stepy({ backLabel: 'Previous', block: true, nextLabel: 'Next', titleClick: true, titleTarget: '.stepy-tab' });

    $(".form_datetime-adv").datetimepicker({
        format: "dd MM yyyy - hh:ii",
        autoclose: true,
        todayBtn: true,
        //startDate: "2013-02-14 10:00",
        minuteStep: 10
    });
    

    $("#header").change(function(){ readURL(this, 'img#headerImage'); });
    $("#logo").change(function(){ readURL(this, 'img#logoImage'); });
    $(".form_datetime-adv input, .input-preview input, .input-preview textarea").change(function(){
        $('#'+$(this).attr('data-preview-id')).html($(this).val() ? $(this).val() : $(this).text());
    });
    $("form#default").submit(function(e){ 
        e.stopPropagation();
        e.preventDefault();
        var formData = new FormData($(this)[0]);
        formData.append('rules', CKEDITOR.instances['rules'].getData());
        var alertType = ["danger", "success", "warning", "info"];
        $.ajax({
            url: $(this).attr("action"),
            type: 'POST',
            data: formData,
            cache: false,
            contentType: false,
            async: false,
            success : function(data, status) {
                if(data.status != null)  $("#messageBox, .messageBox").html('<div class="alert alert-'+alertType[data.status]+'"><button type="button" class="close" data-dismiss="alert">&times;</button>'+data.msg+'</div>');
                else $("#messageBox, .messageBox").html('<div class="alert alert-info"><button type="button" class="close" data-dismiss="alert">&times;</button>'+data+'</div>');
                $.gritter.add({
                    title: 'Notification!',
                    text: data.msg ? data.msg : data,
                    class_name: 'gritter-light'
                });
            },
            error : function(xhr, status) {
                erroMsg = '';
                if(xhr.status===0){ erroMsg = 'There is a problem connecting to internet. Please review your internet connection.'; }
                else if(xhr.status===404){ erroMsg = 'Requested page not found.'; }
                else if(xhr.status===500){ erroMsg = 'Internal Server Error.';}
                else if(status==='parsererror'){ erroMsg = 'Error. Parsing JSON Request failed.'; }
                else if(status==='timeout'){  erroMsg = 'Request Time out.';}
                else { erroMsg = 'Unknow Error.\n'+xhr.responseText;}          
                $("#messageBox, .messageBox").html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Failed. '+erroMsg+'</div>');
                $.gritter.add({
                    title: 'Notification!',
                    text: erroMsg
                });
            },
            processData: false
        });
        return false;
    });
});