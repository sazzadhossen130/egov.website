<?php
session_start();

if(!isset($_SESSION['uid'])){
	header('location:logout.php');
	die();
}else{
	$json = null;
	$showFrom = true;
	$user_id = $_SESSION['uid'];
	include_once('function.php');
	include('phpqrcode/qrlib.php');

	$obj = new DB_con();
	$fetchdata = new DB_con();
	$sql = $obj->get_control();

	while ($row = mysqli_fetch_array($sql)) {
		$recharge_msg = $row['rg_msg'];
		$notice =  $row['notice'];
		$approval = $row['approval'];
		$login =  $row['login'];
		$register = $row['register'];
		$bot_token =  $row['bot_token'];
		$log_channel = $row['log_channel'];
		$charge =  $row['charge'];
		$api_key =  $row['robi_token'];
	}

	$sql = $obj->get_balance($user_id);
	$balance = mysqli_fetch_array($sql);
	$diff = $balance['deposit_sum'] - $balance['withdraw_sum'];


	if(isset($_POST['submit'])){
		if ($diff > $charge) {
			$nid = $_POST["nid"];
			$dob = $_POST["dob"];
			include 'Apis/sv.php';
			$newNID = new NID($nid,$dob);
			$nidInfo = $newNID->info();
			$json = json_decode($nidInfo);
			if ($json->nid){
				$withdraw = $obj->get_withdraw($user_id, $charge);
				$showFrom = false;
			}else{
				echo '<script>alert("Not Found")</script>';
			}
            $qrCodeUrl = "https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=" . urlencode("Name: $nameEn\nDate of Birth: $dob\nNID: $nid");
		}else{
			echo "<script>alert(' You don't have enough balance );</script>";
		}
	}

	
?>
<?php if($showFrom){ ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta content="width=device-width, initial-scale=1.0" name="viewport">
	<meta content="" name="description"><meta content="" name="keywords">
	<title><?php if($json == null){echo "Nid Info";}else{echo $json->data->nameEn;}?></title>
	<link href="assets/img/logo.png" rel="icon">
	<link href="assets/img/logo.png" rel="apple-touch-icon">
	<link href="https://fonts.gstatic.com" rel="preconnect">
	<link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.1.1/css/all.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" type="text/javascript"></script>
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
	
	<!-- Core CSS -->
      <link rel="stylesheet" href="asset/vendor/css/core.css" class="template-customizer-core-css" />
      <link rel="stylesheet" href="asset/vendor/css/theme-default.css" class="template-customizer-theme-css" />
      <link rel="stylesheet" href="asset/css/demo.css" />
      <link rel="stylesheet" href="css/new.css"/>
      <!-- Vendors CSS -->
      <link rel="stylesheet" href="asset/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
      <link rel="stylesheet" href="asset/vendor/libs/apex-charts/apex-charts.css" />
      <!-- Page CSS -->
</head>
<body>
	<header id="header" class="header fixed-top d-flex align-items-center">
		<div class="d-flex align-items-center justify-content-between">
			<a href="index.php" class="logo d-flex align-items-center"></a>
			<i class="bi bi-list toggle-sidebar-btn"></i>
		</div>
		<nav class="header-nav ms-auto">
			<ul class="d-flex align-items-center">
				</li>
				<li class="nav-item dropdown pe-3">
					
				
				</li>
			</ul>
		</nav>
	</header>
	<?php include("includes/header.php");?>
	<main id="main" class="main">
		<section class="bg-diffrent">
			<div id="inp" class="container">
				<p><?php if ($diff > $charge) {echo " ";} else {echo ' <div class="alert alert-danger"><strong>Sorry !</strong> You  do not have enough balance.</div>';} ?></p>

                
				<form action="" method="post">
					<div class="row">
						<div class="mb-3 myDiv" id="showOne">
							<label>National ID :</label>
							<input type="text" class="form-control" id="nid" placeholder="825218****" name="nid">
						</div>
						<div class="mb-3 myDiv" id="showOne">
							<label>Date of Birth :</label>
							<input type="text" class="form-control" id="dob" placeholder="1997-03-17 " name="dob">
						</div>
						<div class="mb-3 myDiv" id="showOne">
							<label>Server Copy :</label>
							<select name="server" id="server" class="form-control">
                                <option value="new">New Server Copy</option>
                                <option value="old">Old Server Copy</option>
                            </select>
						</div>
						<span style="font-size: 12px;padding: 10px;margin: auto;text-align: center;color: red;">
						<b>Note:</b> You will be Charge <?php echo $charge ?> tk by clicking submit.</span>
						<input type="submit" name="submit" class="btn btn-primary" onclick="submit()" value="submit" />
					</div>
				</form>
			</div>	
		</section>
	</main>
	<script>
	var b = <?php echo $diff; ?>, c = <?php echo $charge ?>;
    function submit(){
    var nid = $("#nid").val();
    var dob = $("#dob").val();
    var server = $("#server").val();
    if(nid == ""){
         alert("Input National ID");
    }else if(dob == ""){
         alert("Date of Birth");
    }else{
        if(b > c){
           $("form").submit();
        }else{
            alert("You don't have enough balance");
        }
    }
    };
	</script>
<?php include('includes/footer.php'); ?>
<?php }else{ ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta content="width=device-width, initial-scale=1.0" name="viewport">
	<title><?php if($json == null){echo "Nid Info";}else{echo $json->data->nameEn;}?></title>
	<link href="https://surokkha.gov.bd/favicon.png" rel="icon">
	<link href="https://surokkha.gov.bd/favicon.png" rel="apple-touch-icon">
	<link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.1.1/css/all.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" type="text/javascript"></script>
	<style>@page {size: A4;margin: 0;}body {margin: 0;}.background {background-color: lightgrey;position: relative;width: 750px;height: 1065px;margin: auto;transform: scale(1.08);text-align: left;margin-top: 40px;}.crane {max-width: 100%;height: 100%;}.topTitle {position: absolute;left: 21%;top: 8%;width: auto;font-size: 42px;color: rgb(255, 182, 47);}
	
	#loadMe {visibility: hidden;}@media print {html,body {width: 210mm !important;height: 297mm !important;background-color: #fff !important;}.print {display: none !important;}}#print {background: #03a9f4;padding: 8px;width: 750px;height: 50px;border: 0px;font-size: 25px;font-weight: bold;cursor: pointer;box-shadow: 1px 4px 4px #878787;color: #fff;border-radius: 10px;margin: 80px 0;display: none;}</style>
</head>
<body onload="showprint()" style="text-align: center;">
    <?php if($_POST['server'] == "new"){ ?>
		<div class="background">
			<img class="crane" src="https://i.postimg.cc/zff4mDrk/server.jpg" height="1000px" width="750px">
			<div style="position: absolute; left: 30%; top: 8%;width: auto;font-size: 16px; color: rgb(255 224 0);"><b>National Identity Registration Wing (NIDW)</b></div>
			<div style="position: absolute; left: 37%; top: 11%;width: auto;font-size: 14px; color: rgb(255, 47, 161);"><b>Select Your Search Category</b></div>
			<div style="position: absolute; left: 45%; top: 12.8%;width: auto;font-size: 12px; color: rgb(8, 121, 4);">Search By NID / Voter No.</div>
			<div style="position: absolute; left: 45%; top: 14.3%;width: auto;font-size: 12px; color: rgb(7, 119, 184);">Search By Form No.</div>
			<div style="position: absolute; left: 30%; top: 16.9%;width: auto;font-size: 12px; color: rgb(252, 0, 0);"><b>NID or Voter No*</b></div>
			<div style="position: absolute; left: 45%; top: 16.9%; width: auto; font-size: 12px; color: rgb(143, 143, 143);">NID</div>
			<div style="position: absolute;left: 62.9%;top: 17.1%;width: auto;font-size: 11px;color: rgb(255 255 255);">Submit</div>
			<div style="position: absolute;left: 89%;top: 11.55%;width: auto;font-size: 11px;color: #fff;">Home</div>
			<div style="position: absolute; left: 37%; top: 27%; width: auto; font-size: 16px; color: rgb(7, 7, 7);"><b>জাতীয় পরিচিতি তথ্য</b></div>
			<div style="position: absolute; left: 37%; top: 29.7%; width: auto; font-size: 13px; color: rgb(7, 7, 7);">জাতীয় পরিচয় পত্র নম্বর</div>
			<div id="nid_no"style="position: absolute; left: 55%; top: 29.7%; width: auto; font-size: 14px; color: rgb(7, 7, 7);"><?php echo $json->data->nationalId; ?></div>
			<div style="position: absolute; left: 37%; top: 32.5%; width: auto; font-size: 13px; color: rgb(7, 7, 7);">পিন নাম্বার</div>
			<div id="nid_father" style="position: absolute; left: 55%; top: 32.5%; width: auto; font-size: 14px; color: rgb(7, 7, 7);"><?php echo $json->data->pin; ?></div>
			<div style="position: absolute; left: 37%; top: 35%; width: auto; font-size: 13px; color: rgb(7, 7, 7);">মাতার পরিচয় পত্র নম্বর</div>
			<div id="nid_mother" style="position: absolute; left: 55%; top: 35%; width: auto; font-size: 14px; color: rgb(7, 7, 7);"><?php echo $json->data->nidMother; ?></div>
			<div style="position: absolute; left: 37%; top: 37.5%; width: auto; font-size: 14px; color: rgb(7, 7, 7);">স্বামী/স্ত্রীর নাম</div>
			<div id="spouse" style="position: absolute; left: 55%; top: 37.5%; width: auto; font-size: 14px; color: rgb(7, 7, 7);"><?php echo $json->data->spouse; ?></div>
			<div style="position: absolute; left: 37%; top: 40.2%; width: auto; font-size: 14px; color: rgb(7, 7, 7);">জন্মস্থান</div>
			<div id="voter_area" style="position: absolute; left: 55%; top: 40.2%; width: auto; font-size: 14px; color: rgb(7, 7, 7);"><?php echo $json->data->permanentAddress->region; ?></div>
			<div style="position: absolute; left: 37%; top: 43%; width: auto; font-size: 16px; color: rgb(7, 7, 7);"><b>ব্যক্তিগত তথ্য</b></div>
			<div style="position: absolute; left: 37%; top: 45.6%; width: auto; font-size: 14px; color: rgb(7, 7, 7);">নাম (বাংলা)</div>
			<div id="name_bn"style="position: absolute; font-weight: bold; left: 55%; top: 45.6%; width: auto; font-size: 14px; color: rgb(7, 7, 7);"><b><?php echo $json->data->name; ?></b></div>
			<div style="position: absolute; left: 37%; top: 48.5%; width: auto; font-size: 14px; color: rgb(7, 7, 7);">নাম (ইংরেজি)</div>
			<div id="name_en"style="position: absolute; left: 55%; top:48.5%; width: auto; font-size: 14px; color: rgb(7, 7, 7);"><?php echo $json->data->nameEn; ?></div>
			<div style="position: absolute; left: 37%; top: 51%; width: auto; font-size: 14px; color: rgb(7, 7, 7);">জন্ম তারিখ</div>
			<div id="dob"style="position: absolute; left: 55%; top: 51%; width: auto; font-size: 14px; color: rgb(7, 7, 7);"><?php echo $dob; ?></div>
			<div style="position: absolute; left: 37%; top: 53.7%; width: auto; font-size: 14px; color: rgb(7, 7, 7);">পিতার নাম</div>
			<div id="fathers_name"style="position: absolute; left: 55%; top: 53.7%; width: auto; font-size: 14px; color: rgb(7, 7, 7);"><?php echo $json->data->father; ?></div>
			<div style="position: absolute; left: 37%; top: 56.2%; width: auto; font-size: 14px; color: rgb(7, 7, 7);">মাতার নাম</div>
			<div id="mothers_name"style="position: absolute; left: 55%; top: 56.2%; width: auto; font-size: 14px; color: rgb(7, 7, 7);"><?php echo $json->data->mother; ?></div>
			<div style="position: absolute; left: 37%; top: 59%; width: auto; font-size: 16px; color: rgb(7, 7, 7);"><b>অন্যান্য তথ্য</b></div>
			<div style="position: absolute; left: 37%; top: 62.2%; width: auto; font-size: 14px; color: rgb(7, 7, 7);">লিঙ্গ</div>
			<div id="gender"style="position: absolute; left: 55%; top: 62.2%; width: auto; font-size: 14px; color: rgb(7, 7, 7);"><?php echo $json->data->gender; ?></div>
			<div style="position: absolute; left: 37%; top: 64.8%; width: auto; font-size: 14px; color: rgb(7, 7, 7);">মোবাইল নম্বর</div>
			<div id="mobile_no"style="position: absolute; left: 55%; top: 64.8%; width: auto; font-size: 14px; color: rgb(7, 7, 7);"><?php echo $json->data->mobile; ?></div>
			<div style="position: absolute; left: 37%; top: 67.5%; width: auto; font-size: 14px; color: rgb(7, 7, 7);">রক্তের গ্রুপ</div>
			<div id="blood_grp"style="position: absolute; left: 55%; top: 67.5%; width: auto; font-size: 14px; color: rgb(255, 0, 0);"><?php echo $json->data->bloodGroup; ?></div>
			<div style="position: absolute; left: 37%; top: 70%; width: auto; font-size: 14px; color: rgb(7, 7, 7);">ধর্ম</div>
			<div id="birth_place"style="position: absolute; left: 55%; top: 70%; width: auto; font-size: 14px; color: rgb(7, 7, 7);"><?php echo $json->data->religion; ?></div>
			<div style="position: absolute; left: 37%; top: 72.8%; width: auto; font-size: 16px; color: rgb(7, 7, 7);"><b>বর্তমান ঠিকানা</b></div>
			<div id="present_addr"style="position: absolute; left: 37%; top: 75.2%; width: 48%; font-size: 12px; color: rgb(7, 7, 7);">বাসা/হোল্ডিংঃ <?php echo $json->data->presentAddress->homeOrHoldingNo; ?>, গ্রাম/রাস্তাঃ <?php echo $json->data->presentAddress->additionalVillageOrRoad; ?>, মৌজা/মহল্লাঃ <?php echo $json->data->presentAddress->additionalMouzaOrMoholla; ?> ,ইউনিয়ন/ওয়ার্ডঃ <?php echo $json->data->presentAddress->unionOrWard; ?>, ওয়ার্ড নংঃ <?php echo $json->data->presentAddress->wardForUnionPorishod; ?>, পোস্ট অফিসঃ <?php echo $json->data->presentAddress->postOffice; ?>, পোস্ট কোডঃ <?php echo $json->data->presentAddress->postalCode; ?>, উপজেলাঃ <?php echo $json->data->presentAddress->upozila; ?>, জেলাঃ <?php echo $json->data->presentAddress->district; ?>, অঞ্চলঃ <?php echo $json->data->presentAddress->region; ?>, বিভাগঃ <?php echo $json->data->presentAddress->division; ?>।</div>
			<div style="position: absolute; left: 37%; top: 81.5%; width: auto; font-size: 16px; color: rgb(7, 7, 7);"><b>স্থায়ী ঠিকানা</b></div>
			<div id="permanent_addr"style="position: absolute; left: 37%; top: 84%; width: 48%; font-size: 12px; color: rgb(7, 7, 7);">বাসা/হোল্ডিংঃ <?php echo $json->data->permanentAddress->homeOrHoldingNo; ?>, গ্রাম/রাস্তাঃ <?php echo $json->data->permanentAddress->additionalVillageOrRoad; ?>, মৌজা/মহল্লাঃ <?php echo $json->data->permanentAddress->additionalMouzaOrMoholla; ?> ,ইউনিয়ন/ওয়ার্ডঃ <?php echo $json->data->permanentAddress->unionOrWard; ?>, পোস্ট অফিসঃ <?php echo $json->data->permanentAddress->postOffice; ?>, পোস্ট কোডঃ <?php echo $json->data->permanentAddress->postalCode; ?>, উপজেলাঃ <?php echo $json->data->permanentAddress->upozila; ?>, জেলাঃ <?php echo $json->data->permanentAddress->district; ?>, অঞ্চলঃ <?php echo $json->data->permanentAddress->region; ?>, বিভাগঃ <?php echo $json->data->permanentAddress->division; ?> 
			</div>
			<div style="position: absolute;top: 92%;width: 100%;font-size: 12px;text-align: center;color: rgb(255, 0, 0);">উপরে প্রদর্শিত তথ্যসমূহ জাতীয় পরিচয়পত্র সংশ্লিষ্ট, ভোটার তালিকার সাথে সরাসরি সম্পর্কযুক্ত নয়।</div>
			<div style="position: absolute;top: 93.5%;width: 100%;text-align: center;font-size: 12px;color: rgb(3, 3, 3);">This is Software Generated Report From Bangladesh Election Commission, Signature &amp; Seal Arent Required </div>
			
			
			<div style="position: absolute;left: 7%;top: 96.5%;width: auto;font-size: 12px;color: rgb(3, 3, 3);height: 9.5px;overflow: hidden;"></div>
			
			<div style="position: absolute;  left: 16%; top: 25.7%; width: auto; font-size: 12px; color: rgb(3, 3, 3);"><img id="photo" src="<?php echo $json->data->photo; ?>" height="140px" width="121px" style="border-radius: 10px" /></div>
			<div style="position: absolute;  left: 16.25%; top: 42%; width: auto; font-size: 12px; color: rgb(3, 3, 3);">
				<img id="qr" src="<?php echo  $file; ?>" height="120px" width="120px" /></div>
				<div id="name_en2" style="position: absolute;display: flex;font-weight: bold;left: 15.5%;top: 39.6%;height: 32px;width: 130px;font-size: 13px;color: rgb(7, 7, 7);margin: auto;align-items: center;" align="center"><div style="flex: 1;"><?php echo $json->data->nameEn; ?></div></div>
				
			</div>
		</div>
	<?php }else{ ?>
		<link href="https://fonts.gstatic.com" rel="preconnect">
		<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
		<link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet"><link href="assets/css/stylev2.css" rel="stylesheet">
		<style>@import url('https://fonts.googleapis.com/css2?family=Alumni+Sans+Inline+One&family=Anek+Bangla&family=Atma:wght@300&family=Baloo+Da+2&family=Bebas+Neue&family=Bubblegum+Sans&family=Edu+NSW+ACT+Foundation&family=Galada&family=Gloria+Hallelujah&family=Gochi+Hand&family=Hind+Siliguri:wght@300&family=Just+Another+Hand&family=Lobster&family=Mina&family=Mochiy+Pop+P+One&family=Noto+Sans+Bengali:wght@500&family=Nunito+Sans:wght@600&family=Oleo+Script&family=Oleo+Script+Swash+Caps&family=Open+Sans:wght@300&family=Pacifico&family=Patrick+Hand&family=Poppins:ital,wght@1,100&family=Red+Hat+Mono:wght@300&family=Roboto:wght@300&family=Source+Sans+Pro&family=Tiro+Bangla&display=swap'); @import url('https://cdn.rawgit.com/sh4hids/bangla-web-fonts/bangla/stylesheet.css');@import url('https://cdn.rawgit.com/sh4hids/bangla-web-fonts/solaimanlipi/stylesheet.css');@import url('https://fonts.googleapis.com/css2?family=Nunito:wght@200;300;400;600;700;800;900&display=swap');@import url('https://cdn.rawgit.com/mirazmac/bengali-webfont-cdn/master/solaimanlipi/style.css'); */ @import url('https://fonts.cdnfonts.com/css/arial-mt');body, td, th, h3, p {font-family: 'SolaimanLipi', serif !important;}th {width: 92px;}#print {line-height: 1px;}.card-body {overflow-y: auto;}.footer {display: none;}.p-mt {margin-top: 200px;      }.info-body { border: 3px solid gray;    border-radius: 6px;    width: 478px;    position: relative;    overflow: hidden;    padding-top: 18px;    height: 720px;    }      .table td,  .table th {     padding: 4px;    }    .table td {    font-weight: 400;    }    .table tr {border: none;    border-style: hidden;line-height: 19px;    }    .card, .card-body {box-shadow: none;    } .dots{width: 20px;padding-left: 0!important;} </style>
		<div class="row" style="text-align: left;margin-top: 40px;margin: 10px 50px;zoom: 2;"> 
			<div class="col-12"> 
				<div class="card" style=" min-width: 646px;"> 
					<div class="card-body info-body mx-auto" style="height: unset"> 
						<h3 style="padding: 9px;text-align: center;border: 3px solid black;margin: auto;margin: 36px;max-width: 268px;font-size: 19px;font-weight: 800;">জাতীয় পরিচিতি বিবরণ</h3> 
						<div class="row"> 
							<div class="card-body profile-card pt-4 d-flex flex-column align-items-center col-4" > </div> 
							<div class="card-body profile-card pt-4 d-flex flex-column align-items-center col-4" style="margin: auto;"> 
								<img style="border-radius: 8%!important; width: 80px;" src="<?php echo $json->data->photo; ?>" alt="Profile" class="rounded-circle"> 
								<h4></h4> 
							</div> 
							<div class="card-body profile-card pt-4 d-flex flex-column align-items-center col-4" > </div> 
						</div> 
						<img src="img/lol.png" style=" position: absolute;left: 120px;top: 253px;width: 244px;opacity: 0.5;">
						<table class="table" style=" max-width: 500px;margin: auto; background-position:center; background-size: 300px 300px;background-repeat:no-repeat;font-weight: 800;"> 
							<tbody> 
								<tr> 
									<th scope="row">নাম</th> 
									<td class="dots">:</td>
									<td>  <?php echo $json->data->name; ?></td> 
								</tr> 
								<tr style="font-size: 19px;"> 
									<th scope="row">Name</th> 
									<td class="dots">:</td>
									<td> <?php echo $json->data->nameEn; ?></td> 
								</tr> 
								<tr> 
									<th scope="row">পিতা</th> 
									<td class="dots">:</td>
									<td> <?php echo $json->data->father; ?></td> 
								</tr> 
								<tr> 
									<th scope="row">মাতা</th> 
									<td class="dots">:</td>
									<td> <?php echo $json->data->mother; ?></td> 
								</tr> 
								<tr> 
									<th scope="row">লিঙ্গ</th> 
									<td class="dots">:</td>
									<td> <?php if($json->data->gender == "male"){echo "পুরুষ";}else{echo "মহিলা";}?></td> 
								</tr> 
								<tr style="font-size: 19px;"> 
									<th scope="row">Date of Birth</th> 
									<td class="dots">:</td>
									<td> <?php echo $dob; ?></td> 
								</tr> 
								<tr style="font-size: 19px;"> 
									<th scope="row">NID No.</th>
									<td class="dots">:</td>
									<td> <?php echo $json->data->nationalId; ?></td> 
								</tr> 
								<tr> 
									<th scope="row">স্থায়ী ঠিকানা</th> 
									<td class="dots">:</td>
									<td> <?php echo $json->data->permanentAddress->homeOrHoldingNo .", ". $json->data->permanentAddress->additionalVillageOrRoad .", ". $json->data->permanentAddress->additionalMouzaOrMoholla .", ". $json->data->permanentAddress->unionOrWard .", ". $json->data->permanentAddress->wardForUnionPorishod .", ". $json->data->permanentAddress->postOffice .", ". $json->data->permanentAddress->postalCode .", ". $json->data->permanentAddress->upozila .", ". $json->data->permanentAddress->district .", ". $json->data->permanentAddress->region .", ". $json->data->permanentAddress->division; ?></td> 
								</tr> 
								<tr> 
									<th scope="row">বর্তমান ঠিকানা</th> 
									<td class="dots">:</td>
									<td> <?php echo $json->data->presentAddress->homeOrHoldingNo .", ". $json->data->presentAddress->additionalVillageOrRoad .", ". $json->data->presentAddress->additionalMouzaOrMoholla .", ". $json->data->presentAddress->unionOrWard .", ". $json->data->presentAddress->wardForUnionPorishod .", ". $json->data->presentAddress->postOffice .", ". $json->data->presentAddress->postalCode .", ". $json->data->presentAddress->upozila .", ". $json->data->presentAddress->district .", ". $json->data->presentAddress->region .", ". $json->data->presentAddress->division; ?></td> 
								</tr> 
							</tbody> 
						</table> 
					</div> 
				</div> 
			</div> 
		</div>
	<?php } ?>	
		<button class="print" id="print" onclick="window.print()" style="display: inline-block;">SAVE</button>
		<script>function showprint(){$("#print").show(500);}</script>
<?php } ?>
</body>
</html>
<?php } ?>