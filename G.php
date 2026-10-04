<?php

ob_start();

$API_KEY = getenv('7644369056:AAErnzXUtCd3qYnCQZsetGg8fwVBvcfTl2o');

if (!$API_KEY) {
    http_response_code(500);
    exit('BOT_TOKEN topilmadi');
}


/*
|--------------------------------------------------------------------------
| Telegram API
|--------------------------------------------------------------------------
*/

function bot($method, $datas = [])
{
    global $API_KEY;

    $url = "https://api.telegram.org/bot" . $API_KEY . "/" . $method;

    $ch = curl_init();

    curl_setopt_array($ch, [
        CURLOPT_URL            => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST           => true,
        CURLOPT_POSTFIELDS     => $datas,
        CURLOPT_TIMEOUT        => 15,
    ]);

    $res = curl_exec($ch);

    if (curl_error($ch)) {

        error_log(curl_error($ch));

        curl_close($ch);

        return false;
    }

    curl_close($ch);

    return json_decode($res);
}


/*
|--------------------------------------------------------------------------
| Telegram update
|--------------------------------------------------------------------------
*/

$raw = file_get_contents('php://input');

if (!$raw) {
    echo 'Bot ishlayapti';
    exit;
}

$update = json_decode($raw);

if (!$update) {
    echo 'OK';
    exit;
}


/*
|--------------------------------------------------------------------------
| Message
|--------------------------------------------------------------------------
*/

$message = $update->message ?? null;

if (!$message) {
    echo 'OK';
    exit;
}


$chat_id = $message->chat->id ?? null;
$text = $message->text ?? '';
$cid = $message->chat->id ?? null;

$name = $message->from->first_name ?? '';

$user = $message->from->username ?? '';

$from_id = $message->from->id ?? null;

$mid = $message->message_id ?? null;


/*
|--------------------------------------------------------------------------
| Reply
|--------------------------------------------------------------------------
*/

$reply = null;

if (isset($message->reply_to_message)) {

    $reply = $message->reply_to_message->message_id ?? null;
}


/*
|--------------------------------------------------------------------------
| Admin
|--------------------------------------------------------------------------
*/

$admin = "368581980";


/*
|--------------------------------------------------------------------------
| /start
|--------------------------------------------------------------------------
*/

if ($text === "/start") {

    bot('sendMessage', [

        'chat_id' => $chat_id,

        'text' =>
            "_Assalomu Alaykum_ [$name](tg://user?id=$cid) " .
            "_Botimizga xush kelibsiz !_",

        'parse_mode' => 'Markdown'

    ]);

    echo 'OK';

    exit;
}


/*
|--------------------------------------------------------------------------
| Admin'ga xabar forward qilish
|--------------------------------------------------------------------------
*/

if (
    $text !== "/start" &&
    $from_id != $admin
) {

    bot('forwardMessage', [

        'chat_id' => $admin,

        'from_chat_id' => $chat_id,

        'message_id' => $mid

    ]);
}


/*
|--------------------------------------------------------------------------
| Admin reply orqali foydalanuvchiga javob
|--------------------------------------------------------------------------
*/

if (
    $text &&
    isset($message->reply_to_message) &&
    $text !== "/jonat"
) {

    $forwardFrom =
        $message->reply_to_message->forward_from->id
        ?? null;

    if ($forwardFrom) {

        bot('sendMessage', [

            'chat_id' => $forwardFrom,

            'text' => $text

        ]);

    }
}


echo 'OK';
