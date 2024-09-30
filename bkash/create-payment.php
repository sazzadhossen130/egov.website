<?php

include_once "bkashconfig.php";

$curl = curl_init();

$requestbody = array(
    'mode'                  => '0011',
    'amount'                => $_POST['amount'],
    'currency'              => 'BDT',
    'intent'                => 'sale',
    'payerReference'        => 'site',
    'merchantInvoiceNumber' => random_int(1000000, 9999999),
    'callbackURL'           => CALLBACK,
);

curl_setopt_array($curl, [
  CURLOPT_URL => BASEURL."/tokenized/checkout/create",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => json_encode($requestbody),
  CURLOPT_HTTPHEADER => [
    "Authorization: ".$_SESSION['id_token'],
    "X-APP-Key: ".APPKEY,
    "accept: application/json",
    "content-type: application/json"
  ],
]);

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {

  echo "cURL Error #:" . $err;

} else {
    $urlB = json_decode($response)->bkashURL;

  header("Location: $urlB");
}