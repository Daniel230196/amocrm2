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
    'code' => 'def5020019eec7de8305d738c75e26e5ed556b1ac82d770d041aa0bdcb40fad5c75d0dc51842a37a812495486e919db05f4b4b5617a69715453a0d397be604b0aa8511700b35e1ceeee21215d07adf8ae961583d516cbd8e93aa68c4c5372b108a3445f159d7f25aef079c65b1ea0252381adde64f00765dbd3530de8f2f8a765d0139c8830469deefbf4e8710bddfdb587537ae741580e54bf045a539b63d0358ca552891accb8032ba156c51d901e585ee50ad416e62ebe8ab11e55dc9f929eedf16265a544efaa3874080cd26816e80629c931d8253eb2300ae165bc8f82e0c939d89363533dd0db0cd9115267c482923f12ba1e179dab4c9c43d5555455df90305d0d71f2c52630ab23a1f297afebd0446a62bdd0528f9a1aedef84bb39b520f8bede43f09f19637a69d411cc5a04b21f9e1b35b6d15b39331666b59756cbeac13e01b93c6611a912eb465df7ef8b68d376a1e450fa856285c97373a489e5cee58d4dfe04036f17c23b2da0004e5d8ee3929c50011dfd5a24d620b7d1d56d9d972e7b8e754278d541d31c9d1020f5a5ef2f11aa3ae275ebd0e7d30878cf13f0da92d7e326d57508ecefd8eb9d8009251a2d5712b6fbe71367d4f',
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

(c\Config::getInstance())->set('api', $response);

$access_token = $response['access_token'];
$refresh_token = $response['refresh_token'];
$token_type = $response['token_type'];
$expires_in = $response['expires_in'];
*/
