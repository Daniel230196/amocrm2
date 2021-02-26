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
    'code' => 'def50200f5e9fad9a2f2a29090100923d927a2b635ed54375f892980cabf4b01b55d17df94c9ad2945df368b5b02355385d38804da58ea00f03acd15ea31c834eb31e7fd457c06c079af97d3698dc0f1735dc994327086d57b2ab1acf7ee2327f902407fa4dfa1fe612bd21f18013cd214c9fd751d039f4f9b92c2c59761821a3bb4dd7dca0ca7b2b6dc0969b6f92eace9c9a4c7a3e5d8b4d470745ebfddb55a40f37e54db86998700e061dfe9562121554d9c0c5bda7cbc6f3b7c30852d5374720de83caf62b969ceedcc1b4c176cb7b976da68041187b6818207931bb05dbe8dc58a4edbb925bcff1e071d3088e1718f669b92570991d29909639fb50d79e9e25171280bdf3cc9e3cf2bb11163f9ae7de2fb7bfd53b04138b406a7d9d077851f1b3d06a4c6aa2041f8d104111a2fd05708eb756796618544e9a4282dd30c383655ab1ad3cb31de50a83f8cd7a93681830c0947baae6f3672b3feffc0c867e36bf94ab2e22ed6a3ef66baffa4d41cc17ebc44f56058575cd70f4067157346ec4259d7d71abee74cd334bc3fe4faaf9d3fb95b1daf8fdeccc5f807aff67b5d3fd9d084afcf473820e08bac6a9aa146b08601c87d94ebf0cf6f91f2fc',
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
