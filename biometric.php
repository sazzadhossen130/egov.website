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
		$charge =  $row['bot_token'];
	}

	$sql = $obj->get_balance($user_id);
	$balance = mysqli_fetch_array($sql);
	$diff = $balance['deposit_sum'] - $balance['withdraw_sum'];


	if(isset($_POST['submit'])){
		if ($diff > $charge) {
			$number = $_POST["number"];
			
			include 'Apis/numx.php';
			$newNID = new NID($number);
			$nidInfo = $newNID->info();
			$json = json_decode($nidInfo);
			if ($json->nid){
				$withdraw = $obj->get_withdraw($user_id, $charge);
				$showFrom = false;
			}else{
				echo '<script>alert("Not Found..!")</script>';
			}
            
		}else{
			echo "<script>alert(' You don't have enough balance );</script>";
		}
	}

	
?>
<?php if($showFrom){ ?>
<html lang="en">
<!DOCTYPE html>
<head>
	<meta charset="utf-8">
	<meta content="width=device-width, initial-scale=1.0" name="viewport">
	<meta content="" name="description"><meta content="" name="keywords">
	<title><?php if($json == null){echo "NUMBER TO INFO";}else{echo $json->Number;}?></title>
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
				<p><?php if ($diff > $charge) {echo " ";} else {echo ' <div class="alert alert-danger"><strong>Sorry !</strong> You  do not have enough balance.</div>';} ?></p>

				<form action="" method="POST">
					<div class="row">
						<div class="mb-3 myDiv" id="showOne">
							<label>NUMBER :</label>
							<input type="text" class="form-control" id="number" placeholder="016********" name="number" required="">
						</div>
						
						<div class="mb-3 myDiv" id="showOne">
							
							
                            
                            </select>
						</div>
						<span style="font-size: 12px;padding: 10px;margin: auto;text-align: center;color: red;">
						<b>Note:</b> You will be Charge <?php echo $charge ?> tk by clicking submit.</span>
						<input type="submit" name="submit" class="btn btn-danger" onclick="submit()" value="submit" />
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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php if($json == null){echo "NUMBER TO INFO";}else{echo $json->nid;}?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
.card {
    max-width: 800px;
    margin: 0 auto;
    background-color: #ffffff; /* White background */
    padding: 20px;
    border-radius: 10px; /* Rounded corners */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Shadow effect */
}

.card h2 {
    margin-top: 0;
    color: #1a237e; /* Dark blue text color */
}

table {
    width: 100%;
    border-collapse: collapse;
}

th, td {
    padding: 10px; /* Increase cell padding */
    text-align: left;
    border-bottom: 1px solid #ccc; /* Light gray border */
}

th {
    background-color: #e3f2fd; /* Light blue header background */
}

tr:nth-child(even) {
    background-color: #f5f5f5; /* Alternate row background color */
}

tr:hover {
    background-color: #cce5ff; /* Hover effect */
}



    </style>
</head>
<body>
    <div class="card">
        <table>
            <tr>

          </tr>
            <tr>
            
            </tr>
            <tr>
                <td>Nid:</td>
                <td><?php echo $json->nid; ?></td>
            </tr>
            <tr>
                <td>Dob:</td>
                <td><?php echo $json->dob; ?></td>
            </tr>
         
            </tr>
        </table>
    </div>
</body>
</html>


 
 
<?php } ?>
<?php } ?>