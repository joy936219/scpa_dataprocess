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
            
        }
    });
    
    request.fail(function(jqXHR,textStatus){
        alert('伺服器發生錯誤，將回到登入畫面。');
        window.location.href='./index.html';
    });
  var url = decodeURIComponent(window.location.href);
var parameters = url.split('?')[1];
var values = [];
for(var i=0;i<parameters.split('&').length;i++){
    var parameter = parameters.split('&')[i];
    values.push(parameter.split('=')[1]);
}
//values[0]=schoolname
//values[1]=schooldepname
//values[2]=type
if(values[0]!=''&&values[1]!=''&&values[2]!=''&&values[0]!=null&&values[1]!=null&&values[2]!=null){
    var jdata = $.parseJSON('{"SchoolName":"'+values[0]+'","SchoolDepName":"'+values[1]+'","Type":"'+values[2]+'"}');
    var request = $.ajax({
        url:'./php/loadschooldata.php',
        method:'POST',
        data:jdata,
        datatype:'json'
    });
    request.done(function(data){
        if(data==''){
            alert('無簡章資料。');
            return;
        }
        var json = $.parseJSON(data);
        for(var i =0;i<Object.keys(json[0]).length;i++){
            var seletor='.'+Object.keys(json[0])[i];
            switch(Object.keys(json[0])[i]){
                case 'IsOptional':{
                    if(json[0][Object.keys(json[0])[i]]==='1'){
                        $(seletor).html('是');
                    }else{
                        $(seletor).html('否');
                    }
                    break;
                }
                case 'LJQuota':{
                    if($('.LDQuota').html()===''){
                        $('.LDQuota').html('0');
                    }
                    var num = Number($('.LDQuota').html());
                    num+=Number(json[0][Object.keys(json[0])[i]]);
                    $('.LDQuota').html(String(num));
                    break;
                }
                case 'PHQuota':{
                    if($('.LDQuota').html()===''){
                        $('.LDQuota').html('0');
                    }
                    var num = Number($('.LDQuota').html());
                    num+=Number(json[0][Object.keys(json[0])[i]]);
                    $('.LDQuota').html(String(num));
                    break;
                }
                case 'PTQuota':{
                    if($('.LDQuota').html()===''){
                        $('.LDQuota').html('0');
                    }
                    var num = Number($('.LDQuota').html());
                    num+=Number(json[0][Object.keys(json[0])[i]]);
                    $('.LDQuota').html(String(num));
                    break;
                }
                case 'TTQuota':{
                    if($('.LDQuota').html()===''){
                        $('.LDQuota').html('0');
                    }
                    var num = Number($('.LDQuota').html());
                    num+=Number(json[0][Object.keys(json[0])[i]]);
                    $('.LDQuota').html(String(num));
                    break;
                }
                case 'KMQuota':{
                    if($('.LDQuota').html()===''){
                        $('.LDQuota').html('0');
                    }
                    var num = Number($('.LDQuota').html());
                    num+=Number(json[0][Object.keys(json[0])[i]]);
                    $('.LDQuota').html(String(num));
                    break;
                }
                case 'PreparedData1':{
                    if(json[0]["SendData1"]!='' && json[0]["SendData1"]!=null && json[0]["SendData1"]!='--'){
                        if(json[0][Object.keys(json[0])[i]]==='1'){
                            if($('.PreData1').html()===''){
                                $('.PreData1').html(json[0]["SendData1"]);
                            }else{
                                $('.PreData1').html($('.PreData1').html()+'、'+json[0]["SendData1"]);
                            }
                        }else{
                            if(json[0][Object.keys(json[0])[i]]==='0'){
                                if($('.PreData1').html()===''){
                                    $('.PreData2').html(json[0]["SendData1"]);
                                }else{
                                    $('.PreData2').html($('.PreData2').html()+'、'+json[0]["SendData1"]);
                                }
                            }
                        }
                    }
                    break;
                }
                case 'PreparedData2':{
                    if(json[0]["SendData2"]!='' && json[0]["SendData2"]!=null && json[0]["SendData2"]!='--'){
                        if(json[0][Object.keys(json[0])[i]]==='1'){
                            if($('.PreData1').html()===''){
                                $('.PreData1').html(json[0]["SendData2"]);
                            }else{
                                $('.PreData1').html($('.PreData1').html()+'、'+json[0]["SendData2"]);
                            }
                        }else{
                            if(json[0][Object.keys(json[0])[i]]==='0'){
                                if($('.PreData1').html()===''){
                                    $('.PreData2').html(json[0]["SendData2"]);
                                }else{
                                    $('.PreData2').html($('.PreData2').html()+'、'+json[0]["SendData2"]);
                                }
                            }
                        }
                    }
                    break;
                }
                case 'PreparedData3':{
                    if(json[0]["SendData3"]!='' && json[0]["SendData3"]!=null && json[0]["SendData3"]!='--'){
                        if(json[0][Object.keys(json[0])[i]]==='1'){
                            if($('.PreData1').html()===''){
                                $('.PreData1').html(json[0]["SendData3"]);
                            }else{
                                $('.PreData1').html($('.PreData1').html()+'、'+json[0]["SendData3"]);
                            }
                        }else{
                            if(json[0][Object.keys(json[0])[i]]==='0'){
                                if($('.PreData1').html()===''){
                                    $('.PreData2').html(json[0]["SendData3"]);
                                }else{
                                    $('.PreData2').html($('.PreData2').html()+'、'+json[0]["SendData3"]);
                                }
                            }
                        }
                    }
                    break;
                }
                case 'PreparedData4':{
                    if(json[0]["SendData4"]!='' && json[0]["SendData4"]!=null && json[0]["SendData4"]!='--'){
                        if(json[0][Object.keys(json[0])[i]]==='1'){
                            
                            if($('.PreData1').html()===''){
                                $('.PreData1').html(json[0]["SendData4"]);
                            }else{
                                $('.PreData1').html($('.PreData1').html()+'、'+json[0]["SendData4"]);
                            }
                        }else{
                            if(json[0][Object.keys(json[0])[i]]==='0'){
                                if($('.PreData1').html()===''){
                                    $('.PreData2').html(json[0]["SendData4"]);
                                }else{
                                    $('.PreData2').html($('.PreData2').html()+'、'+json[0]["SendData4"]);
                                }
                            }
                        }
                    }
                    break;
                }
                case 'PreparedData5':{
                    if(json[0]["SendData5"]!='' && json[0]["SendData5"]!=null && json[0]["SendData5"]!='--'){
                        if(json[0][Object.keys(json[0])[i]]==='1'){
                            if($('.PreData1').html()===''){
                                $('.PreData1').html(json[0]["SendData5"]);
                            }else{
                                $('.PreData1').html($('.PreData1').html()+'、'+json[0]["SendData5"]);
                            }
                        }else{
                            if(json[0][Object.keys(json[0])[i]]==='0'){
                                if($('.PreData1').html()===''){
                                    $('.PreData2').html(json[0]["SendData5"]);
                                }else{
                                    $('.PreData2').html($('.PreData2').html()+'、'+json[0]["SendData5"]);
                                }
                            }
                        }
                    }
                    break;
                }
                case 'PreparedData6':{
                    if(json[0]["SendData6"]!='' && json[0]["SendData6"]!=null && json[0]["SendData6"]!='--'){
                        if(json[0][Object.keys(json[0])[i]]==='1'){
                            if($('.PreData1').html()===''){
                                $('.PreData1').html(json[0]["SendData6"]);
                            }else{
                                $('.PreData1').html($('.PreData1').html()+'、'+json[0]["SendData6"]);
                            }
                        }else{
                            if(json[0][Object.keys(json[0])[i]]==='0'){
                                if($('.PreData1').html()===''){
                                    $('.PreData2').html(json[0]["SendData6"]);
                                }else{
                                    $('.PreData2').html($('.PreData2').html()+'、'+json[0]["SendData6"]);
                                }
                            }
                        }
                    }
                    break;
                }
                case 'TestDate':{
                    if(json[0][Object.keys(json[0])[i]]!='0000-00-00'){
                        var days = ['日','一','二','三','四','五','六'];
                        var d = new Date(json[0][Object.keys(json[0])[i]]);
                        var date = String(d.getFullYear())+' 年 '+String(d.getMonth()+1)+' 月 '+String(d.getDate())+' 日 ('+days[d.getDay()]+') ';
                        $(seletor).html(date);
                    }
                    break;
                }
                case 'ChiMagnification':{
                    $(seletor).html(formatNum(json[0][Object.keys(json[0])[i]],2));
                    break;
                }
                case 'EngMagnification':{
                    $(seletor).html(formatNum(json[0][Object.keys(json[0])[i]],2));
                    break;
                }
                case 'MathMagnification':{
                    $(seletor).html(formatNum(json[0][Object.keys(json[0])[i]],2));
                    break;
                }
                case 'Pro1Magnification':{
                    $(seletor).html(formatNum(json[0][Object.keys(json[0])[i]],2));
                    break;
                }
                case 'Pro2Magnification':{
                    $(seletor).html(formatNum(json[0][Object.keys(json[0])[i]],2));
                    break;
                }
                case 'TotalMagnification':{
                    $(seletor).html(formatNum(json[0][Object.keys(json[0])[i]],2));
                    break;
                }
                case 'ChiWeighted':{
                    $(seletor).html(formatNum(json[0][Object.keys(json[0])[i]],2));
                    break;
                }
                case 'EngWeighted':{
                    $(seletor).html(formatNum(json[0][Object.keys(json[0])[i]],2));
                    break;
                }
                case 'MathWeighted':{
                    $(seletor).html(formatNum(json[0][Object.keys(json[0])[i]],2));
                    break;
                }
                case 'Pro1Weighted':{
                    $(seletor).html(formatNum(json[0][Object.keys(json[0])[i]],2));
                    break;
                }
                case 'Pro2Weighted':{
                    $(seletor).html(formatNum(json[0][Object.keys(json[0])[i]],2));
                    break;
                }
                case 'Totalprop':{
                    $(seletor).html(formatNum(json[0][Object.keys(json[0])[i]],0));
                    break;
                }
                case 'Specify1LowScores':{
                    $(seletor).html(formatNum(json[0][Object.keys(json[0])[i]],0));
                    break;
                }
                case 'Specify2LowScores':{
                    $(seletor).html(formatNum(json[0][Object.keys(json[0])[i]],0));
                    break;
                }
                case 'Specify3LowScores':{
                    $(seletor).html(formatNum(json[0][Object.keys(json[0])[i]],0));
                    break;
                }
                case 'Specify4LowScores':{
                    $(seletor).html(formatNum(json[0][Object.keys(json[0])[i]],0));
                    break;
                }
                case 'Specify5LowScores':{
                    $(seletor).html(formatNum(json[0][Object.keys(json[0])[i]],0));
                    break;
                }
                case 'Specify1prop':{
                    if(formatNum(json[0][Object.keys(json[0])[i]],0)==='--')
                    {
                        $(seletor).html(formatNum(json[0][Object.keys(json[0])[i]],0));
                    }else{
                        $(seletor).html(formatNum(json[0][Object.keys(json[0])[i]],0)+'%');
                    }
                    break;
                }
                case 'Specify2prop':{
                    if(formatNum(json[0][Object.keys(json[0])[i]],0)==='--')
                    {
                        $(seletor).html(formatNum(json[0][Object.keys(json[0])[i]],0));
                    }else{
                        $(seletor).html(formatNum(json[0][Object.keys(json[0])[i]],0)+'%');
                    }
                    break;
                }
                case 'Specify3prop':{
                    if(formatNum(json[0][Object.keys(json[0])[i]],0)==='--')
                    {
                        $(seletor).html(formatNum(json[0][Object.keys(json[0])[i]],0));
                    }else{
                        $(seletor).html(formatNum(json[0][Object.keys(json[0])[i]],0)+'%');
                    }
                    break;
                }
                case 'Specify4prop':{
                    if(formatNum(json[0][Object.keys(json[0])[i]],0)==='--')
                    {
                        $(seletor).html(formatNum(json[0][Object.keys(json[0])[i]],0));
                    }else{
                        $(seletor).html(formatNum(json[0][Object.keys(json[0])[i]],0)+'%');
                    }
                    break;
                }
                case 'Specify5prop':{
                    if(formatNum(json[0][Object.keys(json[0])[i]],0)==='--')
                    {
                        $(seletor).html(formatNum(json[0][Object.keys(json[0])[i]],0));
                    }else{
                        $(seletor).html(formatNum(json[0][Object.keys(json[0])[i]],0)+'%');
                    }
                    break;
                }
                case 'ProjCharge':{
                    if(formatNum(json[0][Object.keys(json[0])[i]],0)==='--')
                    {
                        $(seletor).html(formatNum(json[0][Object.keys(json[0])[i]],0));
                    }else{
                        $(seletor).html(formatNum(json[0][Object.keys(json[0])[i]],0)+'元');
                    }
                    break;
                }
                case 'SchoolScoresProp':{
                    if(formatNum(json[0][Object.keys(json[0])[i]],0)==='--')
                    {
                        $(seletor).html('不予<br>採計');
                    }else{
                        $(seletor).html(formatNum(json[0][Object.keys(json[0])[i]],0)+'%');
                    }
                    break;
                }
                case 'LicensesAdd':{
                    if(formatNum(json[0][Object.keys(json[0])[i]],0)==='--')
                    {
                        $(seletor).html('不予<br>加分');
                    }else{
                        $(seletor).html('依加分<br>標準');
                    }
                    break;
                }
                case 'CheckInDate':{
                    var days = ['日','一','二','三','四','五','六'];
                    if(json[0][Object.keys(json[0])[i]]!='0000-00-00'){
                        var d = new Date(json[0][Object.keys(json[0])[i]]);
                        var date = String(d.getFullYear())+' 年 '+String(d.getUTCMonth()+1)+' 月 '+String(d.getDate())+' 日 ('+days[d.getDay()]+') 17 時前';
                        $(seletor).html(date);
                    }
                    break;
                }
                default:{
                    if(json[0][Object.keys(json[0])[i]]!=='' && json[0][Object.keys(json[0])[i]]!=null){
                        $(seletor).html(json[0][Object.keys(json[0])[i]]);
                    }else{
                        $(seletor).html('--');
                    }
                    break;
                }       
            }
        }
    });
}else{
    window.location.href='./index.html';
}
});
function formatNum(num_str,decimal){
    if(num_str!='0'&&num_str!=''&&num_str!=null){
        var num = Number(num_str);
        return num.toFixed(decimal);
    }else{
        return '--';
    }
}
//[
//	{
//		"SchoolID": "721",
//		"SchoolName": "國立臺灣藝術大學",
//		"DepType": "1",
//		"SchoolDepID": "721002",
//		"SchoolDepName": "圖文傳播藝術學系",
//		"Type": "21 資管類",
//		"GeneralQuota": "1",
//		"AborQuota": "0",
//		"LJQuota": "0",
//		"PHQuota": "0",
//		"PTQuota": "0",
//		"TTQuota": "0",
//		"KMQuota": "0",
//		"ExpGeneralQuota": "3",
//		"ExpAborQuota": "0",
//		"PreparedData1": "1",
//		"SendData1": "自傳及讀書計畫",
//		"PreparedData2": "1",
//		"SendData2": "其他有利審查文件",
//		"PreparedData3": "0",
//		"SendData3": "",
//		"PreparedData4": "0",
//		"SendData4": "",
//		"PreparedData5": "0",
//		"SendData5": "",
//		"PreparedData6": "0",
//		"SendData6": "",
//		"UploadDataExp": "1.自傳（至少800字）及讀書計畫（1500字以內）\n2.其他有利審查文件（例：幹部服務、社團表現、作品集、競賽成果、專題報告...等）",
//		"SpecialCondition": "不要求",
//		"ReferCondition": "肢障、視障或聽障嚴重者，於參與實作課程或工廠實習時，易遭遇學習困難，欲就讀者，請詳加考慮。",
//		"ChiMagnification": "0",
//		"EngMagnification": "0",
//		"MathMagnification": "0",
//		"Pro1Magnification": "0",
//		"Pro2Magnification": "0",
//		"TotalMagnification": "3",
//		"ChiWeighted": "1",
//		"EngWeighted": "1",
//		"MathWeighted": "1",
//		"Pro1Weighted": "2",
//		"Pro2Weighted": "2",
//		"Totalprop": "50",
//		"Specify1Proj": "面試",
//		"Specify1LowScores": "70",
//		"Specify1prop": "30",
//		"Specify2Proj": "備審資料審查",
//		"Specify2LowScores": "70",
//		"Specify2prop": "20",
//		"Specify3Proj": "",
//		"Specify3LowScores": "0",
//		"Specify3prop": "0",
//		"Specify4Proj": "",
//		"Specify4LowScores": "0",
//		"Specify4prop": "0",
//		"Specify5Proj": "",
//		"Specify5LowScores": "0",
//		"Specify5prop": "0",
//		"ProjCharge": "750",
//		"ProjCount": "2",
//		"SchoolScoresProp": "0",
//		"LicensesAdd": "1",
//		"SpecifyProExp": "",
//		"SameScoresRefer1": "指定項目1",
//		"SameScoresRefer2": "指定項目2",
//		"SameScoresRefer3": "統測科目英文",
//		"SameScoresRefer4": "統測科目數學",
//		"SameScoresRefer5": "統測總級分",
//		"SameScoresRefer6": "--",
//		"SameScoresReferCount": "5",
//		"UpdateLoadDate": "2017-06-09",
//		"SendRetestDate": "2017-06-13",
//		"TestDate": "2017",
//		"TestTotalDate": "2017-07-04",
//		"TestRecheckDate": "2017-07-05",
//		"IstakenDate": "2017-07-06",
//		"IstakenRecheckDate": "2017-07-06",
//		"CheckInDate": "2017-07-17",
//		"Memo": "分發錄取生應於106年7月17日17時前完成報到手續。",
//		"IsOptional": "0",
//		"IsMeets": "1"
//	}
//]