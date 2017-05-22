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
            $('#Chinese').val(jdata['Chinese']);
            $('#English').val(jdata['English']);
            $('#Math').val(jdata['Math']);
            $('#ProfessionOne').val(jdata['ProfessionOne']);
            $('#ProfessionTwo').val(jdata['ProfessionTwo']);
            $('#Type').html('<option value="'+jdata['Type']+'">'+jdata['Type']+'</option>');
            sumtotal();
            $('#Chinese').keyup(function(){
                sumtotal();
            });
            $('#English').keyup(function(){
                sumtotal();
            });
            $('#Math').keyup(function(){
                sumtotal();
            });
            $('#ProfessionOne').keyup(function(){
                sumtotal();
            });
            $('#ProfessionTwo').keyup(function(){
                sumtotal();
            });
            reload();
        }
    });
    
    request.fail(function(jqXHR,textStatus){
        alert('伺服器發生錯誤，請詢問相關單位。');
    });
    
    $('#btnup').click(function(){
        if($('#btnup').hasClass('disabled') || $('#btndown').hasClass('disabled')){
            return;
        }
        if($('[name=order]:checked').length>0){
            $('#btnup').addClass('disabled');
            $('#btndown').addClass('disabled');
            var td=$($($('[name=order]:checked')[0]).parent()[0]);
            var tr=$(td).parent()[0];
            var OrderID=$($(tr).children()[1]).html();//排名
            if(parseInt(OrderID)==1){
                alert("已經是第一個。");
                $('#btnup').removeClass('disabled');
                $('#btndown').removeClass('disabled');
                return;
            }
            var SchoolName=$($(tr).children()[2]).html();//學校
            var SchoolDepName=$($(tr).children()[3]).html();//系別
            var Type=$('#Type').val();
            var jdata=$.parseJSON('{"Order":"up","OrderID":'+OrderID+',"SchoolName":"'+SchoolName+'","SchoolDepName":"'+SchoolDepName+'","Type":"'+Type+'"}');
            var request1 = $.ajax({
                url:'./php/orderdistfav.php',
                method:'POST',
                data:jdata,
                datatype:'json'
            });
            request1.done(function(data){
                $('#btnup').removeClass('disabled');
                $('#btndown').removeClass('disabled');
                $('#output').html(data);
                $('#output input[name=order]').click(function(e){
                    $('#output tr').removeClass('select');
                    $($($(e.currentTarget).parent()[0]).parent()[0]).addClass('select');
                });
            });
            request1.fail(function(jqXHR,textStatus){
                $('#btnup').removeClass('disabled');
                $('#btndown').removeClass('disabled');
                alert('伺服器發生錯誤，請詢問相關單位。');
            });
        }else{
            alert('請選擇要排序的項目。');
        }
    });
    
    $('#btndown').click(function(){
        if($('#btnup').hasClass('disabled') || $('#btndown').hasClass('disabled')){
            return;
        }
        if($('[name=order]:checked').length>0){
            $('#btnup').addClass('disabled');
            $('#btndown').addClass('disabled');
            var td=$($($('[name=order]:checked')[0]).parent()[0]);
            var tr=$(td).parent()[0];
            var OrderID=$($(tr).children()[1]).html();//排名
            var tb=$(tr).parent()[0];
            if(parseInt(OrderID)==$(tb).children().length){
                alert("已經是最後一個。");
                $('#btnup').removeClass('disabled');
                $('#btndown').removeClass('disabled');
                return;
            }
            var SchoolName=$($(tr).children()[2]).html();//學校
            var SchoolDepName=$($(tr).children()[3]).html();//系別
            var Type=$('#Type').val();
            var jdata=$.parseJSON('{"Order":"down","OrderID":'+OrderID+',"SchoolName":"'+SchoolName+'","SchoolDepName":"'+SchoolDepName+'","Type":"'+Type+'"}');
            var request1 = $.ajax({
                url:'./php/orderdistfav.php',
                method:'POST',
                data:jdata,
                datatype:'html'
            });
            request1.done(function(data){
                $('#btnup').removeClass('disabled');
                $('#btndown').removeClass('disabled');
                $('#output').html(data);
                $('#output input[name=order]').click(function(e){
                    $('#output tr').removeClass('select');
                    $($($(e.currentTarget).parent()[0]).parent()[0]).addClass('select');
                });
            });
            request1.fail(function(jqXHR,textStatus){
                $('#btnup').removeClass('disabled');
                $('#btndown').removeClass('disabled');
                alert('伺服器發生錯誤，請詢問相關單位。');
            });
        }else{
            alert('請選擇要排序的項目。');
        }
    });
});
function delvolfav(Type,SchoolName,SchoolDepName,OrderID){
    var re=confirm('是否確定要刪除此筆?\n學校:'+SchoolName+'\n科系:'+SchoolDepName);
    if(re===true){
        var jdata = $.parseJSON('{"Type":"'+Type+'","SchoolName":"'+SchoolName+'","SchoolDepName":"'+SchoolDepName+'","OrderID":'+OrderID+'}');
        var request1=$.ajax({
            url:'./php/deldistfav.php',
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
        url:'./php/loaddistfav.php',
        method:'POST',
        data:'',
        datatype:'json'
    });
    request1.done(function(data){
        $('#output').html(data);
        $('#output input[name=order]').click(function(e){
            $('#output tr').removeClass('select');
            $($($(e.currentTarget).parent()[0]).parent()[0]).addClass('select');
        });
    });
    request1.fail(function(jqXHR,textStatus){
        alert('伺服器發生錯誤，請詢問相關單位。');
    });
}
function sumtotal(){
    var tt=Number($('#Chinese').val());
    tt+=Number($('#English').val());
    tt+=Number($('#Math').val());
    tt+=Number($('#ProfessionOne').val())*2;
    tt+=Number($('#ProfessionTwo').val())*2;
    $('#Total').val(tt);
}
function printScreen() 
{
    window.open("print.html");
}
function logout(){
    var request = $.ajax({
        url:'./php/logout.php',
        method:'POST',
        data:'',
        datatype:'json'
    });
    request.done(function(data){
        window.location.href='./index.html';
    });
    request.fail(function(jqXHR,textStatus){
        window.location.href='./index.html';
    });
}