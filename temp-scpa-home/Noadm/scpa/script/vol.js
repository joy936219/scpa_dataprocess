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
        $('#English').val(jdata['English']);
        $('#Math').val(jdata['Math']);
        $('#ProfessionOne').val(jdata['ProfessionOne']);
        $('#ProfessionTwo').val(jdata['ProfessionTwo']);
        if(jdata['Type']==='09 商業與管理群'){
            $('#Type').html('<option value="'+jdata['Type']+'">'+jdata['Type']+'</option><option value="21 資管類">21 資管類</option>');
        }else{
            $('#Type').html('<option value="'+jdata['Type']+'">'+jdata['Type']+'</option>');
        }
        $('#Type option[value="'+jdata['Type']+'"]').attr('selected','selected');
        sumtotal1();
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
    });
    
    request.fail(function(jqXHR,textStatus){
        alert('伺服器發生錯誤，請詢問相關單位。');
    });
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

function sumtotal1(){
    var tt=Number($('#Chinese').val());
    tt+=Number($('#English').val());
    tt+=Number($('#Math').val());
    tt+=Number($('#ProfessionOne').val())*2;
    tt+=Number($('#ProfessionTwo').val())*2;
    $('#Total1').val(tt);
}

function startAnalysis() {
    if ($('#Chinese').val() === '' || $('#English').val() === '' || $('#Math').val() === '' || $('#ProfessionOne').val() === '' || $('#ProfessionTwo').val() === '') {
        alert('請輸入所有科目的成績。');
        return;
    }
    if ($('#Type option:selected').val() === '') {
        alert('請選擇考試類群。。');
        return;
    }
    var np=$('[name=schooltype]:checked').val();
    var area=$('#area').val();
    var Chinese = Number($('#Chinese').val());
    var English = Number($('#English').val());
    var Math = Number($('#Math').val());
    var ProfessionOne = Number($('#ProfessionOne').val());
    var ProfessionTwo = Number($('#ProfessionTwo').val());
    var Total1 = Chinese + English + Math + (ProfessionOne*2) + (ProfessionTwo*2);
    var jdata = $.parseJSON('{"Total1":' + Total1 + ',"Type":"' + $('#Type option:selected').val() + '","NP":"'+np+'","Area":"'+area+'"}');
    var request1 = $.ajax({
        url: './php/Analysisscore4.php',
        data: jdata,
        method: 'POST',
        datatype: 'html'
    });
    request1.done(function (data) {
        $('#range1output').html(data);
    });
    request1.fail(function (jqXHR, textStatus) {
        alert('伺服器發生錯誤，請詢問相關單位。');
    });
    var request2 = $.ajax({
        url: './php/Analysisscore5.php',
        data: jdata,
        method: 'POST',
        datatype: 'html'
    });
    request2.done(function (data) {
        $('#range2output').html(data);
    });
    request2.fail(function (jqXHR, textStatus) {
        alert('伺服器發生錯誤，請詢問相關單位。');
    });
    var request3 = $.ajax({
        url: './php/Analysisscore6.php',
        data: jdata,
        method: 'POST',
        datatype: 'html'
    });
    request3.done(function (data) {
        $('#range3output').html(data);
    });
    request3.fail(function (jqXHR, textStatus) {
        alert('伺服器發生錯誤，請詢問相關單位。');
    });
    $('#range2').slideDown();
    $('#range1').slideUp();
    $('#range3').slideUp();
}
function showdetail(type, shool, department) {
    $('#SchoolName').html(shool);
    $('#SchoolDepName').html(department);
    var jdata = $.parseJSON('{"data":{"schoolname":"' + shool + '","schooldepname":"' + department + '","Type":"' + type + '"}}');
    var request = $.ajax({
        url: './php/loadhisscore2.php',
        data: jdata,
        method: 'POST',
        datatype: 'json'
    });
    request.done(function (data1) {
        if(data1==''){
            $('#myChart').html('');
            var line=new Morris.Line({
                element:'myChart',
                resize:true,
                data:[
                    {y:'102年',item1:0},
                    {y:'103年',item1:0},
                    {y:'104年',item1:0},
                    {y:'105年',item1:0}
                ],
                xkey:'y',
                ykeys:['item1'],
                labels:['分數'],
                lineColor:['#3c8dbc'],
                hideHover:'auto',
                ymax:700,
                ymin:0
            });
            ckschdep(type,shool,department);
        }else{
            var sorce = $.parseJSON(data1);
            $('#myChart').html('');
            var line=new Morris.Line({
                element:'myChart',
                resize:true,
                data:[
                    {y:'102年',item1:sorce["5"]},
                    {y:'103年',item1:sorce["4"]},
                    {y:'104年',item1:sorce["3"]},
                    {y:'105年',item1:sorce["2"]}
                ],
                xkey:'y',
                ykeys:['item1'],
                labels:['分數'],
                lineColor:['#3c8dbc'],
                hideHover:'auto',
                ymax:700,
                ymin:0
            });
            ckschdep(type,shool,department);
        }
        
    });
    request.fail(function (jqXHR, textStatus) {
        alert('伺服器發生錯誤，請詢問相關單位。');
    });
}
function ckschdep(type,schoolname,schooldepname) {
    var jdata = $.parseJSON('{"schoolname":"' + schoolname + '","schooldepname":"' + schooldepname + '","Type":"'+type+'"}');
    var request = $.ajax({
        url: './php/ckfav2.php',
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
                    url: './php/insertfav2.php',
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