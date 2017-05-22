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
            $('#ChineseLevel').val(jdata['ChineseLevel']);
            $('#EnglishLevel').val(jdata['EnglishLevel']);
            $('#MathLevel').val(jdata['MathLevel']);
            $('#ProfessionOneLevel').val(jdata['ProfessionOneLevel']);
            $('#ProfessionTwoLevel').val(jdata['ProfessionTwoLevel']);
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
            if(jdata['Type']==='09 商業與管理群'){
                $('#Type').html('<option value="'+jdata['Type']+'">'+jdata['Type']+'</option><option value="21 資管類">21 資管類</option>');
            }else{
                $('#Type').html('<option value="'+jdata['Type']+'">'+jdata['Type']+'</option>');
            }
            $('#Type option[value="'+jdata['Type']+'"]').attr('selected','selected');
            var request1=$.ajax({
                url:'./php/loadarea.php',
                method:'POST',
                data:'',
                datatype:'html'
            });
            request1.done(function(data){
                $('#area').html(data);
            });
            request1.fail(function(jqXHR,textStatus){
                alert('伺服器發生錯誤，請詢問相關單位。');
            });
        }
    });
    
    request.fail(function(jqXHR,textStatus){
        alert('伺服器發生錯誤，請詢問相關單位。');
    });
    $('#range1').hide();
    $('#range2').hide();
    $('#range3').hide();
    $('#btnrange1').click(function(){
        $('#range1').slideToggle();
        $('#range2').slideUp();
        $('#range3').slideUp();
    });
    $('#btnrange2').click(function(){
        $('#range2').slideToggle();
        $('#range1').slideUp();
        $('#range3').slideUp();
    });
    $('#btnrange3').click(function(){
        $('#range3').slideToggle();
        $('#range1').slideUp();
        $('#range2').slideUp();
    });
});
function startAnalysis() {
    var np=$('[name=schooltype]:checked').val();
    var area=$('#area').val();
    var ChineseLevel = Number($('#ChineseLevel').val());
    var EnglishLevel = Number($('#EnglishLevel').val());
    var MathLevel = Number($('#MathLevel').val());
    var ProfessionOneLevel = Number($('#ProfessionOneLevel').val());
    var ProfessionTwoLevel = Number($('#ProfessionTwoLevel').val());
    var Level = ChineseLevel + EnglishLevel + MathLevel + ProfessionOneLevel + ProfessionTwoLevel;
    var jdata = $.parseJSON('{"Level":' + Level + ',"Type":"' + $('#Type option:selected').val() + '","NP":"'+np+'","Area":"'+area+'"}');
    var trydata='<tr><td colspan=9 style="text-align:center;">請購買正式版</td></tr>';
    
    var request2 = $.ajax({
        url: './php/Analysisscore3.php',
        data: jdata,
        method: 'POST',
        datatype: 'html'
    });
    request2.done(function (data) {
        $('#range3output').html(data);
    });
    request2.fail(function (jqXHR, textStatus) {
        alert('伺服器發生錯誤，請詢問相關單位。');
    });
    $('#range1output').html(trydata);
    $('#range2output').html(trydata);
    $('#range3').slideDown();
    $('#range2').slideUp();
    $('#range1').slideUp();
}
function showdetail(type, shool, department) {
    $('#SchoolName').html(shool);
    $('#SchoolDepName').html(department);
    $('#conter').show();
    var jdata = $.parseJSON('{"data":{"schoolname":"' + shool + '","schooldepname":"' + department + '","Type":"' + type + '"}}');
    var request = $.ajax({
        url: './php/loadhisscore.php',
        data: jdata,
        method: 'POST',
        datatype: 'json'
    });
    request.done(function (data1) {
        if(data1==''){
            $('#myChart').html('');
            var sorce = $.parseJSON(data1);
            var line=new Morris.Line({
                element:'myChart',
                resize:true,
                data:[
                    {y:'102年',item1:0},
                    {y:'103年',item1:0},
                    {y:'104年',item1:0},
                    {y:'105年',item1:0},
                    {y:'106年(預估)',item1:0}
                ],
                xkey:'y',
                ykeys:['item1'],
                labels:['分數'],
                lineColor:['#3c8dbc'],
                hideHover:'auto',
                ymax:100,
                ymin:0
            });
            ckschdep(type,shool, department);
        }else{
            $('#myChart').html('');
            var sorce = $.parseJSON(data1);
            var line=new Morris.Line({
                element:'myChart',
                resize:true,
                data:[
                    {y:'102年',item1:sorce["5"]},
                    {y:'103年',item1:sorce["4"]},
                    {y:'104年',item1:sorce["3"]},
                    {y:'105年',item1:sorce["2"]},
                    {y:'106年(預估)',item1:sorce["1"]}
                ],
                xkey:'y',
                ykeys:['item1'],
                labels:['分數'],
                lineColor:['#3c8dbc'],
                hideHover:'auto',
                ymax:100,
                ymin:0
            });
            ckschdep(type,shool, department);
        }
    });
    request.fail(function (jqXHR, textStatus) {
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
    var tt1=Number($('#Chinese').val());
    tt1+=Number($('#English').val());
    tt1+=Number($('#Math').val());
    tt1+=Number($('#ProfessionOne').val())*2;
    tt1+=Number($('#ProfessionTwo').val())*2;
    $('#Total2').val(tt1);
}
function ckschdep(type,schoolname, schooldepname) {
    var jdata = $.parseJSON('{"schoolname":"' + schoolname + '","schooldepname":"' + schooldepname + '","Type":"'+type+'"}');
    var request = $.ajax({
        url: './php/ckfav_try.php',
        data: jdata,
        method: 'POST',
        datatype: 'json'
    });
    request.done(function (data) {
        $('#fav').html(data);
        $('#btnfav').click(function () {
            if ($('#btnfav').text() === "加入我的最愛") {
                var schoolname=$('#SchoolName').text();
                var schooldepname=$('#SchoolDepName').text();
                var jdata = $.parseJSON('{"schoolname":"' + schoolname + '","schooldepname":"' + schooldepname + '","Type":"'+type+'"}');
                var request1 = $.ajax({
                    url: './php/insertfav_try.php',
                    data: jdata,
                    method: 'POST',
                    datatype: 'text'
                });
                request1.done(function (data) {
                    alert(data);
                    ckschdep(type,schoolname,schooldepname);
                });
                request1.fail(function (jqXHR, textStatus) {
                    alert('伺服器發生錯誤，請詢問相關單位。');
                });
            }else{
            }
        });
    });
    request.fail(function () {
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