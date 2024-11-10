<?php
session_start(); // Start session at the beginning of the script

include('./constant/layout/head.php');
include('./constant/connect.php');

$errors = array();

if (isset($_SESSION['userId'])) {
  header('Location: dashboard.php'); // Redirect to dashboard if already logged in
  exit();
}

if (isset($_POST["login"])) {
  $username = $_POST['username'];
  $password = $_POST['password'];

  if (empty($username) || empty($password)) {
    if (empty($username)) {
      $errors[] = "Username is required";
    }
    if (empty($password)) {
      $errors[] = "Password is required";
    }
  } else {
    // Sanitize user inputs for safety
    $username = $connect->real_escape_string($username);
    $password = $connect->real_escape_string($password);

    // First set of credentials for dashboard.php
    $sql = "SELECT * FROM users WHERE username = '$username' AND password = MD5('$password')";
    $result = $connect->query($sql);

    if ($result) {
      if ($result->num_rows == 1) {
        $value = $result->fetch_assoc();
        $user_id = $value['user_id'];

        // Set session and redirect to dashboard.php
        $_SESSION['userId'] = $user_id;
        $_SESSION['username'] = $username;
        echo "<script>setTimeout(function(){ window.location.href = 'dashboard.php'; }, 1500);</script>";
        exit();
      } else {
        $errors[] = "Incorrect username/password combination for dashboard.php";
      }
    } else {
      $errors[] = "Query error: " . $connect->error;
    }

    // Second set of credentials for another_dashboard.php
    $sql2 = "SELECT * FROM agents WHERE name = '$username' AND agentCode = '$password'";
    $result2 = $connect->query($sql2);

    if ($result2) {
      if ($result2->num_rows > 0) {
        $value2 = $result2->fetch_assoc();
        $user_id2 = $value2['id'];

        // Set session and redirect to another_dashboard.php
        $_SESSION['userId'] = $user_id2;
        $_SESSION['username'] = $username;
        echo "<script>setTimeout(function(){ window.location.href = 'manage-cus.php'; }, 1500);</script>";
        exit();
      } else {
        $errors[] = "Incorrect username/password combination for another_dashboard.php";
      }
    } else {
      $errors[] = "Query error: " . $connect->error;
    }

    // Third set of credentials
    $sql3 = "SELECT * FROM user WHERE name = '$username' AND password = '$password'";
    $result3 = $connect->query($sql3);

    if ($result3) {
      if ($result3->num_rows == 1) {
        $value3 = $result3->fetch_assoc();
        $user_id3 = $value3['user_id'];

        // Set session and redirect to another_dashboard.php
        $_SESSION['userId'] = $user_id3;
        $_SESSION['username'] = $username;
        echo "<script>setTimeout(function(){ window.location.href = 'dash.php'; }, 1500);</script>";
        exit();
      } else {
        $errors[] = "Incorrect username/password combination for another_dashboard.php";
      }
    } else {
      $errors[] = "Query error: " . $connect->error;
    }
  }
}
?>


<!-- HTML and form -->
<div id="main-wrapper">
  <div class="unix-login">
    <div class="accountbg"></div>
    <div class="container-fluid" style="background-color: #eff3f6;">
      <div class="row ">
        <div class="col-md-4 mx-auto">
          <div class="login-content">
            <div class="login-form">
              <center><img src="./assets/uploadImage/Logo/spa.png" style="width: 400px; height:120px"></center><br>
              <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" id="loginForm" class="row">
                <div class="form-group col-md-12">
                  <input type="text" name="username" id="username" class="form-control" placeholder="Username" required="">
                </div>
                <div class="form-group col-md-12">
                  <input type="password" id="password" name="password" class="form-control" placeholder="Password" required="">
                </div>
                <div class="col-md-6 form-check">
                  <input type="checkbox" class="pl-3">
                  <label class="form-check-label" for="exampleCheck1">Remember me</label>
                </div>
                <div class="forgot-phone col-md-6 text-right">
                  <a href="#" class="text-right f-w-600 text-white"> Forgot Password?</a>
                </div>
                <div class="col-md-12"> 
                  <button type="submit" name="login" class="f-w-600 btn btn-danger m-t-30">Sign in</button>
                </div>
              </form>
              <br><br>
              <center><p style="color: red;"><b></p>For any Project Development Contact me : </b></p>
              <b><a href="mailto:mayuri.infospace@gmail.com">aeriessofttech@gmail.com</b></a></center>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script src="./assets/js/lib/jquery/jquery.min.js"></script>
<script src="./assets/js/lib/bootstrap/js/popper.min.js"></script>
<script src="./assets/js/lib/bootstrap/js/bootstrap.min.js"></script>
<script src="./assets/js/jquery.slimscroll.js"></script>
<script src="./assets/js/sidebarmenu.js"></script>
<script src="./assets/js/lib/sticky-kit-master/dist/sticky-kit.min.js"></script>
<script src="./assets/js/custom.min.js"></script>
<script>
  function onReady(callback) {
    var intervalID = window.setInterval(checkReady, 1000);
    function checkReady() {
      if (document.getElementsByTagName('body')[0] !== undefined) {
        window.clearInterval(intervalID);
        callback.call(this);
      }
    }
  }

  function show(id, value) {
    document.getElementById(id).style.display = value ? 'block' : 'none';
  }

  onReady(function () {
    show('page', true);
    show('loading', true);
  });  
</script>
</body>
</html>
