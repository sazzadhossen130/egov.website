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
      <h1>Users List</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
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
                  <thead>
                    <tr>
                      <th scope="col"> # </th>
                      <th scope="col"> FullName</th>
                      <th scope="col">Username</th>
                      <th scope="col">Balance</th>
                      <th scope="col">Email</th>
                      <th scope="col">Reg Date</th>
                      <th scope="col"> Add Balance</th>
                      <th scope="col"> Action</th>
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
                        <td><i class="bi bi-person-fill"></i> <?php echo $row['FullName']; ?></td>
                        <td><?php echo $row['Username']; ?></td>
                        <td><?php
                            $sql2 = $obj->get_balance($row['id']);
                            $balance2 = mysqli_fetch_array($sql2);
                            echo ($balance2['deposit_sum'] - $balance2['withdraw_sum']); ?></td>
                        <td><?php echo $row['UserEmail']; ?></td>
                        <td><?php echo $row['RegDate']; ?></td>
                        <td> <a style="
    min-width: 106px;
" class="btn btn-success rounded-pill" href="add_balance.php?id=<?php echo $row['id']; ?>"><i class="bi bi-plus-circle"></i> Balance</a></td>
                        <td> <a href="delete_user.php?id=<?php echo $row['id']; ?>" class="btn btn-danger"> Delete </a></td>
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