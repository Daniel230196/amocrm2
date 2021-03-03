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
    'code' => 'def50200835d5150baa175610ec10d4f6c5fc47719d50d3950739796e1fc037f1d6e60112273e7e9ba19c6e45fcb3159b430591408e1c544d6fcda431ae5166c3fb5ed2c96760d80769635b9164801dcadb1320e461c817d49c63e7466d57f5bd0d2f87400d64c93e5e4b2f7a6d5a777a80458281ce2443964ea9dfcf34625ba874beac08a7fbd0c215246ed71fad47b7845da1eafc9c7ef41ef409296c2ed1f6d749feb3975a269c56f9a035ec0effeaccb59e81b6e919217aeb21e333787e19d97a665b448b378510e7272a80d5d668d41be10f05e316ec6e4a5d393ef3ac8f1cad7db810e7290108091436f167b6b53a11e5fc0b75901ae571ab8236926c9d7042df810bf582aa6ca9c5e98bdf13a32f67d7dee50a21c96c9e5bf7f6c89a2a5408c0736b0823f9dcac4803949c4541aed9f944d3c98815a0faa2e2915ab0a8d5fe6a9895a3194ed3d58c35e5d6805ae1bfce84ec18eb6e6681e6de5b7490ceac53166f47560d1ee4837ce37d1c640e96a8a34b4122ab35401e0fc52d6ae96362a6872a4017856104933628e84b121c92d568f81dbd997e67a5c819282e40072c29f1b6a38117693b0497c011b4a99f8098d5ff1682bea7aee7900',
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

