<?php

function getUri(){
    return $_SERVER['REQUEST_URI'];
}

function dump($object){
    $out = '';
    if(is_array($object)){
        $out = print_r($object , true);
    }elseif(is_object($object)){
        $out = var_export($object , true);
    }
    echo "<pre>" .  $out . "</pre>";
}

function strHas($str , $search, $caseSensitive = false){
    if($caseSensitive){
        return strpos($str , $search) !== false;
    }else{
        return strpos(strtolower($str) , strtolower($search)) !== false;
    }
}

function br($return = false){
    if($return){
        return "<br/>";
    }
    echo "<br/>";
}

function hr($return = false){
    if($return){
        return "<hr/>";
    }
    echo "<hr/>";
}

function currentTime(){
    return date("Y-m-d H:i:s");
}

function baseUri(){
    return '/homework';
}

function fullBaseUri(){
    return $_SERVER['HTTP_HOST'] . baseUri();
}

function message($type , $message , $mustExit = false){
    $data['message'] = $message;
    View::showMessage($type , $data);
    if($mustExit){
        exit;
    }
}

function twoNumber($number){
    return $number < 10 ? $number = '0' . $number : $number;
}

// 1970-01-01 00:00:00 == 1348-10-11 00:00:00 
function jDate($date , $format = 'Y-m-d' ){
    $timestamp = strtotime($date);
    $secondsInOneDay = 24 * 60 * 60;
    $daysPassed = floor($timestamp / $secondsInOneDay) + 1 ;

    $days = $daysPassed;
	
    $day = 11;
    $month = 11;
    $year = 1348;
    $days -= 19;

					//0  1  2  3  4  5    6  7   8   9   10  11
    $daysInMonths = array(31,31,31,31,31,31 , 30, 30, 30, 30, 30, 29);
    $monthNames = array(
        'فروردین',
        'اردیبهشت',
        'خرداد',
        'تیر',
        'مرداد',
        'شهریور',
        'مهر',
        'آبان',
        'آذر',
        'دی',
        'بهمن',
        'اسفند'
    );

    while(true){
        if($days > $daysInMonths[$month-1]){
            $days -= $daysInMonths[$month-1];
            $month++;

            if($month == 13){
                $year++;
                if( ($year - 1347) % 4 == 0){
                    $days--;
                }
                $month = 1;
            }
        }else{
            break;
        }
    } // end of while
    $month = twoNumber($month);
    $days = twoNumber($days);
    $monthName = $monthNames[$month -1 ];

    $output = $format;
    $output = str_replace('Y' , $year , $output);
    $output = str_replace('m' , $month , $output);
    $output = str_replace('M' , $monthName , $output);
    $output = str_replace('d' , $days , $output);

    return $output;


}

  function pagination($uri , $showCount , $activeClass , $deActiveClass , $currentPageIndex , $pageCount){
    ob_start();
    echo '<a href="'.$uri.'/1" class="<?=$activeClass?> btn btn-warning btn-sm rounded-right" style="margin-right:5px;font-size: 12px;">1</a>';
     for ($i=$currentPageIndex - $showCount ; $i<=$currentPageIndex + $showCount; $i++){
         if ($i <= 1) { continue; }
         if ($i >= $pageCount) { continue; }
        if($i == $currentPageIndex){
            echo '<span class="btn active btn-sm rounded-right" style="margin-right:5px;font-size: 12px;">' .$i. ' </span>';
        } else {
            echo '<a href="'.$uri."/".$i.'" class="btn btn-info btn-sm rounded-right" style="margin-right:5px;font-size: 12px;">'.$i.'</a>';
         }
     }
      echo '<a href="'.$uri."/".$pageCount.'" class="btn btn-warning btn-sm rounded-right" style="margin-right:5px;font-size: 12px;">' .$pageCount. '</a>';
      $output = ob_get_clean();
      return $output;
  }


  function checkSession(){
      if($_SESSION['userId'] == null && $_SESSION['login'] == null){
          header("Location: /index/index");
      }
  }

  function md5Hash($value){
      global $config;
      return $config['salt1'] . md5($value) . $config['salt2'];
  }

  function validate_input($input){
      $input = str_replace("<" , "&lt:" , $input);
      $input = str_replace(">" , "&gt:" , $input);
      $input = trim($input);
      if(strlen($input) > 35){
          return;
      }
      return $input;
  }

  function generateHash(){
      $rnd = rand(10000 , 99999);
      $hash = md5($rnd);
      return $hash;
  }

  function csrfToken(){
      $csrf = generateHash();
      $_SESSION['token'] = $csrf;
      return $_SESSION['token'];
  }


  function check_request($redirectPath){
      if(!isset($_SESSION['token'])){
          header("Location: /$redirectPath");
          exit;
      }
      if($_POST['csrf'] == $_SESSION['token']){
          echo "ok";
          unset($_SESSION['token']);
      }else{
          echo "invalid request";
      }
  }

function uploadFile ($path , $file_field = null, $check_image = false, $random_name = false) {

//Config Section
//Set file upload path
//Set max file size in bytes
    $max_size = 1000000;
//Set default file extension whitelist
    $whitelist_ext = array('jpeg','jpg','png','gif');
//Set default file type whitelist
    $whitelist_type = array('image/jpeg', 'image/jpg', 'image/png','image/gif');

//The Validation
// Create an array to hold any output
    $out = array('error'=>null);

    if (!$file_field) {
        $out['error'][] = "Please specify a valid form field name";
    }

    if (!$path) {
        $out['error'][] = "Please specify a valid upload path";
    }

    if (count($out['error'])>0) {
        return $out;
    }

//Make sure that there is a file
    if((!empty($_FILES[$file_field])) && ($_FILES[$file_field]['error'] == 0)) {

// Get filename
        $file_info = pathinfo($_FILES[$file_field]['name']);
        $name = $file_info['filename'];
        $ext = $file_info['extension'];

//Check file has the right extension
        if (!in_array($ext, $whitelist_ext)) {
            $out['error'][] = "Invalid file Extension";
        }

//Check that the file is of the right type
        if (!in_array($_FILES[$file_field]["type"], $whitelist_type)) {
            $out['error'][] = "Invalid file Type";
        }

//Check that the file is not too big
        if ($_FILES[$file_field]["size"] > $max_size) {
            $out['error'][] = "File is too big";
        }

//If $check image is set as true
        if ($check_image) {
            if (!getimagesize($_FILES[$file_field]['tmp_name'])) {
                $out['error'][] = "Uploaded file is not a valid image";
            }
        }

//Create full filename including path
        if ($random_name) {
            // Generate random filename
            $tmp = str_replace(array('.',' '), array('',''), microtime());

            if (!$tmp || $tmp == '') {
                $out['error'][] = "File must have a name";
            }
            $newname = $tmp.'.'.$ext;
        } else {
            $newname = $name.'.'.$ext;
        }

//Check if file already exists on server
        if (file_exists($path.$newname)) {
            $out['error'][] = "A file with this name already exists";
        }

        if (count($out['error'])>0) {
            //The file has not correctly validated
            return $out;
        }

        if (move_uploaded_file($_FILES[$file_field]['tmp_name'], $path.$newname)) {
            //Success
            $out['filepath'] = $path;
            $out['filename'] = $newname;
            return $out;
        } else {
            $out['error'][] = "Server Error!";
        }

    } else {
        $out['error'][] = "No file uploaded";
        return $out;
    }
}
function FileExt($file) { 
	$ext = strtolower(substr(strrchr($file, "."), 1));
	$ext = str_replace("jpeg","jpg",$ext);
	return $ext;
}


?>