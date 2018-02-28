<?php

echo "Hello github2";

$accessToken = "EAAdRg1oVYy4BAA3xgwWw6EKQ018pGvDAZBTZCrRVhjARULLzfQERaX3zri2K8UknLe3KcsKD5oWwF77yJBlKZCm360Y7bZAkSsBb1fViSIvFWZBRKbNOxuWCbHaGb1egDTKZBB0jnovEv3ZBgwNZBTJKoPnhBFXkIrqLtaatF3qHdi9fDt8JL4ZB0";

if(isset($_REQUEST['hub_challenge'])){
	$challenge = $_REQUEST['hub_challenge'];
	$verify_token = $_REQUEST['hub_verify_token'];
	if ($verify_token === 'sarier_token_code') {
	echo $challenge;
	}
}

// echo "hi";
$input = json_decode(file_get_contents('php://input'),true);
var_dump($input);
$senderId = $input["entry"][0]["messaging"][0]["sender"]["id"];
$recipient_id = $input["entry"][0]["messaging"][0]["recipient"]["id"];
$messageArray = $input["entry"][0]["messaging"][0];
// $message = $input["entry"][0]["messaging"][0]["message"]["text"];


if(isTextSendFirstTime($messageArray)){
  send($accessToken,sendFirstMessage($senderId,"Sarier is bras, undies, swim and more for every girl. We're here to help you feel like your best self, inside & out."));
  send($accessToken,sendFirstPostBackBtn($senderId,$recipient_id));
}else{
   if($messageArray["postback"]["payload"] == "SHOP_SARIER"){
        send($accessToken,sendFirstPostBackBtn($senderId));
      }
    if($messageArray["postback"]["payload"] == "CUSTOMER_SERVICE"){
        send($accessToken,customerService($senderId));
      }
}

if(isset($messageArray["message"])){
  if(isset($messageArray["message"]["is_echo"])){
    die();
  }else{
    send($accessToken,senderAction($senderId));
    send($accessToken,sendText($senderId,$messageArray["message"]["text"]));
  }  
}
// else{
//   send($accessToken,sendCard($senderId,"hey!"));
// }


function isTextSendFirstTime($messageArray){
  if(isset($messageArray["postback"])){
      if($messageArray["postback"]["payload"] == "GET_STARTED_PAYLOAD"){
        return true;
      }else{
        return false;
      }
  }else{
    return false;
  }
}

function sendFirstMessage($senderId,$message){
  $jsonData = '{
      "recipient":{
        "id":"'.$senderId.'"
      },
      "message":{
        "text":"'.$message.'"
      }
    }';

    return $jsonData;
}
function sendFirstPostBackBtn($senderId){

  $jsonData = '{
  "recipient":{
    "id":"'.$senderId.'"
  },
  "message":{
    "text": "What are you looking for today?",
    "quick_replies":[
      {
        "content_type":"text",
        "title":"Bra",
        "payload":"BRA",
        "image_url":"http://example.com/img/red.png"
      },
      {
        "content_type":"text",
        "title":"Underware",
        "payload":"UNDERWARE",
        "image_url":"http://example.com/img/red.png"
      },
      {
        "content_type":"location"
      },
      {
        "content_type":"text",
        "title":"Something Else",
        "payload":"SOMETHING_ELSE"
      }
    ]
  }
}';

    return $jsonData;
}

function customerService($senderId){


  $jsonData = '{
  "recipient":{
    "id":"'.$senderId.'"
  },
  "message": {
    "attachment": {
      "type": "template",
      "payload": {
        "template_type": "button",
        "text": "Have a question about an order or need a little extra help? Our customer service team is here for you! You can call or email us any time. You can also email custserv@sarier.com directly and they\'ll get back to you asap.",
        "buttons": [
          {
            "type":"phone_number",
            "title":"📲 Call",
            "payload":"+85515704480"
          },
          { "type": "postback", "title": "📧 Email", "payload": "CUSTOMER_SERVICE_EMAIL" }
        ]
      }
    }
  }
}';

    return $jsonData;
}

function sendText($senderId, $message){
      //
    $reply = "Right now I can understand only send, tell, give . and I can only reply you my name";
    if(preg_match('/(send|tell|text|give)(.*?)your/', $message)){
      $res = json_decode(file_get_contents("https://207374d2.ngrok.io/MYBOTS/firstbot/json-data.php"),true);
      $reply = $res["first-name"];
    }

    $jsonData = '{
      "recipient":{
        "id":"'.$senderId.'"
      },
      "message":{
        "text":"'.$reply.'"
      }
    }';

    return $jsonData;

}

function sendCard($senderId, $messagae){

    $jsonData = '{
      "recipient":{
        "id":"'.$senderId.'"
      },
      "message":{
        "attachment":{
          "type":"image", 
          "payload":{
            "url":"https://cloud.netlifyusercontent.com/assets/344dbf88-fdf9-42bb-adb4-46f01eedd629/68dd54ca-60cf-4ef7-898b-26d7cbe48ec7/10-dithering-opt.jpg"
          }
        }
      }
    }';

    return $jsonData;
}

function senderAction($senderId){
 $jsonData ='{
  "recipient":{
    "id":"'.$senderId.'"
  },
  "sender_action":"typing_on"
}';
return $jsonData;
}

// echo $message." and ".$senderId;
function send($accessToken, $jsonData){

    // https://graph.facebook.com/v2.6/me/messages?access_token=<PAGE_ACCESS_TOKEN>
    $url = "https://graph.facebook.com/v2.6/me/messages?access_token=".$accessToken;

    $ch =curl_init($url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);

    // if(!empty($input["entry"][0]["messaging"][0]["message"])){
      curl_exec($ch);
    // }
}