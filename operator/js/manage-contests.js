var dataTable;
$(document).ready(function(){
    loadAllsContests();
    function loadAllsContests(){
        dataTable = $('#contestlist').DataTable( {
            columnDefs: [ {
                orderable: false,
                className: 'select-checkbox',
                targets:   [0, 1]
            } ],
            select: {
                style:    'os',
                selector: 'td:first-child'
            },
            order: [[ 2, 'asc' ]],
            "processing": true,
            "serverSide": true,
            "scrollX": true,
            "ajax":{
                url :"../REST/manage-contests.php", //employee-grid-data.php",// json datasource
                type: "post",  // method  , by default get
                data: {fetchContests:'true'},
                error: function(){  // error handling
                        $("#contestlist-error").html("");
                        $("#contestlist").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
                        $("#contestlist_processing").css("display","none");

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
    $('.multi-delete-contest').click(function(){
        if(confirm("Are you sure you want to delete selected contests?")) {
            if($('#multi-action-box').prop("checked") || $('#contestlist :checkbox:checked').length > 0) {
                var atLeastOneIsChecked = $('#contestlist :checkbox:checked').length > 0;
                if (atLeastOneIsChecked !== false) {
                    $('#contestlist :checkbox:checked').each(function(){
                        deleteContest($(this).attr('data-id'), $(this).attr('data-header'), $(this).attr('data-logo'));
                    });
                }
                else {
                    $("#myModal h4.modal-title").html('Operation Failed!!!');
                    $("#myModal div.modal-body").html('No row selected. <br/> Please select at least a row and try again. <br/> Thanks.');
                    $("#myModal").modal();//alert("No row selected. You must select atleast a row.");
                }
            }
            else {
                $("#myModal h4.modal-title").html('Operation Failed!!!');
                $("#myModal div.modal-body").html('No row selected. <br/> Please select at least a row and try again. <br/> Thanks.');
                $("#myModal").modal();//alert("No row selected. You must select atleast a row.");
            }
        }
    });
    //Handler for multiple selection
    $('.multi-activate-contest').click(function(){
        if(confirm("Are you sure you want to change contest status for selected contests?")) {
            if($('#multi-action-box').prop("checked") || $('#contestlist :checkbox:checked').length > 0) {
                var atLeastOneIsChecked = $('#contestlist :checkbox:checked').length > 0;
                if (atLeastOneIsChecked !== false) {
                    $('#contestlist :checkbox:checked').each(function(){
                        activateContest($(this).attr('data-id'), $(this).attr('data-status'));
                    });
                }
                else alert("No row selected. You must select atleast a row.");
            }
            else alert("No row selected. You must select atleast a row.");
        }
    });
    var currentStatus ="";
    
    $(document).on('click', '.activate-contest', function() {
        currentStatus = 'Activate'; if(parseInt($(this).attr('data-status')) === 1) currentStatus = "De-activate";
        if(confirm("Are you sure you want to "+currentStatus+" this contest? Contest Title: '"+$(this).attr('data-title')+"'")) activateContest($(this).attr('data-id'),$(this).attr('data-status'));
    });
    $(document).on('click', '.delete-contest', function() {
        if(confirm("Are you sure you want to delete this contest? Contest Title: '"+$(this).attr('data-title')+"'")) deleteContest($(this).attr('data-id'), $(this).attr('data-header'), $(this).attr('data-logo'));
    });
    $(document).on('click', '.edit-contest', function() {
        if(confirm("Are you sure you want to edit this contest? Contest Title: '"+$(this).attr('data-title')+"'")) editContest($(this).attr('data-title'), $(this).find('span#JQDTvalueholder').html());
    });
    
    function deleteContest(id, header, logo){
        $.ajax({
            url: "../REST/manage-contests.php",
            type: 'POST',
            data: {deleteThisContest: 'true', id:id, header:header, logo:logo},
            cache: false,
            success : function(data, status) {
                if(data.status === 1){
                    $("#messageBox, .messageBox").html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>'+data.msg+' </div>');
                    dataTable.ajax.reload();
                }
                else  $("#messageBox, .messageBox").html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>'+data.msg ? data.msg : data+'</div>');
                
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
                $("#messageBox, .messageBox").html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Admin details update failed. '+erroMsg+'</div>');
                $.gritter.add({
                    title: 'Notification!',
                    text: erroMsg
                });
            }
        });
    }
    
    function editContest(name, value){//,
        $('form #addNewContest').val('editContest');
        $('form #multi-action-catAddEdit').text('Update Contest');
        var formVar = {name:name, value:value, name2:name};
        $.each(formVar, function(key, value) {  $('form #'+key).val(value);  });
        CKEDITOR.instances['value'].setData(value);
        $(document).scrollTo('div.panel-info');
    }
    
    function activateContest(id, status){
        var alertType = ["danger", "success", "danger", "error"];
        $.ajax({
            url: "../REST/manage-contests.php",
            type: 'GET',
            data: {activateContest: 'true', id:id, status:status},
            cache: false,
            success : function(data, status) {
                if(data.status === 1 && data.status!=null){
                    $("#messageBox, .messageBox").html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Contest Successfully '+currentStatus+'d!</div>');
                    dataTable.ajax.reload();
                }
                else $("#messageBox, .messageBox").html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Contest Activation Failed. '+data.msg ? data.msg : data+'</div>');
                
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
                $("#messageBox, .messageBox").html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Admin details update failed. '+erroMsg+'</div>');
                $.gritter.add({
                    title: 'Notification!',
                    text: erroMsg
                });
            }
        });
    }
});