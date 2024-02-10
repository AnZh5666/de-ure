<?php

require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';

$name = $_POST['name'];
$email = $_POST['email'];
$phone  = $_POST['phone'];
$message = $_POST['message'];

// Формирование самого письма
$title = "Новый клиент";
$body = "
<h2>Новое письмо</h2>
<b>Имя:</b> $name<br>
<b>Телефон:</b> $phone<br> 
<b>Почта:</b> $email<br><br>
<b>Сообщение:</b><br>$message
";

// Настройки PHPMailer
$mail = new PHPMailer\PHPMailer\PHPMailer();
try {
    $mail->isSMTP();   
    $mail->CharSet = "UTF-8";
    $mail->setLanguage('ru', 'PHPMailer/language/');
    $mail->SMTPAuth = true;
    $mail->Debugoutput = function($str, $level) {$GLOBALS['status'][] = $str;};

// Настройки почты
$mail->Host       = 'smtp.mail.ru'; // SMTP сервера почты
$mail->Username   = 'advokat_zhilyaev@bk.ru'; // Логин на почте
$mail->Password   = 'qcY6sa10jM2URpyxj7RM'; // Пароль на почте для внешних приложений
$mail->SMTPSecure = 'ssl';
$mail->Port       = 465;
$mail->setFrom('advokat_zhilyaev@bk.ru', 'Адвокатский кабинет'); // Адрес самой почты и имя отправителя

 // Адрес получателя письма
$mail->addAddress('anzh58195666@gmail.com'); // Ещё один, если нужен

// Отправка сообщения
$mail->isHTML(true);
$mail->Subject = $title;
$mail->Body = $body;    

// Проверяем отравленность сообщения
if (!$mail->send()) {
    $message = "Ошибка";
} 
else {
    $message = "Заявка отправлена!";
}

} catch (Exception $e) {
    $result = "error";
    $status = "Сообщение не было отправлено. Причина ошибки: {$mail->ErrorInfo}";
}

// Отображение результата
$response = ['message' => $message];
header('Content-type: application/json');
echo json_encode($response);

