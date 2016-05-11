<?php



$to = 'hello@sushilische.ru';

$userEmail = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);

$subject = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW);

$name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW);



$email = "<b>Email:</b> $userEmail";

$name = "<b>Имя:</b> $name";


if (empty($userEmail)) {

	die('Отсутствует или неверен [ez] адрес почты.');

}




$the_file = '';

if (!empty($_FILES['uploaded_file']['tmp_name'])) {

	$path = $_FILES['uploaded_file']['name'];

	if (copy($_FILES['uploaded_file']['tmp_name'], $path)) {

		$the_file = $path;

	}

}



$headers = null;



if (empty($the_file)) {



	$headers = array();

	$headers[] = "MIME-Version: 1.0";

	$headers[] = "Content-type: text/html; charset=UTF-8";

	$headers[] = "From: $name <$userEmail>";

	$headers[] = "Subject: {$subject}";

	$headers[] = "X-Mailer: PHP/" . phpversion();



	$allmsg = "<p>$email</p> <p>$name</p>";

	$allmsg = "<html><head><title>Звуковые системы</title><META HTTP-EQUIV=\"Content-Type\" CONTENT=\"text/html; charset=UTF-8\"></head><body>" . $allmsg . "</body></html>";

	if (!mail($to, $subject, $allmsg, implode("\r\n", $headers))) {

		echo 'Письмо не отправлено - что-то не сработало.';

	} else {

		echo 'Отправлено письмо без вложений.';

	}

} else {



	if (!$the_file) {

		die("Ошибка отправка письма: Файл $the_file не может быть прочитан.");

	}

	$fp = fopen($the_file, "r");

	$file = fread($fp, filesize($path));

	fclose($fp);

	unlink($path);



	$allmsg = "<p>$email</p> <p>$name</p>";

	$allmsg = "<html><head><title>Обратная связь</title><META HTTP-EQUIV=\"Content-Type\" CONTENT=\"text/html; charset=UTF-8\"></head><body>" . $allmsg . "</body></html>";



	$boundary = "--" . md5(uniqid(time()));



	$headers = array();

	$headers[] = "MIME-Version: 1.0";

	$headers[] = "From: <$userEmail>";

	$headers[] = "Subject: {$subject}";

	$headers[] = "X-Mailer: PHP/" . phpversion();

	$headers[] = "Content-Type: multipart/mixed; boundary=\"$boundary\"\n";



	$multipart = array();

	$multipart[] = "--$boundary";

	$multipart[] = "Content-Type: text/html; charset=UTF-8";

	$multipart[] = "Content-Transfer-Encoding: Quot-Printed\r\n";

	$multipart[] = "$allmsg\r\n";

	$multipart[] = "--$boundary";

	$multipart[] = "Content-Type: application/octet-stream";

	$multipart[] = "Content-Transfer-Encoding: base64";

	$multipart[] = "Content-Disposition: attachment; filename = \"" . $path . "\"\r\n";

	$multipart[] = chunk_split(base64_encode($file));

	$multipart[] = "--$boundary";



	if (!mail($to, $subject, implode("\r\n", $multipart), implode("\r\n", $headers))) {

		echo 'Письмо не отправлено - что-то не сработало.';

	} else {

		echo 'Отправлено письмо с вложениями.';

	}

}
