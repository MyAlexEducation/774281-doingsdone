<?php
require_once('init.php');

$transport = new Swift_SmtpTransport("phpdemo.ru", 25);
$transport->setUsername("keks@phpdemo.ru");
$transport->setPassword("htmlacademy");

$mailer = new Swift_Mailer($transport);

$logger = new Swift_Plugins_Loggers_ArrayLogger();
$mailer->registerPlugin(new Swift_Plugins_LoggerPlugin($logger));

$sql_get_tasks = 'SELECT title, critical_time, name, email  FROM tasks JOIN users ON tasks.user_id = users.id WHERE critical_time - CURRENT_TIMESTAMP <= 5999';
$critical_tasks = db_fetch_data($link, $sql_get_tasks);

if (isset($critical_tasks)) {
    foreach ($critical_tasks as $key => $item) {
        $message = new Swift_Message();
        $message->setSubject("Уведомление от сервиса «Дела в порядке»");
        $message->setFrom(['keks@phpdemo.ru' => 'GifTube']);

        $recipient = [];
        $recipient[$item['email']] = $item['name'];
        $message->setBcc($recipient);
        $message_content = 'Уважаемый, ' . $item['name'] . '. У вас запланирована задача ' . $item['title'] . ' на ' . $item['critical_time'];
        $message->setBody($message_content, 'text/html');

        $result = $mailer->send($message);

        if ($result) {
            print("Рассылка успешно отправлена");
        }
        else {
            print("Не удалось отправить рассылку: " . $logger->dump());
        }
    }
}
