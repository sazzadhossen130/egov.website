<?php
if(isset($_GET['trxid'])){
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"/>
	<title>Payment Successful</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0"/>
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.1.1/css/all.css">
	<style>@import url('https://fonts.googleapis.com/css2?family=Lexend+Deca&family=Source+Sans+Pro&display=swap');* {   font-family: 'Source Sans Pro', sans-serif;	box-sizing: border-box;	webkit-box-sizing: border-box;    -moz-box-sizing: border-box;}</style>
</head>
<body style="background: #a0aec0;">
    <div style="position: absolute;top: 50%;left: 50%;color: #ffffff;background: #ffffff;transform: translate(-50%, -50%);max-width: 400px;width: 90%;border: 1px solid;border-radius: 10px;text-align: center;padding: 15px;">
		<i class="fa-solid fa-check" style="font-size: 24px;color: #07e107;padding: 15px;background: #c1f1c1;border-radius: 50%;margin: 5px;width: 54px;height: 54px;"></i>
		<h1 style="color: #4CAF50;margin: 8px;">Payment Successful</h1>
		<h3 style="color: #2196F3;margin: 8px;">Trxid: <?php echo $_GET['trxid'] ?></h3>
		<a href="dashboard.php"><button style="width: 102px;height: 34px;color: #795548;margin: 8px;font-size: 18px;line-height: 34px;font-weight: bold;background: #b5b5b5;border: 0;border-radius: 10px;">OK</button></a>
	</div>
</body>
</html>
<?php
}else if(isset($_GET['cancel'])){
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"/>
	<title>Payment Cancelled</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0"/>
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.1.1/css/all.css">
	<style>@import url('https://fonts.googleapis.com/css2?family=Lexend+Deca&family=Source+Sans+Pro&display=swap');* {   font-family: 'Source Sans Pro', sans-serif;	box-sizing: border-box;	webkit-box-sizing: border-box;    -moz-box-sizing: border-box;}</style>
</head>
<body style="background: #a0aec0;">
    <div style="position: absolute;top: 50%;left: 50%;color: #ffffff;background: #ffffff;transform: translate(-50%, -50%);max-width: 400px;width: 90%;border: 1px solid;border-radius: 10px;text-align: center;padding: 15px;">
		<i class="fa-solid fa-x" style="font-size: 24px;color: #F44336;padding: 15px;background: #f3bdb9;border-radius: 50%;margin: 5px;width: 54px;height: 54px;"></i>
		<h1 style="color: #E91E63;margin: 8px;">Payment Cancelled</h1>
		<h3 style="color: #2196F3;margin: 8px;"><?php echo $_GET['cancel'] ?></h3>
		<a href="recharge.php"><button style="width: 102px;height: 34px;color: #795548;margin: 8px;font-size: 18px;line-height: 34px;font-weight: bold;background: #b5b5b5;border: 0;border-radius: 10px;">OK</button></a>
	</div>
</body>
</html>
<?php
}else{
?>
<html>
<head>
	<meta charset="utf-8"/>
	<title>Payment Error</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0"/>
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.1.1/css/all.css">
	<style>@import url('https://fonts.googleapis.com/css2?family=Lexend+Deca&family=Source+Sans+Pro&display=swap');* {   font-family: 'Source Sans Pro', sans-serif;	box-sizing: border-box;	webkit-box-sizing: border-box;    -moz-box-sizing: border-box;}</style>
</head>
<body style="background: #a0aec0;">
    <div style="position: absolute;top: 50%;left: 50%;color: #ffffff;background: #ffffff;transform: translate(-50%, -50%);max-width: 400px;width: 90%;border: 1px solid;border-radius: 10px;text-align: center;padding: 15px;">
		<i class="fa-solid fa-triangle-exclamation" style="font-size: 24px;color: #f5dc02;padding: 15px;background: #fff8b8;border-radius: 50%;margin: 5px;"></i>
		<h1 style="color: #FF9800;margin: 8px;">Payment Error</h1>
		<h3 style="color: #2196F3;margin: 8px;"><?php echo $_GET['msg'] ?></h3>
		<a href="recharge.php"><button style="width: 102px;height: 34px;color: #795548;margin: 8px;font-size: 18px;line-height: 34px;font-weight: bold;background: #b5b5b5;border: 0;border-radius: 10px;">OK</button></a>
	</div>
</body>
</html>
<?php
}
?>