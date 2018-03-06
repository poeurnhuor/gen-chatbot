<?php

include 'json-data.php';

$dataMessage = displayDataMessage();
$dataCourse = displayDataCourseInfo();

//AccessToken take from Messenger -> Settings from App Dashboard
$accessToken = "EAALDUpemr1wBADXkix4Exhx4zpIFULLjOWNZAk9QZCY1VhZCpw73uSy0iRDBZAMPxzJjSYyCl9ICe9UQo5t2zw53LwoBO0GSga8pZCsyzcu82r8rQVLYvdwb3h5xGOidB6QSJq2kTZAqFtPfFo8lWjoinEpDUHWhZAFug4cbuOA7QZDZD";
//End accessToken take from Messenger -> Settings from App Dashboard

//Verify token code for being enable Webhooks
if(isset($_REQUEST['hub_challenge'])){
    $challenge = $_REQUEST['hub_challenge'];
    $verify_token = $_REQUEST['hub_verify_token'];
    if ($verify_token === 'huor_gen_token_code') {
        echo $challenge;
    }
}
//End verify token code for being enable Webhooks


$input = json_decode(file_get_contents('php://input'),true);
$senderId = $input["entry"][0]["messaging"][0]["sender"]["id"];
$recipient_id = $input["entry"][0]["messaging"][0]["recipient"]["id"];
$messageArray = $input["entry"][0]["messaging"][0];


if(isTextSendFirstTime($messageArray)){
    send($accessToken,sendFirstMessage($senderId, $dataMessage['first-welcome-message']));
    send($accessToken,sendFirstPostBackBtn($senderId,$recipient_id));
}

if(isButtonSendCourse($messageArray)){
    send($accessToken,sendFirstMessage($senderId,$dataCourse['course']));
//    send($accessToken,sendPostBackBtnCourse($senderId,$recipient_id));
}

if(isButtonSendPHP($messageArray)){
    send($accessToken, sendTemplatePHP($senderId));
    send($accessToken,sendPostBackBtnPHP($senderId,$recipient_id));
}

if(isButtonSendContactInfo($messageArray)){
    send($accessToken,sendPostBackBtnContactInfo($senderId,$recipient_id));
}

if(isset($messageArray["message"])){
    if(isset($messageArray["message"]["is_echo"])){
        die();
    }else{
        send($accessToken,senderAction($senderId));
        send($accessToken,sendText($senderId,$messageArray["message"]["text"]));
    }
}

function isTextSendFirstTime($messageArray){
    if(isset($messageArray["postback"])){
        if($messageArray["postback"]["payload"] == "button_get_started"){
            return true;
        }else{
            return false;
        }
    }else{
        return false;
    }
}

function isButtonSendCourse($messageArray){
    if(isset($messageArray["message"])){
        if($messageArray["message"]["quick_reply"]["payload"] == "COURSE"){
            return true;
        }else{
            return false;
        }
    }else{
        return false;
    }
}

function isButtonSendPHP($messageArray){
    if(isset($messageArray["message"])){
        if($messageArray["message"]["quick_reply"]["payload"] == "PHP"){
            return true;
        }else{
            return false;
        }
    }else{
        return false;
    }
}

