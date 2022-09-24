<?php 
require "../function/functions.php";
// jika username telah terdaftar, arahkan user pada page yang sama
if(isset($_POST["failSignUp"])) {
  header("Location: ../sign-up/index.php");
  exit;
}
// jika tombol OK pd info diklik (fail ataupun succes)
if(isset($_POST["signUpInfo"])) {
  header("Location: ../login/index.php");
  exit;
}
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sign Up Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <link rel="stylesheet" href="signup.css">
    <!-- JQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
  </head>
  <body>
    <div class="container-card d-flex justify-content-center flex-column bg-white">
      <h1 class="mt-4">SIGN UP</h1>
      <div class="form-login mt-4">
        <form action="" method="POST">
          <div class="input-form d-flex flex-column align-items-start justify-content-center mb-2">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" id="username" name="username" placeholder="Enter Username">
          </div>
          <div class="input-form d-flex flex-column align-items-start justify-content-center mb-2">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password">
          </div>
          <div class="input-form d-flex flex-column align-items-start justify-content-center mb-3">
            <label for="password" class="form-label">Confirm Password</label>
            <input type="password" class="form-control" id="password" name="cPassword" placeholder="Enter Confirm Password">
          </div>
          <button class="btn btn-primary login mt-4" type="button" name="signup" data-bs-toggle="modal" data-bs-target="#signUpCheckModal">SIGN UP</button>

          <!-- Add User Confirm Modal-->
          <div class="modal fade " id="signUpCheckModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Sign Up</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-start">
                      Apakah yakin ingin membuat akun?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" name="createUser">Create</button>
                    </div>
                  </div>
              </div>
          </div>
        </form>
      </div>
    </div>

    <!-- Notif Sucess Add User -->
    <div class="modal fade" id="signUpSuccessModal">
      <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title">Sign Up</h5>
              </div>
              <div class="modal-body text-start">
                  Akun berhasil dibuat!
              </div>
              <div class="modal-footer">
                  <form action="" method="post">
                      <button type="submit" class="btn btn-primary" name="signUpInfo">OK</button>
                  </form>
              </div>
          </div>
      </div>
    </div>
    <!-- Notif Sucess Add User end -->

    <!-- Notif Fail Add User -->
    <div class="modal fade" id="signUpFailModal">
      <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title">Sign Up</h5>
              </div>
              <div class="modal-body text-start">
                  Akun berhasil dibuat!
              </div>
              <div class="modal-footer">
                  <form action="" method="post">
                      <button type="submit" class="btn btn-primary" name="signUpInfo">OK</button>
                  </form>
              </div>
          </div>
      </div>
    </div>
    <!-- Notif Fail Add User end -->

    <!-- PHP -->
    <?php if(isset($_POST["createUser"])) : ?>
      <?php if(signup($_POST) > 0) : ?>
        <?= '<script>
                $(document).ready(function(){
                    $("#signUpSuccessModal").modal("show");
                });
            </script>';
        ?>
      <?php else: ?>
        <?= '<script>
                $(document).ready(function(){
                    $("#signUpFailModal").modal("show");
                });
            </script>';
        ?>
      <?php endif; ?>
    <?php endif; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
  </body>
</html>
