<?php

if ( empty($_POST) ) {

	exit;

}

require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;


// reCAPTCHA v3
// https://www.google.com/recaptcha/admin/

$recaptcha_check = false;

$recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify';
$recaptcha_secret = '6LcMlS8lAAAAAIEHFKZiLoy_yBP3YTmSlKhuZz_q';
$recaptcha_response = $_POST['recaptcha_response'];

if ( empty($recaptcha_response) === false ) {

    $recaptcha = file_get_contents($recaptcha_url . '?secret=' . $recaptcha_secret . '&response=' . $recaptcha_response);
    $recaptcha = json_decode($recaptcha);

	if ( $recaptcha["success"] and $recaptcha["score"] >= 0.5 ) {

		$recaptcha_check = true;

	}

}

// логируем письма

$log = date('d.m.y H:i') . "\r\n";

foreach ( $_POST as $key => $value ) {

	if ( $key === 'subject' || $key === 'recaptcha_response' ) {

		continue;

	}

	$log .= $_POST[$key] . "\r\n";

}

$log .= "___________\r\n";

if ( $recaptcha_check === false ) {

	$fp = fopen('../../log-invalid-recaptcha.txt', "a");
	fwrite($fp, $log);
	fclose($fp);

	echo '{"title":"reCaptcha error","message":"Пожалуйста, свяжитесь с менеджером на прямую"}';

	exit;

} else {

	$fp = fopen('../../log-mail.txt', "a");
	fwrite($fp, $log);
	fclose($fp);

}

// отправляем письмо

$mail = new PHPMailer();

//Server settings
//$mail->SMTPDebug = SMTP::DEBUG_SERVER;
$mail->isSMTP();
$mail->SMTPAuth   = true;
$mail->Host       = 'mail.hosting.reg.ru';
$mail->Username   = 'info@ccstradedmcc.com';
$mail->Password   = 'yC1nI6fS6aoC8eE2';
$mail->SMTPSecure = 'none';
$mail->Port       = 587;

//Recipients
$mail->setFrom('info@ccstradedmcc.com', 'Palladium Development');
$mail->addAddress('np@palladiumgroup.ae');
$mail->addAddress('v@palladiumgroup.ae');
$mail->addAddress('79198889134@ya.ru');

//Content
$html  = '<b>Имя:</b> ' . $_POST['name'];
$html .= '<br><b>Телефон:</b> ' . $_POST['phone'];
$html .= '<br><b>Объект:</b> ' . $_POST['subject'];
//	$html .= '<br><b>Язык сайта:</b> ' . $_POST['lang'];

$mail->CharSet  = 'UTF-8';
$mail->Subject = $_POST['subject'];
$mail->msgHTML($html);


//send the message, check for errors

$success = new class{};

if ( $mail->send() ) {

	$success->status = "ok";
	$success->title  = "Thanks for your application!";
	$success->message  = "Our manager willcontact you soon";

	if ( $_POST['lang'] === 'ru' ) {

		$success->title = "Отправлено";
		$success->message  = "Мы получили ваше письмо. В скором времени менеджер вам ответит. Спасибо!";

	}

} else {

	$success->title  = "Sending error";
	$success->message  = $mail->ErrorInfo;

}

echo json_encode( $success );