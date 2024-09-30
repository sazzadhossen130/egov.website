<?php
session_start();
if ($_SESSION['uid'] != "1") {
    header('location:logout.php');
} else {

    $user_id = $_SESSION['uid'];
    include_once("function.php");
    $fetchdata = new DB_con();
    $obj = new DB_con();

?>
    <?php include('includes/head.php');
    ?>

    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Payments</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                    <li class="breadcrumb-item active">payments</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title text-center">All Payment History</h5>
                            <table class="table table-bordered">
                                <?php
                                if ($user_id == 1) { ?>
                                    <thead>
                                        <tr>
                                            <th scope="col"> # </th>
                                            <th scope="col"> user_id</th>
                                            <th scope="col">Username</th>
                                            <th scope="col">paymentID</th>
                                            <th scope="col">payerReference</th>
                                            <th scope="col">customerMsisdn</th>
                                            <th scope="col"> trxID</th>

                                            <th scope="col">amount</th>
                                            <th scope="col">merchantInvoiceNumber</th>
                                            <th scope="col">paymentExecuteTime</th>
                                            <!--<th scope="col"> Action</th>-->
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php
                                        $sql = $obj->fetch_bkash_pay();
                                        $cnt = 1;
                                        while ($row = mysqli_fetch_array($sql)) {
                                        ?>
                                            <tr>
                                                <th scope="row"> <?php echo $row['id']; ?> </th>
                                                <td><?php echo $row['user_id']; ?></td>
                                                <td><?php echo $row['username']; ?></td>
                                                <td><?php echo $row['paymentID']; ?></td>
                                                <td><?php echo $row['payerReference']; ?></td>

                                                <td><?php echo $row['customerMsisdn']; ?></td>
                                                <td><?php echo $row['trxID']; ?></td>
                                                <td><?php echo $row['amount']; ?></td>
                                                <td><?php echo $row['merchantInvoiceNumber']; ?></td>
                                                <td><?php echo $row['paymentExecuteTime']; ?></td>
                                                <!--<td> <a href="refund.php?id=<?php echo $row['id']; ?>&paymentID=<?php echo $row['paymentID']; ?>&amount=<?php echo $row['amount']; ?>&trxID=<?php echo $row['trxID']; ?>" class="btn btn-danger"> Refund </a></td>-->
                                            </tr>
                                        <?php
                                            $cnt = $cnt + 1;
                                        } ?>
                                    </tbody>

                                <?php
                                } else { ?>

                                    <thead>
                                        <tr>
                                            <th scope="col"> ID </th>
                                            <th scope="col"> FullName</th>
                                            <th scope="col">Username</th>
                                            <th scope="col">Email</th>
                                            <th scope="col">Reg Date</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php
                                        $sql = $obj->fetch_users();
                                        $cnt = 1;
                                        while ($row = mysqli_fetch_array($sql)) {
                                        ?>
                                            <tr>
                                                <th scope="row"> <?php echo $row['id']; ?> </th>
                                                <td><?php echo $row['FullName']; ?></td>
                                                <td><?php echo $row['Username']; ?></td>
                                                <td><?php echo $row['UserEmail']; ?></td>
                                                <td><?php echo $row['RegDate']; ?></td>

                                            </tr>
                                        <?php
                                            $cnt = $cnt + 1;
                                        } ?>
                                    </tbody>



                                <?php  }

                                ?>

                            </table>






                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <?php include('includes/footer.php');
    ?>
<?php } ?>