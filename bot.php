<?php
// URL API LINE
$API_URL = 'https://api.line.me/v2/bot/message';
// ใส่ Channel access token (long-lived)
$ACCESS_TOKEN = 'PMMv8ix0Wv771V5FbGFDBCNmCvCz3+Fdglq3WuXxbFyy1Zu87/bJdR+B9WqqYuTKy8cw+WkzFfWlAm8GqxunPHL2z0/smvur2fSaISfpnJJOjh8dDZJ0CFL0fLx20KjSaCqkQVZJoKOAfHcCkWcBawdB04t89/1O/w1cDnyilFU=';
// ใส่ Channel Secret
$CHANNEL_SECRET = '52c420785498f08717003ea1e7e945a0';

// Set HEADER
$POST_HEADER = array('Content-Type: application/json', 'Authorization: Bearer ' . $ACCESS_TOKEN);
// Get request content
$request = file_get_contents('php://input');
// Decode JSON to Array
$request_array = json_decode($request, true);

/*
if ( sizeof($request_array['events']) > 0 ) {
    foreach ($request_array['events'] as $event) {
    
    $reply_message = '';
    $reply_token = $event['replyToken'];
    $data = [
       'replyToken' => $reply_token,
       'messages' => [
          ['type' => 'text', 
           'text' => json_encode($request_array)]
       ]
    ];
    $post_body = json_encode($data, JSON_UNESCAPED_UNICODE);
    $send_result = send_reply_message($API_URL.'/reply', $POST_HEADER, $post_body);
    echo "Result: ".$send_result."\r\n";
 }
}
echo "OK";
*/

if ( sizeof($request_array['events']) > 0 ) {
    foreach ($request_array['events'] as $event) {
       
       $reply_message = '';
       $reply_token = $event['replyToken'];
       $text = $event['message']['text'];
       $data = [
          'replyToken' => $reply_token,
          'messages' => [['type' => 'text', 'text' => $text ]]
       ];
       $post_body = json_encode($data, JSON_UNESCAPED_UNICODE);
       $send_result = send_reply_message($API_URL.'/reply',      $POST_HEADER, $post_body);
       echo "Result: ".$send_result."\r\n";
     }
 }

function send_reply_message($url, $post_header, $post_body)
{
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $post_header);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_body);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    $result = curl_exec($ch);
    curl_close($ch);

    return $result;
}
?>