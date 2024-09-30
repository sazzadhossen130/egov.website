<?php
session_start();
include_once('function.php');
$obj = new DB_con();

$user_id = $_SESSION['uid'];

if ($user_id == 1) {

if (isset($_GET['id'])) {

    $i = $_GET['i'];
    $id = $_GET['id'];
    $deposit = $_GET['amount'];

    if ($id == "decline") {

        $result =  $obj->delete_recharge($i);
        if ($result) {
            echo "<script>alert('Declined Recharge successfully.');</script>";
            echo "<script>window.location.href = 'recharge_requests.php'</script>";
        } else {
            echo "something went wrong ";
            echo "<script>window.location.href = 'recharge_requests.php'</script>";
        }
    } else {

        $result = $obj->insert_deposit($deposit, $id);
        if ($result) {
            echo "<script>alert('Recharge successfull.');</script>";
            $result = $obj->delete_recharge($i);
            echo "<script>window.location.href = 'recharge_requests.php'</script>";
        } else {
            echo "something went wrong ";
            echo "<script>window.location.href = 'recharge_requests.php'</script>";
        }
    }
}
} else {
    header('location:error-404.html');
}
