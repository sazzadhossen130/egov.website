<?php
session_start();
if ($_SESSION['uid'] != "1") {
  header('location:logout.php');
} else {

  $user_id = $_SESSION['uid'];
  include_once("function.php");
  $fetchdata = new DB_con();
  $obj = new DB_con();

  if ($user_id == 1) {
?>
    <?php include('includes/head.php');  ?>

    <main id="main" class="main">

      <div class="pagetitle">
        <h1>recharge requests</h1>
        <nav>
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
            <li class="breadcrumb-item active">recharge requests</li>
          </ol>
        </nav>
      </div><!-- End Page Title -->

      <section class="section">
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title text-center">All Pending Requests</h5>

                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th> ID </th>
                      <th> User ID </th>
                      <th> Username</th>
                      <th> number</th>
                      <th> TXN id</th>
                      <th> Amount</th>
                      <th class="text-center"> Action </th>
                      <th> Date & Time</th>

                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $sql = $obj->get_recharge();
                    $cnt = 1;
                    while ($row = mysqli_fetch_array($sql)) {
                    ?>
                      <tr>
                        <td> <?php echo $row['id']; ?> </td>
                        <td><?php echo $row['user_id']; ?></td>
                        <td><?php echo $row['username']; ?></td>
                        <td><?php echo $row['number']; ?></td>
                        <td><?php echo $row['txn_id']; ?></td>
                        <td><?php echo $row['deposit']; ?></td>
                        <td><a class="btn btn-success rounded-pill" href="recharge_approve.php?i=<?php echo $row['id']; ?>&id=<?php echo $row['user_id']; ?>&amount=<?php echo $row['deposit']; ?>&username=<?php echo $row['username']; ?>"> Approve</a>

                          <a class="btn btn-danger rounded-pill" href="recharge_approve.php?i=<?php echo $row['id']; ?>&id=decline"> Decline</a>

                        </td>
                        <td><?php echo $row['date']; ?></td>

                      </tr>
                    <?php
                      $cnt = $cnt + 1;
                    } ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </section>
    </main>

    <?php include('includes/footer.php');
    ?>
<?php } else {
    header('location:error-404.html');
  }
} ?>