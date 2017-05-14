function check(){

   var msg = "";
   var f = document.FileForm;
   var style = /\.(xls|xlsx)$/i; 
   if(!style.test(f.file1.value)){
   	  alert('檔案格式不正確');
   	  //return;
   }
   else{
   	  document.FileForm.submit();  
   }
}

function Notice(){
    
}
function filecheck(){
    //return confirm('資料匯入前，會先將資料庫原資料刪除，才進行匯入，請問是否要匯入?'); 
    //$('.left').val('loading....');
}
function seesioncheck(){
   

    $.ajax({
        url:"./php/sessioncheck.php",
               
        success:function(data){
           if(data == 'NO'){
               
               window.location.href = 'http://120.119.80.10/scpa-dataprocess/index.html';
           }
           else{

           }
        },
        error:function (argument) {
           alert(argument);

        }


    });
}
function logout(){
   $.ajax({
        url:"./php/logout.php",
               
        success:function(data){
                
               window.location.href = 'http://120.119.80.10/scpa-dataprocess/index.html';         
        },
        error:function (argument) {
           alert(argument);

        }


    });

   //window.location.href = 'http://120.119.80.10/exceltest/index.html';

}
function FileType(){

       $('#file_name').val(null);
       if($('select').val()=='組距資料'){
            
            $('#file_name').attr('multiple',true);
            
       }
       else{
            
            $('#file_name').attr('multiple',false);
            
       }
   
}