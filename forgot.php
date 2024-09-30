<?php
session_start();
error_reporting(0);
if (isset($_SESSION['uid'])){
    header('location:dashboard.php');
}


define('DB_HOST','localhost');
define('DB_USER','nayimxyz_goodboy');
define('DB_PASS','nayimxyz_goodboy');
define('DB_NAME','nayimxyz_goodboy');

function sentMail($id,$name,$email){
    $data = [];
    $data['id'] = $id;
    $data['name'] = $name;
    $data['email'] = $email;
    $data['time'] = strtotime("+15 minutes",strtotime(date("Y-m-d H:i:s")));
    $reset = str_replace("=","",base64_encode(bin2hex(json_encode($data))));
    $subject = "Reset your Server Copy password";
    $body = "<h3>Hello ".$name.",</h3><h4>Your password reset link is :</h4><center><p>https://tmx-army.xyz/forgot.php?reset=".$reset."</p></center><p>Use this link within 15 minutes, After 15 minutes this link is useless</p><br><center><p>If you don't recognide ".$email." , You can safely ignore this email. </p></center>";
        
    $post = http_build_query(['name' => 'Server Copy','email' => $email,'subject' => $subject,'body' => $body]);
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, 'https://mail.kaichi-tore.xyz/');
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER , 1);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, false);
    curl_setopt($curl, CURLOPT_HTTPHEADER, [
        'Content-Type: application/x-www-form-urlencoded',
        'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/113.0.0.0 Safari/537.36'
    ]);
    $data = curl_exec($curl);
    curl_close($curl);
    
    if($data == "200"){
        return true;
    }else{
        return false;
    }
}
if(isset($_POST['email'])){
    $email = $_POST['email'];
    $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $checkUserList  = mysqli_query($conn,"SELECT * FROM `tblusers` WHERE `UserEmail` = '$email'");
    $totalUserList = mysqli_num_rows($checkUserList);
        if($totalUserList > 0){
            $row = mysqli_fetch_array($checkUserList);
            $id = $row['id'];
            $name = $row['FullName'];
            $sentMail = sentMail($id,$name,$email);
            if($sentMail){
                echo '<script>alert("Mail sent successfully!")</script>';
                showForgotMsg('Mail sent successfully','একটি পাসওয়ার্ড রিসেট লিঙ্ক আপনার ইমেল পাঠানো হয়েছে. <br><span style="color:red;"> স্প্যাম/প্রচারমূলক মেইল চেক করতে ভুলবেন না। আপনি সেখানে লিঙ্ক খুঁজে পেতে পারেন </span>');   
            }else{
                echo '<script>alert("Failed to send mail!")</script>';
                showForgotPassword();  
            }
        }else{
            echo '<script>alert("Email not found!")</script>';
            showForgotPassword();
        }
}else if(isset($_GET['reset'])){
    $reset = json_decode(hex2bin(base64_decode($_GET['reset'])),true);
    $time = strtotime(date("Y-m-d H:i:s"));
    if($time < $reset['time']){
        $_SESSION['reset'] = $reset['id'];
        showNewPassword();
    }else{
        showForgotMsg('Link Expired','লিঙ্কের মেয়াদ শেষ। এই লিঙ্কটি শুধুমাত্র 15 মিনিটের জন্য ব্যবহারযোগ্য ছিল');
    }
}else if(isset($_POST['password'],$_POST['confirm'],$_SESSION['reset'])){
    $id = $_SESSION['reset'];
    $password = $_POST['password'];
    $confirm = $_POST['confirm'];
    if($password == ""){
        echo '<script>alert("Input your password!")</script>';
        showNewPassword();
    }else if($password != $confirm){
        echo '<script>alert("Confirm password not matched!")</script>';
        showNewPassword(); 
    }else{
        $pass = md5($password);
        $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        $updatePassword = mysqli_query($conn, "UPDATE `tblusers` SET `Password` = '$pass' WHERE `tblusers`.`id` = '$id'");
        if($updatePassword){
            $checkUserList  = mysqli_query($conn,"SELECT * FROM `tblusers` WHERE `id` = '$id'");
            $row = mysqli_fetch_array($checkUserList);
            $Username = $row['Username'];
            echo '<script>alert("Password reset successfully!")</script>';
            showForgotMsg('Password reset successfully!','পাসওয়ার্ড সফলভাবে আপডেট করা হয়েছে। এখন আপনি নতুন পাসওয়ার্ড দিয়ে লগইন করতে পারেন<br>Username: '.$Username);
        }else{
            echo '<script>alert("Failed to update password!")</script>';
            showNewPassword();
        }
    }
}else{
    showForgotPassword();
}

