<?php
namespace Speechx;
/**
 * author: speechx-rtzhang
 * Date: 2016/12/26
 * Time: 16:55
 */

use Speechx\Core\Curl;

include_once 'autoloader.php';

Autoloader::register();

$token = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJfaWQiOiI1ODdlMmRmYWE2OGIxMTQ1MTFmNzMzMDgiLCJlbWFpbCI6ImFiY2RAYWJjLmNvbSIsInVzZXJuYW1lIjoidGVzdDExIiwiZXhwIjoxNDg1MjY5MTc0LCJpYXQiOjE0ODQ2NjQzNzR9.N3VLb-qaeIQyXHGOLK63onf177l33Neg-UflK3WpxNs";
$url = "http://192.168.0.101:8080/publisher/ids";
$header = array(
    'Authorization:Bearer '.$token,
    'Content-Type:application/json; charset=utf-8'
);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
curl_setopt($ch, CURLOPT_SSLVERSION, 1);
$response = curl_exec($ch);
curl_close($ch);

var_dump($response);



?>