<?php
session_start();

// if logged in redirect to dashboard
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
  header("location: dashboard.php");
  exit;
}

require_once "./config/config.php";

$username = $password = "";
$error = "";

// form
if ($_SERVER["REQUEST_METHOD"] == "POST") {

  // check all
  if (empty(trim($_POST["username"]))) {
    $error = "Please enter username.";
  } else {
    $username = trim($_POST["username"]);
  }
  if (empty(trim($_POST["password"]))) {
    $error = "Please enter your password.";
  } else {
    $password = trim($_POST["password"]);
  }

  // all valid
  if (empty($error)) {
    // select username
    $sql = "select id, username, password from users where username = ?";
    if ($stmt = mysqli_prepare($link, $sql)) {
      // bind variables
      mysqli_stmt_bind_param($stmt, "s", $param_username);
      $param_username = $username;
      if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_store_result($stmt);
        // if username exist
        if (mysqli_stmt_num_rows($stmt) == 1) {
          mysqli_stmt_bind_result($stmt, $id, $username, $db_password);
          if (mysqli_stmt_fetch($stmt)) {
            // if password match
            if ($password === $db_password) {
              session_start();

              $_SESSION["loggedin"] = true;
              $_SESSION["id"] = $id;
              $_SESSION["username"] = $username;

              header("location: dashboard.php");
            } else {
              $error = "Invalid password";
            }
          }
        } else {
          $error = "Invalid username";
        }
      } else {
        $error = "Some error";
      }
      mysqli_stmt_close($stmt);
    }
  }
  mysqli_close($link);
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset='utf-8'>
  <meta http-equiv='X-UA-Compatible' content='IE=edge'>
  <meta name='viewport' content='width=device-width, initial-scale=1'>
  <link rel='stylesheet' href='./css/login.css'>
  <link rel='stylesheet' href='./css/main.css'>
  <link rel='stylesheet' href='./css/floatingbg.css'>
  <title>PETSHOP | Login</title>
</head>
<body>

<div class="container">
	<div class="screen">
		<div class="screen__content">
			<form action="login.php" method ="post" class="login">
			<div class = "h2-login"> 
			<h3> PETSHOP <br>Admin Log In </h3>
			</div>
        <?php echo $error; ?>
				<div class="login__field">
					<i class="login__icon fas fa-user"></i>
					<input type="text" name = "username" class="login__input" placeholder="username admin">
				</div>
				<div class="login__field">
					<i class="login__icon fas fa-lock"></i>
					<input type="password" name= "password" class="login__input" placeholder="password admin">
				</div>

					<label class = "form-style-2"> 
						<span> <input type = "submit" value = "Log In"> </span>
					</label>
				</button>				
			</form>
		</div>
		<div class="screen__background">
			<span class="screen__background__shape screen__background__shape4"></span>
			<span class="screen__background__shape screen__background__shape3"></span>		
			<span class="screen__background__shape screen__background__shape2"></span>
			<span class="screen__background__shape screen__background__shape1"></span>
		</div>		
	</div>

	<div class="waveWrapper waveAnimation">
		<div class="waveWrapperInner bgTop">
		  <div class="wave waveTop" style="background-image: url('http://front-end-noobs.com/jecko/img/wave-top.png')"></div>
		</div>
		<div class="waveWrapperInner bgMiddle">
		  <div class="wave waveMiddle" style="background-image: url('http://front-end-noobs.com/jecko/img/wave-mid.png')"></div>
		</div>
		<div class="waveWrapperInner bgBottom">
		  <div class="wave waveBottom" style="background-image: url('http://front-end-noobs.com/jecko/img/wave-bot.png')"></div>
		</div>
	  </div><div class="waveWrapper waveAnimation">
		<div class="waveWrapperInner bgTop">
		  <div class="wave waveTop" style="background-image: url('http://front-end-noobs.com/jecko/img/wave-top.png')"></div>
		</div>
		<div class="waveWrapperInner bgMiddle">
		  <div class="wave waveMiddle" style="background-image: url('http://front-end-noobs.com/jecko/img/wave-mid.png')"></div>
		</div>
		<div class="waveWrapperInner bgBottom">
		  <div class="wave waveBottom" style="background-image: url('http://front-end-noobs.com/jecko/img/wave-bot.png')"></div>
		</div>
	  </div>

</div>

</body>
</html>
