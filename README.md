# Bots

Simple Telegram Bot API library for PHP

## Quick Start
Initiate with `setToken` and end with `run` method.
### Sample 1: Start
```php
require 'Bot.php';

Bot::setToken(BOT_TOKEN, BOT_USERNAME); //init (required)
Bot::start('Welcome, I am a bot.'); //event
Bot::run(); //launch (required)
```
<img src='https://github.com/dannsbass/dannsbass.github.io/blob/master/assets/img/bot-start.png'>

### Sample 2: Keyboard

```php
Bot::chat('/help', function(){
    $keyboard = Bot::keyboard('
    [/info] [/admin]
    [/help]
    ');
    $options = ['reply_markup' => $keyboard];
    return Bot::sendMessage("List of Commands:", $options);
});
```
<img src='https://github.com/dannsbass/dannsbass.github.io/blob/master/assets/img/keyboard.png'>

### Sample 3: Inline Keyboard

```php
Bot::chat('/inline_keyboard', function(){
    $inline_keyboard = Bot::inline_keyboard('
    [Google|https://www.google.com] [Facebook|https://www.facebook.com]
    [More|more_data]
    ');
    $options = ['reply_markup' => $inline_keyboard];
    return Bot::sendMessage("Options:", $options);
});
```

<img src='https://github.com/dannsbass/dannsbass.github.io/blob/master/assets/img/inline_keyboard.png'>

### Sample 4: Sending Document

```php
Bot::chat('/send', function($file){
    if (file_exists($file)) return Bot::sendDocument($file);
    return Bot::sendMessage("$file not exists");
});
```

<img src='https://github.com/dannsbass/dannsbass.github.io/blob/master/assets/img/send-document.png'>

## Documentation

Note that all properties and methods are static.
### Bot Properties

|Property|Type|Description|
|---|---|---|
|token|string|bot token from @BotFather|
|name|string|bot name from @BotFather|
|url|string|telegram URL for endpoint|
|getUpdates|array|parsed-JSON from Telegram server|
|_command|array|list of commands and responses|
|_onMessage|array|list of events (types) and the responses|
|version|integer|app version|
|message_id|string|message ID|
|message_text|string|message text|
|user|string|first name (and last name)|
|from_id|integer|from ID|
|chat_id|integer|from ID|
|admin_id|integer|admin ID|

### Bot Methods

|Method|Parameter(s)|Description|
|---|---|---|
|setToken|`string` bot token, `string` bot name||
|setAdmin|`integer` admin ID||
|isAdmin||to check if user is admin|
|name||to get bot name|
|chat|`string` command, `string|callback` response|to set command and its response|
|cmd|`string` command, `string|callback` response|to set command and its response|
|chat_array|`array` list of command and its response|to set command and its response|
|keyboard|`string` keyboard pattern, `string` input_field_placeholder = 'type here', `boolean` resize_keyboard = true, `boolean` one_time_keyboard = true|to create keyboard(s) from string|
|inline_keyboard|`string` keyboard pattern|to create keyboard(s) from string|
|message_id||to get message id|
|message_text||to get message text|
|user||to get user first name (and last name)|
|from_id||to get user ID|
|chat_id||to get chat ID|
|on|`string` type, `string|callback` response|to set response|
|regex|`string` pattern, `string|callback` response|to set response|
|run||to run the bot|
|send|`string` method, `array` data|to send request to Telegram server|
|answerInlineQuery|result, `array` options = []|to answer Inline Query|
|answerCallbackQuery|text, `array` options = []|to answer Callback Query|
|message||to get body of message JSON from user|
|type||to get type of message|
|`__callStatic`|`string` method, `array` parameters|to get type of message|
|prosesPesan|`string` teks, `array` data = null|to get type of message|
|bg_exec|`string` function name, `array` parameters, `string` PHP script to be loaded first, `integer` timeout = 1000|to call function in background|

### Telegram Methods

All Telegram methods are compatible with this bot. For example:

```php
echo Bot::getMe();
echo Bot::setWebhook(WEBHOOK_URL);
echo Bot::getWebhookInfo();
echo Bot::deleteWebhook(true); //default is `false` for `drop_pending_updates`, see: https://core.telegram.org/bots/api#deletewebhook
```

See more: https://core.telegram.org/bots/api#available-methods 