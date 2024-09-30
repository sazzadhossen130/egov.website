<?php
session_start();
if(!isset($_SESSION['uid'])) {
 header('location:logout.php');
}else{
 $id = $_SESSION['uid'];
 $username = $_SESSION['username'];
}

include 'function.php';
define('BKS_URL', 'https://tokenized.pay.bka.sh/v1.2.0-beta/tokenized');
define('BKS_USER', '0179186409');
define('BKS_PASS', '_:_}&ZUX)6f');
define('BKS_KEY', 'zIKZrgSpRQjl8OUtJRD1RL5Ntc');
define('BKS_SEC', 'lRyUJUqfzpGgXU6Jez1lxzAwihFXbjwi065pthSS5V1uNwinlhVG');

$conn = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
if(!$conn){
 header("Location:recharge-msg.php?msg=Database connection lost");
}else{
    $fetchdata = new DB_con();
    $data = $fetchdata->get_control();
 $row = mysqli_fetch_array($data);
 $recharge_msg = $row['rg_msg'];
 $approval = $row['robi_token'];
}

function getProtocolServer(){
    if (isset($_SERVER['HTTPS']) &&($_SERVER['HTTPS'] == 'on'  $_SERVER['HTTPS'] == 1)  isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https'){
     $protocol = 'https://';
    }else{
     $protocol = 'http://';
    }
 $server = $_SERVER['SERVER_NAME'];
    return $protocol.$server;
}

function getAuthToken(){
 $curl = curl_init();
 curl_setopt($curl, CURLOPT_URL, BKS_URL.'/checkout/token/grant');
 curl_setopt($curl, CURLOPT_POST, 1);
 curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode(['app_key' => BKS_KEY,'app_secret' => BKS_SEC]));
 curl_setopt($curl, CURLOPT_RETURNTRANSFER , 1);
 curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
 curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
 curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
 curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type:application/json','username:'. BKS_USER,'password:'. BKS_PASS]);
 $content = curl_exec($curl);
    curl_close($curl);
    $response = json_decode($content, true);
 if($response['statusCode'] == "0000"){
  $_SESSION['id_token'] = $response['id_token'];
  return $response['id_token'];
 }else{
  return null;
 } 
}

function createPaymentLink($ammount){ 
 $domain = getProtocolServer();
 $authToken = getAuthToken();
 if($authToken != null){
  $curl = curl_init();
  curl_setopt($curl, CURLOPT_URL, BKS_URL.'/checkout/create');
  curl_setopt($curl, CURLOPT_POST, 1);
  curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode(['mode' => '0011','amount' => $ammount,'payerReference' => " ",'callbackURL' => $domain ."/recharge.php",'currency' => 'BDT','intent' => 'sale','merchantInvoiceNumber' => 'Inv'.rand()]));
  curl_setopt($curl, CURLOPT_RETURNTRANSFER , 1);
  curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
  curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
  curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
  curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type:application/json','Authorization:'. $authToken,'X-APP-Key:'. BKS_KEY]);
  $content = curl_exec($curl);
  curl_close($curl);
  $response = json_decode($content, true);
  if($response['statusCode'] == "0000"){
   return $response['bkashURL'];
  }else{
   return null;
  }
 }else{
  return null;
 }
}

function getPaymentDetils($paymentID){
 $authToken = getAuthToken();
 if(isset($_SESSION['id_token'])){
  $curl = curl_init();
  curl_setopt($curl, CURLOPT_URL, BKS_URL.'/checkout/execute');
  curl_setopt($curl, CURLOPT_POST, 1);
  curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode(['paymentID' => $paymentID]));
  curl_setopt($curl, CURLOPT_RETURNTRANSFER , 1);
  curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
  curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
  curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
  curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type:application/json','Authorization:'.$_SESSION['id_token'],'X-APP-Key:'. BKS_KEY]);
  $content = curl_exec($curl);
  curl_close($curl);
  $response = json_decode($content, true);
  if($response['statusCode'] == "0000"){
   $result = [];
   $result['success'] = true;
   $result['payerReference'] = $response['payerReference'];
   $result['customerMsisdn'] = $response['customerMsisdn'];
   $result['trxID'] = $response['trxID'];
   $result['amount'] = $response['amount'];
   $result['merchantInvoiceNumber'] = $response['merchantInvoiceNumber'];
   $result['paymentExecuteTime'] = $response['paymentExecuteTime'];
   return $result;
  }else{
   $result = [];
   $result['success'] = false;
   $result['statusMessage'] = $response['statusMessage'];
   return $result;
  }
 }else{
  return null;
 }
}

