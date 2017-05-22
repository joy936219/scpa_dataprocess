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
        }
    });
    
    request.fail(function(jqXHR,textStatus){
        alert('伺服器發生錯誤，請詢問相關單位。');
    });
    
    $('#btnsave').click(function(){
        var jdata;
        var password;
        var newpassword;
        var ckpassword;
        var passwordhash;
        var newpasswordhash;
        
        password=$('#Password').val();
        newpassword=$('#newPassword').val();
        ckpassword=$('#ckPassword').val();
        if(password===''){
            alert('請輸入舊密碼。');
            return;
        }
        if(newpassword===''){
            alert('請輸入新密碼。');
            return;
        }
        if(ckpassword===''){
            alert('請再輸入一次新密碼。');
            return;
        }
        if(newpassword!=ckpassword){
            alert('密碼不一致。');
            return;
        }
        var hashObj1 = new jsSHA('SHA-1','TEXT',{numRounds: 1});
        hashObj1.update(password);
        passwordhash=hashObj1.getHash('HEX');
        var hashObj2 = new jsSHA('SHA-1','TEXT',{numRounds: 1});
        hashObj2.update(newpassword);
        newpasswordhash=hashObj2.getHash('HEX');
        jdata=$.parseJSON('{"Password":"'+passwordhash+'","newPassword":"'+newpasswordhash+'"}');
        var request = $.ajax({
            url:'./php/changepw_try.php',
            method:'POST',
            data:jdata,
            datatype:'json'
        });
        request.done(function(data){
            if(data.includes('OK')){
                alert('密碼已變更，下次登入請使用新密碼。');
                window.location.href='./home_try.html';
            }else{
                if(data.includes('NO')){
                    alert('請確認舊密碼是否正確。');
                }else{
                    alert('伺服器發生錯誤，請詢問相關單位。');
                }
            }
        });
        request.fail(function(jqXHR,textStatus){
            alert('伺服器發生錯誤，請詢問相關單位。');
        });
    });
});
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