function showForgotPassword(){
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot password</title>
    <style>
        body {
            font-family: 'Public Sans', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }

        .container-xxl {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .authentication-wrapper {
            width: 100%;
            max-width: 400px;
        }

        .authentication-inner {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        .app-brand-logo img {
            width: 100px;
            height: 100px;
        }

        h3 {
            margin-bottom: 10px;
        }

        p {
            margin-bottom: 20px;
        }

        form {
            text-align: center;
        }

        label {
            font-size: 14px;
            font-weight: 500;
            color: #495057;
            margin-bottom: 5px;
            display: block;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ced4da;
            border-radius: 4px;
            box-sizing: border-box;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #0056b3;
        }

        a {
            text-decoration: none;
            color: #007bff;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="container-xxl">
        <div class="authentication-wrapper">
            <div class="authentication-inner">
                <div class="card">
                    <div class="card-body">
                        <div class="justify-content-center">
                            <center><span class="app-brand-logo demo"><img src="assets/img/logo.png"></span></center>
                            <center><h3 style="color:red;">Welcome</h3></center>
                            <center><p style="color:green;">ইমেইল ব্যবহার করে পাসওয়ার্ড রিসেট করুন</p></center>
                            <form class="loginform" action="forgot.php" method="POST">
                                <label for="" class="text-uppercase text-sm">Your Email</label>
                                <input type="text" placeholder="Email" name="email" class="form-control mb-2" required>
                                <button class="btn btn-primary d-grid w-100" name="login" type="submit">SUBMIT</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
<?php
}

function showNewPassword(){
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New password</title>
    <style>
        body {
            font-family: 'Public Sans', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }

        .container-xxl {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .authentication-wrapper {
            width: 100%;
            max-width: 400px;
        }

        .authentication-inner {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        .app-brand-logo img {
            width: 100px;
            height: 100px;
        }

        h3 {
            margin-bottom: 10px;
        }

        p {
            margin-bottom: 20px;
        }

        form {
            text-align: center;
        }

        label {
            font-size: 14px;
            font-weight: 500;
            color: #495057;
            margin-bottom: 5px;
            display: block;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ced4da;
            border-radius: 4px;
            box-sizing: border-box;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #0056b3;
        }

        a {
            text-decoration: none;
            color: #007bff;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="container-xxl">
        <div class="authentication-wrapper">
            <div class="authentication-inner">
                <div class="card">
                    <div class="card-body">
                        <div class="justify-content-center">
                            <center><span class="app-brand-logo demo"><img src="assets/img/logo.png"></span></center>
                            <center><h3 style="color:red;">Password Reset</h3></center>
                            <center><p style="color:green;">নতুন পাসওয়ার্ড তৈরি করুন</p></center>
                            <form class="loginform" action="forgot.php" method="POST">
                                <label for="" class="text-uppercase text-sm">New password</label>
                                <input type="password" placeholder="New password" name="password" class="form-control mb-2" required>
                                <label for="" class="text-uppercase text-sm">Confirm password</label>
                                <input type="password" placeholder="Confirm password" name="confirm" class="form-control mb-2" required>
                                <button class="btn btn-primary d-grid w-100" name="login" type="submit">SUBMIT</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
<?php
}

function showForgotMsg($title,$msg){
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    <style>
        body {
            font-family: 'Public Sans', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }

        .container-xxl {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .authentication-wrapper {
            width: 100%;
            max-width: 400px;
        }

        .authentication-inner {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        .app-brand-logo img {
            width: 100px;
            height: 100px;
        }

        h3 {
            margin-bottom: 10px;
        }

        p {
            margin-bottom: 20px;
        }

        form {
            text-align: center;
        }

        label {
            font-size: 14px;
            font-weight: 500;
            color: #495057;
            margin-bottom: 5px;
            display: block;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ced4da;
            border-radius: 4px;
            box-sizing: border-box;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #0056b3;
        }

        a {
            text-decoration: none;
            color: #007bff;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="container-xxl">
        <div class="authentication-wrapper">
            <div class="authentication-inner">
                <div class="card">
                    <div class="card-body">
                        <div class="justify-content-center">
                            <center><span class="app-brand-logo demo"><img src="assets/img/logo.png"></span></center>
                            <center><h3 style="color:red;"><?php echo $title; ?></h3></center>
                            <center><p style="color:green;"><?php echo $msg; ?></p></center>
                            <a href="/"><button class="btn btn-primary d-grid w-100" name="login" type="submit">OK</button></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
<?php
}
?>
