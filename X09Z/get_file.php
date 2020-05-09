<?php
$s_file = "http://qox.monster/X09Z/index93847.html";
$file = "get_url.txt";
 
$check = FALSE;
$hash = $_GET['hash'];
 
if(strlen($hash) != 32) {
 exit("Вернитесь обратно и запустите трансляцию вновь");
}
 
$arr = file($file);
 
$fd = fopen($file,"w");
if(!$fd) {
 exit("Не возможно открыть файл");
}
 
if(!flock($fd,LOCK_EX)) {
 exit("Блокировка файла не удалась");
}
 
for ($i = 0; count($arr) > $i; $i++) {
 
 if($hash == rtrim($arr[$i])) {
 
 $check = TRUE;
 }
 else {
 fwrite($fd,$arr[$i]);
 }
}
 
if(!flock($fd,LOCK_UN)) {
 exit("Не возможно разблокировать файл");
}
fclose($fd);
 
if($check) {
 header("Content-Description: File Transfer");
 header("Content-Type: text/html");
 header("Content-Disposition: ; filename=".basename($s_file));
 header("Content-Transfer-Encoding:binary");
 
header('Content-Length: '.$filesize);
header("Content-Range: 0-".($filesize-1)."/".$filesize);
 
 ob_clean();
 flush();
 
 readfile($s_file);
 exit();
}
else {
 exit("Вернитесь обратно и запустите трансляцию вновь");
}
?>