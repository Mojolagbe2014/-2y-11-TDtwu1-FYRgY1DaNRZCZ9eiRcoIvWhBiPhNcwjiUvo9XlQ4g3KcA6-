var dataTable;
function dump(obj) {
    var out = '';
    for (var i in obj) {
        out += i + ": " + obj[i] + "\n";
    }

    alert(out);
//
//    // or, if you wanted to avoid alerts...
//
//    var pre = document.createElement('pre');
//    pre.innerHTML = out;
//    document.body.appendChild(pre)
}
$(document).ready(function(){
    loadAllRegisteredEntrants();
    function loadAllRegisteredEntrants(){
        dataTable = $('#entrantlist').DataTable( {
            columnDefs: [ {
                orderable: false,
                className: 'select-checkbox',
                targets:   [0, 1]
            } ],
            select: {
                style:    'os',
                selector: 'td:first-child'
            },
            order: [[ 3, 'asc' ]],
            "processing": true,
            "serverSide": true,
            "scrollX": true,
            "ajax":{
                url :"../REST/manage-entrants.php", //employee-grid-data.php",// json datasource
                type: "GET",  // method  , by default get
                data: {fetchEntrants:'true'},
                error: function(e){  // error handling
                    dump(e);
                        $("#entrantlist-error").html("");
                        $("#entrantlist").append('<tbody class="alert alert-danger"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
                        $("#entrantlist_processing").css("display","none");

                }
            }
        } );
    }
    //Select Multiple Values
    $("#multi-action-box").click(function () {
        var checkAll = $("#multi-action-box").prop('checked');
        if (checkAll) {
            $(".multi-action-box").prop("checked", true);
        } else {
            $(".multi-action-box").prop("checked", false);
        }
    });
    //Handler for multiple selection
    $('.multi-message-entrant').click(function(){
        if(confirm("Are you sure you want to change entrant type for selected entrants?")) {
            if($('#multi-action-box').prop("checked") || $('#entrantlist :checkbox:checked').length > 0) {
                var atLeastOneIsChecked = $('#entrantlist :checkbox:checked').length > 0;
                if (atLeastOneIsChecked !== false) {
                    $('#entrantlist :checkbox:checked').each(function(){
                        sendEmail($(this).attr('data-email'));
                    });
                }
                else alert("No row selected. You must select atleast a row.");
            }
            else alert("No row selected. You must select atleast a row.");
        }
    });
    $('.multi-delete-entrant').click(function(){
        if(confirm("Are you sure you want to delete selected entrants?")) {
            if($('#multi-action-box').prop("checked") || $('#entrantlist :checkbox:checked').length > 0) {
                var atLeastOneIsChecked = $('#entrantlist :checkbox:checked').length > 0;
                if (atLeastOneIsChecked !== false) {
                    $('#entrantlist :checkbox:checked').each(function(){
                        deleteEntrant($(this).attr('data-id'));
                    });
                }
                else alert("No row selected. You must select atleast a row.");
            }
            else alert("No row selected. You must select atleast a row.");
        }
    });
    
    $(document).on('click', '.message-entrant', function() {
        if(confirm("Are you sure you want to email this entrant? Entrant Email: '"+$(this).attr('data-email')+"'")) sendEmail($(this).attr('data-email'));
    });
    $(document).on('click', '.delete-entrant', function() {
        if(confirm("Are you sure you want to delete this entrant? Entrant Email: '"+$(this).attr('data-email')+"'")) deleteEntrant($(this).attr('data-id'));
    });
    
    function deleteEntrant(entrantId){
            $.ajax({
            url: "../REST/manage-entrants.php",
            type: 'POST',
            data: {deleteThisEntrant: 'true', id:entrantId},
            cache: false,
            success : function(data, status) {
                if(data.status === 1){
                    $("#messageBox, .messageBox").html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>'+data.msg+'</div>');
                    dataTable.ajax.reload();
                }
                else if(data.status !== 1 && data.status !== "undefined"){
                    $("#messageBox, .messageBox").html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>'+data.msg+'</div>');
                } else $("#messageBox, .messageBox").html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>'+data+'</div>');
                
                $.gritter.add({
                    title: 'Notification!',
                    text: data.msg ? data.msg : data
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
                $("#messageBox, .messageBox").html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Entrant details update failed. '+erroMsg+'</div>');
                $.gritter.add({
                    title: 'Notification!',
                    text: erroMsg
                });
            }
        });
    }
    function sendEmail(entrantEmail){
        $.ajax({
            url: "../REST/manage-entrants.php",
            type: 'GET',
            data: {sendEmail: 'true', email:entrantEmail},
            cache: false,
            success : function(data, status) {
                if(data.status === 1){
                    $("#messageBox, .messageBox").html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>'+data.msg+' </div>');
                    dataTable.ajax.reload();
                }
                else if(data.status !== 1 && data.status !== "undefined"){
                    $("#messageBox, .messageBox").html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>'+data.msg+'</div>');
                } else $("#messageBox, .messageBox").html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>'+data+'</div>');
                $.gritter.add({
                    title: 'Notification!',
                    text: data.msg ? data.msg : data
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
                $("#messageBox, .messageBox").html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Entrant details update failed. '+erroMsg+'</div>');
                $.gritter.add({
                    title: 'Notification!',
                    text: erroMsg
                });
            }
        });
    }
});