function isButtonSendContactInfo($messageArray){
    if(isset($messageArray["postback"])){
        if($messageArray["postback"]["payload"] == "CONTACT_INFO"){
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

function sendTemplatePHP($senderId){

    $dataTemplate = displayDataTemplate();
    $url_1 = $dataTemplate['url']['php']['url-1'];
    $phpTitle_1 = $dataTemplate['title']['php']['title-1'];
    $phpSubtitle_1 = $dataTemplate['title']['php']['subtitle-1'];

    $url_2 = $dataTemplate['url']['php']['url-2'];
    $phpTitle_2 = $dataTemplate['title']['php']['title-2'];
    $phpSubtitle_2 = $dataTemplate['title']['php']['subtitle-2'];

    $jsonData = '{
      "recipient":{
        "id":"'.$senderId.'"
      },
      "message": {
        "attachment": {
            "type": "template",
            "payload": {
                "template_type": "generic",
                "elements": [
                      {
                        "title": "'.$phpTitle_1.'",
                        "subtitle": "'.$phpSubtitle_1.'",
                        "image_url": "'.$url_1.'",
                        "buttons": [{
                            "title": "View",
                            "type": "web_url",
                            "url": "https://www.medium.com/",
                            "messenger_extensions": "false",
                            "webview_height_ratio": "full"
                        }],
                        "default_action": {
                            "type": "web_url",
                            "url": "https://www.medium.com/",
                            "messenger_extensions": "false",
                            "webview_height_ratio": "full"
                        }
                    },
                    {
                         "title": "'.$phpTitle_2.'",
                        "subtitle": "'.$phpSubtitle_2.'",
                        "image_url": "'.$url_2.'",
                        "buttons": [{
                            "title": "View",
                            "type": "web_url",
                            "url": "https://www.medium.com/",
                            "messenger_extensions": "false",
                            "webview_height_ratio": "full"
                        }],
                        "default_action": {
                            "type": "web_url",
                            "url": "https://www.medium.com/",
                            "messenger_extensions": "false",
                            "webview_height_ratio": "full"
                        }
                    }
                ]
            }
        }
    }
    }';
    return $jsonData;
}

function sendPostBackBtnContactInfo($senderId){

    $dataContact = displayDataContact();

    $jsonData = '{
  "recipient":{
    "id":"'.$senderId.'"
  },
  "message":{
    "text": "'.$dataContact['data-contact'].'",
    "quick_replies":[
       {
        "content_type":"text",
        "title":"Course",
        "payload":"COURSE",
      },
      {
        "content_type":"text",
        "title":"PHP",
        "payload":"PHP",
      },
      {
        "content_type":"text",
        "title":"MySQL",
        "payload":"MYSQL"
      },
      {
        "content_type":"text",
        "title":"Oracal",
        "payload":"ORACAL"
      },
      {
        "content_type":"text",
        "title":"CCNA2",
        "payload":"CCNA2"
      },
      {
        "content_type":"text",
        "title":"JAVA",
        "payload":"JAVA"
      },
      {
        "content_type":"text",
        "title":"CCNA2",
        "payload":"CCNA2"
      },
      {
        "content_type":"text",
        "title":"WORD",
        "payload":"MICROSOFT_WORD"
      },
      {
        "content_type":"text",
        "title":"EXCEL",
        "payload":"MICROSOFT_EXCEL"
      },
      {
        "content_type":"text",
        "title":"POWER-POINT",
        "payload":"POWER_POINT"
      },
      {
        "content_type":"location"
      }
    ]
  }
}';
    return $jsonData;
}

function sendPostBackBtnPHP($senderId){

    $dataCourse = displayDataCourseInfo();

    $jsonData = '{
  "recipient":{
    "id":"'.$senderId.'"
  },
  "message":{
    "text": "'.$dataCourse['php'].'",
    "quick_replies":[
       {
        "content_type":"text",
        "title":"Course",
        "payload":"COURSE",
      },
      {
        "content_type":"text",
        "title":"PHP",
        "payload":"PHP",
      },
      {
        "content_type":"text",
        "title":"MySQL",
        "payload":"MYSQL"
      },
      {
        "content_type":"text",
        "title":"Oracal",
        "payload":"ORACAL"
      },
      {
        "content_type":"text",
        "title":"CCNA2",
        "payload":"CCNA2"
      },
      {
        "content_type":"text",
        "title":"JAVA",
        "payload":"JAVA"
      },
      {
        "content_type":"text",
        "title":"CCNA2",
        "payload":"CCNA2"
      },
      {
        "content_type":"text",
        "title":"WORD",
        "payload":"MICROSOFT_WORD"
      },
      {
        "content_type":"text",
        "title":"EXCEL",
        "payload":"MICROSOFT_EXCEL"
      },
      {
        "content_type":"text",
        "title":"POWER-POINT",
        "payload":"POWER_POINT"
      },
      {
        "content_type":"location"
      }
    ]
  }
}';
    return $jsonData;
}

