function updatecontrol(){
	
	var ctrl1 = $('#sw').prop('checked');
	var ctrl2 = $('#sw2').prop('checked');
	var ctrl1_name = $('#ctrl1').html().trim(); 
	var ctrl2_name = $('#ctrl2').html().trim(); 
    
	$.ajax({
		url:'./php/control.php',
		method:'post',
		data:{control1:ctrl1 , control2:ctrl1 , control1_name:ctrl1_name , control2_name : ctrl2_name},
		success:function(data){
           alert('test');
		},
		error:function(err){
			alert('failed');

		}
	});
}

