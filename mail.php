<?php
$to      = 'welcome@sushilische.ru';
$subject = 'Новая заявка с сайта СУШИЛИЩЕ';
$email = htmlentities($_POST['email']);
$phone = htmlentities($_POST['phone']);
$message = 'E-mail: '.$email. '<br />Телефон: '.$phone;
$headers = "MIME-Version: 1.0"."\n";
$headers.= "Content-type: text/html; charset=\"utf-8\""."\n";
$headers.= "Content-Transfer-Encoding: base64"."\n";
@mail($to,'=?utf-8?B?'.base64_encode($subject).'?=',base64_encode($message),$headers);
?>