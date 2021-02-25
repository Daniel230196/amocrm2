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
    'code' => 'def50200bd0f7403e111dec15b9c734d832bf2176859b9a923b63a3789e5d19bef235fad9d4d5a52bfff0a746714db5af79e74838769cbedc65e75f30b4c44a681d6f789007f76a9e5693bc1974b7772f9532345e5cb68029b74ed6d902ed7fbe057f58c90ff610289adde0ec72ca6258cbb0757e680092b3374ab3973e5ef7884b8c6d04a8baffac05918c69472b8b7836f8f04f4bcb5a8262f65711e3371cc9920be6e1bf50707beb685110a40712c2524add2c93ec805e1560eac24010b09133f9256f64b4976185f82f5a66930519087999176cdcd1ba44f08ddd147b18c7e5258aeb78b3bb26a3fcefd8542c17cae9291b5fd8feab2e186c698036846a47328438ca290bcbed98dd0c5f340b53a2c7016a0765ea4816a8a6d02dff1ff13f4c0efceef81b9f81f95b8fd6576ea252aed1a15444ff99e2e33a8cff94595176a53a6d23d28b442999b26cbf27dee90774809b7d0d7a0f828a8d603d36b72f1b51d35e41a57d2241bb0991004e8ad2052eb5a2b458a24d3162bc2758c0c5b4224e42c2fd09857769ef389c104b7bdcaa5a115623c09bb03ff7559a2787d4029253b13abed35d91bbdea15ee624e81d1af30e93e892088d98092dc8e',
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