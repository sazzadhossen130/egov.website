<?php
session_start();
error_reporting(0);

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

  if (isset($_POST['login_control'])) {
    $in_login = $_POST['login_control'];
    $result = $obj->in_login($in_login);
    if ($result) {
      echo "<script>alert('login setting updated.');</script>";
    }
  }

  if (isset($_POST['notice_control'])) {
    $in_notice = $_POST['notice_control'];
    $result = $obj->in_notice($in_notice);
    if ($result) {
      echo "<script>alert('Notice updated.');</script>";
    }
  }
  if (isset($_POST['register_control'])) {
    $in_register = $_POST['register_control'];
    $result = $obj->in_register($in_register);
    if ($result) {
      echo "<script>alert('register setting updated.');</script>";
    }
  }
  if (isset($_POST['approval_control'])) {
    $in_approval = $_POST['approval_control'];
    $result = $obj->in_approval($in_approval);
    if ($result) {
      echo "<script>alert('approval setting updated.');</script>";
    }
  }
  if (isset($_POST['charge_control'])) {
    $in_charge = $_POST['charge_control'];
    $result = $obj->in_charge($in_charge);
    if ($result) {
      echo "<script>alert('Charge updated.');</script>";
    }
  }
  if (isset($_POST['recharge_control'])) {
    $in_rg_msg = $_POST['recharge_control'];
    $result = $obj->in_rg_msg($in_rg_msg);
    if ($result) {
      echo "<script>alert('Recharge msg updated.');</script>";
    }
  }
  if (isset($_POST['bot_control'])) {
    $in_bot = $_POST['bot_control'];
    $result = $obj->in_bot($in_bot);
    if ($result) {
      echo "<script>alert('Bot token updated.');</script>";
    }
  }
  if (isset($_POST['log_control'])) {
    $in_log = $_POST['log_control'];
    $result = $obj->in_log($in_log);
    if ($result) {
      echo "<script>alert('Log channel updated.');</script>";
    }
  }

  if (isset($_POST['robi_token'])) {
    $in_robi_token = $_POST['robi_token'];
    $result = $obj->in_robi_token($in_robi_token);
    if ($result) {
      echo "<script>alert('Minimum Recharge updated.');</script>";
    }
  }
  if (isset($_POST['bl_user'])) {
    $in_bl_id = $_POST['bl_user'];
    $result = $obj->in_bl_id($in_bl_id);
    if ($result) {
      echo "<script>alert('BL user updated.');</script>";
    }
  }
  if (isset($_POST['bl_token'])) {
    $in_bl_token = $_POST['bl_token'];
    $result = $obj->in_bl_token($in_bl_token);
    if ($result) {
      echo "<script>alert('BL token updated.');</script>";
    }
  }


  ?>

  <?php include('includes/head.php');
  ?>
  <style>
    .card-body {
      overflow: auto;
    }
  </style>
  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Control Panel</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
          <li class="breadcrumb-item active">controls</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">


        <div class="card-body pt-0">
          <div class="card mb-3">
            <div class="card-header">
              <div class="row flex-between-end">
                <div class="col-auto align-self-center">
                  <h5 class="mb-0" data-anchor="data-anchor">Control Panel</h5>
                </div>
              </div>
            </div>
            <div class="card-body bg-light">
              <div class="row light">


                <div class="col-sm-6 col-lg-4 mb-4">
                  <div class="card text-white bg-secondary">
                    <div class="card-body">
                      <form method="post" action="">
                        <div class="card-title">Login</div>
                        <select name="login_control" class="form-select" aria-label="select on or off">
                          <?php if ($login == 1) { ?>
                            <option value="1" selected>ON</option>
                            <option value="0">OFF</option>
                          <?php } else { ?>
                            <option value="1">ON</option>
                            <option value="0" selected>OFF</option>
                          <?php }

                          ?>
                        </select>
                        <div class="col-12 mt-3 text-end">
                          <button class="btn btn-danger" type="submit">Submit</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
                <div class="col-sm-6 col-lg-4 mb-4">
                  <div class="card text-white bg-secondary">
                    <div class="card-body">
                      <form method="post" action="">
                        <div class="card-title">Register</div>
                        <select name="register_control" class="form-select" aria-label="select on or off">
                          <?php if ($register == 1) { ?>
                            <option value="1" selected>ON</option>
                            <option value="0">OFF</option>
                          <?php } else { ?>
                            <option value="1">ON</option>
                            <option value="0" selected>OFF</option>
                          <?php }

                          ?>

                        </select>
                        <div class="col-12 mt-3 text-end">
                          <button class="btn btn-danger" type="submit" name="register">Submit</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>



                <div class="col-sm-6 col-lg-4 mb-4">
                  <div class="card text-white bg-secondary">
                    <div class="card-body">
                      <form method="post" action="">
                        <div class="card-title">SERVER COPY</div>
                        <input value="<?php echo $charge; ?>" class="form-control" type="text" name="charge_control" required="">
                        <div class="col-12 mt-3 text-end">
                          <button class="btn btn-danger" type="submit" name="charge">Submit</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>


                <div class="col-sm-6 col-lg-4 mb-4">
                  <div class="card text-white bg-secondary">
                    <div class="card-body">
                      <form method="post" action="">
                        <div class="card-title">NID MAKE</div>
                        <input value="<?php echo $log_channel; ?>" class="form-control" type="text" name="log_channel" required="">
                        <div class="col-12 mt-3 text-end">
                          <button class="btn btn-danger" type="submit" name="log_channel">Submit</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>

                <div class="col-sm-6 col-lg-4 mb-4">
                  <div class="card text-white bg-secondary">
                    <div class="card-body">
                      <form method="post" action="">
                        <div class="card-title">NUMBER TO INFO</div>
                        <input value="<?php echo $bot_token; ?>" class="form-control" type="text" name="bot_token" required="">
                        <div class="col-12 mt-3 text-end">
                          <button class="btn btn-danger" type="submit" name="bot_token">Submit</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
                <div class="col-sm-6 col-lg-4 mb-4">
                  <div class="card text-white bg-secondary">
                    <div class="card-body">
                      <form method="post" action="">
                        <div class="card-title">Minimum Recharge</div>
                        <input value="<?php echo $robi_token; ?>" class="form-control" type="text" name="robi_token" required="">
                        <div class="col-12 mt-3 text-end">
                          <button class="btn btn-danger" type="submit" name="log-channel">Submit</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>



                <div class="col-sm-6 mb-4">
                  <div class="card text-white bg-info">
                    <div class="card-body">
                      <form method="post" action="">
                        <div class="card-title">Recharge msg</div>
                        <textarea class="form-control" style="min-height: 200px;" type="text" name="recharge_control" required=""><?php echo $recharge_msg; ?></textarea>
                        <div class="col-12 mt-3 text-end">
                          <button class="btn btn-danger" type="submit" name="recharge">Submit</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>

                <div class="col-sm-6 mb-4">
                  <div class="card text-white bg-info">
                    <div class="card-body">
                      <form method="post" action="">
                        <div class="card-title">Notice</div>
                        <textarea style="min-height: 200px;" class="form-control" type="text" name="notice_control" required=""><?php echo $notice; ?></textarea>
                        <div class="col-12 mt-3 text-end">
                          <button class="btn btn-danger" type="submit" name="notice">Submit</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>

                <!--<div class="col-sm-6 col-lg-4 mb-4">-->
                <!--  <div class="card text-white bg-info">-->
                <!--    <div class="card-body">-->
                <!--      <form method="post" action="">-->
                <!--        <div class="card-title">Bot Token</div>-->
                <!--        <input class="form-control" type="text" name="bot_control" required="">-->
                <!--        <div class="col-12 mt-3 text-end">-->
                <!--          <button class="btn btn-danger" type="submit" name="bot">Submit</button>-->
                <!--        </div>-->
                <!--      </form>-->
                <!--    </div>-->
                <!--  </div>-->
                <!--</div>-->

                <!--<div class="col-sm-6 col-lg-4 mb-4">-->
                <!--  <div class="card text-white bg-dark">-->
                <!--    <div class="card-body">-->
                <!--      <form method="post" action="">-->
                <!--        <div class="card-title">log channel</div>-->
                <!--        <input class="form-control" type="text" name="log_control" required="">-->
                <!--        <div class="col-12 mt-3 text-end">-->
                <!--          <button class="btn btn-danger" type="submit" name="log-channel">Submit</button>-->
                <!--        </div>-->
                <!--      </form>-->
                <!--    </div>-->
                <!--  </div>-->
                <!--</div>-->

                <!--<div class="col-sm-6 col-lg-4 mb-4">-->
                <!--  <div class="card text-white bg-primary ">-->
                <!--    <div class="card-body">-->
                <!--      <form method="post" action="">-->
                <!--        <div class="card-title">Robi Api user id</div>-->
                <!--        <input class="form-control" type="text" name="robi_user" required="">-->
                <!--        <div class="col-12 mt-3 text-end">-->
                <!--          <button class="btn btn-danger" type="submit" name="log-channel">Submit</button>-->
                <!--        </div>-->
                <!--      </form>-->
                <!--    </div>-->
                <!--  </div>-->
                <!--</div>-->

                <!--<div class="col-sm-6 col-lg-4 mb-4">-->
                <!--  <div class="card text-white  bg-secondary ">-->
                <!--    <div class="card-body">-->
                <!--      <form method="post" action="">-->
                <!--        <div class="card-title">Robi Token</div>-->
                <!--        <input class="form-control" type="text" name="robi_token" required="">-->
                <!--        <div class="col-12 mt-3 text-end">-->
                <!--          <button class="btn btn-danger" type="submit" name="log-channel">Submit</button>-->
                <!--        </div>-->
                <!--      </form>-->
                <!--    </div>-->
                <!--  </div>-->
                <!--</div>-->

                <!--<div class="col-sm-6 col-lg-4 mb-4">-->
                <!--  <div class="card text-white bg-success ">-->
                <!--    <div class="card-body">-->
                <!--      <form method="post" action="">-->
                <!--        <div class="card-title">Bl user number</div>-->
                <!--        <input class="form-control" type="text" name="bl_user" required="">-->
                <!--        <div class="col-12 mt-3 text-end">-->
                <!--          <button class="btn btn-danger" type="submit" name="log-channel">Submit</button>-->
                <!--        </div>-->
                <!--      </form>-->
                <!--    </div>-->
                <!--  </div>-->
                <!--</div>-->

                <!--<div class="col-sm-6 col-lg-4 mb-4">-->
                <!--  <div class="card text-white bg-danger">-->
                <!--    <div class="card-body">-->
                <!--      <form method="post" action="">-->
                <!--        <div class="card-title">BL Token</div>-->
                <!--        <input class="form-control" type="text" name="bl_token" required="">-->
                <!--        <div class="col-12 mt-3 text-end">-->
                <!--          <button class="btn btn-danger" type="submit" name="log-channel">Submit</button>-->
                <!--        </div>-->
                <!--      </form>-->
                <!--    </div>-->
                <!--  </div>-->
                <!--</div>-->




              </div>
            </div>
            <div class="col-12  text-center">
              MADE WITH LOVE BY <a href="https://t.me/Blackcat4200">
                <p class="text-bold">BLACKCAT</p>
              </a>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>

  <?php include('includes/footer.php');
  ?>
<?php } ?>