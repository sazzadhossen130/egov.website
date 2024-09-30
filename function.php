<?php

include('includes/database.php');


	class DB_con{
		function __construct(){
			$con = mysqli_connect(192.168.0.100, egovwebs_svc_check, w4bJyjDJHZhPtvX3rUuq, egovwebs_svc_check);
			$this->dbh = $con;
			if (mysqli_connect_errno()) {
				echo "Failed to connect to MySQL: " . mysqli_connect_error();
			}
		}

		// for username availblty
		public function usernameavailblty($uname)
		{
			$result = mysqli_query($this->dbh, "SELECT Username FROM tblusers WHERE Username='$uname'");
			return $result;
		}

		// Function for registration recharge_approve
		public function registration($fname, $uname, $uemail, $pasword)
		{
			$ret = mysqli_query($this->dbh, "insert into tblusers(FullName,Username,UserEmail,Password) values('$fname','$uname','$uemail','$pasword')");
			return $ret;
		}

		// Function for signin
		public function signin($uname, $password)
		{
			// $result = mysqli_query($this->dbh, "select id,FullName from tblusers where Username='$uname' and Password='$password'");
			// // die(var_dump($result));
			// return $result;
			$query = "select * from tblusers where Username=? and Password=?";
			$stmt = $this->dbh->prepare($query);
			$stmt->bind_param('ss',$uname,$password);
			$stmt->execute();
			$result = $stmt->get_result()->fetch_all();
			// die(var_dump($result));
			return $result;
		}


		public function insert_submission($certi_no, $type, $national_id, $passport_no, $nationality, $name, $gender, $date_birth, $doseone_date, $doseone_name, $dosetwo_date, $dosetwo_name, $dosethree_date, $dosethree_name, $vacc_center, $vacc_by, $total_dose, $file, $user_id)
		{
			$ret = mysqli_query($this->dbh, "insert into tbl_submission(certi_no,type,national_id,passport_no,nationality,name,gender,date_birth,doseone_date,doseone_name,dosetwo_date,dosetwo_name,dosethree_date,dosethree_name,vacc_center,vacc_by,total_dose,qr_code,submitted_by) values('$certi_no','$type','$national_id','$passport_no','$nationality','$name','$gender','$date_birth','$doseone_date','$doseone_name','$dosetwo_date','$dosetwo_name','$dosethree_date','$dosethree_name','$vacc_center','$vacc_by','$total_dose','$file','$user_id')");

			return $ret;
		}

		// update submission 	
		public function update_submission($certi_no, $type, $national_id, $passport_no, $nationality, $name, $gender, $date_birth, $doseone_date, $doseone_name, $dosetwo_date, $dosetwo_name, $dosethree_date, $dosethree_name, $vacc_center, $vacc_by, $total_dose, $id)
		{
			$ret = mysqli_query($this->dbh, "update tbl_submission set certi_no='$certi_no',type='$type',national_id='$national_id',passport_no='$passport_no',nationality='$nationality',name='$name',gender='$gender',date_birth='$date_birth',doseone_date='$doseone_date',doseone_name='$doseone_name',dosetwo_date='$dosetwo_date',dosetwo_name='$dosetwo_name',dosethree_date='$dosethree_date',dosethree_name='$dosethree_name',vacc_center='$vacc_center',vacc_by='$vacc_by',total_dose='$total_dose' where id='$id' ");

			return $ret;
		}

		public function fetchdata($user_id)
		{
			$result = mysqli_query($this->dbh, "select * from tbl_submission where submitted_by=$user_id order by id desc");
			return $result;
		}

		public function fetch_users()
		{
			$result = mysqli_query($this->dbh, "select * from tblusers order by id desc");
			return $result;
		}
		
		public function fetch_bkash_pay()
		{
			$result = mysqli_query($this->dbh, "select * from bkash_pay order by id desc");
			return $result;
		}

		// for user id 
		public function user_id($id)
		{
			$result = mysqli_query($this->dbh, "SELECT * FROM tbl_submission WHERE id=$id");
			return $result;
		}


		// delete user id 
		public function delete_submission($id)
		{
			$result = mysqli_query($this->dbh, "DELETE FROM tbl_submission WHERE id=$id");
			return $result;
		}

	// delete user id 
		public function delete_bks($id)
		{
			$result = mysqli_query($this->dbh, "DELETE FROM bkash_pay WHERE id=$id");
			return $result;
		}


		// delete user id 
		public function delete_user($id)
		{
			$result = mysqli_query($this->dbh, "DELETE FROM tblusers WHERE id=$id");
			return $result;
		}


		// for user id 
		public function user_certi_no($id)
		{
			$result = mysqli_query($this->dbh, "SELECT * FROM tbl_submission WHERE certi_no='$id'");
			return $result;
		}


		// for deposit balance
		public function insert_deposit($deposit, $id)
		{
			$result = mysqli_query($this->dbh, "insert into tbl_balance(deposit,user_id) values('$deposit','$id' )");
			return $result;
		}

		public function get_deposit($id)
		{
			$result = mysqli_query($this->dbh, "select * from tbl_balance where user_id=$id  and deposit > 0 order by id desc");
			return $result;
		}

		// for recharge balance
		public function request_deposit($number, $txn_id, $deposit, $id, $username)
		{
			$result = mysqli_query($this->dbh, "insert into tbl_request(number,txn_id,deposit,user_id,username) values('$number','$txn_id','$deposit','$id','$username' )");
			return $result;
		}

		// for fetching recharge requests
		public function get_recharge()
		{
			$result = mysqli_query($this->dbh, "select * from tbl_request where deposit > 0 order by id desc");
			return $result;
		}

		// for delet recharge history
		public function delete_recharge($i)
		{
			$result = mysqli_query($this->dbh, "DELETE FROM tbl_request WHERE id=$i");
			return $result;
		}

		// for balance 
		public function get_balance($user_id)
		{
			$result = mysqli_query($this->dbh, "SELECT SUM(deposit) AS deposit_sum, SUM(withdraw) AS withdraw_sum  FROM tbl_balance WHERE user_id=$user_id");
			return $result;
		}

		// for withdraw
		public function get_withdraw($user_id, $chargee)
		{
			$result = mysqli_query($this->dbh, "insert into tbl_balance(user_id,withdraw) values('$user_id','$chargee')");
			return $result;
		}
		
		
		
		
		
			// insert control
		public function in_login($in_login)
		{
			$result = mysqli_query($this->dbh, "UPDATE `control` SET `login` = '$in_login' WHERE `control`.`id` = 1;");
			return $result;
		}
		public function in_register($in_register)
		{
			$result = mysqli_query($this->dbh, "UPDATE `control` SET `register` = '$in_register' WHERE `control`.`id` = 1;");
			return $result;
		}
		public function in_approval($in_approval)
		{
			$result = mysqli_query($this->dbh, "UPDATE `control` SET `approval` = '$in_approval' WHERE `control`.`id` = 1;");
			return $result;
		}
		public function in_charge($in_charge)
		{
			$result = mysqli_query($this->dbh, "UPDATE `control` SET `charge` = '$in_charge' WHERE `control`.`id` = 1;");
			return $result;
		}
		public function in_rg_msg($in_rg_msg)
		{
			$result = mysqli_query($this->dbh, "UPDATE `control` SET `rg_msg` = '$in_rg_msg' WHERE `control`.`id` = 1;");
			return $result;
		}
		public function in_bot($in_bot)
		{
			$result = mysqli_query($this->dbh, "UPDATE `control` SET `bot_token` = '$in_bot' WHERE `control`.`id` = 1;");
			return $result;
		}
		public function in_log($in_log)
		{
			$result = mysqli_query($this->dbh, "UPDATE `control` SET `log_channel` = '$in_log' WHERE `control`.`id` = 1;");
			return $result;
		}
		public function in_notice($in_notice)
		{
			$result = mysqli_query($this->dbh, "UPDATE `control` SET `notice` = '$in_notice' WHERE `control`.`id` = 1;");
			return $result;
		}
		public function in_robi_id($in_robi_id)
		{
			$result = mysqli_query($this->dbh, "UPDATE `control` SET `robi_user` = '$in_robi_id' WHERE `control`.`id` = 1;");
			return $result;
		}
		public function in_robi_token($in_robi_token)
		{
			$result = mysqli_query($this->dbh, "UPDATE `control` SET `robi_token` = '$in_robi_token' WHERE `control`.`id` = 1;");
			return $result;
		}
		public function in_bl_id($in_bl_id)
		{
			$result = mysqli_query($this->dbh, "UPDATE `control` SET `bl_user` = '$in_bl_id' WHERE `control`.`id` = 1;");
			return $result;
		}
		public function in_bl_token($in_bl_token)
		{
			$result = mysqli_query($this->dbh, "UPDATE `control` SET `bl_token` = '$in_bl_token' WHERE `control`.`id` = 1;");
			return $result;
		}
	
			// GET control_value
		public function get_control()
		{
			$result = mysqli_query($this->dbh, "SELECT * FROM control WHERE id=1 LIMIT 1");
			return $result;
		}
		
		// bkash history
		public function bkash_pay($user_id, $username, $paymentID, $payerReference, $customerMsisdn, $trxID, $amount, $merchantInvoiceNumber, $paymentExecuteTime )
		{
			$result = mysqli_query($this->dbh, "insert into bkash_pay(user_id,username,paymentID,payerReference,customerMsisdn,trxID,amount,merchantInvoiceNumber,paymentExecuteTime) values('$user_id','$username','$paymentID','$payerReference','$customerMsisdn','$trxID','$amount','$merchantInvoiceNumber','$paymentExecuteTime' )");
			return $result;
		}
		
		
		
		
	}
	
