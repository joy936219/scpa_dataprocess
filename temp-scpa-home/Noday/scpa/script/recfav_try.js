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
            window.location.href='./home.html';
        }else{
            var Name = jdata['LastName']+jdata['FirstName'];
            $('#navName').html(Name);
            $('#navheaderName').html(Name);
            $('#ChineseLevel').val(jdata['ChineseLevel']);
            $('#EnglishLevel').val(jdata['EnglishLevel']);
            $('#MathLevel').val(jdata['MathLevel']);
            $('#ProfessionOneLevel').val(jdata['ProfessionOneLevel']);
            $('#ProfessionTwoLevel').val(jdata['ProfessionTwoLevel']);
            $('#Type').html('<option value="'+jdata['Type']+'">'+jdata['Type']+'</option>');
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
            reload();
        }
    });
    
    request.fail(function(jqXHR,textStatus){
        alert('伺服器發生錯誤，請詢問相關單位。');
    });
});
function delrecfav(Type,SchoolName,SchoolDepName){
    var re=confirm('是否確定要刪除此筆?\n學校:'+SchoolName+'\n科系:'+SchoolDepName);
    if(re===true){
        var jdata = $.parseJSON('{"Type":"'+Type+'","SchoolName":"'+SchoolName+'","SchoolDepName":"'+SchoolDepName+'"}');
        var request1=$.ajax({
            url:'./php/delrecfav_try.php',
            method:'POST',
            data:jdata,
            datatype:'text'
        });
        request1.done(function(data){
            alert(data);
            reload();
        });
        request1.fail(function(jqXHR,textStatus){
            alert('伺服器發生錯誤，請詢問相關單位。');
        });
    }
}
function reload(){
    var request1=$.ajax({
        url:'./php/loadrecfav_try.php',
        method:'POST',
        data:'',
        datatype:'json'
    });
    request1.done(function(data){
        $('#output').html(data);
    });
    request1.fail(function(jqXHR,textStatus){
        alert('伺服器發生錯誤，請詢問相關單位。');
    });
}
function sumtotal(){
    var tt=Number($('#ChineseLevel').val());
    tt+=Number($('#EnglishLevel').val());
    tt+=Number($('#MathLevel').val());
    tt+=Number($('#ProfessionOneLevel').val());
    tt+=Number($('#ProfessionTwoLevel').val());
    $('#Total').val(tt);
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