//function sendPostBackBtnCourse($senderId){
//    $jsonData = '{
//  "recipient":{
//    "id":"'.$senderId.'"
//  },
//  "message":{
//    "text": "You can ask us the price of each courses",
//    "quick_replies":[
//       {
//        "content_type":"text",
//        "title":"Course",
//        "payload":"COURSE",
//      },
//      {
//        "content_type":"text",
//        "title":"PHP",
//        "payload":"PHP",
//      },
//      {
//        "content_type":"text",
//        "title":"MySQL",
//        "payload":"MYSQL"
//      },
//      {
//        "content_type":"text",
//        "title":"Oracal",
//        "payload":"ORACAL"
//      },
//      {
//        "content_type":"text",
//        "title":"CCNA2",
//        "payload":"CCNA2"
//      },
//      {
//        "content_type":"text",
//        "title":"JAVA",
//        "payload":"JAVA"
//      },
//      {
//        "content_type":"text",
//        "title":"CCNA2",
//        "payload":"CCNA2"
//      },
//      {
//        "content_type":"text",
//        "title":"WORD",
//        "payload":"MICROSOFT_WORD"
//      },
//      {
//        "content_type":"text",
//        "title":"EXCEL",
//        "payload":"MICROSOFT_EXCEL"
//      },
//      {
//        "content_type":"text",
//        "title":"POWER-POINT",
//        "payload":"POWER_POINT"
//      },
//      {
//        "content_type":"location"
//      }
//    ]
//  }
//}';
//    return $jsonData;
//}

function sendFirstPostBackBtn($senderId){

    $messageGetStarted = displayMessageGetStarted();

    $jsonData = '{
  "recipient":{
    "id":"'.$senderId.'"
  },
  "message":{
    "text": "'.$messageGetStarted['message-get-started'].'",
    "quick_replies":[
       {
        "content_type":"text",
        "title":"Course",
        "payload":"COURSE",
      },
      {
        "content_type":"text",
        "title":"PHP",
        "payload":"PHP",
      },
      {
        "content_type":"text",
        "title":"MySQL",
        "payload":"MYSQL"
      },
      {
        "content_type":"text",
        "title":"Oracal",
        "payload":"ORACAL"
      },
      {
        "content_type":"text",
        "title":"CCNA2",
        "payload":"CCNA2"
      },
      {
        "content_type":"text",
        "title":"JAVA",
        "payload":"JAVA"
      },
      {
        "content_type":"text",
        "title":"CCNA2",
        "payload":"CCNA2"
      },
      {
        "content_type":"text",
        "title":"WORD",
        "payload":"MICROSOFT_WORD"
      },
      {
        "content_type":"text",
        "title":"EXCEL",
        "payload":"MICROSOFT_EXCEL"
      },
      {
        "content_type":"text",
        "title":"POWER-POINT",
        "payload":"POWER_POINT"
      },
      {
        "content_type":"location"
      }
    ]
  }
}';
    return $jsonData;
}


//function customerService($senderId){
//    $jsonData = '{
//  "recipient":{
//    "id":"'.$senderId.'"
//  },
//  "message": {
//      "attachment": {
//      "type": "template",
//      "payload": {
//        "template_type": "button",
//        "text": "Have a question about an order or need a little extra help? Our customer service team is here for you! You can call or email us any time. You can also email custserv@sarier.com directly and they\'ll get back to you asap.",
//        "buttons": [
//          {
//            "type":"postback",
//            "title":"📲 +855 96 670 7122",
//            "payload":"+855 96 670 7122"
//          },
//          { "type": "postback", "title": "📧 huorpoeurn22@gmail.com", "payload": "CUSTOMER_SERVICE_EMAIL" }
//        ]
//      }
//    }
//  }
//}';
//    return $jsonData;
//}

