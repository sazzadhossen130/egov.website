<?php
ob_start();
include_once "./bkashconfig.php";

$curl = curl_init();

$data = json_encode([
  "paymentID" => $_GET['paymentID'],
]);

if(!isset($_GET['paymentID']) || empty($_GET['paymentID']) ){
  $_SESSION['Error'] = "ভুল রিকুয়েস্ট।";
  header("Location: ../recharge.php?statusMessage=error&id=0");
  die();
}

curl_setopt_array($curl, [
  CURLOPT_URL => BASEURL . "/tokenized/checkout/execute",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => $data,
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

  $_SESSION['Error'] = json_encode($err);

  header("Location: ../recharge.php?statusMessage=error&id=1");
  die();

} else {

  $response = json_decode($response);
  //add config file for db connection
  include('../inc/db.php');
  // validate payment
  if($response->statusMessage !== 'Successful' || $response->transactionStatus !== 'Completed'){
    header("Location: ../recharge.php?statusMessage=error&id=2");
    die();
  }else if($response->statusMessage === 'Successful' && $response->transactionStatus === 'Completed'){
    //update user balance
    
    $userAcc = $_SESSION['user'];
    $amunt = $response->amount;

    
    // Prepare the SQL statement with values directly in the query
    $sql = "UPDATE users SET balance = balance + '$amunt' WHERE id = '$userAcc'";
    
    // Execute the query for balance update
    $result = mysqli_query($conn, $sql);
    
    
   
    
    
    header("Location: ../recharge.php?statusMessage=success&id=1");
    die();
  }else{

    header("Location: ../recharge.php?statusMessage=error&id=3");
    die();
  }
}