function curl($url,$headData,$postData){
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_POST, 1);
	curl_setopt($curl, CURLOPT_POSTFIELDS, $postData);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER , 1);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($curl, CURLOPT_HTTPHEADER, $headData);
	$content = curl_exec($curl);
	curl_close($curl);
	return $content;
}

function getNidInfo($nid,$dob){
	$result = [];
	$url = 'https://gd.police.gov.bd/api/NationalIdentityInfo/GetNationalIdentityInfo';
	$headData = ['content-type: application/json'];
	$postData = json_encode(["nid" => $nid, "dob" => $dob, "callName" => 'NIDVerifyAlok']);
	$nidInfo = json_decode(curl($url,$headData,$postData),true);
	if(isset($nidInfo['status'], $nidInfo['nidInfo']['status'])){
		if($nidInfo['status'] && $nidInfo['nidInfo']['status'] == "OK"){
			$result['success'] = true;
			$result['nidData'] = $nidInfo['nidInfo']['success']['data'];
		}else{
			$result['success'] = false;
		}
	}else{
		$result['success'] = false;
	}
	return $result;
}
	
function getNidModInfo($nid,$dob){
    $nidInfo = getNidInfo($nid,$dob);
    if($nidInfo['success']){
		$result['success'] = true;
		$result['nidData']['name'] = $nidInfo['nidData']['name'];
		$result['nidData']['nameEn'] = $nidInfo['nidData']['nameEn'];
		$result['nidData']['nationalId'] = $nidInfo['nidData']['nationalId'];
		$result['nidData']['gender'] = $nidInfo['nidData']['gender'];
		$result['nidData']['bloodGroup'] = $nidInfo['nidData']['bloodGroup'];
		$result['nidData']['dateOfBirth'] = $nidInfo['nidData']['dateOfBirth'];
		$result['nidData']['birthPlace'] = $nidInfo['nidData']['permanentAddress']['district'];
		$result['nidData']['father'] = $nidInfo['nidData']['father'];
		$result['nidData']['nidFather'] = $nidInfo['nidData']['nidFather'];
		$result['nidData']['mother'] = $nidInfo['nidData']['mother'];
		$result['nidData']['nidMother'] = $nidInfo['nidData']['nidMother'];
		$result['nidData']['spouse'] = $nidInfo['nidData']['spouse'];
		$result['nidData']['voterArea'] = $nidInfo['nidData']['voterArea'];
		$result['nidData']['voterAreaCode'] = $nidInfo['nidData']['voterAreaCode'];
		$result['nidData']['mobile'] = $nidInfo['nidData']['mobile'];
		$result['nidData']['religion'] = $nidInfo['nidData']['religion'];
		$result['nidData']['photo'] = $nidInfo['nidData']['photo'];
		$result['nidData']['permanentAddress'] = $nidInfo['nidData']['permanentAddress'];
		$result['nidData']['presentAddress'] = $nidInfo['nidData']['presentAddress'];
		$explodeVoterArea = explode(' (',$nidInfo['nidData']['voterArea']);
		$uniqueVillageOrRoad = $explodeVoterArea[0];
		if($result['nidData']['permanentAddress']['additionalVillageOrRoad'] == ""){
			$result['nidData']['permanentAddress']['additionalVillageOrRoad'] = $uniqueVillageOrRoad;
		}
		if($result['nidData']['presentAddress']['additionalVillageOrRoad'] == "" && $result['nidData']['presentAddress']['region'] == $result['nidData']['permanentAddress']['region']){
			$result['nidData']['presentAddress']['additionalVillageOrRoad'] = $uniqueVillageOrRoad;
		}
		$result['msg'] = 'Developed by Samiul Alim!';
    }else{
    	$result['success'] = false;
    	$result['msg'] = 'Info not found!';
    }
	return json_encode($result);
}
?>