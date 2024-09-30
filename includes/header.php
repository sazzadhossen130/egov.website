<?php $sql = $obj->get_control();
while ($row = mysqli_fetch_array($sql)) {
    $recharge_msg = $row['rg_msg'];
    $notice =  $row['notice'];
    $approval = $row['approval'];
    $login =  $row['login'];
    $register = $row['register'];
    $bot_token =  $row['bot_token'];
    $log_channel = $row['log_channel'];
    $charge =  $row['charge'];
    $robi_id = $row['robi_user'];
    $robi_token =  $row['robi_token'];
    $bl_id = $row['bl_user'];
    $bl_token =  $row['bl_token'];
} ?>
<!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <a href="index.php" class="logo d-flex align-items-center">
        <!-- <img src="https://surokkha.gov.bd/static/media/logo-f.5c608b98.png" alt=""> -->
        <!-- <span class="d-none d-lg-block">NID</span> -->
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">

        <li class="nav-item dropdown">
          <?php
          $sql = $fetchdata->get_balance($user_id);
          $balance = mysqli_fetch_array($sql);
          ?>
          <button type="button" class="btn btn-danger mb-2"> <i class="bi bi-currency-dolla me-1"></i> Balance: <span class="badge bg-white text-primary"><?php echo ($balance['deposit_sum'] - $balance['withdraw_sum']); ?></span>
          </button>
        </li><!-- End Messages Nav -->

        <li class="nav-item dropdown pe-3">

          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <!-- <img src="assets/img/profile-img.jpg" alt="Profile" class="rounded-circle"> -->
            <span class="d-none d-md-block dropdown-toggle ps-2"><?php echo  $_SESSION['username']; ?></span>
          </a><!-- End Profile Iamge Icon -->

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
              <a class="dropdown-item d-flex align-items-center" href="pass.php">
                <!--<i class="bi bi-box-arrow-right"></i>-->
                <span>Change pass</span>
              </a>
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="logout.php">
                <i class="bi bi-box-arrow-right"></i>
                <span>Sign Out</span>
              </a>
            </li>

          </ul><!-- End Profile Dropdown Items -->
        </li><!-- End Profile Nav -->

      </ul>
    </nav><!-- End Icons Navigation -->

  </header><!-- End Header -->