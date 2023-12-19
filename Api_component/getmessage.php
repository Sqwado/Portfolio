<?php

$message = new Message($database);

$messages = $message->getMessages();

$data = [];

foreach ($messages as $message) {
    $data[] = [
        "id_message" => $message["id_message"],
        "email" => $message["email"],
        "content" => $message["content"],
        "sending_date" => $message["sending_date"],
        "readed" => $message["readed"]
    ];
}

echo json_encode($data, JSON_PRETTY_PRINT);
