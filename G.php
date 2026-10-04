<?php

$token = getenv('8309664031:AAHfLUSSomKD8iPKxnDlB2S2IceQ6nWSeZY');

if ($token === false) {
    echo "ERROR: BOT_TOKEN environment variable topilmadi";
    exit;
}

if (trim($token) === '') {
    echo "ERROR: BOT_TOKEN mavjud, lekin bo'sh";
    exit;
}

echo "OK: BOT_TOKEN topildi";
exit;
?>
