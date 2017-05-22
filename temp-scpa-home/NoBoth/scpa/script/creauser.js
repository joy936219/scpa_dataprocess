$(function(){
    $("button[type=submit]").click(function(){
        var hash;
        var UserID=$('#UserID').val();
        var LastName=$('#LastName').val();
        var FirstName=$('#FirstName').val();
        var Password=$('#Password').val();
        var ckPassword=$('#ckPassword').val();
        if(UserID==""||
          LastName==""||
          FirstName==""||
          Password==""||
          ckPassword==""){
            alert("請確認輸入所有資料。");
            return;
        }
        if(Password!=ckPassword){
            alert("請確認密碼是否相符。");
            $($('#Password').parent()[0]).addClass('has-error');
            $($('#ckPassword').parent()[0]).addClass('has-error');
            return;
        }
        $($('#Password').parent()[0]).removeClass('has-error');
        $($('#ckPassword').parent()[0]).removeClass('has-error');
        var hashObj = new jsSHA('SHA-1','TEXT',{numRounds: 1});
            hashObj.update(Password);
            hash=hashObj.getHash('HEX');
        var jdata1=$.parseJSON('{"UserID":"'+UserID+'","LastName":"'+LastName+'","FirstName":"'+FirstName+'","Password":"'+hash+'"}');
        var request1=$.ajax({
            url:'php/creauser.php',
            data:jdata1,
            method:'POST',
            datatype:'text'
        });
        request1.done(function(data){
            if(data.includes("hasuser")){
                alert('此帳號已申請。');
                $($('#UserID').parent()[0]).addClass('has-error');
            }else{
                if(data.includes("error")){
                    alert('伺服器發生錯誤，請詢問相關單位。');
                    $($('#UserID').parent()[0]).removeClass('has-error');
                }else{
                    if(data.includes("OK")){
                        $($('#UserID').parent()[0]).removeClass('has-error');
                        alert('申請成功。');
                        window.location.href="index_try.html";
                    }
                }
            }
        });
        request1.fail(function (jqXHR, textStatus) {
            alert('伺服器發生錯誤，請詢問相關單位。');
        });
    });
    $('.register-box-body .btn-danger').click(function(){
        window.location.href="index_try.html";
    });
    $('.register-box-body .btn-warning').click(function(){
        $('#UserID').val('');
        $('#LastName').val('');
        $('#FirstName').val('');
        $('#Password').val('');
        $('#ckPassword').val('');
    });
});