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
        var Name = jdata['LastName']+jdata['FirstName'];
        $('#navName').html(Name);
        $('#navheaderName').html(Name);
        $('#UserID').val(jdata['UserID']);
        $('#FirstName').val(jdata['FirstName']);
        $('#LastName').val(jdata['LastName']);
        $('#Phone').val(jdata['Phone']);
        $('#SchoolName').val(jdata['SchoolName']);
        $('#SchoolDepName').val(jdata['SchoolDepName']);
        $('#Chinese').val(jdata['Chinese']);
        $('#ChineseLevel').val(jdata['ChineseLevel']);
        $('#English').val(jdata['English']);
        $('#EnglishLevel').val(jdata['EnglishLevel']);
        $('#Math').val(jdata['Math']);
        $('#MathLevel').val(jdata['MathLevel']);
        $('#ProfessionOne').val(jdata['ProfessionOne']);
        $('#ProfessionOneLevel').val(jdata['ProfessionOneLevel']);
        $('#ProfessionTwo').val(jdata['ProfessionTwo']);
        $('#ProfessionTwoLevel').val(jdata['ProfessionTwoLevel']);
        if(jdata['FirstName']==='' || jdata['FirstName']===null || jdata['LastName']==='' || jdata['LastName']===''||jdata['Phone']===''||jdata['Phone']===null){
            alert('請輸入必填資料，考試類群和成績儲存後將無法進行修改。');
            $('#Type').attr('disabled',null);
            $('#Chinese').attr('readonly',null);
            $('#ChineseLevel').attr('readonly',null);
            $('#English').attr('readonly',null);
            $('#EnglishLevel').attr('readonly',null);
            $('#Math').attr('readonly',null);
            $('#MathLevel').attr('readonly',null);
            $('#ProfessionOne').attr('readonly',null);
            $('#ProfessionOneLevel').attr('readonly',null);
            $('#ProfessionTwo').attr('readonly',null);
            $('#ProfessionTwoLevel').attr('readonly',null);
        }
        sumtotal();
        $('#ChineseLevel').keyup(function(){
            sumtotal();
        });
        $('#EnglishLevel').keyup(function(){
            sumtotal();
        });
        $('#MathLevel').keyup(function(){
            sumtotal();
        });
        $('#ProfessionOneLevel').keyup(function(){
            sumtotal();
        });
        $('#ProfessionTwoLevel').keyup(function(){
            sumtotal();
        });
        sumtotal1();
        $('#Chinese').keyup(function(){
            sumtotal1();
        });
        $('#English').keyup(function(){
            sumtotal1();
        });
        $('#Math').keyup(function(){
            sumtotal1();
        });
        $('#ProfessionOne').keyup(function(){
            sumtotal1();
        });
        $('#ProfessionTwo').keyup(function(){
            sumtotal1();
        });
        var request1 = $.ajax({
            url:'./php/loadtype.php',
            method:'POST',
            data:'',
            datatype:'html'
        });
        request1.done(function(data){
            $('#Type').html(data);
            $('#Type option[value="'+jdata['Type']+'"]').attr('selected','selected');
        });
        request1.fail(function(jqXHR,textStatus){
            alert('伺服器發生錯誤，請詢問相關單位。');
        });
    });
    
    request.fail(function(jqXHR,textStatus){
        alert('伺服器發生錯誤，請詢問相關單位。');
    });
    
    $('#btnsave').click(function(){
        var jdata;
        if($('#FirstName').val()===''){
            alert('請輸入名字。');
            return;
        }
        if($('#LastName').val()===''){
            alert('請輸入姓氏。');
            return;
        }
        if($('#Phone').val()===''){
            alert('請輸入手機。');
            return;
        }
        jdata=$.parseJSON('{"data":{"UserID":"'+$('#UserID').val()+'","Password":"'+$('#Password').val()+'","SchoolName":"'+$('#SchoolName').val()+'","SchoolDepName":"'+$('#SchoolDepName').val()+'","FirstName":"'+$('#FirstName').val()+'","LastName":"'+$('#LastName').val()+'","Phone":"'+$('#Phone').val()+'","Type":"'+$('#Type option:selected').val()+'","Chinese":'+$('#Chinese').val()+',"ChineseLevel":'+$('#ChineseLevel').val()+',"English":'+$('#English').val()+',"EnglishLevel":'+$('#EnglishLevel').val()+',"Math":'+$('#Math').val()+',"MathLevel":'+$('#MathLevel').val()+',"ProfessionOne":'+$('#ProfessionOne').val()+',"ProfessionOneLevel":'+$('#ProfessionOneLevel').val()+',"ProfessionTwo":'+$('#ProfessionTwo').val()+',"ProfessionTwoLevel":'+$('#ProfessionTwoLevel').val()+'}}');
        var request = $.ajax({
            url:'./php/saveuser.php',
            method:'POST',
            data:jdata,
            datatype:'json'
        });
        request.done(function(data){
            if(data==='OK'){
                alert('已儲存。');
                $('#Type').attr('disabled','disabled');
                $('#Chinese').attr('readonly','readonly');
                $('#ChineseLevel').attr('readonly','readonly');
                $('#English').attr('readonly','readonly');
                $('#EnglishLevel').attr('readonly','readonly');
                $('#Math').attr('readonly','readonly');
                $('#MathLevel').attr('readonly','readonly');
                $('#ProfessionOne').attr('readonly','readonly');
                $('#ProfessionOneLevel').attr('readonly','readonly');
                $('#ProfessionTwo').attr('readonly','readonly');
                $('#ProfessionTwoLevel').attr('readonly','readonly');
            }else{
                alert('伺服器發生錯誤，請詢問相關單位。');
            }
        });
        request.fail(function(jqXHR,textStatus){
            alert('伺服器發生錯誤，請詢問相關單位。');
        });
    });
});
function sumtotal(){
    var tt=Number($('#ChineseLevel').val());
    tt+=Number($('#EnglishLevel').val());
    tt+=Number($('#MathLevel').val());
    tt+=Number($('#ProfessionOneLevel').val());
    tt+=Number($('#ProfessionTwoLevel').val());
    $('#Total').val(tt);
}
function sumtotal1(){
    var tt=Number($('#Chinese').val());
    tt+=Number($('#English').val());
    tt+=Number($('#Math').val());
    tt+=Number($('#ProfessionOne').val())*2;
    tt+=Number($('#ProfessionTwo').val())*2;
    $('#Total1').val(tt);
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