function checkNewPaymentID($paymentID,$trxID,$amount){
 global $conn;
 $checkPaymentList = mysqli_query($conn, "SELECT * FROM bkash_pay WHERE paymentID = '$paymentID', trxID = '$trxID', amount = '$amount'");
 $totalPaymentList = mysqli_num_rows($checkPaymentList);
 if($totalPaymentList > 0){
  return false;
 }else{
  return true;
 }
}

function savePaymentID($paymentID,$paymentDetils){
 global $conn,$id,$username;
 $payerReference = $paymentDetils['payerReference'];
 $customerMsisdn = $paymentDetils['customerMsisdn'];
 $trxID = $paymentDetils['trxID'];
 $amount = $paymentDetils['amount'];
 $merchantInvoiceNumber = $paymentDetils['merchantInvoiceNumber'];
 $paymentExecuteTime = $paymentDetils['paymentExecuteTime'];
 $newPaymentList = mysqli_query($conn, "INSERT INTO bkash_pay (id, user_id, username, paymentID, payerReference, customerMsisdn, trxID, amount, merchantInvoiceNumber, paymentExecuteTime) VALUES (NULL, '$id', '$username', '$paymentID', '$payerReference', '$customerMsisdn', '$trxID', '$amount', '$merchantInvoiceNumber', '$paymentExecuteTime')");
 if($newPaymentList){
  return true;
 }else{
  return false;
 }
}

function addBalance($amount){
 global $conn,$id,$username;
 $newBalanceList = mysqli_query($conn, "INSERT INTO tbl_balance (id, user_id, username, deposit, withdraw) VALUES (NULL, '$id', '$username', '$amount', '0')");
 if($newBalanceList){
  return true;
 }else{
  return false;
 }
}

if(isset($_POST['amount'])){
 $amount = $_POST['amount'];
 if($amount >= $approval){
  $bkashURL = createPaymentLink($amount);
  if($bkashURL != null){
   header("Location: ".$bkashURL);
  }else{
   header("Location:recharge-msg.php?msg=Something went wrong");
  }
 }else{
     echo '<script>alert("Minimum recharge limit '.$approval.' tk");</script>';
  showHtml();
 }
}else if(isset($_GET['status'],$_GET['paymentID'])){
 $status = $_GET['status'];
 $paymentID = $_GET['paymentID'];
 if($status == 'success'){
  $paymentDetils = getPaymentDetils($paymentID);
  if($paymentDetils != null){
   if($paymentDetils['success']){
    $savePaymentID = savePaymentID($paymentID,$paymentDetils);
    if($savePaymentID){
     $addBalance = addBalance($paymentDetils['amount']);
     if($addBalance){
      header("Location:recharge-msg.php?trxid=".$paymentDetils['trxID']);
     }else{
      header("Location:recharge-msg.php?msg=Failed to add balance");
     }
    }else{
      header("Location:recharge-msg.php?msg=Failed to save payment");
    }
   }else{
    header("Location:recharge-msg.php?msg=".$paymentDetils['statusMessage']);
   }
  }else{
   header("Location:recharge-msg.php?msg=AuthToken not found");
  }
 }else if($status == 'cancel'){
  header("Location:recharge-msg.php?cancel=Payment cancelled by user");
 }else{
  header("Location:recharge-msg.php?msg=Something went wrong");
 }
}else{
 showHtml();
}

