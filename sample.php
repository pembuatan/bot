<?php

/**
 * content of `config.php`
 * <?php 
 * require 'Bot.php';
 * define('ADMIN_ID', 123456****);
 * define('BOT_TOKEN', '564143****:AAGaqmnwAmRjUAkXFHXn45uZQ_CU5UUow_M');
 * define('BOT_USERNAME', 'Testing*****bot');
 * 
 * Bot::setToken(BOT_TOKEN, BOT_USERNAME);
 * Bot::setAdmin(ADMIN_ID);
 */
require __DIR__ . '/config.php';

// echo Bot::setWebhook('https://your-domain.com/bot.php'); die; // to set your bot webhook
// echo Bot::getWebhookInfo(); die; // to retrieve your webhook info
// echo Bot::deleteWebhook(true); die; // to delete the existing webhook

# When user sends `/start`
Bot::start('Welcome, I am a bot');

# to handle text message
Bot::text(function($text){
    $msg = Bot::message();
    if (isset($msg['reply_to_message'])){
        switch ($text){
            case '/del':
                # delete replied message
                Bot::deleteMessage();
                # delete user message
                return Bot::deleteMessage(Bot::$message_id);
        }
    }
});

# to handle inline keyboard when user pressed it
Bot::callback_query(function($data){
    $char = '📎';
    $char_pos = strpos($data, $char);
    if ($char_pos === 0){
        $file = str_replace($char, '', $data);
        if (file_exists($file)) return Bot::sendDocument($file);
        return Bot::sendMessage("$file not exist");
    }
});

# get list of files on the server
Bot::chat('/ls|/files', function(){
    $files = glob("*.*");
    $keyboard_string = '';
    foreach ($files as $file) {
        $file = basename($file);
        $keyboard_string .= "[📎$file]\n";
    }
    $options = ['reply_markup' => Bot::inline_keyboard($keyboard_string)];
    return Bot::sendMessage("List of files: ", $options);
});

# download file
Bot::chat('/download', function ($file) {
    if (!Bot::isAdmin()) return reply("Sorry, you are not Admin");
    if (empty($file)) return Bot::sendMessage("Usage: <code>/download [file name]</code>", ['parse_mode' => 'html']);
    if (!file_exists($file)) return reply("$file not exist");
    return Bot::sendDocument($file);
});

# to run or evaluate PHP script (be careful)
Bot::chat('/run|/eval', function($script){
    if (!Bot::isAdmin()) return reply("Sorry, you are not Admin");
    return eval($script);
});

# to perform regular expression
Bot::regex('/^\/([a-zA-Z_]+)([\d]+)$/', function ($match) {
    return reply("Alphabet: {$match[1]}. Nombor: {$match[2]}");
});

# When user sends anything
Bot::all(function($anything){
    # background process
    Bot::bg_exec('Bot::sendMessage', [$anything], 'require "config.php"; Bot::$getUpdates = json_decode(\''.json_encode(Bot::$getUpdates).'\', true);', 10000);
    return reply("You send $anything");
});

# to run or launch the bot
Bot::run();

# your functions
function reply(string $message, array $options = [])
{
    return Bot::sendMessage($message, $options);
}
