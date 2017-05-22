$(function(){
    $('html').keydown(function(evt){
        if(evt.which===13){
            login();
        }
    });
});
function login() {
    var user=$('#user').val();
    var password=$('#password').val();
    var hash;
    if(user===''){
        alert('請輸入帳號。');
    }else{
        if(password===''){
            alert('請輸入密碼。');
        }else{
            var hashObj = new jsSHA('SHA-1','TEXT',{numRounds: 1});
            hashObj.update(password);
            hash=hashObj.getHash('HEX');
            var jdata = $.parseJSON('{"user":"'+user+'","password":"'+hash+'"}');
            var request = $.ajax({
                url:'./php/login.php',
                method:'POST',
                data:jdata,
                dataType:"text"
            });
                
            request.done(function(msg){
                if(msg.includes('Error')){
                    alert('帳號或密碼錯誤。');
                }else{
                    if(msg.includes('Login')){
                        window.location.href='./home.html';
                    }else{
                        alert('伺服器發生錯誤，請詢問相關單位。');
                    }
                }
            });
            
            request.fail(function(jqXHR, textStatus){
                alert('伺服器發生錯誤，請詢問相關單位。');
            });
        }
    }
}
