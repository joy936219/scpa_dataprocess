<?php
include('conn.php');

$control1_status = $_POST['control1'];
$control2_status = $_POST['control2'];

$control1_name = $_POST['control1_name'];
$control2_name = $_POST['control2_name'];

$update_query1 = "update control set status =$control1_status where name ='$control1_name'";
$update_query2 = "update control set status =$control2_status where name ='$control2_name'";

mysqli_query($conn,$update_query1);
mysqli_query($conn,$update_query2);

mysqli_close($conn);

if($control1_status == 'true' && $control2_status == 'true'){
	$files = glob('../../scpa/*'); // get all file names
	foreach($files as $file){ // iterate files
  		if(is_file($file))
    		unlink($file); // delete file
	}
	smartCopy('../../temp-scpa-home/All/scpa','../../scpa');
	
	
}
else{
	if($control1_status == 'false' && $control2_status == 'true'){
        $files = glob('../../scpa/*'); // get all file names
		foreach($files as $file){ // iterate files
  			if(is_file($file))
    			unlink($file); // delete file
		}
		smartCopy('../../temp-scpa-home/Noadm/scpa', '../../scpa');
		
       
		//copy('../../temp-scpa-home/Noadm/test.xlsx','../../scpa/test.xlsx');

	}
	else{
		if($control1_status == 'true' && $control2_status == 'false'){
            $files = glob('../../scpa/*'); // get all file names
			foreach($files as $file){ // iterate files
  			if(is_file($file))
    			unlink($file); // delete file
			}
            smartCopy('../../temp-scpa-home/Noday/scpa', '../../scpa');
            

            
			//copy('../../temp-scpa-home/Noday/test.xlsx','../../scpa/test.xlsx');
		}
		else{
			$files = glob('../../scpa/*'); // get all file names
			foreach($files as $file){ // iterate files
  			if(is_file($file))
    			unlink($file); // delete file
			}
			smartCopy('../../temp-scpa-home/NoBoth/scpa','../../scpa');
		    

		}
	}
}

echo 'OK';
//引用至https://jsnwork.kiiuo.com/archives/1385/php-%E8%A4%87%E8%A3%BD%E7%9B%AE%E9%8C%84%E6%88%96%E8%B3%87%E6%96%99%E5%A4%BE-copy
function smartCopy($source, $dest, $options=array('folderPermission'=>0755,'filePermission'=>0755))
    {
        $result=false;
 
        if (is_file($source)) {
            if ($dest[strlen($dest)-1]=='/') {
                if (!file_exists($dest)) {
                    cmfcDirectory::makeAll($dest,$options['folderPermission'],true);
                }
                $__dest=$dest."/".basename($source);
            } else {
                $__dest=$dest;
            }
            $result=copy($source, $__dest);
            chmod($__dest,$options['filePermission']);
 
        } elseif(is_dir($source)) {
            if ($dest[strlen($dest)-1]=='/') {
                if ($source[strlen($source)-1]=='/') {
                    //Copy only contents
                } else {
                    //Change parent itself and its contents
                    $dest=$dest.basename($source);
                    @mkdir($dest);
                    chmod($dest,$options['filePermission']);
                }
            } else {
                if ($source[strlen($source)-1]=='/') {
                    //Copy parent directory with new name and all its content
                    @mkdir($dest,$options['folderPermission']);
                    chmod($dest,$options['filePermission']);
                } else {
                    //Copy parent directory with new name and all its content
                    @mkdir($dest,$options['folderPermission']);
                    chmod($dest,$options['filePermission']);
                }
            }
 
            $dirHandle=opendir($source);
            while($file=readdir($dirHandle))
            {
                if($file!="." && $file!="..")
                {
                     if(!is_dir($source."/".$file)) {
                        $__dest=$dest."/".$file;
                    } else {
                        $__dest=$dest."/".$file;
                    }
                    //echo "$source/$file ||| $__dest<br />";
                    $result=smartCopy($source."/".$file, $__dest, $options);
                }
            }
            closedir($dirHandle);
 
        } else {
            $result=false;
        }
        return $result;
    }
?>