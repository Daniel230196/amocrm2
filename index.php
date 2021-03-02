<?php

use core as c;

require_once 'vendor/autoload.php';

/*c\Loader::start();*/

$request = new c\Request();

c\Router::start($request);


/*$subdomain = 'dann70s';
$link = 'https://' . $subdomain . '.amocrm.ru/oauth2/access_token';

$data = [
    'client_id' => '6a24cf0e-68dc-48ea-b5c5-343f9818a0d9',
    'client_secret' => 'xdPH0pqiXzt9RtoD1GYCXELGbGmq9ZTBKksjdWFdMXo1KdZkf8HKuyOG0O3HDFMX',
    'grant_type' => 'authorization_code',
    'code' => 'def50200e5b2746ef55a5f8251437abb0b0aa9ab502565744abad05ce6f87f94d56550bcfe841b2da95dc826f4583abbe56add9f9e4cf07466299933a9ddd46ca2bf776d3042bf391585fd1758f27c12159b747f9979f9bc675f78d2776d997495138fc826e253de32217436c0e0e3c0219d28fbad6a65f035d0fdd5ac8be57774544ceba1cc1080001e24bf2a1e8de70860ef7cb729ce032edb23621a81740fe23330df6d401728cae5877d09f2aa45a485211918856b66853e2ba261fd466d9e418b4e27e8dff23535cc928824b8e0ffce4f1e12f86e72f868ad7bbbcae77b9f5e4cf36578a52cfaee9a6b429e7c673ddcc0dceace29cad59f0eb684a415814e157e2c78d8efc242a4e0bcd94e6eb777c3a6b4f68c32582e06bb55674a8d27e131aa12da7c42f493d3b83cd2764de2cf483e01dd977bbdd599e77081baeff5f56582bad489b10bfab58caad5d886b7516bc8410a1c251239350212befd4872e079b93d13c1831ee7dd0474dd43e6b2464c284adc1aafcea7f4809e3e742736c37c3f99de2c57d5fb8bbe62b71e0bf52e0a80d0ccc66ec04a95d659c359f0b0204a1614afd310963bf563ddd0b75f67aead1457f61c8ef28632f0d0',
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
$expires_in = $response['expires_in'];*/

