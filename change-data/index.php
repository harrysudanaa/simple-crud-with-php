<?php 
session_start();
require "../function/functions.php";
// jika belum pernah melakukan login
if(!isset($_SESSION["login"])) {
    $url = "http://localhost/crud-dasar/login/index.php";
    header("Location: " . $url);
    exit;
}
// tangkap id yg dikirim oleh index.php
$id = $_GET["id"];
// lakukan query pada data yg sesuai dengan id yg dipilih
$handphone = query("SELECT * FROM handphones WHERE id = $id")[0];
// cek apakah tombol info ubah diklik
if(isset($_POST["changeInfo"])) {
  header("Location: ../index.php");
  exit;
}

?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Change Data</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <link rel="stylesheet" href="change.css">
    <!-- JQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
  </head>
  <body>
    <div class="container bg-white rounded p-5">
      <!-- Title -->
      <h1>Ubah Data</h1>
      <p>Ubah data smartphone pada kolom dibawah ini.</p>
      <!-- Title end -->

      <!-- Form  -->
      <div class="form-login mt-4 rounded p-3">

        <form action="" method="POST">
          <!-- Ambil id dari data yg dipilih -->
          <input type="hidden" name="id" value="<?= $handphone["id"]; ?>">
          <div class="input-form d-flex flex-column align-items-start justify-content-center mb-2">
            <label for="merek" class="form-label">Merek</label>
            <input type="text" class="form-control" id="merek" name="merek" value="<?= $handphone["merek"]; ?>">
          </div>
          <div class="input-form d-flex flex-column align-items-start justify-content-center mb-2">
            <label for="nama" class="form-label">Nama Smartphone</label>
            <input type="text" class="form-control" id="nama" name="nama" value="<?= $handphone["nama"]; ?>">
          </div>
          <div class="input-form d-flex flex-column align-items-start justify-content-center mb-2">
            <label for="chipset" class="form-label">Chipset</label>
            <input type="text" class="form-control" id="chipset" name="chipset" value="<?= $handphone["chipset"]; ?>">
          </div>
          <div class="input-form d-flex flex-column align-items-start justify-content-center mb-3">
            <label for="ram" class="form-label">RAM</label>
            <input type="text" class="form-control" id="ram" name="ram" value="<?= $handphone["ram"]; ?>">
          </div>
          <!-- <div class="input-form d-flex flex-column align-items-start justify-content-center mb-3">
            <label for="password" class="form-label">Gambar</label>
            <img src="../img/ip12.jpg" width="100" height="100" class="mb-3">
            <input type="file" class="form-control" id="password" placeholder="Enter Password">
          </div> -->

          <!-- Modal Update Data-->
          <div class="modal fade" id="updateModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Ubah Data</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body text-start">
                        Apakah yakin mengubah data?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" name="change">Change</button>
                    </div>
                </div>
            </div>
          </div>

          </form>
      </div>
        <!-- Form end -->
      
      <!-- Button confirm -->
      <div class="button mt-4 d-flex justify-content-between">
        <button type="button" class="btn btn-outline-secondary"><a href="../index.php" class="cancel text-decoration-none">Cancel</a></button>
        <button class="btn btn-primary login" type="submit" data-bs-toggle="modal" data-bs-target="#updateModal">Change data</button>
      </div>
      <!-- Button Confirm end -->

    <!-- Notif Sucess Change Data -->
    <div class="modal fade" id="updateSuccessModal">
      <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title">Ubah Data</h5>
              </div>
              <div class="modal-body text-start">
                  Data berhasil diubah!
              </div>
              <div class="modal-footer">
                  <form action="" method="post">
                      <button type="submit" class="btn btn-primary" name="changeInfo">OK</button>
                  </form>
              </div>
          </div>
      </div>
    </div>
    <!-- Notif Sucess Add Data end -->

    <!-- Notif Fail Change Data -->
    <div class="modal fade" id="updateFailModal">
      <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title">Ubah Data</h5>
              </div>
              <div class="modal-body text-start">
                  Data gagal diubah!
              </div>
              <div class="modal-footer">
                  <form action="" method="post">
                      <button type="submit" class="btn btn-primary" name="changeInfo">OK</button>
                  </form>
              </div>
          </div>
      </div>
    </div>
    <!-- Notif Fail Change Data end -->

      <!-- Logic PHP -->
    <?php if(isset($_POST["change"])) : ?>
      <?php if(changeData($_POST) > 0) : ?>
        <!-- JQuery untuk munculkan modal -->
          <?= '<script>
                  $(document).ready(function(){
                      $("#updateSuccessModal").modal("show");
                  });
              </script>';
          ?>
      <?php else : ?>
          <?= '<script>
                  $(document).ready(function(){
                      $("#updateFailModal").modal("show");
                  });
              </script>';
          ?>
      <?php endif; ?>
    <?php endif; ?>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
  </body>
</html>
