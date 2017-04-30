<?php

ob_start();
define('API_KEY',' xxxxx '); // توكن
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

$update = json_decode(file_get_contents('php://input'));
$message = $update->message;
$chat_id = $message->chat->id;
$text = $message->text;
$from_id = $message->from->id;
$chat_id2 = $update->callback_query->message->chat->id;
$message_id = $update->callback_query->message->message_id;
$data = $update->callback_query->data;
$text2 = $update->callback_query->message->text;
include "short.php";


$join = file_get_contents("https://api.telegram.org/bot".API_KEY."/getChatMember?chat_id=@Set_Web&user_id=".$from_id);
 
 if (strpos($join , '"status":"left"') !== false ){
bot('sendMessage', [
'chat_id'=>$chat_id,
'parse_mode'=>'Markdown',
'text'=>"عذرا ❗يجب عليك الدخول للقناة 🕴🔹\n لكي يمكنك استخدام البوت 🤖🍁" . "\n\n" . "Sorry 📪 You can't Use❗️This bot 🤖\nYou have to ❌ join to the bot channel ♻️",
'reply_markup'=>json_encode([
      'inline_keyboard'=>[
        [
          ['text'=>'اضغط هنا للدخول ☘', 'url'=>"https://telegram.me/set_web"]
        ],
         [
          ['text'=>'Click here to join ❇️' , 'url'=>"https://telegram.me/set_web"]
        ],
]

])
]);
}

if($text == "/start" && !strpos($join , '"status":"left"') !== false){
bot('sendMessage', [
'chat_id'=>$chat_id,
'message_id'=>$message_id,
'text'=>"اهلا ✨ بك عزيزي في بوت 🤖🍁\nاختصار الروابط 🔖 قم بٲرسال رابط وسوف 🔭\n اختصره لك في الحال 🚹",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[
['text'=>'ابدٲ ✳️', 'callback_data'=>"start"],
],
[
         ['text'=>'تابعنا ✨', 'callback_data'=>'channel']
        ],
        [
         ['text'=>'المطور 🔭', 'url'=>'https://telegram.me/omar_real']
        ],
        [
        ['text'=>'شارك البوت 🚹', 'switch_inline_query'=>""]
        ],
]
])
]);
}

if($data == "home" && !strpos($join , '"status":"left"') !== false){
bot('editMessageText', [
'chat_id'=>$chat_id2, 
'message_id'=>$message_id,
'text'=>"اهلا ✨ بك عزيزي في بوت 🤖🍁\nاختصار الروابط 🔖 قم بٲرسال رابط وسوف 🔭\n اختصره لك في الحال 🚹",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[
['text'=>'ابدٲ ✳️', 'callback_data'=>"start"],
],
[
         ['text'=>'تابعنا ✨', 'callback_data'=>'channel']
        ],
        [
         ['text'=>'المطور 🔭', 'url'=>'https://telegram.me/omar_real']
        ],
        [
        ['text'=>'شارك البوت 🚹', 'switch_inline_query'=>""]
        ],
]
])
]);
}

if($data=="channel" && !strpos($join , '"status":"left"') !== false){
   bot('editMessageText',[
   'chat_id'=>$chat_id2,
    'message_id'=>$message_id,
    'text'=>'تابعنا عبر الروابط للتالية 📩',
   'reply_markup'=>json_encode([
'inline_keyboard'=>[
        [
          ['text'=>'القناة الرسمية ✅', 'url'=>"https://telegram.me/set_web"]
        ],
        [
        ['text'=>'تيم EVS ✨', 'url'=>"https://telegram.me/TeamEVS"]
        ],
        [
        ['text'=>'فريق لمسة 💡', 'url'=>"https://telegram.me/touch_t"]
        ],
        [
        ['text'=>'الصفحة الرئيسية 📩️', 'callback_data'=>"home"]
        ]
      ]
    ])
        ]);

         }
         
         
if($data == "start" && !strpos($join , '"status":"left"') !== false){
bot('editmessageText', [
'chat_id'=>$chat_id2,
'message_id'=>$message_id,
'text'=>"ارسل 📩 الرابط الخاص بك الان ➖🔻",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[
['text'=>'اختصر❕', 'callback_data'=>"speak_ar"],
]
]
])
]);
}

if(preg_match('/^([Hh]ttp|[Hh]ttps)(.*)/',$text) && !$data){
file_put_contents('short.php', '<?php' . "\n" . '$short[] = ' . "'$text'" . ";");
}

if($data == "speak_ar" && !in_array("/^([Hh]ttp|[Hh]ttps)(.*)/", $short)){
$url = file_get_contents('http://llink.ir/yourls-api.php?signature=a13360d6d8&action=shorturl&url='.$short[0].'&format=sample');

bot('answerCallbackQuery', [
'callback_query_id'=>$update->callback_query->id,
'message_id'=>$messagd_id,
'chat_id'=>$chat_id2,
'text'=>'جاري ♻️ اختصار رابطك 📛'
]);


bot('editMessageText',[
'callbackMessage'=>'جاري اختصار رابطك 🔗 ',
'chat_id'=>$chat_id2,
'message_id'=>$message_id,
'text'=>"انتضر قليلا",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[
['text'=>'10%', 'callback_data'=>"speak_ar"],
]
]
])
]);
sleep(1);
bot('editMessageText', [
'chat_id'=>$chat_id2,
'message_id'=>$message_id,
'text'=>"انتضر قليلا",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[
['text'=>'40%', 'callback_data'=>"speak_ar"],
]
]
])
]);
sleep(1);
bot('editMessageText', [
'chat_id'=>$chat_id2,
'message_id'=>$message_id,
'text'=>"انتضر قليلا",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[
['text'=>'50%', 'callback_data'=>"speak_ar"],
]
]
])
]);
sleep(1);
bot('editMessageText', [
'chat_id'=>$chat_id2,
'message_id'=>$message_id,
'text'=>"انتضر قليلا",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[
['text'=>'80%', 'callback_data'=>"speak_ar"],
]
]
])
]);
sleep(1);
bot('editMessageText', [
'chat_id'=>$chat_id2,
'message_id'=>$message_id,
'text'=>"انتضر قليلا",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[
['text'=>'100%', 'callback_data'=>"speak_ar"],
]
]
])
]);
sleep(1);
bot('editMessageText', [
'chat_id'=>$chat_id2,
'message_id'=>$message_id,
'text'=>'تمت ✅ العملية ✨',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[
['text'=>'مرة اخرى 🔄', 'callback_data'=>"start"],
],
[
['text'=>'الصفحة الرئيسية 🏠 ', 'callback_data'=>"home"],
]
]
])
]);

bot('sendMessage', [
'chat_id'=>$chat_id2,
'message_id'=>$message_id,
'text'=>"الرابط الخاص بك ✨ \nالرابط 🗒 :  " . $url,
]);
}
