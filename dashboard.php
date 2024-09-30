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
		
    	$sv = $row['charge'];
		$nidmake =  $row['log_channel'];
		$bio = $row['bot_token']; 
		
		
		
		
		

	}


	
?>
<?php if($showFrom){ ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta content="width=device-width, initial-scale=1.0" name="viewport">
	<meta content="" name="description"><meta content="" name="keywords">
	<title><?php if($json == null){echo "Dashboard";}else{echo $json->nameEn;}?></title>
	<link href="https://surokkha.gov.bd/favicon.png" rel="icon">
	<link href="https://surokkha.gov.bd/favicon.png" rel="apple-touch-icon">
	<link href="https://fonts.gstatic.com" rel="preconnect">
	<link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.1.1/css/all.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" type="text/javascript"></script>
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
	<link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
	<link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
	<link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
	<link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
	<link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
	<link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">
	<link href="assets/css/style.css" rel="stylesheet">
</head>
<body>
	<header id="header" class="header fixed-top d-flex align-items-center">
		<div class="d-flex align-items-center justify-content-between">
			<a href="index.php" class="logo d-flex align-items-center"></a>
			<i class="bi bi-list toggle-sidebar-btn"></i>
		</div>
		<nav class="header-nav ms-auto">
			<ul class="d-flex align-items-center">
				<li class="nav-item dropdown"><?php $sql = $fetchdata->get_balance($user_id); $balance = mysqli_fetch_array($sql); ?>
					<button type="button" class="btn btn-danger mb-2"> <i class="bi bi-currency-dolla me-1"></i> Balance: <span class="badge bg-white text-primary"><?php echo ($balance['deposit_sum'] - $balance['withdraw_sum']); ?></span></button>
				</li>
				<li class="nav-item dropdown pe-3">
					<a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
						<span class="d-none d-md-block dropdown-toggle ps-2"><?php echo  $_SESSION['username']; ?></span>
					</a>
					<ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
						<li class="dropdown-header">
							<h6><?php echo  $_SESSION['fname']; ?></h6>
							<span><?php echo  $_SESSION['username']; ?></span>
						</li>
						<li>
							<hr class="dropdown-divider">
						</li>
						<li>
							<hr class="dropdown-divider">
						</li>
						<li>
							<a class="dropdown-item d-flex align-items-center" href="logout.php">
								<i class="bi bi-box-arrow-right"></i>
								<span>Sign Out</span>
							</a>
						</li>
					</ul>
				</li>
			</ul>
		</nav>
	</header>
	<?php include('includes/sidebar.php'); ?>
	<main id="main" class="main">
		<section class="section profile">
			<div id="inp" class="container mt-6 col-md-12 mb-5">
				<marquee style="padding: 10px;background: white;border-radius: 5px;border: 1px solid #0d6efd;"><?php echo $notice ?></marquee>
	
	
	
	
	
	<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f8f9fa;
    }
    .card-title {
      font-size: 1.5rem;
      font-weight: bold;
      margin-bottom: 1rem;
    }
    .card {
      margin: 1rem 0;
    }
    .card img {
      width: 50px;
    }
    .card-body {
      display: flex;
      align-items: center;
      justify-content: space-between;
    }
    .card-text {
      margin: 0;
    }
    .btn-enter {
      font-size: 1rem;
      font-family: 'SolaimanLipi', sans-serif;
    }
    .btn-price {
      font-size: 1rem;
      padding: 0.5rem 1rem;
      color: #fff;
      width: 100px; /* Ensure uniform button size */
    }
  </style>
</head>
<body>

<div class="container">
  <div class="row">
    <div class="col-12">
      <div class="text-center my-4">
        <h1 class="card-title">DASHBOARD</h1>
      </div>
    </div>

    <div class="col-md-6">
      <div class="card">
        <div class="card-body">
          <div class="d-flex align-items-center">
            <img src="assets/logo-icon/bio.png" alt="Logo">
            <div class="ms-3">
              <a href="biometric.php" class="btn btn-enter">বায়োমেট্রিক</a>
            </div>
          </div>
          <button href="biometric.php"  class="btn btn-danger btn-price"><?php echo $bio; ?> ৳</button>
        </div>
      </div>
    </div>

    <div class="col-md-6">
      <div class="card">
        <div class="card-body">
          <div class="d-flex align-items-center">
            <img src="assets/logo-icon/sv.png" alt="Logo">
            <div class="ms-3">
                <a href="server_copy.php" class="btn btn-enter">সার্ভার কপি</a>  
            </div>
          </div>
          <button href="server_copy.php" class="btn btn-danger btn-price"><?php echo $sv; ?> ৳</button>
        </div>
      </div>
    </div>

     <div class="col-md-6">
      <div class="card">
        <div class="card-body">
          <div class="d-flex align-items-center">
            <img src="assets/logo-icon/nid.png" alt="Logo">
            <div class="ms-3">
           <a href="nid_make.php" class="btn btn-enter">এন আইডি মেক</a>
              </div>
          </div>
          <button href="nid_make.php" class="btn btn-danger btn-price"><?php echo $nidmake; ?> ৳</button>
        </div>
      </div>
    </div> 

   <div class="col-md-6">
      <div class="card">
        <div class="card-body">
          <div class="d-flex align-items-center">
            <img src="assets/logo-icon/surakkha.png" alt="Logo">
            <div class="ms-3">
              <a href="new-card.php" class="btn btn-enter">সুরক্ষা ক্লোন</a>
            </div>
          </div>
          <button type="button" class="btn btn-danger btn-price">20 ৳</button>
        </div>
      </div>
    </div>  

    <div class="col-md-6">
      <div class="card">
        <div class="card-body">
          <div class="d-flex align-items-center">
            <img src="assets/logo-icon/birth.png" alt="Logo">
            <div class="ms-3">
           <a href="birth.php" class="btn btn-enter">জন্মনিবন্ধন মেক</a>
            </div>
          </div>
          <button href="birth.php" class="btn btn-danger btn-price">150 ৳</button>
        </div>
      </div>
    </div> 

    <div class="col-md-6">
      <div class="card">
        <div class="card-body">
          <div class="d-flex align-items-center">
            <img src="https://cdn-icons-png.flaticon.com/512/5600/5600529.png" alt="Logo">
            <div class="ms-3">
              <a href="police_clearance.php" class="btn btn-enter">পুলিশ ক্লিয়ারেন্স</a>
            </div>
          </div>
          <button type="button" class="btn btn-danger btn-price">50 ৳</button>
        </div>
      </div>
    </div>

      <!--!<div class="card">
        <div class="card-body">
          <div class="d-flex align-items-center">
            <img src="assets/logo-icon/amiprobashi.png" alt="Logo" style="width: 80px;">
            <div class="ms-3">
              <a href="pdo.php" class="btn btn-enter">পিডিও ক্লোন</a>
            </div>
          </div>
          <button type="button" class="btn btn-danger btn-price">20 ৳</button>
        </div>
      </div>
    </div>

  </div>
</div> -->

<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>

	
	
	
	
	
	
			
		
	<script>

        }
    }
    };
	</script>
<?php include('includes/footer.php'); ?>
<?php }else{ ?>
<?php } ?>
<?php } ?>