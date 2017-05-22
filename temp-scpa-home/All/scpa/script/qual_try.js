var table;
$(function(){
    var request = $.ajax({
        url:'./php/getuserdata_try.php',
        method:'POST',
        data:'',
        datatype:'json'
    });
    
    request.done(function(data){
        if(data.includes("error")){
            alert('找不到此帳號。');
            window.location.href='./index_try.html';
        }
        var jdata = $.parseJSON(data);
        if(jdata['FirstName']==='' || jdata['FirstName']===null || jdata['LastName']==='' || jdata['LastName']===''||jdata['Phone']===''||jdata['Phone']===null){
            //導覽至個人資料
            alert('帳號資料不完整，將引導至個人資料，請完成資料輸入。');
            window.location.href='./home_try.html';
        }else{
            var Name = jdata['LastName']+jdata['FirstName'];
            $('#navName').html(Name);
            $('#navheaderName').html(Name);
            if(jdata['Type']==='09 商業與管理群'){
                $('#Type').html('<option value="'+jdata['Type']+'">'+jdata['Type']+'</option><option value="21 資管類">21 資管類</option>');
            }else{
                $('#Type').html('<option value="'+jdata['Type']+'">'+jdata['Type']+'</option>');
            }
            var request3=$.ajax({
                url:'./php/loadarea.php',
                method:'POST',
                data:'',
                datatype:'html'
            });
            request3.done(function(data){
                $('#Area').html(data);
                $('#Area').change(function(){
                    var Area=$('#Area').val();
                    var jdata3=$.parseJSON('{"Area":"'+Area+'"}');
                    var request1 = $.ajax({
                        url:'./php/loadschool.php',
                        method:'POST',
                        data:jdata3,
                        datatype:'html'
                    });
                    request1.done(function(data){
                        $('#SchoolName').html(data);
                        $('#SchoolName').change(function(){
                            var type=$('#Type').val();
                            var jdata2 =$.parseJSON('{"SchoolName":"'+$('#SchoolName').val()+'","Type":"'+type+'"}');
                            var request2 = $.ajax({
                                url:'./php/loadschooldep.php',
                                method:'POST',
                                data:jdata2,
                                datatype:'html'
                            });
                            request2.done(function(data2){
                                $('#SchoolDepName').html(data2);
                                $('#SchoolDepName').change(function(){
                                    $('#ChiWeighted').val('');
                                    $('#EngWeighted').val('');
                                    $('#MathWeighted').val('');
                                    $('#Pro1Weighted').val('');
                                    $('#Pro2Weighted').val('');
                                });
                            });
                            request2.fail(function(jqXHR,textStatus){
                                alert('伺服器發生錯誤，請詢問相關單位。');
                            });
                        });
                    });
                    request1.fail(function(jqXHR,textStatus){
                        alert('伺服器發生錯誤，請詢問相關單位。');
                    });
                });
            });
            request3.fail(function(jqXHR,textStatus){
                alert('伺服器發生錯誤，請詢問相關單位。');
            });
        }
    });
    
    request.fail(function(jqXHR,textStatus){
        alert('伺服器發生錯誤，請詢問相關單位。');
    });
    
    
    table = $('#example2').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false
    });
    $('#ChiWeighted').keypress(function(){
        $('#SchoolName').val('');
        $('#SchoolDepName').html('');
    });
    $('#EngWeighted').keypress(function(){
        $('#SchoolName').val('');
        $('#SchoolDepName').html('');
    });
    $('#MathWeighted').keypress(function(){
        $('#SchoolName').val('');
        $('#SchoolDepName').html('');
    });
    $('#Pro1Weighted').keypress(function(){
        $('#SchoolName').val('');
        $('#SchoolDepName').html('');
    });
    $('#Pro2Weighted').keypress(function(){
        $('#SchoolName').val('');
        $('#SchoolDepName').html('');
    });
});
function search(){
    var SchoolName=$('#SchoolName').val();
    var SchoolDepName=$('#SchoolDepName').val();
    var type=$('#Type').val();
    var Area=$('#Area').val();
    if(SchoolName==null){
        SchoolName='';
    }
    if(SchoolDepName==null){
        SchoolDepName='';
    }
    var jdata1 = $.parseJSON('{"SchoolName":"'+SchoolName+'","SchoolDepName":"'+SchoolDepName+'","Type":"'+type+'","Area":"'+Area+'"}');
    var request1 = $.ajax({
        url:'./php/searchschooldata1.php',
        method:'POST',
        data:jdata1,
        datatype:'html'
    });
    request1.done(function(data1){
        table.destroy();
        $('#output').html(data1);
        table=$('#example2').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false
        });
    });
    request1.fail(function(jqXHR,textStatus){
        alert('伺服器發生錯誤，請詢問相關單位。');
    });
}
function logout(){
    var request = $.ajax({
        url:'./php/logout_try.php',
        method:'POST',
        data:'',
        datatype:'json'
    });
    request.done(function(data){
        window.location.href='./index_try.html';
    });
    request.fail(function(jqXHR,textStatus){
        window.location.href='./index_try.html';
    });
}