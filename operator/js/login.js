$(document).ready(function(){
    $("form#login-form").submit(function(e){ 
        e.stopPropagation();
        e.preventDefault();
        var formDatas = $(this).serialize();
        
        $.ajax({
            url: $(this).attr("action"),
            type: 'POST',
            data: formDatas,
            cache: false,
            success : function(data, status) {
                if(data.status == "1"){ 
                    $.each(data.info, function(i, item) {
                        if (typeof localStorage !== "undefined") {
                            sessionStorage.SWPLoggedInAdmin = true;
                            sessionStorage.SWPAdminName = item.userName;
                            sessionStorage.SWPAdminFullName = item.name;
                            sessionStorage.SWPAdminRole = item.role;
                            sessionStorage.SWPadminId = item.id;
                            sessionStorage.SWPadminEmail = item.email;
                        }
                    });
                    $("#messageBox, .messageBox").html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button><img src="img/cycling.GIF" width="30" height="30" alt="Ajax Loading"> Login Successful! Welcome '+sessionStorage.SWPAdminName+', redirecting... please wait ...</div>');
                    setInterval(function(){ window.location = 'index'; }, 2000);
                }
                else if(data.status != "undefined" && data.status !=1) {
                    $("#messageBox, .messageBox").html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>'+data.msg+'</div>');
                }
                else $("#messageBox, .messageBox").html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>'+data+'</div>');
            },
            error : function(xhr, status) {
                erroMsg = '';
                if(xhr.status===0){ erroMsg = 'There is a problem connecting to internet. Please review your internet connection.'; }
                else if(xhr.status===404){ erroMsg = 'Requested page not found.'; }
                else if(xhr.status===500){ erroMsg = 'Internal Server Error.';}
                else if(status==='parsererror'){ erroMsg = 'Error. Parsing JSON Request failed.'; }
                else if(status==='timeout'){  erroMsg = 'Request Time out.';}
                else { erroMsg = 'Unknow Error.\n'+xhr.responseText;}          
                $("#messageBox, .messageBox").html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>'+erroMsg+'</div>');
            }
        });
        return false;
    });
});