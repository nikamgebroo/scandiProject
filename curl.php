<?php
$url = 'https://jsonplaceholder.typicode.com/users';
//$resource = curl_init($url);
//curl_setopt($resource, CURLOPT_URL, $url);
//curl_setopt($resource, CURLOPT_RETURNTRANSFER, true);
//$result = curl_exec($resource);

//echo $result;

//$responseCode =curl_getinfo($resource, CURLINFO_HTTP_CODE);
//echo $responseCode;
$resource = curl_init($url);
$user = [
    'name' => 'zura aghdghoma',
    'username' => 'zura',
    'email' => 'diophantzura@rambler.com'
];
 curl_setopt_array($resource,[
 CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => json_encode($user),
     CURLOPT_RETURNTRANSFER =>true,
     CURLOPT_HTTPHEADER =>['content-type:application/json']
    ]);
$result = curl_exec($resource);
echo $result;