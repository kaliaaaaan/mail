<?php
define('HOST','localhost');
define('USER','root');
define('PASS','');
define('DBNAME','db_name');
$youremail = "kalian48@yandex.ru";

try {
  $dbh = new PDO("mysql:host=".HOST.";dbname=".DBNAME."",USER,PASS);
   $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   $dbh -> exec("SET NAMES UTF8");
   header("Content-Type: text/html; charset=utf-8");
}
catch(PDOException $e) {
  echo "Обнаружена ошибка. Напишите администратору. $email<br>";  
  file_put_contents('PDOErrors.txt', $e->getMessage(), FILE_APPEND);
}
$theme = $_POST["theme1"];
$name = $_POST["name1"];
$useremail = $_POST["email1"];
$text = $_POST["text1"];
try{
    $subject = $theme;
    $header .= "Content-type: text/plain; charset=\"utf-8\"\r\n";
    $header="From: $name <$useremail>\r\n\r\n";
    $message = "Вам пришло сообщение от, $name!\n Текст сообщения: $text";
    if (mail($youremail, $subject, $message, $header))
            echo "Спасибо, мы свяжемся с Вами в ближайшее время!";
     else
        echo "Сообщение не доставлено попытайтесь еще раз!";  
     $query = "INSERT INTO sendmail
             (theme,name,email,text) 
              VALUES (:theme,:name,:email,:text)";
     $data = array(':theme'=>$theme,':name'=>$name,':email'=>$useremail,':text'=>$text);
     $statement = $dbh->prepare($query);
     $statement->execute($data); 
 }
 catch(PDOException $e){
         throw new Exception($e -> getMessage() . "  " . get_class($this).' -> '.__METHOD__);
          $file = "exceptionlog.txt";
         file_put_contents($file, $e -> getMessage(), FILE_APPEND);
}
?>
