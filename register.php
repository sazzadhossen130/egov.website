<?php
// include Function  file
include_once('function.php');
// Object creation
$userdata = new DB_con();

  $data = $userdata->get_control();
	while ($row = mysqli_fetch_array($data)) {
		$recharge_msg = $row['rg_msg'];
		$notice =  $row['notice'];
		$approval = $row['approval'];
		$login =  $row['login'];
		$register = $row['register'];
		$bot_token =  $row['bot_token'];
		$log_channel = $row['log_channel'];
		$charge =  $row['charge'];
	}
	
	if($register == '0'){
	  include "maintenance.html";
      die();
	}

if (isset($_POST['submit'])) {
  // Posted Values
  $fname = $_POST['fullname'];
  $uname = $_POST['username'];
  $uemail = $_POST['email'];
  $pasword = md5($_POST['password']);
  //Function Calling
  $sql = $userdata->registration($fname, $uname, $uemail, $pasword);
  if ($sql) {
    // Message for successfull insertion
    echo "<script>alert('Registration successfull.');</script>";
    echo "<script>window.location.href='signin.php'</script>";
  } else {
    // Message for unsuccessfull insertion
    echo "<script>alert('Something went wrong. Please try again');</script>";
    echo "<script>window.location.href='signin.php'</script>";
  }
}
?>
<?php include('includes/head2.php');
?>
<main>
  <div class="container">

    <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

            <div class="d-flex justify-content-center py-4">
              <a href="index.php" class="logo d-flex align-items-center w-auto">
                <img src="assets/img/logo.png" alt="">
                <span class="d-none d-lg-block">WELCOME</span>
              </a>
            </div><!-- End Logo -->

            <div class="card mb-3">

              <div class="card-body">

                <div class="pt-4 pb-2">
                  <h5 class="card-title text-center pb-0 fs-4">Create an Account</h5>
                  <p class="text-center small">Enter your personal details to create account</p>
                </div>

                <form class="row g-3 needs-validation" action='' method="POST" novalidate>
                  <div class="col-12">
                    <label for="yourName" class="form-label">Name</label>
                    <input type="text" name="fullname" class="form-control" id="yourName" required>
                    <div class="invalid-feedback">Please, enter your name!</div>
                  </div>

                  <div class="col-12">
                    <label for="yourEmail" class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" id="yourEmail" required>
                    <div class="invalid-feedback">Please enter a valid Email adddress!</div>
                  </div>

                  <div class="col-12">
                    <label for="yourUsername" class="form-label">Username</label>
                    <div class="input-group has-validation">
                      <span class="input-group-text" id="inputGroupPrepend">@</span>
                      <input type="text" id="username" name="username" onblur="checkusername(this.value)" class="form-control" id="yourUsername" required>
                      <span id="usernameavailblty"></span>
                      <div class="invalid-feedback">Please choose a username.</div>
                    </div>
                  </div>

                  <div class="col-12">
                    <label for="yourPassword" class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" id="yourPassword" required>
                    <div class="invalid-feedback">Please enter your password!</div>
                  </div>

                  <div class="col-12">
                    <button class="btn btn-danger w-100" type="submit" id="submit" name="submit">Create Account</button>
                  </div>
                  <div class="col-12">
                    <p class="small mb-0">Already have an account? <a href="signin.php">Log in</a></p>
                    
                  </div>
                </form>

              </div>
            </div>

            <div class="credits">

            </div>

          </div>
        </div>
      </div>

    </section>

  </div>
</main><!-- End #main -->

<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

<!-- Vendor JS Files -->
<script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/vendor/chart.js/chart.min.js"></script>
<script src="assets/vendor/echarts/echarts.min.js"></script>
<script src="assets/vendor/quill/quill.min.js"></script>
<script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
<script src="assets/vendor/tinymce/tinymce.min.js"></script>
<script src="assets/vendor/php-email-form/validate.js"></script>

<!-- Template Main JS File -->
<script src="assets/js/main.js"></script>

<script src="assets/jquery-1.11.1.min.js"></script>
<script src="assets/bootstrap.min.js"></script>

<script>
  function checkusername(va) {
    $.ajax({
      type: "POST",
      url: "check_availability.php",
      data: 'username=' + va,
      success: function(data) {
        $("#usernameavailblty").html(data);
      }
    });

  }
</script>

</body>

</html> 