function showHtml(){
    global $fetchdata,$id,$username;
    $obj = $fetchdata; $user_id = $id;
    $data = $fetchdata->get_control();
 $row = mysqli_fetch_array($data);
 $recharge_msg = $row['rg_msg'];
 $approval = $row['approval'];
    include('includes/head.php');
?>
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Recharge</h1>
 <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                    <li class="breadcrumb-item active">Recharge</li>
                </ol>
            </nav>
        </div>
        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title text-center card-title col-sm-10 col-md-8 mx-auto align-center text-center"><?php echo $recharge_msg; ?></h5>
                            <table class="table table-bordered">
                                <form action="" method="post">
                                    <div class="row">
                                        <div class="col-md-5">
                                            <h4>Auto Recharge</h4>
                                            <div class="mb-3 mt-3">
                                                <label> Amount :</label>
                                                <input type="number" class="form-control" name="amount" required min="<?php echo $robi_token; ?>">
                                            </div>
                                            <input type="submit" name="submit" class="btn btn-danger" value="NEXT" />
                                        </div>
                                    </div>
                                </form>
                            </table>
      </div>
                    </div>
     <div class="card"> 
      <div class="card-body col-sm-12 mx-auto"> 
       <h5 class="card-title">Add balance</h5> 
       <ol class="list-group list-group-numbered"> 
        <li class="list-group-item d-flex justify-content-between align-items-start"> 
         <div class="ms-2 me-auto"> 
          <div class="fw-bold">100 BDT</div> 
         </div> 
         <form action="" method="POST"> 
          <input class="fw-bold" type="text" id="amount" name="amount" value="10" hidden=""> 
          <button type="submit" class="btn btn-primary roounded-pill">Recharge</button> 
         </form> 
        </li> 
        <li class="list-group-item d-flex justify-content-between align-items-start"> 
         <div class="ms-2 me-auto"> 
          <div class="fw-bold">200 BDT</div> 
         </div> 
         <form action="" method="POST"> 
          <input class="fw-bold" type="text" id="amount" name="amount" value="200" hidden=""> 
          <button type="submit" class="btn btn-primary roounded-pill">Recharge</button> 
         </form> 
        </li> 
        <li class="list-group-item d-flex justify-content-between align-items-start"> 
         <div class="ms-2 me-auto"> 
          <div class="fw-bold">300 BDT</div> 
         </div> 
         <form action="" method="POST"> 
          <input class="fw-bold" type="text" id="amount" name="amount" value="300" hidden=""> 
          <button type="submit" class="btn btn-primary roounded-pill">Recharge</button> 
         </form> 
        </li> 
        <li class="list-group-item d-flex justify-content-between align-items-start"> 
         <div class="ms-2 me-auto"> 
          <div class="fw-bold">500 BDT</div> 
         </div> 
         <form action="" method="POST"> 
          <input class="fw-bold" type="text" id="amount" name="amount" value="500" hidden=""> 
          <button type="submit" class="btn btn-primary roounded-pill">Recharge</button> 
         </form> 
        </li> 
        <li class="list-group-item d-flex justify-content-between align-items-start"> 
         <div class="ms-2 me-auto"> 
          <div class="fw-bold">1000 BDT</div> 
         </div> 
         <form action="" method="POST"> 
          <input class="fw-bold" type="text" id="amount" name="amount" value="1000" hidden="">
<button type="submit" class="btn btn-primary roounded-pill">Recharge</button> 
         </form> 
        </li> 
        
        <li class="list-group-item d-flex justify-content-between align-items-start"> 
         <div class="ms-2 me-auto"> 
          <div class="fw-bold">2000 BDT</div> 
         </div> 
         <form action="" method="POST"> 
          <input class="fw-bold" type="text" id="amount" name="amount" value="2000" hidden=""> 
          <button type="submit" class="btn btn-primary roounded-pill">Recharge</button> 
          
          
         </form> 
        </li> 
       </ol> 
      </div> 
     </div>
     <div class="card">
                        <div class="card-body col-sm-12 mx-auto"> 
       <h5 class="card-title">Recharge History</h5> 
                            <div class="container">
                                <div class="row">
                                    <div class="col-sm-2"></div>
                                    <div class="col-md-8">
                                        <table class="table table-bordered">
                                            <thead><tr><th> ID </th><th> User ID </th><th> Username</th><th> Deposit</th><th> Date</th> </tr></thead>
                                            <tbody><?php $sql = $obj->get_deposit($id);$cnt = 1; while ($row = mysqli_fetch_array($sql)) {?><tr><td> <?php echo $row['id']; ?> </td><td><?php echo $row['user_id']; ?></td><td><?php echo $row['username']; ?></td><td><?php echo $row['deposit']; ?></td><td><?php echo $row['date']; ?></td></tr> <?php $cnt = $cnt + 1;} ?></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
<?php include('includes/footer.php'); } ?>