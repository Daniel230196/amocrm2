<?php

use core as c;

require_once 'vendor/autoload.php';

/*c\Loader::start();*/

$request = new c\Request();

c\Router::start($request);


/*
$subdomain = 'dann70s';
$link = 'https://' . $subdomain . '.amocrm.ru/oauth2/access_token';

$data = [
    'client_id' => '6a24cf0e-68dc-48ea-b5c5-343f9818a0d9',
    'client_secret' => 'xdPH0pqiXzt9RtoD1GYCXELGbGmq9ZTBKksjdWFdMXo1KdZkf8HKuyOG0O3HDFMX',
    'grant_type' => 'authorization_code',
    'code' => 'def5020089f81fbc9cf2871ae55c0f0562b6a4b648ad4f55a316687d62b3ce43c8d1b59d58fd29bcf9e83b1e6d82fcff657d75c6df98ebf0b840ca0bb8b9e84bdbd96ba410644c7dd5f6a8eed4ffa08f7b654f912a7136f996bf46b44514a3300d4fa273c49c0baf0fff5124dfaf391f8576a158ce785e97c4e4938697b3e4dd4fc95f42623582be35bc1ccb1f00a33d59acd48b6d047b46f27f4468d9879012e604e23f17b3b5ad2b4ae38dafd1ae4f472540d1f58d06e03e91034dcf16179b8cd67069a259676e28247529e7409c283d730e1c4530cdfe5a83d4f135901a80cf8a1f7fbfa79535b9c9eb417197c10af18fc871b77d48493d2e401deda3f24d13ab5aaf3b173c32b212374bb19d014052279505bb8561151c4363e243e55ac439a6d9fb694fc8c8034bd57317ea79469e1ec52f33e07c0151f5f101fcd50bf6a8f75ba848ca2e90c90dc247716086ee23ad6180ce7164c3b4f49c411a96c90c1903f7e2beee8dfbbe305ab67cef32cb9d58965f5d5c479753809c8f518ac571529bf7276dfc7c85244dfd0318aae61f5e84398141987f4f5867387a04b008b68bd1e06405abb0f7e19ab862e7993c249010a19f111d7c4543c6e4d2',
    'redirect_uri' => 'https://google.com',
];


$curl = curl_init();
curl_setopt($curl,CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl,CURLOPT_USERAGENT,'amoCRM-oAuth-client/1.0');
curl_setopt($curl,CURLOPT_URL, $link);
curl_setopt($curl,CURLOPT_HTTPHEADER,['Content-Type:application/json']);
curl_setopt($curl,CURLOPT_HEADER, false);
curl_setopt($curl,CURLOPT_CUSTOMREQUEST, 'POST');
curl_setopt($curl,CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($curl,CURLOPT_SSL_VERIFYPEER, 1);
curl_setopt($curl,CURLOPT_SSL_VERIFYHOST, 2);
$out = curl_exec($curl);
$code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
curl_close($curl);

$code = (int)$code;
$errors = [
    400 => 'Bad request',
    401 => 'Unauthorized',
    403 => 'Forbidden',
    404 => 'Not found',
    500 => 'Internal server error',
    502 => 'Bad gateway',
    503 => 'Service unavailable',
];

try
{

    if ($code < 200 || $code > 204) {
        throw new Exception(isset($errors[$code]) ? $errors[$code] : 'Undefined error', $code);
    }
}
catch(\Exception $e)
{
    die('Ошибка: ' . $e->getMessage() . PHP_EOL . 'Код ошибки: ' . $e->getCode());
}


$response = json_decode($out, true);

$access_token = $response['access_token'];
$refresh_token = $response['refresh_token'];
$token_type = $response['token_type'];
$expires_in = $response['expires_in'];

echo 'acc: '.$access_token . "</br>";
echo 'ref: '.$refresh_token . "</br>";*/