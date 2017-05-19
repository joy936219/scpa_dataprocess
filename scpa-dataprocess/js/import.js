function check() {

    var msg = "";
    var f = document.FileForm;
    var style = /\.(xls|xlsx)$/i;
    if (!style.test(f.file1.value)) {
        alert('檔案格式不正確');
        //return;
    } else {
        document.FileForm.submit();
    }
}

function Notice() {

}


function filecheck() {
    var v = confirm('資料匯入前，會先將資料庫原資料刪除，才進行匯入，請問是否要匯入?');
    if (!v) {
        event.preventDefault();
    } else {
        $('#submit').addClass('disabled');
        $('.left').html('<div class="overlay"><i class="fa fa-spinner fa-spin"></i></div>');
    }

}

function seesioncheck() {


    $.ajax({
        url: "./php/sessioncheck.php",

        success: function(data) {
            if (data == 'NO') {

                window.location.href = 'http://120.119.80.10/scpa-dataprocess/index.html';
            } else {
                if (window.location.href == 'http://120.119.80.10/scpa-dataprocess/import.html') {
                    document.getElementById("form1").reset();
                }
                //document.getElementById("form1").reset();

                $('#navName').html(data);
                $('#navheaderName').html(data);

            }
        },
        error: function(argument) {
            alert(argument);

        }


    });
}

function logout() {
    $.ajax({
        url: "./php/logout.php",

        success: function(data) {

            window.location.href = 'http://120.119.80.10/scpa-dataprocess/index.html';
        },
        error: function(argument) {
            alert(argument);

        }


    });

    //window.location.href = 'http://120.119.80.10/exceltest/index.html';

}

function FileType() {

    $('#file_name').val(null);
    if ($('select').val() == '組距資料') {

        $('#file_name').attr('multiple', true);

    } else {

        $('#file_name').attr('multiple', false);

    }

}

function loadcontrol() {
    $.ajax({
        url: './php/loadcontrol.php',
        method: 'post',
        success: function(data) {
            for (var i = 0; i < data.length; i++) {
                var s = null;
                if (data[i]['name'] == $('#ctrl1').html().trim()) {
                    switch (data[i]['status']) {
                        case '1':
                            s = 'on';
                            break;
                        case '0':
                            s = 'off';
                            break;
                    }
                    $('#sw').bootstrapToggle(s);
                } else {
                    if (data[i]['name'] == $('#ctrl2').html().trim()) {
                        switch (data[i]['status']) {
                            case '1':
                                s = 'on';
                                break;
                            case '0':
                                s = 'off';
                                break;
                        }
                        $('#sw2').bootstrapToggle(s);
                    }
                }
            }

        },
        error: function(err) {
            alert('發生錯誤');
        }
    });

}

function updatecontrol() {

    var ctrl1 = $('#sw').prop('checked');
    var ctrl2 = $('#sw2').prop('checked');
    var ctrl1_name = $('#ctrl1').html().trim();
    var ctrl2_name = $('#ctrl2').html().trim();

    $('#updatebtn').addClass('disabled');
    //$('.left').html('<div class="overlay"><i class="fa fa-spinner fa-spin"></i></div>');

    $('#updatebtn').text('更新中...');
    $.ajax({
        url: './php/update_control.php',
        method: 'post',
        data: { control1: ctrl1, control2: ctrl2, control1_name: ctrl1_name, control2_name: ctrl2_name },
        success: function(data) {
            if (data == 'OK') {
                alert('更新成功');
                loadcontrol();
                $('#updatebtn').removeClass('disabled');
                $('#updatebtn').text('更新');
            }

        },
        error: function(err) {
            alert('發生錯誤');

        }
    });
}
