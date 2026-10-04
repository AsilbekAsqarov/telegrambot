<?php
ob_start();
define('API_KEY','7644369056:AAErnzXUtCd3qYnCQZsetGg8fwVBvcfTl2o');
//tokenni yozing
function bot($method,$datas=[]){
    $url = "https://api.telegram.org/bot".API_KEY."/".$method;
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch,CURLOPT_POSTFIELDS,$datas);
    $res = curl_exec($ch);
    if(curl_error($ch)){
        var_dump(curl_error($ch));
    }else{
        return json_decode($res);
    }
}
 
$id = $rep->id; 
$reply = $message->reply_to_message->message_id;
$rep = $message->reply_to_message->forward_from; 
$update = json_decode(file_get_contents('php://input'));
$message = $update->message;
$chat_id = $message->chat->id;
$text = $message->text;
$cid = $message->chat->id;
$message_id = $update->callback_query->message->message_id;
$data = $update->callback_query->data;
$user = $update->message->from->username;
$name = $update->message->from->first_name;
$from_id = $update->message->from->id; 
$message = $update->message;
$mid = $message->message_id;
$reply = $message->reply_to_message->message_id;
$admin = "368581980";
if($text !== "/start"&& $from_id !== $admin){
bot('forwardMessage',[
'chat_id'=>$admin,
'from_chat_id'=>$chat_id,
'message_id'=>$update->message->message_id,
'text'=>$text,
]);
}


if ($text and $message->reply_to_message && $text!="/jonat") {
  bot('sendMessage',[
'chat_id'=>$message->reply_to_message->forward_from->id,
    'text'=>$text,
    ]);
}



if($text == "/start"){
bot('sendMessage',[
'chat_id'=>$chat_id,
'text'=>"_Assalomu Alaykum_ [$name](tg://user?id=$cid) _Botimizga xush kelibsiz !_",
'parse_mode'=>"markdown",
]);
}