function sendText($senderId, $message){

    $dataCourse = displayDataCourseInfo();
    $dataMessage = displayDataMessage();

    $reply = $dataMessage['text-hello'];

    if(preg_match('/(what|What|could|Could|can|Can|I want|I need)(.*?) course?/', $message)){
        //   $dataCourse = json_decode(file_get_contents('http://api.icndb.com/jokes/random'), true);
        // $dataCourse = ['value']['joke'];
        $reply= $dataCourse['course'];
    }

    if(preg_match('/(how much|price|cost)(.*?) CCNA?/', $message) || preg_match('/(How much|Price|Cost)(.*?) ccna?/', $message)
        || preg_match('/(How much|Price|Cost)(.*?) CCNA?/', $message) ||preg_match('/(how much|price|cost)(.*?) ccna?/', $message)){
        $reply = $dataCourse['ccna1']. ' ' . 'and' . ' ' . $dataCourse['ccna2'];
    }

    if(preg_match('/(how much|price|cost)(.*?) mysql?/', $message) || preg_match('/(how much|price|cost)(.*?) MySQL?/', $message) || preg_match('/(How much|Price|Cost)(.*?) MySQL?/', $message)){
        $reply = $dataCourse['mysql'];
    }

    if(preg_match('/(how much|price|cost)(.*?) oracal?/', $message) || preg_match('/(How much|Price|Cost)(.*?) Oracal?/', $message) || preg_match('/(How much|Price|Cost)(.*?) oracal?/', $message)){
        $reply = $dataCourse['oracal'];
    }

    if(preg_match('/(how much|price|cost)(.*?) java?/', $message) || preg_match('/(How much|Price|Cost)(.*?) Java?/', $message)
        || preg_match('/(How much|Price|Cost)(.*?) JAVA?/', $message) || preg_match('/(how much|price|cost)(.*?) JAVA?/', $message)){
        $reply = $dataCourse['java'];
    }

    if(preg_match('/(how much|price|cost)(.*?) php?/', $message) || preg_match('/(How much|Price|Cost)(.*?) php?/', $message)
        || preg_match('/(How much|Price|Cost)(.*?) PHP?/', $message) || preg_match('/(how much|price|cost)(.*?) PHP?/', $message)){
        $reply = $dataCourse['php'];
    }

    if(preg_match('/(how much|price|cost)(.*?) microsoft word?/', $message) || preg_match('/(how much|price|cost)(.*?) Microsoft Word?/', $message)
        || preg_match('/(how much|price|cost)(.*?) Microsoft word?/', $message) ||preg_match('/(how much|price|cost)(.*?) microsoft Word?/', $message)
        || preg_match('/(How much|Price|Cost)(.*?) microsoft word?/', $message) || preg_match('/(How much|Price|Cost)(.*?) Microsoft Word?/', $message)
        || preg_match('/(How much|Price|Cost)(.*?) Microsoft word?/', $message) ||preg_match('/(How much|Price|Cost)(.*?) microsoft Word?/', $message)){
        $reply = $dataCourse['microsoft']['word']['price'];
    }

    if(preg_match('/(how much|price|cost)(.*?) microsoft excel?/', $message) || preg_match('/(how much|price|cost)(.*?) Microsoft Excel?/', $message)
        || preg_match('/(how much|price|cost)(.*?) Microsoft excel?/', $message) ||preg_match('/(how much|price|cost)(.*?) microsoft Excel?/', $message)
        || preg_match('/(How much|Price|Cost)(.*?) microsoft excel?/', $message) || preg_match('/(How much|Price|Cost)(.*?) Microsoft Excel?/', $message)
        || preg_match('/(How much|Price|Cost)(.*?) Microsoft excel?/', $message) ||preg_match('/(How much|Price|Cost)(.*?) microsoft Excel?/', $message)){
        $reply = $dataCourse['microsoft']['excel']['price'];
    }


    if(preg_match('/(how much|price|cost)(.*?) microsoft power point?/', $message) || preg_match('/(how much|price|cost)(.*?) Microsoft Power Point?/', $message)
        || preg_match('/(how much|price|cost)(.*?) Microsoft power point?/', $message) ||preg_match('/(how much|price|cost)(.*?) microsoft Power Point?/', $message)
        ||preg_match('/(How much|Price|Cost)(.*?) microsoft power point?/', $message) || preg_match('/(How much|Price|Cost)(.*?) Microsoft Power Point?/', $message)
        || preg_match('/(How much|Price|Cost)(.*?) Microsoft power point?/', $message) ||preg_match('/(How much|Price|Cost)(.*?) microsoft Power Point?/', $message)){
        $reply = $dataCourse['microsoft']['power-point']['price'];
    }

    if(preg_match('/(great|Great|thank|Thank|like|Like|love|Love|that|That)(.*?) /', $message)){
        $reply = "Thanks for being interested in our courses. If any, please contact us";
    }

    if(preg_match('/(bye|Bye|see|See|ask|Ask|contact|Contact)(.*?) /', $message)){
        $reply = "Ok see you, you can ask me whenever you need more details. thanks!";
    }

    if(preg_match('/(Hello|Hi|hello|hi|Hey|hey)(.*?) /', $message)){
        $reply = $dataMessage['text-hello'];
    }

    $jsonData = '{
    
      "recipient":{
        "id":"'.$senderId.'"
      },
      "message":{
   
      "attachment": {
      "type": "template",
      "payload": {
        "template_type": "button",
        "text": "'.$reply.'",
        "buttons": [
            {
            "type":"web_url",
            "url":"https://www.google.com",
            "title":"More Detail"
          }
        ]
      }
    },
   
    "quick_replies":[
      {
        "content_type":"text",
        "title":"Course",
        "payload":"COURSE",
      },
      {
        "content_type":"text",
        "title":"PHP",
        "payload":"PHP",
      },
      {
        "content_type":"text",
        "title":"MySQL",
        "payload":"MYSQL"
      },
      {
        "content_type":"text",
        "title":"Oracal",
        "payload":"ORACAL"
      },
      {
        "content_type":"text",
        "title":"CCNA2",
        "payload":"CCNA2"
      },
      {
        "content_type":"text",
        "title":"JAVA",
        "payload":"JAVA"
      },
      {
        "content_type":"text",
        "title":"CCNA2",
        "payload":"CCNA2"
      },
      {
        "content_type":"text",
        "title":"WORD",
        "payload":"MICROSOFT_WORD"
      },
      {
        "content_type":"text",
        "title":"EXCEL",
        "payload":"MICROSOFT_EXCEL"
      },
      {
        "content_type":"text",
        "title":"POWER-POINT",
        "payload":"POWER_POINT"
      },
      {
        "content_type":"location"
      }
    ]
  }
}';
    return $jsonData;
}

//function sendCard($senderId, $messagae){
//    $jsonData = '{
//      "recipient":{
//        "id":"'.$senderId.'"
//      },
//      "message":{
//        "attachment":{
//          "type":"image",
//          "payload":{
//            "url":"https://cloud.netlifyusercontent.com/assets/344dbf88-fdf9-42bb-adb4-46f01eedd629/68dd54ca-60cf-4ef7-898b-26d7cbe48ec7/10-dithering-opt.jpg"
//          }
//        }
//      }
//    }';
//    return $jsonData;
//}

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
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, True);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, False);
//     if(!empty($input["entry"][0]["messaging"][0]["message"])) {
         curl_exec($ch);

         $errors = curl_error($ch);
         $dataCourseponse = curl_getinfo($ch, CURLINFO_HTTP_CODE);

         var_dump($errors);
         var_dump($dataCourseponse);

         curl_close($ch);
//     }

 }

?>

