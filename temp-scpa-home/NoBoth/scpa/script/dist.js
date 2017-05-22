$(function(){
    var request = $.ajax({
        url:'./php/getuserdata.php',
        method:'POST',
        data:'',
        datatype:'json'
    });
    
    request.done(function(data){
        if(data.includes("error")){
            alert('找不到此帳號。');
            window.location.href='./index.html';
        }
        var jdata = $.parseJSON(data);
        if(jdata['FirstName']==='' || jdata['FirstName']===null || jdata['LastName']==='' || jdata['LastName']===''||jdata['Phone']===''||jdata['Phone']===null){
            //導覽至個人資料
            alert('帳號資料不完整，將引導至個人資料，請完成資料輸入。');
            window.location.href='./home.html';
        }else{
            var Name = jdata['LastName']+jdata['FirstName'];
            $('#navName').html(Name);
            $('#navheaderName').html(Name);
            $('#Type').html(jdata['Type']);
            $("#Year").change(function(){
                var Year=$("#Year").val();
                if(Year==""){
                    $('#output').html("");
                    return;
                }
                var jdata2=$.parseJSON('{"Type":"'+jdata['Type']+'","Year":'+Year+'}');
                var request2=$.ajax({
                    url:'./php/loaddist.php',
                    method:'POST',
                    data:jdata2,
                    datatype:'html'
                });
                request2.done(function(data2){
                    $('#output').html(data2);
                });
                request2.fail(function(jqXHR,textStatus){
                    alert('伺服器發生錯誤，請詢問相關單位。');
                });
            });
        }
    });
    
    request.fail(function(jqXHR,textStatus){
        alert('伺服器發生錯誤，請詢問相關單位。');
    });
});