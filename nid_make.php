<?php
session_start();

if (!isset($_SESSION['uid'])) {
   header('location:logout.php');
   die();
} else {
   $json = null;
   $showFrom = true;
   $user_id = $_SESSION['uid'];
   include_once('function.php');
   include('phpqrcode/qrlib.php');

   $obj = new DB_con();
   $fetchdata = new DB_con();
   $sql = $obj->get_control();

   while ($row = mysqli_fetch_array($sql)) {
      $recharge_msg = $row['rg_msg'];
      $notice =  $row['notice'];
      $approval = $row['approval'];
      $login =  $row['login'];
      $register = $row['register'];
      $charge = $row['log_channel'];
   }

   $sql = $obj->get_balance($user_id);
   $balance = mysqli_fetch_array($sql);
   $diff = $balance['deposit_sum'] - $balance['withdraw_sum'];

   if (isset($_POST['submit'])) {
      if ($diff >= $charge) {
         $withdraw = $obj->get_withdraw($user_id, $charge);
         $showFrom = false;
      } else {
         echo '<script>alert("Insufficient balance")</script>';
      }
   }
}
?>

<?php if ($showFrom) { ?>
   <!DOCTYPE html>
   <html lang="en">

   <head>
      <meta charset="utf-8">
      <meta content="width=device-width, initial-scale=1.0" name="viewport">
      <meta content="" name="description">
      <meta content="" name="keywords">
      <title><?php if ($json == null) {
                  echo "NID MAKE";
               } else {
                  echo $_POST['nid'];
               } ?></title>
      <link href="https://surokkha.gov.bd/favicon.png" rel="icon">
      <link href="https://surokkha.gov.bd/favicon.png" rel="apple-touch-icon">
      <link href="https://fonts.gstatic.com" rel="preconnect">
      <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.1.1/css/all.css">
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" type="text/javascript"></script>
      <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
      <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
      <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
      <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
      <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
      <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
      <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
      <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">
      <link href="assets/css/style.css" rel="stylesheet">
   </head>

   <body>
      <header id="header" class="header fixed-top d-flex align-items-center">
         <div class="d-flex align-items-center justify-content-between">
            <a href="index.php" class="logo d-flex align-items-center"></a>
            <i class="bi bi-list toggle-sidebar-btn"></i>
         </div>
         <nav class="header-nav ms-auto">
            <ul class="d-flex align-items-center">
               <li class="nav-item dropdown"><?php $sql = $fetchdata->get_balance($user_id);
                                             $balance = mysqli_fetch_array($sql); ?>
                  <button type="button" class="btn btn-danger mb-2"> <i class="bi bi-currency-dolla me-1"></i> Balance: <span class="badge bg-white text-primary"><?php echo ($balance['deposit_sum'] - $balance['withdraw_sum']); ?></span></button>
               </li>
               <li class="nav-item dropdown pe-3">
                  <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                     <span class="d-none d-md-block dropdown-toggle ps-2"><?php echo  $_SESSION['username']; ?></span>
                  </a>
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
                        <a class="dropdown-item d-flex align-items-center" href="logout.php">
                           <i class="bi bi-box-arrow-right"></i>
                           <span>Sign Out</span>
                        </a>
                     </li>
                  </ul>
               </li>
            </ul>
         </nav>
      </header>
      <?php include('includes/sidebar.php'); ?>
      <main id="main" class="main">
         <section class="section profile">
            <div id="inp" class="container mt-6 col-md-12 mb-5">
               <marquee style="padding: 10px;background: white;border-radius: 5px;border: 1px solid #0d6efd;"><?php echo $notice ?></marquee>
               <p><?php if ($diff > $charge) {
                     echo " ";
                  } else {
                     echo ' <div class="alert alert-danger"><strong>Sorry !</strong> You  do not have enough balance.</div>';
                  } ?></p>
               <form action="" method="POST">
                  <div class="row">
                     <div class="mb-3 myDiv" id="showOne">
                        <label>Photo:</label>
                        <input type="file" class="form-control" name="photo" accept="image/*">
                     </div>
                     <div class="mb-3 myDiv" id="showOne">
                        <label>Signature:</label>
                        <input type="file" class="form-control" name="signature" accept="image/*">
                     </div>
                  </div>
                  <div class="row">
                     <div class="mb-3 myDiv" id="showOne">
                        <label>Name (Bangla):</label>
                        <input type="text" class="form-control" name="name_bn" placeholder="নাম (বাংলা)" required>
                     </div>
                     <div class="mb-3 myDiv" id="showOne">
                        <label>Name (English):</label>
                        <input type="text" class="form-control" name="name_en" placeholder="Name (English)" required>
                     </div>
                     <div class="mb-3 myDiv" id="showOne">
                        <label>NID Number:</label>
                        <input type="text" class="form-control" name="nid" placeholder="825218****" required>
                     </div>
                     <div class="mb-3 myDiv" id="showOne">
                        <label>PIN Number:</label>
                        <input type="text" class="form-control" name="pin" placeholder="PIN Number" required>
                     </div>
                     <div class="mb-3 myDiv" id="showOne">
                        <label>Father's Name:</label>
                        <input type="text" class="form-control" name="father" placeholder="Father's Name" required>
                     </div>
                     <div class="mb-3 myDiv" id="showOne">
                        <label>Mother's Name:</label>
                        <input type="text" class="form-control" name="mother" placeholder="Mother's Name" required>
                     </div>
                     <div class="mb-3 myDiv" id="showOne">
                        <label>Birth Place:</label>
                        <input type="text" class="form-control" name="birth" placeholder="Birth Place" required>
                     </div>
                     <div class="mb-3 myDiv" id="showOne">
                        <label>Date Of Birth:</label>
                        <input type="text" class="form-control" name="dob" placeholder="05 Nov 2005" required>
                     </div>
                     <div class="mb-3 myDiv" id="showOne">
                        <label>Card issue date:</label>
                        <input type="text" class="form-control" name="card_date" placeholder="Card date" required>
                     </div>
                     <div class="mb-3 myDiv" id="showOne">
                        <label>Blood Group:</label>
                        <input type="text" class="form-control" name="blood" placeholder="Blood Group" required>
                     </div>
                     <div class="mb-3 myDiv" id="showOne">
                        <label>Address:</label>
                        <input type="text" class="form-control" name="address" placeholder="Address Line" required>
                     </div>
                  </div>
                  <span style="font-size: 12px;padding: 10px;margin: auto;text-align: center;color: red;">
                     <b>Note:</b> You will be charged <?php echo $charge ?> tk by clicking submit.
                  </span>
                  <input type="submit" name="submit" class="btn btn-danger" onclick="submit()" value="Submit" />
               </form>


               </form>
            </div>
         </section>
      </main>
      <script>
      </script>
      <?php include('includes/footer.php'); ?>
   <?php } else { ?>
      <html lang="en">

      <head>
         <title>nid-<?php echo isset($_POST['nid']) ? $_POST['nid'] : ''; ?></title>
         <link href="https://sonnetdp.github.io/nikosh/css/nikosh.css" rel="stylesheet" type="text/css">
         <!--<link rel="stylesheet" href="css/nstyle.css">-->
         <link href="https://fonts.maateen.me/kalpurush/font.css" rel="stylesheet">
         <link rel="stylesheet" href="assets/css/bootstrap.min.css" integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">
         <script src="assets/JavaScript/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
         <script src="assets/JavaScript/bootstrap.min.js" integrity="sha384-oesi62hOLfzrys4LxRF63OJCXdXDipiYWBnvTl9Y9/TRlw5xlKIEHpNyvvDShgf/" crossorigin="anonymous"></script>
         <script src="assets/JavaScript/jquery-1.11.1.min.js"></script>
         <link rel="stylesheet" href="assets/css/tx1337.css" data-n-g="" />
         <style>
            @media print {
               @page {
                  margin: 0;
               }
            }
         </style>
         <script>
            window.onload = function() {
               var hub3_code = '<pin><?php echo isset($_POST['pin']) ? $_POST['pin'] : ''; ?></pin><name><?php echo isset($_POST['name_en']) ? $_POST['name_en'] : ''; ?></name><DOB><?php echo isset($_POST['dob']) ? $_POST['dob'] : ''; ?>/DOB><FP></FP><F>Right Index</F><TYPE>A</TYPE><V>2.0</V><ds>302c0214103fc01240542ed736c0b48858c1c03d80006215021416e73728de9618fedcd368c88d8f3a2e72096d</ds>';

               console.log(hub3_code);

               PDF417.init(hub3_code);

               var barcode = PDF417.getBarcodeArray();

               // block sizes (width and height) in pixels
               var bw = 2;
               var bh = 2;

               // create canvas element based on number of columns and rows in barcode
               var canvas = document.createElement('canvas');
               canvas.width = bw * barcode['num_cols'];
               canvas.height = bh * barcode['num_rows'];
               document.getElementById('barcode').appendChild(canvas);

               var ctx = canvas.getContext('2d');

               // graph barcode elements
               var y = 0;
               // for each row
               for (var r = 0; r < barcode['num_rows']; ++r) {
                  var x = 0;
                  // for each column
                  for (var c = 0; c < barcode['num_cols']; ++c) {
                     if (barcode['bcode'][r][c] == 1) {
                        ctx.fillRect(x, y, bw, bh);
                     }
                     x += bw;
                  }
                  y += bh;
               }
            }
         </script>
         <script src="assets/JavaScript/bcmath-min.js" type="text/javascript"></script>
         <script src="assets/JavaScript/pdf417-min.js" type="text/javascript"></script>
      </head>

      <body>
         <div id="__next" data-reactroot="">
            <main>
               <div>
                  <main class="w-full overflow-hidden">
                     <div class="container w-full py-12 lg:flex lg:items-start" style="padding-top: 0;">
                        <div class="w-full lg:pl-6">
                           <div class="flex items-center justify-center">
                              <div class="w-full">

                                 <div class="flex items-start gap-x-2 bg-transparent mx-auto w-fit" id="nid_wrapper">
                                    <div id="nid_front" class="w-full border-[1.999px] border-black">
                                       <header class="px-1.5 flex items-start gap-x-2 justify-between relative">
                                          <img class="w-[38px] absolute top-1.5 left-[4.5px]" src="assets/Images/bangladeshicon.png" alt="assets/Images/bangladeshicon2.png" />
                                          <div class="w-full h-[60px] flex flex-col justify-center">
                                             <h3 style="font-size:20px" class="text-center font-medium tracking-normal pl-11 bn leading-5"><span style="margin-top:1px;display:inline-block">গণপ্রজাতন্ত্রী বাংলাদেশ সরকার</span></h3>
                                             <p class="text-[#007700] text-right tracking-[-0rem] leading-3" style="font-size:11.46px;font-family:arial;margin-bottom:-0.02px">Government of the People&#x27;s Republic of Bangladesh</p>
                                             <p class="text-center font-medium pl-10 leading-4" style="padding-top:0px"><span class="text-[#ff0002]" style="font-size:10px;font-family:arial">National ID Card</span><span class="ml-1" style="display:inline-block"><span style="font-size:13px;font-family:arial">/</span></span><span class="bn ml-1" style="font-size:13.33px">জাতীয় পরিচয় পত্র</span></p>
                                          </div>
                                       </header>
                                       <div class="w-[101%] -ml-[0.5%] border-b-[1.9999px] border-black" style="width: 100%;margin-left: 0;"></div>
                                       <div class="pt-[3.8px] pr-1 pl-[2px] bg-center w-full flex justify-between gap-x-2 pb-5 relative">
                                          <div class="absolute inset-x-0 top-[2px] mx-auto z-10 flex items-start justify-center"><img style="background:transparent;width: 114px;height: 114px;" class="ml-[20px] w-[125px] h-[116px" src="assets/Images/flower-logo.png" alt="" /></div>

                                          <div class="relative z-50">
                                             <label for="photo" class="custom-file-upload">
                                                <img style="margin-top:-2px" id="userPhoto" class="w-[68.2px] h-[78px]" alt="photo" src="photo/*" />
                                             </label>
                                             <input id="photo" type="file" style="display: none;" onchange="previewUserPhoto(this);" accept="photo/*" />

                                             <script>
                                                function previewUserPhoto(input) {
                                                   if (input.files && input.files[0]) {
                                                      var reader = new FileReader();

                                                      reader.onload = function(e) {
                                                         document.getElementById('userPhoto').src = e.target.result;
                                                      }

                                                      reader.readAsDataURL(input.files[0]);
                                                   }
                                                }
                                             </script>
                                             <div class="text-center text-xs flex items-start justify-center pt-[5px] w-[68.2px] mx-auto h-[38.5px] overflow-hidden" id="card_signature"><span style="font-family:Comic sans ms"></span>
                                                <label for="userSignUpload" class="custom-file-upload">
                                                   <img id="sign" src="photo/*" alt="sign" />
                                                </label>
                                                <input id="userSignUpload" type="file" style="display: none;" onchange="previewUserSign(this);" accept="photo/*" />

                                                <script>
                                                   function previewUserSign(input) {
                                                      if (input.files && input.files[0]) {
                                                         var reader = new FileReader();

                                                         reader.onload = function(e) {
                                                            document.getElementById('sign').src = e.target.result;
                                                         }

                                                         reader.readAsDataURL(input.files[0]);
                                                      }
                                                   }
                                                </script>
                                             </div>
                                          </div>
                                          <div class="w-full relative z-50">
                                             <div style="height:5px"></div>
                                             <div class="flex flex-col gap-y-[10px]" style="margin-top: 1px;">
                                                <div>
                                                   <p class="space-x-4 leading-3" style="padding-left:1px"><span class="bn" style="font-size:16.53px">নাম:</span><span class="" style="font-size:16.53px;padding-left:3px;-webkit-text-stroke:0.4px black" id="nameBn"><?php echo isset($_POST['name_bn']) ? $_POST['name_bn'] : ''; ?></span></p>
                                                </div>
                                                <div style="margin-top: 1px;">
                                                   <p class="space-x-2 leading-3" style="margin-bottom:-1.4px;margin-top:1.4px;padding-left:1px"><span style="font-size:11px">Name:</span><span style="font-size:12.73px;padding-left:1px" id="nameEn"><?php echo isset($_POST['name_en']) ? $_POST['name_en'] : ''; ?></span></p>
                                                </div>





                                                <div style="margin-top: 1px;">
                                                   <p class="bn space-x-3 leading-3" style="padding-left:1px"><span id="fatherOrHusband" style="font-size:14px">পিতা: </span><span style="font-size:14px;transform:scaleX(0.724)" id="card_father_name"><?php echo isset($_POST['father']) ? $_POST['father'] : ''; ?></span></p>
                                                </div>


                                                <div style="margin-top: 1px;">
                                                   <p class="bn space-x-3 leading-3" style="margin-top:-2.5px;padding-left:1px"><span style="font-size:14px">মাতা: </span><span style="font-size:14px;transform:scaleX(0.724)" id="card_mother_name"><?php echo isset($_POST['mother']) ? $_POST['mother'] : ''; ?></span></p>
                                                </div>
                                                <div class="leading-4" style="font-size:12px;margin-top:-1.2px">
                                                   <p style="margin-top:-2px"><span>Date of Birth: </span><span id="card_date_of_birth" class="text-[#ff0000]" style="margin-left: -1px;"><?php echo isset($_POST['dob']) ? $_POST['dob'] : ''; ?></span></p>
                                                </div>
                                                <div class="-mt-0.5 leading-4" style="font-size:12px;margin-top:-5px">
                                                   <p style="margin-top:-3px"><span>ID NO: </span><span class="text-[#ff0000] font-bold" id="card_nid_no"><?php echo isset($_POST['nid']) ? $_POST['nid'] : ''; ?></span></p>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    <div id="nid_back" class="w-full border-[1.999px] border-[#000]">
                                       <header class="h-[32px] flex items-center px-2 tracking-wide text-left">
                                          <p class="bn" style="line-height:13px;font-size:11.33px;letter-spacing:0.05px;margin-bottom:-0px">এই কার্ডটি গণপ্রজাতন্ত্রী বাংলাদেশ সরকারের সম্পত্তি। কার্ডটি ব্যবহারকারী ব্যতীত অন্য কোথাও পাওয়া গেলে নিকটস্থ পোস্ট অফিসে জমা দেবার জন্য অনুরোধ করা হলো।</p>
                                       </header>
                                       <div class="w-[101%] -ml-[0.5%] border-b-[1.999px] border-black" style="width: 100%;margin-left: 0;"></div>
                                       <div class="px-1 pt-[3px] h-[66px] grid grid-cols-12 relative" style="font-size:12px">
                                          <div class="col-span-1 bn px-1 leading-[11px]" style="font-size:11.73px;letter-spacing:-0.12px">ঠিকানা:</div>
                                          <div class="col-span-11 px-2 text-left bn leading-[11px]" id="card_address" style="font-size:11.73px;letter-spacing:-0.12px"><?php echo isset($_POST['address']) ? $_POST['address'] : ''; ?></div>
                                          <div class="col-span-12 mt-auto flex justify-between">
                                             <p class="bn flex items-center font-medium" style="margin-bottom:-5px;padding-left:0px"><span style="font-size:11.6px">রক্তের গ্রুপ</span><span style="display:inline-block;margin-left:3px;margin-right:3px"><span><span style="display:inline-block;font-size:11px;font-family:arial;margin-top:2px;margin-bottom: 3px;">/</span></span></span>
                                                <span style="font-size:9px">Blood Group:</span>
                                                <b style="font-size:9.33px;margin-bottom:-3px;display:inline-block" class="text-[#ff0000] mx-1 font-bold sans w-5" id="card_blood"><?php echo isset($_POST['blood']) ? $_POST['blood'] : ''; ?></b><span style="font-size:10.66px"> জন্মস্থান: </span><span class="ml-1" id="card_birth_place" style="font-size:10.66px"><?php echo isset($_POST['birth']) ? $_POST['birth'] : ''; ?></span>
                                             </p>
                                             <div class="text-gray-100 absolute -bottom-[2px] w-[30.5px] h-[13px] -right-[2px] overflow-hidden" style="margin-right: 1px;margin-bottom: 1px;">
                                                <img src="assets/Images/mududdron.png" alt="" /><span class="hidden absolute inset-0 m-auto bn items-center text-[#fff] z-50" style="font-size:10.66px"><span class="pl-[0.2px]">মূদ্রণ:</span><span class="block ml-[3px]">০১</span></span>
                                                <div class="hidden w-full h-full absolute inset-0 m-auto border-[20px] border-black z-30"></div>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="w-[101%] -ml-[0.5%] border-b-[1.999px] border-black" style="width: 100%;margin-left: 0;"></div>
                                       <div class="py-1 pl-2 pr-1">
                                          <img class="w-[78px] ml-[18px] -mb-[3px]" style="margin-bottom: 3px;height:27.3px;" src="assets/Images/adminsign.jpg" />
                                          <div class="flex justify-between items-center -mt-[5px]">
                                             <p class="bn" style="font-size:14px">প্রদানকারী কর্তৃপক্ষের স্বাক্ষর</p>
                                             <span class="pr-4 bn" style="font-size:12px;padding-top:1px">প্রদানের তারিখ:<span class="ml-2.5" id="card_date"></span><?php echo isset($_POST['card_date']) ? $_POST['card_date'] : ''; ?></span>
                                          </div>
                                          <div id="barcode" class="w-full h-[39px] mt-1" alt="NID Card Generator" style="margin-top: 1.5px;margin-left: -3px;">
                                             <style>
                                                canvas {
                                                   width: 102%;
                                                   height: 100%;
                                                }
                                             </style>
                                             <!---<img id="card_qr_code" class="w-full h-[39px] mt-1" alt="NID Card Generator" 
src="assets/Images/notfound.png"/>--->
                                          </div>
                                       </div>
                                    </div>
                                 </div>

                              </div>
                           </div>
                        </div>
                     </div>
               </div>
            </main>
            <br /><br /><br /><br /><br /><br /><br />
            <footer></footer>
         </div>
         <div class="Toastify"></div>
         </main>
         </div>
         <script>
            window.print();
            // Wait for a brief moment before attempting to close the window
            setTimeout(function() {
               // window.close();
            }, 3000); // You can adjust the delay as needed
         </script>
         <script>
            var finalEnlishToBanglaNumber = {
               '0': '০',
               '1': '১',
               '2': '২',
               '3': '৩',
               '4': '৪',
               '5': '৫',
               '6': '৬',
               '7': '৭',
               '8': '৮',
               '9': '৯'
            };

            String.prototype.getDigitBanglaFromEnglish = function() {
               var retStr = this;
               for (var x in finalEnlishToBanglaNumber) {
                  retStr = retStr.replace(new RegExp(x, 'g'), finalEnlishToBanglaNumber[x]);
               }
               return retStr;
            };

            var date_number = "";
            var bangla_date_number = date_number.getDigitBanglaFromEnglish();

            document.getElementById("card_date").innerHTML = bangla_date_number;
         </script>
      </body>

      </html>


   <?php } ?>