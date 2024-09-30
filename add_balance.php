<?php
session_start();
if ($_SESSION['uid'] != "1") {
  header('location:logout.php');
} else {

?>

  <?php
  include_once('function.php');
  $obj = new DB_con();
  $fetchdata = new DB_con();


  $user_id = $_SESSION['uid'];

  $sql = $obj->get_balance($user_id);
  $balance = mysqli_fetch_array($sql);
  $diff = $balance['deposit_sum'] - $balance['withdraw_sum'];


  $id = $_GET['id'];
  if (isset($_POST['submit'])) {
    $deposit = $_POST['deposit'];
    $result = $obj->insert_deposit($deposit, $id);
    if ($result) {
      echo "<script>alert('Deposit successfull.');</script>";
    } else {
      echo "something went wrong ";
    }
  }

  ?>
  <?php include('includes/head.php');
  ?>

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Users List</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item active">Users List</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title text-center">All Users List</h5>

              <table class="table table-bordered">
                <?php
                if ($user_id == 1) { ?>
                  <form action="" method="post">
                    <div class="row">
                      <div class="col-md-5">
                        <h4> Add Balance </h4>
                        <div class="mb-3 mt-3">
                          <label> Deposit Balance :</label>
                          <input type="number" class="form-control" name="deposit">
                        </div>

                        <input type="submit" name="submit" class="btn btn-primary" value="submit" />
                      </div>

                    </div>
                  </form>

                <?php
                } else { ?>


                <?php  }

                ?>

              </table>


              <div class="container">
                <div class="row">
                  <div class="col-sm-2">
                  </div>
                  <div class="col-md-8">
                    <table class="table table-bordered">
                      <thead>
                        <tr>
                          <th> ID </th>
                          <th> User ID </th>
                          <th> Username</th>
                          <th> Deposit</th>
                          <th> Date</th>

                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $sql = $obj->get_deposit($id);
                        $cnt = 1;
                        while ($row = mysqli_fetch_array($sql)) {
                        ?>
                          <tr>
                            <td> <?php echo $row['id']; ?> </td>
                            <td><?php echo $row['user_id']; ?></td>
                            <td><?php echo $row['username']; ?></td>
                            <td><?php echo $row['deposit']; ?></td>
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
          </div>
        </div>
      </div>
    </section>
  </main>

  <?php include('includes/footer.php');
  ?>
<?php } ?>