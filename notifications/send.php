<?php
require 'vendor/autoload.php';
use Google\Auth\Credentials\ServiceAccountCredentials;
use Google\Auth\HttpHandler\HttpHandlerFactory;

?>
<?php


$credintals = new ServiceAccountCredentials(
    "https://www.googleapis.com/auth/firebase.messaging",
    json_decode(file_get_contents("ems3-4b249-firebase-adminsdk-e0bap-d5c5858967.json"),true)
);
$token = $credintals->fetchAuthToken(HttpHandlerFactory::build());
$accessToken = $token['access_token'];
$ch = curl_init("https://fcm.googleapis.com/v1/projects/ems3-4b249/messages:send");
curl_setopt($ch, CURLOPT_HTTPHEADER,[
    'Content-Type: application/json',
    'Authorization: '. 'Bearer '. $accessToken
]);

curl_setopt($ch, CURLOPT_POSTFIELDS,'{
  "message": {
    "token": "f49s_WkdUWDBspaidHJHEb:APA91bE-DHXOZmW7AB11xigHJ7piNp9bGk8NfogBpL6fBZ7N8jdRCZoQsgLDAi0G5zl63sZPp92l48-Heme4Tg1hPSD7MyC1e2PEAAVuyFrtDD_tLtLeCo0",
    "notification": {
      "title": "Background Message Title",
      "body": "Background message body",
      "image":"https://www.freeiconspng.com/uploads/green-yes-check-mark-png-17.png"
    },
    "webpush": {
      "fcm_options": {
        "link": "https://google.com"
      }
    }
  }
}');

curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
curl_setopt($ch,CURLOPT_VERBOSE,true);

curl_setopt($ch,CURLOPT_CUSTOMREQUEST,"post");
$response = curl_exec($ch);
if(curl_errno($ch)){
  echo 'Error:' . curl_error($ch);
}else{
  echo $response;
}
curl_close($ch);
echo "<script> console.log('accessToken: " . $accessToken . "');</script>";
?>