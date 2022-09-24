<?php 
session_start();
require "../function/functions.php";
// cek apakah sudah ada cookie
if(isset($_COOKIE["id"]) && isset($_COOKIE["key"])) {
  // ambil value dari cookie
  $id = $_COOKIE["id"];
  $key = $_COOKIE["key"];

  // ambil username berdasarkan id
  $result = mysqli_query($conn, "SELECT username FROM users WHERE id = $id");
  $row = mysqli_fetch_assoc($result);

  // cek cookie dan username
  if($key === hash("sha256", $row["username"])) {
    $_SESSION["login"] = true;
  }
}
// jika sudah pernah melakukan login
if(isset($_SESSION["login"])) {
  $url = "http://localhost/crud-dasar/index.php";
  header("Location: " . $url);
  exit;
}
// apabila username atau pw salah
if(isset($_POST["failLogin"])) {
  header("Location: ../login/index.php");
  exit;
}
// cek apakah tombol login diklik
if(isset($_POST["login"])) {
  // ambil username dan pw yg diinput user
  $username = $_POST["username"];
  $password = $_POST["password"];

  // cek apakah username ada di db
  $result = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");

  // jika ada username dlm db
  // dptkan record data username (1 = true, 0 = false)
  if(mysqli_num_rows($result) == 1) {
    // ambil data password
    $row = mysqli_fetch_assoc($result);
    // cek apakah sesuai pw yg telah diacak pada db
    if(password_verify($password, $row["password"])) {
      // tandai bahwa sudah login ke sistem
      $_SESSION["login"] = true;
      // cek apakah tombol remember me diklik
      if(isset($_POST["remember"])) {
        // buat cookie
        setcookie("id", $row["id"], time() + 30, "/");
        setcookie("key", hash("sha256", $row["username"]), time() + 30, "/");
      }
      // redirect
      header("Location: ../index.php");
      exit;
    }
  }
// jika tidak ada username
$error = true;
if($error) {
  echo '
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <link rel="stylesheet" href="signup.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <div class="modal fade" id="loginFailModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Login</h5>
            </div>
            <div class="modal-body text-start">
                Username atau password salah!
            </div>
            <div class="modal-footer">
                <form action="" method="post">
                    <button type="submit" class="btn btn-primary" name="failLogin">OK</button>
                </form>
            </div>
        </div>
    </div>
    </div>
    <script>
    $(document).ready(function(){
        $("#loginFailModal").modal("show");
    });
    </script>
    ';
    return false;
}
}
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
  </head>
  <body>
    <div class="container-card d-flex justify-content-center flex-column bg-white">
      <h1 class="mt-4">LOGIN</h1>
      <div class="form-login mt-4">
        <form action="" method="POST">
          <div class="input-form d-flex flex-column align-items-start justify-content-center mb-2">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" id="username" name="username" placeholder="Enter Username">
          </div>
          <div class="input-form d-flex flex-column align-items-start justify-content-center mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password">
          </div>
          <div class="form-check remember d-flex align-items-center justify-content-between">
            <input class="form-check-input" type="checkbox" value="" id="remember" name="remember">
            <label class="form-check-label" for="remember">Remember me</label>
            <a href="#" class="link-primary">Forgot Password?</a>
          </div>
          <button class="btn btn-primary login mt-4" type="submit" name="login">LOGIN</button>
        </form>
      </div>
      <div class="signup">
        <p class="mb-4">Don't have any account? <a href="../sign-up/index.php" class="text-decoration-none">Sign up</a></p>
      </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
  </body>
</html>
