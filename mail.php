<?php
// Подключаем PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Подключаем файлы PHPMailer
require 'vendor/autoload.php';

$data['error'] = false;

$name = $_POST['name'];
$email = $_POST['email'];
$subject = $_POST['subject'];
$message = $_POST['message'];

if (empty($name)) {
    $data['error'] = 'Please enter your name.';
} elseif (filter_var($email, FILTER_VALIDATE_EMAIL) == false) {
    $data['error'] = 'Please enter a valid email address.';
} elseif (empty($subject)) {
    $data['error'] = 'Please enter your subject.';
} elseif (empty($message)) {
    $data['error'] = 'The message field is required!';
} else {
    // Формируем содержимое письма
    $formcontent = "From: $name\nSubject: $subject\nEmail: $email\nMessage: $message";

    // Указываем адрес получателя
    $recipient = "YOUR_EMAIL_ADDRESS"; // Замените на свой email

    // Настроим PHPMailer
    $mail = new PHPMailer(true);

    try {
        // Настройки SMTP сервера
        $mail->isSMTP();
        $mail->Host = 'edilomirbekulyoffer@gmail.com';  // Укажите свой SMTP сервер
        $mail->SMTPAuth = true;
        $mail->Username = 'edilomirbekulyoffer@gmail.com'; // Замените на свой email
        $mail->Password = 'Ediloffer2004!'; // Замените на свой пароль
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // От кого и кому отправляем письмо
        $mail->setFrom($email, $name);
        $mail->addAddress($recipient); // Получатель

        // Содержание письма
        $mail->isHTML(false); // Отправляем текстовое сообщение
        $mail->Subject = $subject;
        $mail->Body = $formcontent;

        // Отправляем письмо
        $mail->send();
        $data['error'] = false;
    } catch (Exception $e) {
        $data['error'] = 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo;
    }
}

echo json_encode($data);
?>
